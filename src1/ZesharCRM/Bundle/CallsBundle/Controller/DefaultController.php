<?php

namespace ZesharCRM\Bundle\CallsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ZesharCRMCallsBundle:Default:index.html.twig', array('name' => $name));
    }
}
