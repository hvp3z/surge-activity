<?php

namespace ZesharCRM\Bundle\CoreBundle\Service;

use Symfony\Component\HttpFoundation\Response;


use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;

class DeletedLeadListBlockService extends BaseBlockService
{
    private $container = null;

    public function __construct($name, $templating, $container=null)
    {
        parent::__construct($name, $templating);
        $this->container = $container;
    }

    public function getName()
    {
        return 'Deleted Elements';
    }

    public function getDefaultSettings()
    {
        return array();
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = array_merge($this->getDefaultSettings(), $blockContext->getSettings());

        $curBlock = 'ZesharCRMCoreBundle:Block:block_deleted_lead_list.html.twig';
        if (!$this->container->get('security.context')->isGranted("ROLE_SUPER_ADMIN")) {
            $curBlock = 'ZesharCRMCoreBundle:Block:block_empty.html.twig';
        }

        $entityAdmin = $this->container->get('zeshar_crm_core.admin.lead');

        $link = $entityAdmin->generateUrl('listDeleted');

        return $this->renderResponse($curBlock, array(
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings,
            'link'  => $link
        ), $response);
    }
}