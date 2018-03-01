<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class LeadScoringAdmin extends Admin
{
    private $total =array();
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('total')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('lead.name')
            ->add('opportunity.name')
            ->add('total', null, array(
                'label' => 'Score'
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $checkCriteria = array();
        $subject = $this->getSubject();
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine');
        $firstCriteria = $em->getRepository('ZesharCRMLeadScoringBundle:ScoringCriteria')->findBy(array('parent' => null));
        $checkCriteriaId = unserialize($subject->getScoring());
        $this->showTotal($firstCriteria);

        if (is_array($checkCriteriaId)) {
            foreach ($this->total as $value) {
                if (in_array($value->getId(), $checkCriteriaId)) {
                    array_push($checkCriteria,$value);
                }
            }
        }

        $formMapper
            ->add('criteria', 'entity', array(
                'expanded' => true,
                'multiple' => true,
                'mapped' => false,
                'class' => 'ZesharCRMLeadScoringBundle:ScoringCriteria',
                'choices' => $this->total,
                'data' => $checkCriteria
            ))
            ->add('total',null,array(
                'read_only' => true
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('lead.name')
            ->add('opportunity.name')
            ->add('total', null, array(
                'label' => 'Score'
            ))
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('scoring', 'scoring');
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

    public function preUpdate($object)
    {
        $scoring = array();
        $totalScore = 0;

        $data = $this->getForm()->get('criteria')->getData();

        foreach($data as $value ){
            array_push($scoring,$value->getId());
            $totalScore += $value->totalScore;
        }
        $object->setTotal($totalScore);
        $object->setScoring(serialize($scoring));
        unset($this->total);
    }

}
