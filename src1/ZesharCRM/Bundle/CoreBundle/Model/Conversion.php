<?php

namespace ZesharCRM\Bundle\CoreBundle\Model;

use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\ConversionType;

/**
 * Class Conversion
 *  The logic in the conversation rate per user is: If I have 100 quotes, and I convert 10 to Sold, my conversion rate would be 10% (10/100)
    a) Quotes Conversion  rate = Sale/Quotes (%)
    b) Opportunity Conversion  rate = Quotes/Opportunity(%)
    c) Warm Leads Conversion  rate = Opportunities/ Warm Leads (%)
    d) Cold Leads Conversion  rate = Warm Leads/Cold Leads (%)

 *
 *
 * @package ZesharCRM\Bundle\CoreBundle\Model
 */
class Conversion
{
    protected $conversionTypes = array();
    protected $converstionPairs = array();


    protected $container;

    public function __construct($container){
        $this->container = $container;
        $this->conversionTypes = array(
            OperationType::COLD_TO_WARM_LEAD,
            OperationType::LEAD_TO_OPPORTUNITY,
            OperationType::OPPORTUNITY_TO_QUOTE,
            OperationType::SUCCESS_QUOTE,
        );

        $this->conversionPairs = array(
          ConversionType::QUOTES_CONVERSION_RATE => array(OperationType::SUCCESS_QUOTE, OperationType::OPPORTUNITY_TO_QUOTE),
          ConversionType::OPPORTUNITY_CONVERSION_RATE => array(OperationType::OPPORTUNITY_TO_QUOTE, OperationType::LEAD_TO_OPPORTUNITY),
          ConversionType::WARM_LEADS_CONVERSION_RATE => array(OperationType::LEAD_TO_OPPORTUNITY, OperationType::COLD_TO_WARM_LEAD),
          ConversionType::COLD_LEADS_CONVERSION_RATE => array(OperationType::COLD_TO_WARM_LEAD, OperationType::COLD_BECAME_ACTIVE),
        );


    }

    public function getConversion(){

        $data = array();

        foreach($this->conversionPairs as $type => $conversion){
            $data[$type] = $this->getRates( $conversion[0], $conversion[1]);
        }
        return  $this->transformConversionByUser($data);
    }

    protected function getRates($type1, $type2){
        $currentUser = $this->container->get('security.context')->getToken()->getUser();

        $em = $this->container->get('doctrine.orm.entity_manager');
        $set = $em->getRepository('ZesharCRMCoreBundle:Operation')->getOperationsPerUser( $type1, $type2, $currentUser);
        $normalizeFunction = function($value){
//            $value['title'] = $value['entity']->getTitle();

            $value['percent'] = $this->getPercent($value['type1Count'], $value['type2Count']);
            return $value;
        };


        $set = array_map(function($value) use ($type1, $type2, $normalizeFunction){
              $user = $value['user'];
              $value['percent'] = $this->getPercent($value['type1Count'], $value['type2Count']);
              $user->productSet = array_map($normalizeFunction,
                $this->getRatesForEntityType($type1, $type2, $user, 'LeadCategory'));

              $user->sourceSet = array_map($normalizeFunction,
                $this->getRatesForEntityType($type1, $type2, $user, 'LeadSource'));
              $user->campaignSet = array_map($normalizeFunction,
                $this->getRatesForEntityType($type1, $type2, $user, 'Activity'));

              return $value;
          }, $set);
        return $set;

    }

    protected function getRatesForEntityType($type1, $type2, $user, $entityName){
        $em = $this->container->get('doctrine.orm.entity_manager');
        return $em->getRepository('ZesharCRMCoreBundle:Operation')->getOperationsPerEntityByUser($type1, $type2, $user, $entityName);
    }


    protected function getPercent($a, $b){
        if($b == 0){
            return $a == 0 ? 'N/A' : 'Inf';
        }

        return sprintf('%.2f', $a / $b * 100) . '%';
    }

    protected function transformConversionByUser($data){
        $resultingSet = array();


        foreach($data as $type => $dataSet){
            foreach($dataSet as $userSet){
                $uId = $userSet['user']->getId();
//                unset($userSet['user']);
                $resultingSet[$uId][$type] = $userSet;

            }

        }

        $normalizedSet = array();
        foreach($resultingSet as $uId => $row){
            $entry = array();

            foreach($row as $transitionType => $results){
                if(!isset($entry['user'])){
                    $entry['user'] = $results['user'];
                }
                $entry[$transitionType] = $results['percent'];
            }

            $productSet = array();
            $sourceSet = array();
            $campaignSet = array();
            foreach($row as $transitionType => $results){
                $user = $results['user'];

                $productSet[$transitionType] = $user->productSet;
                $sourceSet[$transitionType] = $user->sourceSet;
                $campaignSet[$transitionType] = $user->campaignSet;
            }

            $entry['user']->productTable = $this->makeRows($this->mergeSet($productSet));
            $entry['user']->sourceTable = $this->makeRows($this->mergeSet($sourceSet));
            $entry['user']->campaignTable = $this->makeRows($this->mergeSet($campaignSet));

            $normalizedSet[] = $entry;

        }
        return $normalizedSet;
    }


    protected function mergeSet($set){
        $mergedSet = array();
        foreach($set as $transitionType => $entitySet){
            if($entitySet){
                foreach($entitySet as $row){
                    $eId = $row['entity']->getId();

                    $mergedSet[$eId][$transitionType] = $row;
                }

            }


        }
        return $mergedSet;
    }

    protected function makeRows($set){
        $normalizedSet = array();
        foreach($set as $eId => $row){
            $entry = array();

            foreach($row as $transitionType => $results){
                if(!isset($entry['entity'])){
                    $entry['entity'] = $results['entity'];
                }
                $entry[$transitionType] = $results['percent'];
            }


            $normalizedSet[] = $entry;

        }
        return $normalizedSet;
    }








}