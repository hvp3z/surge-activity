<?php

namespace ZesharCRM\Bundle\CoreBundle\Listener;

use Symfony\Component\Security\Http\Logout\DefaultLogoutSuccessHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\HttpUtils;
use ZesharCRM\Bundle\CoreBundle\Entity\Log;
use ZesharCRM\Bundle\CoreBundle\Enum\LogType;

class LogoutHandler extends DefaultLogoutSuccessHandler
{

    protected $httpUtils;
    protected $targetUrl;

    /**
     * @param HttpUtils $httpUtils
     * @param string    $targetUrl
     */
    public function __construct(HttpUtils $httpUtils, $security, $container)
    {
        $this->httpUtils = $httpUtils;

        $this->targetUrl = '/';

        $this->security = $security;
        $this->container = $container;


    }

    /**
     * {@inheritdoc}
     */
    public function onLogoutSuccess(Request $request)
    {
        if($this->security->getToken()){
            $user = $this->security->getToken()->getUser();
            $em = $this->container->get('doctrine.orm.entity_manager');
            $logAction = new Log();
            $logAction
                ->setPerformer($user)
                ->setOperationType(LogType::LOGOUT);

            $em->persist($logAction);
            $em->flush();
        }

        return $this->httpUtils->createRedirectResponse($request, $this->targetUrl);
    }

}
 