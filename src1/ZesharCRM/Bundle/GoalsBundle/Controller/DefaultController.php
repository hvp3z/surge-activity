<?php

namespace ZesharCRM\Bundle\GoalsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ZesharCRMGoalsBundle:Default:index.html.twig', array('name' => $name));
    }
}
