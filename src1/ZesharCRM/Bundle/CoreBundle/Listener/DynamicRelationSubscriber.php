<?php
//
//namespace ZesharCRM\Bundle\CoreBundle\Listener;
//
//use Doctrine\Common\EventSubscriber;
//use Doctrine\ORM\Events;
//use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
//use Symfony\Component\DependencyInjection\ContainerInterface;
//use ZesharCRM\Bundle\GoalsBundle\Entity\Goal;
//
//class DynamicRelationSubscriber implements EventSubscriber{
//
//    private $container;
//
//
//    public function __construct(ContainerInterface $container)
//    {
//        $this->container = $container;
//    }
//
//    public function getSubscribedEvents()
//    {
//        return array(
//            Events::loadClassMetadata,
//        );
//    }
//
//    /**
//     * @param LoadClassMetadataEventArgs $eventArgs
//     */
//    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
//    {
//        $bundles = $this->container->getParameter('kernel.bundles');
//
//        // the $metadata is the whole mapping info for this class
//        $metadata = $eventArgs->getClassMetadata();
//
//        if ($metadata->getName() != 'ZesharCRM\Bundle\CoreBundle\Entity\LeadCategory' ) {
//            return;
//        }
//
//        $namingStrategy = $eventArgs
//            ->getEntityManager()
//            ->getConfiguration()
//            ->getNamingStrategy()
//        ;
//
//        $metadata->mapOneToOne(array(
//            'targetEntity'  => 'ZesharCRM\Bundle\GoalsBundle\Entity\Goal',
//            'fieldName'     => 'goal',
//            'inversedBy'     => 'goalCategory',
//            'joinColumns' => array(
//                array(
//                    'name'                  => 'goal',
//                    'referencedColumnName'  => 'id',
//                ),
//            ),
//        ));
//
//       // print_r($metadata);die;
//    }
//}