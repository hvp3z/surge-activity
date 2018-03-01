<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ReportsController extends Controller
{

    public function userPerformanceAction()
    {
        $adminPool  = $this->get('sonata.admin.pool');

        $reportManager = $this->get('zeshar_crm_core.admin.report_manager');
        $user = (!in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) ? $this->getUser() : null;
        $set = $reportManager->getLeadReport($user);
        return $this->render(
          'ZesharCRMCoreBundle:Reports:list.html.twig',
          array(
            'pageTitle' => 'Lead Performance',
            'admin_pool' => $adminPool,
            'base_template' => $adminPool->getTemplate('layout'),
            'dataSet' => $set['data'],
            'header' => $set['header'],
            'rangeFrom' => $reportManager->getFrom(),
            'rangeTo' => $reportManager->getTo(),
          )
        );
    }

    public function userConversionAction()
    {
//        $admin_pool = $this->get('sonata.admin.pool');
//
//        $parameters['admin']         = isset($parameters['admin']) ? $parameters['admin'] : $this->admin;
//        $parameters['base_template'] = isset($parameters['base_template']) ? $parameters['base_template'] : $this->getBaseTemplate();

        /**@var  \Sonata\AdminBundle\Admin\Pool $adminPool */
        $adminPool  = $this->get('sonata.admin.pool');

        /**
         * @var \ZesharCRM\Bundle\CoreBundle\Model\Report $reportManager
         */
        $reportManager = $this->get('zeshar_crm_core.admin.report_manager');
        $set = $reportManager->getConversionReport();
        $set = $this->filterSet($set);

//        $data = array(array('1', 'asfd', '23423', 'opp'),array('1', 'asfd', '23423', 'opp'),array('1', 'asfd', '23423', 'opp'));//$reportManager->getData();
        return $this->render(
          'ZesharCRMCoreBundle:Reports:conversion.html.twig',
          array(
            'pageTitle' => 'Conversion Rate',
            'admin_pool' => $adminPool,
            'base_template' => $adminPool->getTemplate('layout'),
            'dataSet' => $set['data'],
            'header' => $set['header'],
            'rangeFrom' => $reportManager->getFrom(),
            'rangeTo' => $reportManager->getTo(),
          )
        );
    }

    public function userAuditAction()
    {
        /**@var  \Sonata\AdminBundle\Admin\Pool $adminPool */
        $adminPool  = $this->get('sonata.admin.pool');

        /**
         * @var \ZesharCRM\Bundle\CoreBundle\Model\Report $reportManager
         */
        $reportManager = $this->get('zeshar_crm_core.admin.report_manager');

        $set = $reportManager->getAuditReport();

        return $this->render(
            'ZesharCRMCoreBundle:Reports:audit_report.html.twig',
            array(
                'admin_pool' => $adminPool,
                'rangeFrom' => $reportManager->getFrom(),
                'rangeTo' => $reportManager->getTo(),
            ));
    }


    private function filterSet($set)
    {
        $data = $set['data'];

        if(!empty($data)){
            foreach($data as $k=>$d){
                $userData = reset($d);
                if(!empty($userData)){
                    $productData = $this->filter($userData->productTable);
                    $userData->productTable = $productData;
                    $sourceData = $this->filter($userData->sourceTable);
                    $userData->sourceTable = $sourceData;
                    $campaignData = $this->filter($userData->campaignTable);
                    $userData->campaignTable = $campaignData;
                }
                $allNA = true;
                for($i=1; $i<count($d); $i++){
                    $str = $d[$i];
                    if($str != 'N/A'){
                        $allNA = false;
                    }
                }
                if($allNA){
                    unset($data[$k]);
                }
            }
            $set['data'] = array_values($data);
        }

        return $set;
    }

    private function filter($dataArr)
    {
        $removeKeys = array();

        if(!empty($dataArr)){
            foreach($dataArr as $k=>$data){
                $allNA = true;
                for($i=1; $i<count($data); $i++){
                    $str = $data[$i];
                    if($str != 'N/A'){
                        $allNA = false;
                    }
                }

                if($allNA){
                    unset($dataArr[$k]);
                }
            }
        }

        return array_values($dataArr);
    }

}
