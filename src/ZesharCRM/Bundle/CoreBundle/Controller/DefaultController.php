<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function profileInfoAction()
    {
        if ( ($user = $this->get('security.context')->getToken()->getUser()) && (is_object($user)) ) {
            return $this->render('ZesharCRMCoreBundle:Default:profile-info.html.twig', array('username' => $user->getUsername()));
        } else {
            throw $this->createNotFoundException('No user is logged in');
        }
    }
    
}
