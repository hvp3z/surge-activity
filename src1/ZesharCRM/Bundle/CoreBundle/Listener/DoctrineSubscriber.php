<?php
namespace ZesharCRM\Bundle\CoreBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use ZesharCRM\Bundle\CoreBundle\Entity\Opportunity;
use ZesharCRM\Bundle\CoreBundle\Enum\LeadType;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\MilestoneOperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\OpportunityStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\GoalKind;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use ZesharCRM\Bundle\CoreBundle\Entity\Operation;
use ZesharCRM\Bundle\CoreBundle\Entity\MilestoneOperation;
use ZesharCRM\Bundle\CoreBundle\Entity;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

class DoctrineSubscriber implements EventSubscriber
{

    private $container;
    private $operations;
    private $milestoneOperations;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'onFlush',
            'preUpdate',
            'postPersist',
            'postUpdate',
            'postFlush',
            Events::loadClassMetadata,
        );
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof Lead) {

        }
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->linkToLead($entity, $em);
//            if($entity instanceof Entity\Lead){
//                $this->milestoneOperations[] = $this->saveMilestoneOperation(MilestoneOperationType::NEW_LEAD, $entity, $entity->getAssignee());
//                $this->operations[] = $this->saveOperation(OperationType::COLD_LEAD, $entity, $entity->getAssignee());
//            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->linkToLead($entity, $em);
        }
    }

    protected function linkToLead($entity, $em)
    {
        if ($entity instanceof Entity\LeadPrequalificationAuto
          || $entity instanceof Entity\LeadPrequalificationDriver
          || $entity instanceof Entity\LeadPrequalificationInsuredAddress
          || $entity instanceof Entity\LeadAttachment
          || $entity instanceof Entity\LeadEvent
        ) {
            if(method_exists($entity, 'getLead')){
                $leadSubject = $entity->getLead();
                $method = 'setLead';
            } elseif (method_exists($entity, 'getLeadSubject')){
                $leadSubject = $entity->getLead();
                $method = 'setLeadSubject';
            }
            if(isset($leadSubject) && method_exists($leadSubject, 'getLead') && $lead = $leadSubject->getLead()){
                call_user_func(array($entity, $method), $lead);
                $meta = $em->getClassMetadata(get_class($entity));
                $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
            }
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof Lead ) {
            if($args->hasChangedField('type') && (int) $args->getOldValue('type') === (int) LeadType::COLD && ((int) $args->getNewValue('type') === LeadType::WARM || (int) $args->getNewValue('type') === LeadType::HOT )) {
                $this->operations[] = $this->saveOperation(OperationType::COLD_TO_WARM_LEAD, $entity);
            }
            if ($args->hasChangedField('status') && (int) $args->getOldValue('status') === (int) DealStatus::PENDING && (int) $args->getNewValue('status') === DealStatus::CANCELLED) {
                $this->operations[] = $this->saveOperation(OperationType::CANCELLED_LEAD, $entity);
            }
            if ($args->hasChangedField('status') && (int) $args->getOldValue('status') === (int) DealStatus::PENDING && (int) $args->getNewValue('status') === DealStatus::SUCCESS) {
                $this->saveIntermediateLeadTypeOperations($entity);
                $this->operations[] = $this->saveOperation(OperationType::LEAD_TO_OPPORTUNITY, $entity);
                $this->milestoneOperations[] = $this->saveMilestoneOperation(MilestoneOperationType::LEAD_TO_OPPORTUNITY, $entity);
            }
            if ($args->hasChangedField('assignee') && $args->getOldValue('assignee') != $args->getNewValue('assignee') && (int) $entity->getType() === LeadType::COLD) {
                $this->operations[] = $this->saveOperation(OperationType::COLD_LEAD, $entity, $args->getNewValue('assignee'));
            }
            if ($entity->getCreatedAt()->format('U') == $args->getOldValue('updatedAt')->format('U')) {
                $this->milestoneOperations[] = $this->saveMilestoneOperation(MilestoneOperationType::NEW_LEAD, $entity, $entity->getAssignee());
                $this->operations[] = $this->saveOperation(OperationType::COLD_LEAD, $entity, $entity->getAssignee());
            }
        } elseif ($entity instanceof Opportunity && $args->hasChangedField('status')) {
            if ($args->getOldValue('status') === OpportunityStatus::PENDING_OPPORTUNITY && (int) $args->getNewValue('status') === OpportunityStatus::CANCELLED_OPPORTUNITY) {
                $this->operations[] = $this->saveOperation(OperationType::CANCELLED_OPPORTUNITY, $entity);
                $this->milestoneOperations[] = $this->saveMilestoneOperation(MilestoneOperationType::OPPORTUNITY_TO_LEAD, $entity);
            } elseif ($args->getOldValue('status') === OpportunityStatus::PENDING_OPPORTUNITY && (int) $args->getNewValue('status') === OpportunityStatus::PENDING_QUOTE) {
                $this->operations[] = $this->saveOperation(OperationType::OPPORTUNITY_TO_QUOTE, $entity);
                $this->milestoneOperations[] = $this->saveMilestoneOperation(MilestoneOperationType::OPPORTUNITY_TO_QUOTE, $entity);
            } elseif ($args->getOldValue('status') === OpportunityStatus::PENDING_OPPORTUNITY && (int) $args->getNewValue('status') === OpportunityStatus::SUCCESS_QUOTE) {
                $this->operations[] = $this->saveOperation(OperationType::SUCCESS_QUOTE, $entity);
                $this->milestoneOperations[] = $this->saveMilestoneOperation(MilestoneOperationType::SOLD, $entity);
            } elseif ($args->getOldValue('status') === OpportunityStatus::PENDING_QUOTE && (int) $args->getNewValue('status') === OpportunityStatus::PENDING_OPPORTUNITY) {
                $this->operations[] = $this->saveOperation(OperationType::CANCELLED_QUOTE, $entity);
                $this->milestoneOperations[] = $this->saveMilestoneOperation(MilestoneOperationType::QUOTE_TO_OPPORTUNITY, $entity);
            } elseif ($args->getOldValue('status') === OpportunityStatus::PENDING_QUOTE && (int) $args->getNewValue('status') === OpportunityStatus::SUCCESS_QUOTE) {
                $this->operations[] = $this->saveOperation(OperationType::SUCCESS_QUOTE, $entity);
                $this->milestoneOperations[] = $this->saveMilestoneOperation(MilestoneOperationType::SOLD, $entity);
            } elseif ($args->getOldValue('status') === OpportunityStatus::SUCCESS_QUOTE && (int) $args->getNewValue('status') === OpportunityStatus::WIN_BACK) {
                $this->operations[] = $this->saveOperation(OperationType::WIN_BACK_QUOTE, $entity);
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        if(!empty($this->operations)) {
            $em = $args->getEntityManager();
            foreach ($this->operations as $operation) {
                if($operation->getOperationType() == OperationType::SUCCESS_QUOTE) {
                    $dispatcher = $this->container->get('event_dispatcher');
                    $dispatcher->dispatch('goal.increase');
                }
                $em->persist($operation);
            }

            if(!empty($this->milestoneOperations) && (is_array($this->milestoneOperations) || is_object($this->milestoneOperations))){
                foreach ($this->milestoneOperations as $milestoneOperation) {
                    $em->persist($milestoneOperation);
                }
            }

            $this->operations = [];
            $this->milestoneOperations = [];
            $em->flush();
        }
    }

    private function saveIntermediateLeadTypeOperations($entity)
    {
        $leadType = $entity->getType();

        switch ($leadType) {
            case LeadType::COLD :
                $this->operations[] = $this->saveOperation(OperationType::COLD_TO_WARM_LEAD, $entity);
                $this->operations[] = $this->saveOperation(OperationType::HOT_LEAD, $entity);
                break;
            case LeadType::WARM :
                $this->operations[] = $this->saveOperation(OperationType::HOT_LEAD, $entity);
        }
    }

    private function saveOperation($type, $leadSubject, $performer = null)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $roles = $user->getRoles();
        if(in_array('ROLE_SUPER_ADMIN', $roles)){
            $userAssignee = $leadSubject->getAssignee();
            $user = $userAssignee ? $userAssignee : $user;
        }

        $entity = new Operation();
        $entity->setPerformedAt(new \DateTime('now'));
        $entity->setEntity($leadSubject);
        $entity->setPerformer($performer ?: $user);
        $entity->setOperationType($type);
        return $entity;
    }

    private function saveMilestoneOperation($type, $leadSubject, $performer = null)
    {
        //var_dump($entityId);die;
        $entity = new MilestoneOperation();
        $entity->setPerformedAt(new \DateTime('now'));
        $entity->setLeadSubject($leadSubject);
        $entity->setPerformer($performer ?: $this->container->get('security.context')->getToken()->getUser());
        $entity->setOperationType($type);
        return $entity;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        // the $metadata is the whole mapping info for this class
        $metadata = $eventArgs->getClassMetadata();

        $namingStrategy = $eventArgs
            ->getEntityManager()
            ->getConfiguration()
            ->getNamingStrategy()
        ;

        $bandles = $this->container->getParameter('kernel.bundles');

        if ($metadata->getName() != 'ZesharCRM\Bundle\CoreBundle\Entity\LeadSubject' || !isset($bandles['ZesharCRMLeadScoringBundle'])) {
            return;
        }

        $metadata->mapOneToOne(array(
            'targetEntity' => 'ZesharCRM\Bundle\LeadScoringBundle\Entity\LeadScoring',
            'mappedBy' => 'opportunity',
            'fieldName'     => 'scoring',
            'joinColumn' => array(
                'name'                  => 'opportunity_id',
                'referencedColumnName'  => $namingStrategy->referenceColumnName(),
            ),
        ));
    }
}