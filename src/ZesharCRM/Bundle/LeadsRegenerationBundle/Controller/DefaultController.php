<?php

namespace ZesharCRM\Bundle\LeadsRegenerationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ZesharCRMLeadsRegenerationBundle:Default:index.html.twig', array('name' => $name));
    }
}
