<?php

namespace ZesharCRM\Bundle\CallsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ZesharCRM\Bundle\CallsBundle\Entity\CallReporting;
use ZesharCRM\Bundle\CallsBundle\Enum\CallReportingType;
use ZesharCRM\Bundle\CallsBundle\Enum\CallReportingStatus;

class CallReportingController extends Controller
{
    public function createAction(Request $request)
    {
        $contactId = $request->get('Contact');

        $callReportingStatus = CallReportingStatus::getNumericalMap();

        $dialCallStatus = $request->get('DialCallStatus');

        $dialCallDuration = $request->get('DialCallDuration');

        $em = $this->getDoctrine();

        if (!empty($contactId)) {
            $contact = $em->getRepository('ZesharCRMCoreBundle:Contact')->findOneById($contactId);
            if ($contact) {
                $entity = new CallReporting();
                $entity->setSubject($contact->getContactCard()->getFirstName().' '.$contact->getContactCard()->getLastName());
                $entity->setContact($contact);
                $entity->setDescription('');
                $entity->setType(CallReportingType::OUTBOUND);
                $entity->setStatus($callReportingStatus[$dialCallStatus]);
                $entity->setStartsAt(new \DateTime());
                if ($dialCallDuration) {
                    $entity->setDuration(new \DateTime(gmdate('H:i:s', $dialCallDuration)));
                }
                $em->getManager()->persist($entity);
                $em->getManager()->flush($entity);
            }
        }
        return $this->render('ZesharCRMCallsBundle:Default:callreporting.html.twig');
    }

    public function createCallAction()
    {
        $accountSid = 'ACb48aad149ce15faa88403d8551876de6';
        $authToken = 'aa5f86287203c49f7087fd233f2ef170';
        $version = "2010-04-01";
        $appSid     = 'AP7e71f275c55d76ccf8d2e3d10467b0c0';

        $capability = new \Services_Twilio_Capability($accountSid, $authToken);
        $capability->allowClientOutgoing($appSid);
        $capability->allowClientIncoming('SurgEdge');

        return $this->render('ZesharCRMCallsBundle:Default:calltoken.html.twig',array('token' => $capability->generateToken()));
    }


}