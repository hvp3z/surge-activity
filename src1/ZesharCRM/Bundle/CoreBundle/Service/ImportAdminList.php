<?php

namespace ZesharCRM\Bundle\CoreBundle\Service;

use Symfony\Component\HttpFoundation\Response;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use ZesharCRM\Bundle\CoreBundle\Helper\CSVTypes;

class ImportAdminList extends BaseBlockService
{

    private $container = null;

    public function __construct($name, $templating, $container=null)
    {
        parent::__construct($name, $templating);
        $this->container = $container;  
    }

    public function getName()
    {
        return 'Import CSV';
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

        $curBlock = 'ZesharCRMCoreBundle:Block:block_admin_list.html.twig';
        if (!$this->container->get('security.context')->isGranted("ROLE_SUPER_ADMIN")) {
            $curBlock = 'ZesharCRMCoreBundle:Block:block_empty.html.twig';
        }

        return $this->renderResponse($curBlock, array(
            'block'     => $blockContext->getBlock(),
            'allTypes'  => CSVTypes::getTypesAndIds(),
            'settings'  => $settings,
            'groups' => $this->container->get('sonata.admin.pool')->getDashboardGroups(),
            ), $response);
    }
}
