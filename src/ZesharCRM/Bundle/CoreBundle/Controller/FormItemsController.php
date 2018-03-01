<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZesharCRM\Bundle\CoreBundle\Enum\EventGoal;
use ZesharCRM\Bundle\CoreBundle\Enum\DriverTicketType;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityPriority;
use ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject;
use ZesharCRM\Bundle\CallsBundle\Enum\CallReportingStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\ContactType;

class FormItemsController extends Controller
{
    
    private function getEntitySelect($persistentObjectName, $activeId = null, $emptyOption = true, $titleProperty = 'title', $emptyOptionTitle = ' - Select One -', $formItemId = null, $disabled = false, $additionalParams = array())
    {
        $repository = $this->getDoctrine()->getRepository($persistentObjectName);

        $user = self::getLoggedInUser();
        $company = $user->getCompany();

        if(get_class($repository) == 'ZesharCRM\Bundle\CoreBundle\Repository\ActivityRepository') {
            $qb = $this->getDoctrine()->getManager()->getRepository('ZesharCRMCoreBundle:Activity')->createQueryBuilder('a');
            $date = new \DateTime('today');
            $timestamp = $date->getTimestamp();
            $now = date("Y-m-d H:i:s", $timestamp);
            $activities = $qb
                ->andWhere('a.finishesAt >= :now')
                ->leftJoin('a.creator', 'u')
                ->andWhere('u.company = :company')
                ->setParameters(array('now' => $now, 'company' => $company));
            if (isset($additionalParams['assignee']) && $additionalParams['assignee'] !== null) {
                $activities = $qb
                    ->andWhere('a.assignee = :assignee')
                    ->setParameter('assignee', $additionalParams['assignee']);
            }
            $entities = $activities->getQuery()->getResult();
        } elseif (get_class($repository) == 'ZesharCRM\Bundle\CoreBundle\Repository\UserRepository') {
            $qb = $this->getDoctrine()->getManager()->getRepository('ZesharCRMCoreBundle:User')->createQueryBuilder('u');
            $users = $qb
                ->andWhere('u.company = :company')
                ->setParameters(array('company' => $company));
            $entities = $users->getQuery()->getResult();
        } else {
            $qb = $this->getDoctrine()->getManager()->getRepository($persistentObjectName)->createQueryBuilder('o');
            $objects = $qb
                ->leftJoin('o.creator', 'u')
                ->andWhere('u.company = :company')
                ->setParameters(array('company' => $company));
            $entities = $objects->getQuery()->getResult();
        }

        if (!$formItemId) {
            $pieces = explode(':', $persistentObjectName);
            $formItemId = lcfirst(end($pieces));
        }
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:entitySelect.html.twig',
            array(
                'entities' => $entities,
                'activeId' => $activeId,
                'emptyOption' => $emptyOption,
                'titleProperty' => $titleProperty,
                'emptyOptionTitle' => $emptyOptionTitle,
                'formItemId' => $formItemId,
                'disabled' => $disabled,
            )
        );
    }

    private function getYearSelect($activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -', $formItemId = null, $disabled = false)
    {

        $years = range(1902, date("Y"));
        krsort($years);
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:customDataSelect.html.twig',
            array(
                'data' => $years,
                'activeValue' => $activeValue,
                'emptyOption' => $emptyOption,
                'emptyOptionTitle' => $emptyOptionTitle,
                'formItemId' => $formItemId,
                'disabled' => $disabled,
            )
        );
    }

    private function getGoalSelect($activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -', $formItemId = null, $disabled = false)
    {
        $goals = EventGoal::getHumanTitles();
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:customDataSelect.html.twig',
            array(
                'notArray' => true,
                'data' => $goals,
                'activeValue' => $activeValue,
                'emptyOption' => $emptyOption,
                'emptyOptionTitle' => $emptyOptionTitle,
                'formItemId' => $formItemId,
                'disabled' => $disabled,
                'fromEnum' => true
            )
        );
    }

    private function getTicketsSelect($first = false, $activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -', $formItemId = null, $disabled = false)
    {
        $tickets = DriverTicketType::getHumanTitles();
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:driverTicketsField.html.twig',
            array(
                'data' => $tickets,
                'activeValue' => $activeValue,
                'emptyOption' => $emptyOption,
                'emptyOptionTitle' => $emptyOptionTitle,
                'formItemId' => $formItemId,
                'disabled' => $disabled,
                'fromEnum' => true,
                'first' => $first,
            )
        );
    }    

    private function getContactResultSelect($first = false, $activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -', $formItemId = null, $disabled = false)
    {
        $results = CallReportingStatus::getHumanTitlesMap();
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:customDataSelect.html.twig',
            array(
                'notArray' => true,
                'data' => $results,
                'activeValue' => $activeValue,
                'emptyOption' => $emptyOption,
                'emptyOptionTitle' => $emptyOptionTitle,
                'formItemId' => $formItemId,
                'disabled' => $disabled,
                'fromEnum' => true,
                'first' => $first,
            )
        );
    }

    private function getContactTypeSelect($first = false, $activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -', $formItemId = null, $disabled = false)
    {
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:customDataSelect.html.twig',
            array(
                'notArray' => true,
                'data' => ContactType::getHumanTitlesMapWide(),
                'activeValue' => null,
                'emptyOption' => $emptyOption,
                'emptyOptionTitle' => $emptyOptionTitle,
                'formItemId' => $formItemId,
                'disabled' => $disabled,
                'fromEnum' => true,
                'first' => $first,
            )
        );
    }

    public function getPrioritySelect($activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -', $formItemId = null, $disabled = false)
    {
        $priorities = OpportunityPriority::getHumanTitles();

        return $this->render(
            'ZesharCRMCoreBundle:FormItems:customDataSelect.html.twig',
            array(
                'notArray' => true,
                'data' => $priorities,
                'activeValue' => $activeValue,
                'emptyOption' => $emptyOption,
                'emptyOptionTitle' => $emptyOptionTitle,
                'formItemId' => $formItemId,
                'disabled' => $disabled,
                'fromEnum' => true
            )
        );
    }

    private function getAutoBlock($last = false, $first = false, $single = false, $autoYear = null, $autoMake = null, $autoModel = null, $autoVinNumber = null, $id = null)
    {

        if ($autoModel == null) {
            $empty = true;
        } else {
            $empty = false;
        }
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:leadPrequalificationAutoBlock.html.twig',
            array(
                'last' => $last,
                'first' => $first,
                'autoYear' => $autoYear,
                'autoMake' => $autoMake,
                'autoModel' => $autoModel,
                'autoVinNumber' => $autoVinNumber,
                'empty' => $empty,
                'singleEmpty' => $single,
                'autoId' => $id,
            )
        );


    }

    private function getLeadScoringBlock($object){
      $em = $this->getDoctrine();
      $checkCriteria = array();
      $subject = $em->getRepository('ZesharCRMLeadScoringBundle:LeadScoring')->getLeadScoringByLead($object);

      $firstCriteria = $em->getRepository('ZesharCRMLeadScoringBundle:ScoringCriteria')->findBy(array('parent' => null));
      $checkCriteriaId = unserialize($subject->getScoring());
      $this->showTotal($firstCriteria);
      $em->getRepository('ZesharCRMLeadScoringBundle:LeadScoring')->attachPortions($firstCriteria);


      return $this->render(
        'ZesharCRMCoreBundle:FormItems:leadScoringBlock.html.twig',
        array(
          'rootCriteria' => $firstCriteria,
          'chosen' => $checkCriteriaId,
          'data' => $checkCriteria,

        )
      );
    }

    private function showTotal($entities, $percent = null)
    {
      foreach($entities as $entity){
        if ($percent) {
          $currentPercent = $percent*$entity->getScore()/100;
        } else {
          $currentPercent = $entity->getScore();
        }
        if (count($entity->getChildren()) > 0){
          $this->showTotal($entity->getChildren(),$currentPercent);
        } else {
          $entity->totalScore = $currentPercent;
          $this->total[] = $entity;
        }
      }
    }

    private function getDriverBlock($last = false, $single = false, $name = null, $dob = null, $license = null, $ageLicensed = null, $tickets = null, $id = null)
    {
        if ($name == null) {

            $empty = true;
        } else {
            $empty = false;
        }
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:leadPrequalificationDriverBlock.html.twig',
            array(
                'last' => $last,
                'name' => $name,
                'dob' => $dob,
                'license' => $license,
                'ageLicensed' => $ageLicensed,
                'tickets' => $tickets,
                'empty' => $empty,
                'singleEmpty' => $single,
                'driverId' => $id
            )
        );
    }

    private function getInsuredAddressBlock($previousCarrierPolice = null, $previousCarrierXDate = null, $previousCarrierName = null, $last = false, $single = false, $type = null, $city = null, $address = null, $state = null, $zipCode = null, $id = null)
    {
        if ($type == null) {
            $empty = true;
        } else {
            $empty = false;
        }
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:leadPrequalificationInsuredAddressBlock.html.twig',
            array(
                'last' => $last,
                'singleEmpty' => $single,
                'type' => $type,
                'address' => $address,
                'state' => $state,
                'zipCode' => $zipCode,
                'empty' => $empty,
                'city' => $city,
                'insuredAddressId' => $id,
                'previousCarrierPolice' => $previousCarrierPolice,
                'previousCarrierXDate' => $previousCarrierXDate,
                'previousCarrierName' => $previousCarrierName,
            )
        );
    }

    public function leadSourceSelectAction($activeId = null, $emptyOption = true, $titleProperty = 'title', $emptyOptionTitle = ' - Select One -')
    {
        return call_user_func_array(array($this, 'getEntitySelect'), array_merge(array('ZesharCRMCoreBundle:LeadSource'), func_get_args()));
    }

    public function leadTypeSelectAction($activeId = null, $emptyOption = true, $titleProperty = 'title', $emptyOptionTitle = ' - Select One -')
    {
        return call_user_func_array(array($this, 'getEntitySelect'), array_merge(array('ZesharCRMCoreBundle:LeadType'), func_get_args()));
    }

    public function leadEventTypeSelectAction($activeId = null, $emptyOption = true, $titleProperty = 'title', $emptyOptionTitle = ' - Select One -')
    {
        return call_user_func_array(array($this, 'getEntitySelect'), array_merge(array('ZesharCRMCoreBundle:LeadEventType'), func_get_args()));
    }

    public function contactResultSelectAction($first = false, $activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -')
    {
        return $this->getContactResultSelect($first, $activeValue, $emptyOption, $emptyOptionTitle, 'contact_result');
    }

    public function contactTypeSelectAction($first = false, $activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -')
    {
        return $this->getContactTypeSelect($first, $activeValue, $emptyOption, $emptyOptionTitle, 'contact_type');
    }

    public function leadPrequalificationTicketsSelectAction($first = false, $activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -')
    {
        return $this->getTicketsSelect($first, $activeValue, $emptyOption, $emptyOptionTitle, 'driver_tickets');
    }

    public function leadCategorySelectAction($activeId = null, $emptyOption = true, $titleProperty = 'title', $emptyOptionTitle = ' - Select One -')
    {
        return call_user_func_array(array($this, 'getEntitySelect'), array_merge(array('ZesharCRMCoreBundle:LeadCategory'), func_get_args()));
    }
    
    public function leadCampaignSelectAction($activeId = null, $emptyOption = true, $titleProperty = 'title', $emptyOptionTitle = ' - Select One -', $formItemId = 'leadCampaign', $disabled = false, $additionalParams = null)
    {
        //print_r(func_get_args());die;
        return call_user_func_array(array($this, 'getEntitySelect'), array_merge(array('ZesharCRMCoreBundle:Activity'), func_get_args()));
    }
    
    public function assigneeSelectAction($activeId = null, $emptyOption = true, $titleProperty = 'username', $emptyOptionTitle = ' - Select One -', $formItemId = 'assignee', $disabled = false)
    {
        return call_user_func_array(array($this, 'getEntitySelect'), array_merge(array('ZesharCRMCoreBundle:User'), func_get_args()));
    }

    public function prioritySelectAction($activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -')
    {
        //print_r($activeValue)
        return $this->getPrioritySelect($activeValue, $emptyOption, $emptyOptionTitle, 'priority');
    }

    public function leadPrequalificationYearSelectAction($activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -')
    {
        return $this->getYearSelect($activeValue, $emptyOption, $emptyOptionTitle, 'year');
    }

    public function leadEventGoalSelectAction($activeValue = null, $emptyOption = true, $emptyOptionTitle = ' - Select One -')
    {
        return $this->getGoalSelect($activeValue, $emptyOption, $emptyOptionTitle, 'goal');
    }

    public function leadPrequalificationAutoBlockAction($last = false, $first = false, $single = false, $autoYear = null, $autoMake = null, $autoModel = null, $autoVinNumber = null, $id = null )
    {
        return $this->getAutoBlock($last, $first, $single, $autoYear, $autoMake, $autoModel, $autoVinNumber, $id);
    }

    public function leadPrequalificationDriverBlockAction($last = false, $single = false, $name = null, $dob = null, $license = null, $ageLicensed = null, $tickets = null, $id = null )
    {
        return $this->getDriverBlock($last, $single, $name, $dob, $license, $ageLicensed, $tickets, $id);
    }

    public function leadPrequalificationInsuredAddressBlockAction($previousCarrierPolice = null, $previousCarrierXDate = null, $previousCarrierName = null, $last = false, $single = false, $type = null, $city = null, $address = null, $state = null, $zipCode = null, $id = null )
    {
        return $this->getInsuredAddressBlock($previousCarrierPolice, $previousCarrierXDate, $previousCarrierName, $last, $single, $type, $city, $address, $state, $zipCode, $id);
    }

    public function leadScoringAction($object){
      return $this->getLeadScoringBlock($object);
    }

    public function leadScoringSectionAction($choices, $data){
      return $this->getLeadScoringSectionBlock($choices, $data);
    }
    
    public function contactStatusSelectAction($activeValue = null)
    {
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:contactStatusSelect.html.twig',
            array(
                'activeValue' => $activeValue,
            )
        );
    }
    
    public function leadStatusSelectAction($activeValue = null)
    {
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:leadStatusSelect.html.twig',
            array(
                'activeValue' => $activeValue,
            )
        );
    }

    /*public function leadTypeSelectAction($activeValue = null)
    {
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:leadTypeSelect.html.twig',
            array(
                'activeValue' => $activeValue,
            )
        );
    }*/

    public function insuredAddressesTypeSelectAction($activeValue = null)
    {
        return $this->render(
            'ZesharCRMCoreBundle:FormItems:insuredAddressesTypeSelect.html.twig',
            array(
                'activeValue' => $activeValue,
            )
        );
    }

    public function entityDetailsAction($subject, $type)
    {
        return $this->render(
          'ZesharCRMCoreBundle:FormItems:entityDetails.html.twig',
          array(
            'subject' => $subject,
            'type' => $type,
          )
        );
    }

    private function getLoggedInUser()
    {
        if ($user = $this->container->get('security.context')->getToken()->getUser()) {
            return $user;
        }
        return NULL;
    }
    
}
