<?php

namespace ZesharCRM\Bundle\CoreBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Entity\Opportunity;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use Doctrine\ORM\EntityManager;

class LeadSubject
{

    /** @var ContainerInterface  */
    private $container;
    /** @var EntityManager  */
    private $em;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function getNextId($entity, $leadCampaign = '')
    {
        $entityId = $entity->getId();
        if ($entity instanceof Lead ) {
            $query = $this->em->createQueryBuilder()
                ->select('MIN(l.id)')
                ->from('ZesharCRMCoreBundle:Lead', 'l')
                ->where('l.id > :id')
                ->andWhere('l.status = :status')
                ->andWhere('l.deletedAt IS NULL')
                ->setParameter('id' , $entityId)
                ->setParameter('status', 1);
            if ($leadCampaign) {
                $query->andWhere('l.leadCampaign = :leadCampaign')
                    ->setParameter('leadCampaign', $leadCampaign);
            }
            $id = $query
                ->getQuery()
                ->getSingleResult();//print_r($id);die;
        } elseif ($entity instanceof Opportunity) {

            $id = $this->em->createQueryBuilder()
                ->select('MIN(l.id)')
                ->from('ZesharCRMCoreBundle:Opportunity', 'l')
                ->where('l.id > :id')
                ->andWhere('l.deletedAt IS NULL')
                ->setParameter('id', $entityId)
                //->setMaxResults(1)
                ->getQuery()
                ->getSingleResult();

        } else {
            return null;
        }


        return $id[1];
    }

    public function getPreviousId($entity, $leadCampaign = '')
    {
        $entityId = $entity->getId();
        if ($entity instanceof Lead ) {
            $query = $this->em->createQueryBuilder()
                ->select('MAX(l.id)')
                ->from('ZesharCRMCoreBundle:Lead', 'l')
                ->where('l.id < :id')
                ->andWhere('l.status = :status')
                ->andWhere('l.deletedAt IS NULL')
                ->setParameters(array('id' => $entityId, 'status' => 1));
            if ($leadCampaign) {
                $query->andWhere('l.leadCampaign = :leadCampaign')
                    ->setParameter('leadCampaign', $leadCampaign);
            };
            $id = $query
                ->getQuery()
                ->getSingleResult();
        } elseif ($entity instanceof Opportunity) {
            $id = $this->em->createQueryBuilder()
                ->select('MAX(l.id)')
                ->from('ZesharCRMCoreBundle:Opportunity', 'l')
                ->where('l.id < :id')
                ->andWhere('l.deletedAt IS NULL')
                ->setParameter('id', $entityId)
                ->getQuery()
                ->getSingleResult();
        } else {
            return null;
        }

        return $id[1];
    }

    public function checkType($entity)
    {
        if ($entity instanceof Lead || $entity instanceof Opportunity) {
            return true;
        } else {
            return false;
        }
    }

    public function getLeadScoringByLead($leadSubject)
    {
        $bandles = $this->container->getParameter('kernel.bundles');
        if (isset($bandles['ZesharCRMLeadScoringBundle'])) {
            if ($leadSubject instanceof Opportunity) {
                $lead = $leadSubject->getLead();
            } else {
                $lead = $leadSubject;
            }
            $entity = $this->em->getRepository('ZesharCRMLeadScoringBundle:LeadScoring')->findOneBy(array('lead' => $lead->getId()));
            return $entity;
        } else {
            return false;
        }
    }
}