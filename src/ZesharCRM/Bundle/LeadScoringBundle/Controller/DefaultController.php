<?php

namespace ZesharCRM\Bundle\LeadScoringBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ZesharCRMLeadScoringBundle:Default:index.html.twig', array('name' => $name));
    }
}
