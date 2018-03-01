<?php

namespace ZesharCRM\Bundle\LeadsRegenerationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Controller\CoreController;
use ZesharCRM\Bundle\CoreBundle\Entity\Lead;
use ZesharCRM\Bundle\CoreBundle\Entity\Opportunity;

class CrossSellAdminController extends CoreController
{
    public function crossSellAction(Request $request)
    {
        $dr = $this->getDoctrine();

        $contactCardId = $request->get('card');

        $contactCard = $dr->getRepository('ZesharCRMCoreBundle:ContactCard')->findOneById($contactCardId);

        $lead = $dr->getRepository('ZesharCRMCoreBundle:Lead')->findBy(array('contactCard' => $contactCard));

        $opportunity = $dr->getRepository('ZesharCRMCoreBundle:Opportunity')->findBy(array('contactCard' => $contactCard));

        $products = $dr->getRepository('ZesharCRMCoreBundle:LeadCategory')->findAll();

        $product = array_diff($products,array_unique(array_merge($this->getCategory($lead),$this->getCategory($opportunity))));

        return $this->render('ZesharCRMLeadsRegenerationBundle:CrossSell:crosssell.html.twig', array(
            'base_template'   => $this->getBaseTemplate(),
            'admin_pool'      => $this->container->get('sonata.admin.pool'),
            'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'),
            'product'         => $product,
            'card'            => $contactCardId
        ));
    }

    public function generateLeadAction (Request $request)
    {
        $dr = $this->getDoctrine();

        $productId = $request->get('product');

        $contactCardId = $request->get('card');

        $user = $this->getUser();

        $contactCard = $dr->getRepository('ZesharCRMCoreBundle:ContactCard')->findOneById($contactCardId);

        $product = $dr->getRepository('ZesharCRMCoreBundle:LeadCategory')->findOneById($productId);

        $lead = $dr->getRepository('ZesharCRMCoreBundle:Lead')->createLead($contactCard,$product,$user);

        return new RedirectResponse($this->generateUrl('sonata_admin_crosssell',array('card'=> $contactCardId)));
    }

    private function getCategory ($entities)
    {
        $category = array();

        foreach($entities as $entity) {

            if ($entity instanceof Lead ) {

                $category[] = $entity->getLeadCategory();

            } elseif ($entity instanceof Opportunity) {

                $category[] = $entity->getOpportunityCategory();

            }
        }
        return $category;
    }
}
