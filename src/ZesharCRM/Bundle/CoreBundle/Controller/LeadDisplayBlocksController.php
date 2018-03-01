<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZesharCRM\Bundle\CoreBundle\Entity\DriverTicket;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadType;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory;
use ZesharCRM\Bundle\CoreBundle\Entity\Attachment;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadSubjectEmail;
use ZesharCRM\Bundle\CoreBundle\Entity\Operation;
use ZesharCRM\Bundle\CoreBundle\Entity\OpportunityAttachment;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment;
use ZesharCRM\Bundle\CoreBundle\Entity\Opportunity;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationAuto;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationDriver;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadPrequalificationInsuredAddress;
use ZesharCRM\Bundle\CoreBundle\Entity\ContactCard;
use ZesharCRM\Bundle\CoreBundle\Entity\Contact;
use ZesharCRM\Bundle\CallsBundle\Entity\CallReporting;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactCardType;
use ZesharCRM\Bundle\CoreBundle\Repository\LeadRepository;
use ZesharCRM\Bundle\CoreBundle\Repository\LeadSubjectRepository;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;

class LeadDisplayBlocksController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $action = $request->get('action');
        $method = $action . 'Action';
        if (method_exists($this, $method)) {
            $this->getDoctrine()->getManager()->getFilters()->disable('lead_subject_filter');
            return $this->$method($request);
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
    }

    private function leadEvent($params)
    {
        $happensAt = \DateTime::createFromFormat('M d, Y_h:ia', $params['date'] . '_' . $params['time']);
        if ($happensAt === false) {
            $happensAt = null;
        }

        $em = $this->getDoctrine()->getManager();

        $leadsRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');
        $lead = $leadsRepository->find($params['lead_id']);

        if ($lead instanceof Opportunity) {
            $lead = $lead->getLead();
        }

        $type = $em->getRepository('ZesharCRMCoreBundle:LeadEventType')->find($params['leadEventType']);

        if (is_null($lead)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException(sprintf('no lead found by id %ld', $params['lead_id']));
            return;
        }

        if (isset($params['event_id']) && $params['event_id']) {
            $leadEvent = $em->getRepository('ZesharCRMCoreBundle:LeadEvent')->findOneBy(array('id' => $params['event_id']));
        } else {
            $leadEvent = new \ZesharCRM\Bundle\CoreBundle\Entity\LeadEvent();
        }
        if ($params['goal'] == '') {
            $params['goal'] = null;
        }

        $leadEvent
            ->setLead($lead)
            ->setHappensAt($happensAt)
            ->setLocation($params['location'])
            ->setGoal($params['goal'])
            ->setType($type)
        ;

        $em->persist($leadEvent);
        $em->flush();

        return $leadEvent;
    }
    
    public function leadEventAction(Request $request)
    {
        $params = $request->request->all();
        $this->leadEvent($params);
        
//        if (empty($params['lead_id']) || empty($params['date']) || empty($params['time']) || empty($params['location']) || empty($params['goal']) || empty($params['leadEventType'])) {
//            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException('Incomplete data.');
//            return;
//        }

        return new Response();
    }

    private function leadProcessing($params)
    {
        /** @var $admin AdminInterface */
        $admin = $this->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_core.admin.opportunity');

        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        /** @var $leadsRepository LeadSubjectRepository */
        $leadsRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');

        /** @var $lead LeadSubject */
        $lead = $leadsRepository->find($params['lead_id']);
        if (isset($params['leadSource'])) {
            $leadSource = $em->getRepository('ZesharCRMCoreBundle:LeadSource')->find($params['leadSource']);
            $lead->setLeadSource($leadSource);
        }
        if (isset($params['leadCampaign'])) {
            $leadCampaign = $em->getRepository('ZesharCRMCoreBundle:Activity')->find($params['leadCampaign']);
            $lead->setLeadCampaign($leadCampaign);
        }
        if (isset($params['amount'])) {
            if ($params['amount'] == '') {
                $lead->setQuotedAmount(null);
            } else {
                $lead->setQuotedAmount($params['amount']);
            }
        }
        if (isset($params['effective_date'])) {
            $effectiveDate = \DateTime::createFromFormat('M d, Y_h:ia', $params['effective_date'] . '_0:00am');
            $lead->setEffectiveDate($effectiveDate);
        }

        if (isset($params['closing_date'])) {
            $closingDate = \DateTime::createFromFormat('M d, Y_h:ia', $params['closing_date'] . '_0:00am');
            $lead->setClosingDate($closingDate);
        }

        if (isset($params['quantity'])) {
            $quantity = $params['quantity'];
        } else {
            $quantity = 1;
        }

        $lead->setQuantity($quantity);

        if ($lead instanceof Opportunity) {
            /** @var $leadEntity Lead */
            $leadEntity = $lead->getLead();
        } elseif ($lead instanceof Lead) {
            $leadEntity = $lead;
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        if (isset($params['lead_type2'])) {
            $leadEntity->setType($params['lead_type2']);
        }

        if (isset($params['criteria'])) {
            $scoring = !empty($params['criteria']) ? $params['criteria'] : array();

            $totalScore = !empty($params['scoring-total']) ? $params['scoring-total'] : 0;
            if($lead instanceof Opportunity){
                $lead = $lead->getLead();
            }
            $leadScoring = $em->getRepository('ZesharCRMLeadScoringBundle:LeadScoring')->getLeadScoringByLead($lead);

            $leadScoring->setTotal($totalScore);
            $leadScoring->setScoring(serialize($scoring));
        }

        if ( isset($params['assignee'])) {
            $assignee = $em->getRepository('ZesharCRMCoreBundle:User')->find($params['assignee']);

            $lead->setAssignee($assignee);
        }

        if ( isset($params['leadType'])) {
            /** @var $leadType LeadType */
            $leadType = $em->getRepository('ZesharCRMCoreBundle:LeadType')->find($params['leadType']);

            $lead->setLeadType($leadType);
        }

        if (isset($params['priority']) && !empty($params['priority'])) {
            $lead->setPriority($params['priority']);
        }

        if (isset($params['leadCategory'])) {
            /** @var $leadCategory LeadCategory */
            $leadCategory = $em->getRepository('ZesharCRMCoreBundle:LeadCategory')->findOneBy(array('id' => $params['leadCategory']));
            $lead->setLeadCategory($leadCategory);
        }

        if ($lead->getContactCard()) {
            $contactCardId = $lead->getContactCard()->getId();

            if ($contact = $em->getRepository('ZesharCRMCoreBundle:Contact')->findOneBy(array('isDefault' => 1, 'contactCard' => $contactCardId))) {
                $newStatus = null;
                if(empty($params['leadSource']) && empty($params['leadCampaign']) && empty($params['leadType'])){
                    $newStatus = 2;
                }elseif(empty($params['contact_type']) || empty($params['contact_result'])){
                    $newStatus = 3;
                }else{
                    $newStatus = 1;
                }
                if ($newStatus !== 2 && $newStatus !== null) {
                    if (!$operation = $em->getRepository('ZesharCRMCoreBundle:Operation')->findOneBy(array('operationType' => OperationType::COLD_BECAME_ACTIVE, 'entity' => $lead))) {
                        $operation = new Operation();
                        $operation->setPerformedAt(new \DateTime('now'));
                        $operation->setEntity($lead);
                        $operation->setPerformer($assignee);
                        $operation->setOperationType(OperationType::COLD_BECAME_ACTIVE);
                        $em->persist($operation);
                    }
                }
                $contact->setDonotCall($newStatus);
                $em->persist($contact);
//                 if (!isset($params['contact_status']) && $lead->getContactCard()->getCallStatusString() != 'Yes') {
//                    $contact->setDonotCall(3);
//                    $em->persist($contact);
//                 }
            }
        }

        if (isset($params['contact_type']) && isset($params['contact_result'])) {
            if ($lead->getContactCard()) {
                $contactCardId = $lead->getContactCard()->getId();
                $contactResult = !empty($params['contact_result']) ? $params['contact_result'] : 6;

                if ($contact = $em->getRepository('ZesharCRMCoreBundle:Contact')->findOneBy(array( 'isDefault' => 1, 'contactCard' => $contactCardId))) {
                    if (isset($params['contact_status'])) {
                        $contact->setDonotCall($params['contact_status']);
                        $em->persist($contact);
                    }

                    $eventsType = $params['contact_type'] ? $params['contact_type'] : 0;

                    $callReporting = new CallReporting();
                    $callReporting->setContact($contact);
                    $callReporting->setDescription('Contact Attempt');
                    $callReporting->setStatus($contactResult);
                    $callReporting->setType(2);
                    $callReporting->setLead($lead);
                    $callReporting->setStartsAt(new \DateTime());
                    $callReporting->setAssignee($this->getUser());
                    $callReporting->setEventsType($eventsType);
                    $em->persist($callReporting);
                }
            }
        }

        $em->persist($lead);
        $em->flush();

        return $lead;

    }

    public function getActivitiesByAssigneeAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $activities = $em->getRepository('ZesharCRMCoreBundle:Activity')->findBy(array('assignee' => $request->request->get('assigneeId')));

        $serializedActivities = array();
        foreach ($activities as $activity) {
            $serializedActivities[] = array('id' => $activity->getId(), 'title' => $activity->getTitle());
        }

        $serializedActivities = json_encode($serializedActivities);

        return new JsonResponse(array(
            'success' => true,
            'count' => sizeof($serializedActivities),
            'activities' => $serializedActivities
        ));
    }

    public function leadProcessingAction(Request $request)
    {
        $params = $request->request->all();

        $this->leadProcessing($params);

        $redirectUrl = null;
        $sold = false;

        $content = json_encode(array('redirectUrl' => $redirectUrl, 'sold' => $sold));


        return new Response($content);
    }

    private function updateQuantity($lead, $em)
    {
        // $autosLead = $em->getRepository('ZesharCRMCoreBundle:LeadPrequalificationAuto')->findByLead($lead);
        // $insuredAddresses = $em->getRepository('ZesharCRMCoreBundle:LeadPrequalificationInsuredAddress')->findByLead($lead);

        // $quantity = count($autosLead) + count($insuredAddresses);

        // $lead->setQuantity($quantity);

        $em->flush($lead);
    }

    public function leadDeleteEventAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();

        if (empty($params['event_id'])) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $event = $em->getRepository('ZesharCRMCoreBundle:LeadEvent')->findOneBy(array('id' => $params['event_id']));

        $em->remove($event);
        $em->flush();

        return new Response();
    }
    private function leadNote($params)
    {
        if (!$params['note'] && !$params['attachmentFile']) {
            return new Response;
        }

        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $leadsRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');
        $lead = $leadsRepository->find($params['lead_id']);

        if (isset($params['noteId'])) {
            $attachment = $em->getRepository('ZesharCRMCoreBundle:Attachment')->findOneBy(array('id' => $params['noteId']));
            $leadAttachment = $em->getRepository('ZesharCRMCoreBundle:LeadAttachment')->findOneBy(array('attachment' => $attachment));

            if(!$attachment){
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
            }

            if (!isset($params['note'])) {
                $em->remove($attachment);

                $em->flush();
                return new Response();
            }
        } else {
            $attachment = new Attachment();
            $leadAttachment = new LeadAttachment();
        }

        $attachment->setCreator($this->getUser());
        $attachment->setText($params['note']);
        if (isset($params['fileName']) && isset($params['originalFileName'])) {
            $fileName = $params['fileName'];
            $originalFileName = $params['originalFileName'];
            $attachment->setFilename($originalFileName);
            $attachment->setFile($fileName);

        }

        $leadAttachment->setLead($lead);
        $leadAttachment->setAttachment($attachment);

        $em->persist($attachment);
        $em->persist($leadAttachment);

        $em->flush();
        if ($lead instanceof Opportunity && $lead->getLead()) {
            $em->refresh($lead->getLead());
            $em->refresh($lead);
        }

        $note = array( 'note' => $attachment->getText(),
            'id' => $attachment->getId(),
            'author' => $attachment->getCreator()->getUsername(),
            'posted_at' => $attachment->getCreatedAt(),
            'updated_at' => $attachment->getUpdatedAt(),
        );
        if ($attachment->getFile()) {
            $note['download_url'] = $attachment->getDownloadUrl();
            $note['filename'] = $attachment->getFilename();
        }

        return $lead;
    }

    public function leadNoteAction(Request $request)
    {
        $params = $request->request->all();

        $lead = $this->leadNote($params);

        $engine = $this->container->get('templating');
        $content = $engine->render('ZesharCRMCoreBundle:CRUD:DisplayPartial/lead_opportunity_show_notes_content.html.twig', array('object' => $lead));
        return new Response($content);
    }

    public function leadNoteAttachAction(Request $request)
    {
        if ($request->isMethod('POST')) {

            if ($request->files->get('attachmentFile')) {
                /** @var $file UploadedFile */
                $file = $request->files->get('attachmentFile');
            } elseif($request->files->get('changeAttachmentFile')) {
                /** @var $file UploadedFile */
                $file = $request->files->get('changeAttachmentFile');
            }

           // print_r($file);return;

            $originalFileName = $file->getClientOriginalName();
            $extension = substr($originalFileName, strrpos($originalFileName, '.') + 1);
            $newFilename = md5($originalFileName . microtime(TRUE)) . '_' . mt_rand(0, 100000) . '.' . $extension;
            $file->move(WEB_DIRECTORY . '/uploads/attachments', $newFilename);

            $response = array('fileName' => json_encode($newFilename), 'originalFileName' => json_encode($originalFileName), 'path' => BASE_PATH . '/uploads/attachments/' . $newFilename);
            $r  = new Response();
            $r->setContent(json_encode($response));
            return $r;

        }
        return;
    }

    private function leadPrequalification($params)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        /** @var $leadsRepository LeadSubjectRepository */
        $leadsRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');

        /** @var $lead LeadSubject */
        $lead = $leadsRepository->find($params['lead_id']);

        //  $lead->getPrequalificationAutos()
        foreach ($params['autoId'] as $key => $autoId) {
            if($params['year'][$key] == null && $params['auto_make'][$key] == null &&  $params['auto_model'][$key] == null &&
                $params['auto_vinNumber'][$key] == null) {
                if ($autoId) {
                    //  print_r($params);return;
                    $auto = $em->getRepository('ZesharCRMCoreBundle:LeadPrequalificationAuto')->findOneBy(array('id' => $autoId));
                    $em->remove($auto);
                    $em->flush();

                }
                continue;
            }

            if ($autoId) {
                /** @var $auto LeadPrequalificationAuto */
                $auto = $em->getRepository('ZesharCRMCoreBundle:LeadPrequalificationAuto')->findOneBy(array('id' => $autoId));

            } else {
                /** @var $auto LeadPrequalificationAuto */
                $auto = new LeadPrequalificationAuto();
            }

            $auto->setLead($lead);
            $auto->setYear((int) $params['year'][$key]);
            $auto->setMake($params['auto_make'][$key]);
            $auto->setMake($params['auto_make'][$key]);
            $auto->setModel($params['auto_model'][$key]);
            $auto->setVinNumber($params['auto_vinNumber'][$key]);

            $em->persist($auto);
        }

        foreach ($params['driverId'] as $key => $driverId) {
            if($params['driver_name'][$key] == null && $params['driver_dob'][$key] == null && $params['driver_license'][$key] == null &&
                $params['driver_ageLicensed'][$key] == null && $params['driver_tickets'][$key] == null) {
                if ($driverId) {
                    $driver = $em->getRepository('ZesharCRMCoreBundle:LeadPrequalificationDriver')->findOneBy(array('id' => $driverId));
                    $em->remove($driver);
                    $em->flush();
                }
                continue;
            }
            if ($driverId) {
                /** @var $driver LeadPrequalificationDriver */
                $driver = $em->getRepository('ZesharCRMCoreBundle:LeadPrequalificationDriver')->findOneBy(array('id' => $driverId));
            } else {
                /** @var $driver LeadPrequalificationDriver */
                $driver = new LeadPrequalificationDriver();
            }

            $ageLicensed = $params['driver_ageLicensed'][$key] == null ? 0 : $params['driver_ageLicensed'][$key];

            $driver->setLead($lead);
            $driver->setName($params['driver_name'][$key]);
           // $driver->setDob($params['driver_dob'][$key]);
            $driverDob = \DateTime::createFromFormat('M d, Y_h:ia', $params['driver_dob'][$key] . '_0:00am');

            if ($driverDob === false) {
                $driverDob = null;
            }
            $driver->setDob($driverDob);
            $driver->setLicense($params['driver_license'][$key]);
            $driver->setAgeLicensed($ageLicensed);
            $tickets = $driver->getTickets();

            $obtainedTicketsId = array();
         //   print_r($params['driver_tickets'][$key]);return;
            if (!empty($params['driver_tickets'][$key]) && is_array($params['driver_tickets'][$key])) {
                foreach ($params['driver_tickets'][$key] as $ticketInfo) {
                    if (isset($ticketInfo['type']) && !empty($ticketInfo['type']) ) {
                        if (isset($ticketInfo['id']) && !empty($ticketInfo['id'])) {
                            /** @var $ticket DriverTicket */
                            $ticket = $em->getRepository('ZesharCRMCoreBundle:DriverTicket')->find($ticketInfo['id']);
                            $obtainedTicketsId[] = $ticketInfo['id'];
                        } else {
                            $ticket = new DriverTicket();
                            $ticket->setDriver($driver);
                        }
                        $ticket->setType($ticketInfo['type']);
                        $em->persist($ticket);
                    }
                }
            }

            if (!empty($tickets)) {
                foreach ($tickets as $setTicket) {
                    if (!empty($obtainedTicketsId)) {
                        if (!in_array($setTicket->getId(), $obtainedTicketsId)) {
                            $deleteTicket = $em->getRepository('ZesharCRMCoreBundle:DriverTicket')->find($setTicket->getId());
                            $em->remove($deleteTicket);
                            $em->flush();
                        }
                    }
                }
            }

            $em->persist($driver);
        }

        foreach ($params['insuredAddressId'] as $key => $insuredAddressId) {

            if ((!isset($params['ins_address_type'][$key]) || empty($params['ins_address_type'][$key])) && empty($params['ins_address_address'][$key]) &&
                empty($params['ins_address_city'][$key])  && empty($params['ins_address_state'][$key])  && empty($params['ins_address_zipCode'][$key]) &&
                empty($params['previous_carrier_name'][$key]) && empty($params['previous_carrier_police'][$key])) {
                //var_dump($insuredAddressId);return;
                if ($insuredAddressId) {
                    $insuredAddress = $em->getRepository('ZesharCRMCoreBundle:LeadPrequalificationInsuredAddress')->findOneBy(array('id' => $insuredAddressId));
                    $em->remove($insuredAddress);
                    $em->flush();
                }
                continue;
            }

            if ($insuredAddressId) {
                /** @var $insuredAddress LeadPrequalificationInsuredAddress */
                $insuredAddress = $em->getRepository('ZesharCRMCoreBundle:LeadPrequalificationInsuredAddress')->findOneBy(array('id' => $insuredAddressId));
            } else {
                /** @var $insuredAddress LeadPrequalificationInsuredAddress */
                $insuredAddress = new LeadPrequalificationInsuredAddress();
            }

            $insuredAddress->setLead($lead);
            if (isset($params['ins_address_type'][$key])) {
                $insuredAddress->setType($params['ins_address_type'][$key]);
            }
            $insuredAddress->setAddress($params['ins_address_address'][$key]);
            $insuredAddress->setCity($params['ins_address_city'][$key]);
            $insuredAddress->setState($params['ins_address_state'][$key]);
            $insuredAddress->setZipCode($params['ins_address_zipCode'][$key]);
            $insuredAddress->setPreviousCarrierName($params['ins_address_name'][$key]);
            $insuredAddress->setPreviousCarrierPolice($params['ins_address_policy'][$key]);
            $insuredAddressXDate = \DateTime::createFromFormat('M d, Y_h:ia', $params['ins_address_xdate'][$key] . '_0:00am');

            if ($insuredAddressXDate === false) {
                $insuredAddressXDate = null;
            }
            $insuredAddress->setPreviousCarrierXDate($insuredAddressXDate);

            $em->persist($insuredAddress);
        }

        if ($params['leadCategory']) {
            /** @var $lead LeadCategory */
            $leadCategory = $em->getRepository('ZesharCRMCoreBundle:LeadCategory')->findOneBy(array('id' => $params['leadCategory']));

            $lead->setLeadCategory($leadCategory);
        }

        $lead->setPreviousCarierName($params['previous_carrier_name']);
        $lead->setPreviousCarrierPolice($params['previous_carrier_police']);
        $xDate = \DateTime::createFromFormat('M d, Y_h:ia', $params['pckr1'] . '_0:00am');

        if ($xDate === false) {
            $xDate = null;
        }
        $lead->setPreviousCarrierXDate($xDate);

        $em->persist($lead);
        $em->flush();

        if ($lead instanceof Lead) {
            $leadEntity = $lead;
        } elseif ($lead instanceof Opportunity) {
            $leadEntity = $lead->getLead();
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        $this->updateQuantity($leadEntity, $em);

        return $leadEntity;
    }

    public function leadPrequalificationAction(Request $request)
    {
        $params = $request->request->all();

       $this->leadPrequalification($params);

        return new Response();
    }

//    public  function leadAssignAction(Request $request)
//    {
//        $params = $request->request->all();
//        $response = new Response();
//        //print_r($params);return;
//
//        if (isset($params['lead_id']) && isset($params['assignee'])) {
//            /** @var $em EntityManager */
//            $em = $this->getDoctrine()->getManager();
//
//            /** @var $leadsRepository LeadRepository */
//            $leadsRepository = $em->getRepository('ZesharCRMCoreBundle:Lead');
//
//            /** @var $lead Lead */
//            $lead = $leadsRepository->find($params['lead_id']);
//            $assignee = $em->getRepository('ZesharCRMCoreBundle:User')->find($params['assignee']);
//
//            $lead->setAssignee($assignee);
//
//            $em->persist($lead);
//            $em->flush();
//
//            if (!$this->get('security.context')->isGranted('ROLE_ADMIN') && $this->getUser()->getId() != $params['assignee']) {
//                $response->setContent(json_encode(array('redirect' => true)));
//            }
//        }
//
//        return $response;
//    }

    public function transitionOpportunityAction(Request $request)
    {
        $params = $request->request->all();
        $urlParams = array();
        if (isset($params['leadCampaign'])) {
            $urlParams['leadCampaign'] = $params['leadCampaign'];
        }

        $response = new Response();

        /** @var $opportunityAdmin AdminInterface */
        $opportunityAdmin = $this->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_core.admin.opportunity');
        $leadAdmin = $this->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_core.admin.lead');

        if ($params['status'] && $params['lead']) {
            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            if ($params['status'] == 'opportunity_to_quote') {

                $leadSubject = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->find($params['lead']);
                if ($leadSubject instanceof Opportunity) {
                    /** @var $opportunity Opportunity */
                    $opportunity = $leadSubject;
                } else {
                    /** @var $opportunity Opportunity */
                    $opportunity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneBy(array('lead' => $params['lead']));
                }

                $opportunity->setStatus(OpportunityStatus::PENDING_QUOTE);
                $redirectUrl = $opportunityAdmin->generateObjectUrl('show', $opportunity, $urlParams, true);

            } elseif ($params['status'] == 'quote_to_opportunity') {
                $leadSubject = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->find($params['lead']);
                if ($leadSubject instanceof Opportunity) {
                    /** @var $opportunity Opportunity */
                    $opportunity = $leadSubject;
                } else {
                    /** @var $opportunity Opportunity */
                    $opportunity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneBy(array('lead' => $params['lead']));
                }

                $opportunity->setStatus(OpportunityStatus::PENDING_OPPORTUNITY);
                $redirectUrl = $opportunityAdmin->generateObjectUrl('show', $opportunity, $urlParams, true);

            } elseif ($params['status'] == 'opportunity_to_sold') {
                $leadSubject = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->find($params['lead']);
                if ($leadSubject instanceof Opportunity) {
                    /** @var $opportunity Opportunity */
                    $opportunity = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->find($params['lead']);
                    if (!$opportunity->getQuantity()) {
                        $opportunity->setQuantity(1);
                    }
                } else {
                    $opportunity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneBy(array('lead' => $params['lead']));
                   // print_r($opportunity->getId());die;
                }

                $product = $opportunity->getOpportunityCategory();
                if ($product) {
                    $opportunity->setStatus(OpportunityStatus::SUCCESS_QUOTE);

                    $soldOpportunities = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('leadCategory' => $product, 'status' => OpportunityStatus::SUCCESS_QUOTE));
                    $average = 0;
                    $quotedAmounts = 0;
                    $commonQuantity = 0;
                    if (!empty($soldOpportunities)) {
                        /** @var $soldOpportunity Opportunity */
                        foreach ($soldOpportunities as $soldOpportunity) {
                            $quotedAmounts +=  $soldOpportunity->getQuotedAmount();
                            $commonQuantity +=  $soldOpportunity->getQuantity();
                        }
                    }

                    if ($commonQuantity != 0) {
                        $average = round($quotedAmounts/$commonQuantity, 2);
                    }

                    $product->setAverage($average);
                }


                $opportunity->setEffectiveDT($params['effective_dt']);
//                $opportunity->setPolicyNumber($params['policy_number']);
//                $opportunity->setLineCode($params['line_code']);
//                $opportunity->setLspCode($params['lsp_code']);
//                $opportunity->setRenewalCount($params['renewal_count']);
//                $opportunity->setPremium($params['premium']);
//                $opportunity->setVehicleCount($params['vehicle_count']);
//                $opportunity->setHomeownersCount($params['homeowners_count']);
//                $opportunity->setIsArchive(true);

                if($product){
                    $redirectUrl = $opportunityAdmin->generateObjectUrl('SoldQuote', $opportunity, $urlParams, true);
                }else{
                    $redirectUrl = $opportunityAdmin->generateObjectUrl('listQuote', $opportunity, $urlParams, true);
                }

            } elseif ($params['status'] == 'opportunity_to_lead') {

                /** @var $opportunity Opportunity */
                $opportunity = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->find($params['lead']);
                $opportunity->setStatus(OpportunityStatus::CANCELLED_OPPORTUNITY);
                $opportunity->setIsArchive(true);

                $lead = $opportunity->getLead();
                $lead->setStatus(DealStatus::PENDING);
                $lead->setIsArchive(false);
                $lead->setLeadCampaign(null);
                $opportunity->setLeadCampaign(null);
                $em->persist($opportunity);
                $em->persist($lead);

                $redirectUrl = $leadAdmin->generateObjectUrl('show', $lead, $urlParams, true);

            } else {

                /** @var $leadsRepository LeadRepository */
                $leadsRepository = $em->getRepository('ZesharCRMCoreBundle:Lead');


                /** @var $lead Lead */
                $lead = $leadsRepository->find($params['lead']);

                $opportunity = $em->getRepository('ZesharCRMCoreBundle:Opportunity')->findOneBy(array('lead' => $params['lead']));

                /** @var $opportunity Opportunity */
                if (!$opportunity) {
                    $opportunity = $leadsRepository->createOpportunity($lead);
                } else {
                    $opportunity->setStatus(OpportunityStatus::PENDING_OPPORTUNITY);
                }

                $opportunity->setLeadCampaign($lead->getLeadCampaign());
                $lead->setIsArchive(true);

                $em->persist($opportunity);
                $em->persist($lead);


//                /** @var $leadSubjectRepository LeadRepository */
//                $leadSubjectRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');
//
//                /** @var $leadSubject LeadSubject */
//                $leadSubject = $leadSubjectRepository->findOneBy(array('id' => $lead->getId()));
//                $em->remove($leadSubject);
//                $em->flush();

                switch ($params['status']) {
                    case 'quote':
                        $opportunity->setStatus(OpportunityStatus::PENDING_QUOTE);
                        break;
                }

                if ($params['leadCampaign']) {
                    $nextId = $leadsRepository->getNextId($lead, $params['leadCampaign']);
                    if (!$nextId) {
                        $nextId = $leadsRepository->getFirstId($lead, $params['leadCampaign']);
                    }
                    if ($nextId) {
                        $nextLead = $leadsRepository->find($nextId);
                        $redirectUrl = $leadAdmin->generateObjectUrl('show', $nextLead, $urlParams, true);
                    } else {
                        $redirectUrl = $leadAdmin->generateUrl('list', $urlParams, true);
                    }

                } else {
                    $redirectUrl = $opportunityAdmin->generateObjectUrl('show', $opportunity, $urlParams, true);
                }


            }

            $em->flush();
            $response->setContent(json_encode(array('redirect' => $redirectUrl)));
        }

        return $response;
    }

    private function saveDetails($params)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $leadSubject LeadSubject */
        $leadSubject = $em->getRepository('ZesharCRMCoreBundle:LeadSubject')->find($params['leadId']);

        if(isset($params['contactCardId']) && $params['contactCardId']){
            $contactCard = $em->getRepository('ZesharCRMCoreBundle:ContactCard')->find($params['contactCardId']);
        } elseif((isset($params['selectedCard']) && $params['selectedCard'])){
            $contactCard = $em->getRepository('ZesharCRMCoreBundle:ContactCard')->find($params['selectedCard']);
        } else {
            $contactCard = new ContactCard();
            $em->persist($contactCard);
        }

        if(isset($params['selectedCard']) && $params['selectedCard']){
            //do nothing
//            $contactCard = $em->getRepository('ZesharCRMCoreBundle:ContactCard')->find($params['selectedCard']);
        }  else {
            $contactCard->setFirstName($params['firstName']);
            $contactCard->setMiddleInitial($params['middleName']);
            $contactCard->setLastName($params['lastName']);
            $contactCard->setStreetAddress($params['address']);
            $contactCard->setCity($params['city']);
            $contactCard->setZip($params['zipcode']);
            $contactCard->setState($params['state']);
            $contactCard->setOther($params['other']);

            $contactCard->setType(ContactCardType::LEAD);

            if(isset($params['phone']) && $params['phone']){
                if(!($contactCard->getPhone())){
                    $contact = new Contact();
                } else {
                    $contact = $contactCard->getPhone();
                }

                $contact->setContactCard($contactCard);
                $contact->setType(ContactType::GENERIC_PHONE);
                $contact->setValue($params['phone']);
                $contact->setIsDefault(true);
                $em->persist($contact);
            }

            if(isset($params['email']) && $params['email']){
                if(!($contactCard->getEmail())){
                    $contact = new Contact();
                } else {
                    $contact = $contactCard->getEmail();
                }
                $contact->setContactCard($contactCard);
                $contact->setType(ContactType::EMAIL);
                $contact->setValue($params['email']);
                $contact->setIsDefault(true);
                $em->persist($contact);
            }
        }

        if ($params['formType'] == 'lead'){
            $leadSubject->setContactCard($contactCard);
        } else {
            $leadSubject->setContactCardOpportunity($contactCard);
        }

        if (isset($params['copyFromLead']) && $params['copyFromLead']){
            $contactCardOpportunity = clone $contactCard;
            $em->persist($contactCardOpportunity);
            $leadSubject->setContactCardOpportunity($contactCardOpportunity);

        }

        $em->flush();

        if ($leadSubject instanceof Opportunity && $leadSubject->getLead()) {
            $em->refresh($leadSubject->getLead());
        }
        $em->refresh($leadSubject);
        $em->refresh($contactCard);

        return $leadSubject;
    }

    public function saveAllDataLeadAction(Request $request)
    {
        $params = $request->request->all();

        $message = '';

        if ($params['forms'] && $params['forms']['saveDetails']) {
            $leadSubject = $this->saveDetails($params['forms']['saveDetails']);
            foreach ($params['forms'] as $action=>$values) {
                $this->$action($values);
            }
        } else {
            $message = 'Error data!';
        }


        $content = json_encode(array('message' => $message));

        return new Response($content);
    }

    public function saveDetailsAction(Request $request)
    {
        $params = $request->request->all();
        $message = '';

        $leadSubject = $this->saveDetails($params);

        $engine = $this->container->get('templating');
        $content = $engine->render('ZesharCRMCoreBundle:CRUD:DisplayPartial/lead_opportunity_show_entity_details.html.twig', array('object' => $leadSubject));

        $response = new JsonResponse();
        $response->setData(array(
            'content' => $content,
            'message' => $message,
          ));
        return $response;
//
//            /** @var $admin AdminInterface */
//            $admin = $this->get('sonata.admin.pool')->getAdminByAdminCode('zeshar_crm_core.admin.opportunity');
//
//            $redirectUrl = $admin->generateObjectUrl('show', $opportunity, array(), true);
//            $response->setContent(json_encode(array('redirect' => $redirectUrl)));
    }

    public function leadEmailSendAction(Request $request)
    {
        $params = $request->request->all();
//        print_r($params);return;

        $message = \Swift_Message::newInstance()
            ->setSubject('subject')
            ->setFrom('devzeshar@gmail.com')
//            ->set
            ->setTo($params['email_to'])
            ->setBody($params['email_text'], 'text/html')
        ;
        $this->get('mailer')->send($message);


        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        /** @var $leadsRepository LeadRepository */
        $leadsRepository = $em->getRepository('ZesharCRMCoreBundle:LeadSubject');

        /** @var $leadSubject LeadSubject */
        $leadSubject = $leadsRepository->find($params['lead_id']);

        $leadEmail = new LeadSubjectEmail();
        $leadEmail->setMessage($params['email_text']);
        $leadEmail->setTheme($params['email_theme']);
        $leadEmail->setLeadId($leadSubject);

        $em->persist($leadEmail);
        $em->flush();

        return new Response();
    }


    private function validateZipcode($zipCode)
    {
        if(preg_match("/^([0-9]{5})(-[0-9]{4})?$/i",$zipCode))
            return true;
        else
            return false;
    }

}
