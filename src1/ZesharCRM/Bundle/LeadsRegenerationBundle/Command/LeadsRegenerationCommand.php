<?php

namespace ZesharCRM\Bundle\LeadsRegenerationBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ZesharCRM\Bundle\CoreBundle\Enum\DealStatus;

class LeadsRegenerationCommand extends ContainerAwareCommand{

    protected function configure()
    {
        $this
            ->setName('leads:regeneration')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        date_default_timezone_set('UTC');
        $text = '';
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $entities = $em->getRepository('ZesharCRMLeadsRegenerationBundle:LeadsRegeneration')->findRegenerationLeads();
        foreach($entities as $entity) {
            $lead = $entity->getLead();
            $lead->setStatus(DealStatus::PENDING);
            $text .= $lead->getName();
            $em->persist($lead);
            $em->remove($entity);
        }
        $em->flush();
        $output->writeln($text);
    }

} 