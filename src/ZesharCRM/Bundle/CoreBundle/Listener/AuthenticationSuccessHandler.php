<?php

namespace ZesharCRM\Bundle\CoreBundle\Listener;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    protected $router;
    protected $security;
    protected $container;

    public function __construct( HttpUtils $httpUtils, array $options, Router $router, SecurityContext $security, Container $container)
    {
        $this->router = $router;
        $this->security = $security;
        $this->container = $container;
        parent::__construct( $httpUtils, $options );
    }

    public function onAuthenticationSuccess( Request $request, TokenInterface $token )
    {
        $url = 'dashboard';
        $user = $this->security->getToken()->getUser();

        $checkSubscription = false;
        if ($this->security->isGranted('ROLE_SUPER_ADMIN') && (!$this->security->isGranted('ROLE_ULTRA_ADMIN') && !$user->getId() == 125)) {
            $checkSubscription = true;
        } elseif (!$this->security->isGranted('ROLE_ULTRA_ADMIN')) {
            if ($user->getId() == 125) {
                return  new RedirectResponse($this->router->generate($url));
            }
            // it's sale or anyone else...
            $company = $user->getCompany();
            // get admin of this company
            $users = $company->getUsers();
            $finalUsers = $this->getUsersByRole($users, 'ROLE_SUPER_ADMIN');
            if(!empty($finalUsers)){
                $user = $finalUsers[0];
                $checkSubscription = true;
            }
        }

        if (is_object($user) && in_array('ROLE_SALES_PERSON', $user->getRoles()) && $this->isAdminDisabled($user)) {
            $ex = new AccountExpiredException(
                    'Sorry, Something is not working right!!' .
                    "\n" .
                    'Please contact your systems administrator!'
                );
            $ex->setUser($user);
            throw $ex;
        }

        $ADNService = $this->container->get('zeshar_crm_core.adn');
        //$this->checkPayment($user, $ADNService);

        if ($checkSubscription) {
            $billingInfo = $user->getBillingInfo();
            if (!empty($billingInfo)) {
                $billingInfo = $billingInfo[0];
            }

            // check user billing subscription status\
            $subscription = $ADNService->ADNGetSubscription($user, $billingInfo);

            if ($subscription['success']) {
                $subscriptionStatus = $subscription['subscriptionStatus'];

                // if everything is OK , redirect him to the dashboard
                // if not, set ROLE_DISABLED_ADMIN role, set disabled, set billing status into inactive
                if ($subscriptionStatus != 'expired' /*$subscriptionStatus == 'active'*/){
                    return  new RedirectResponse($this->router->generate($url));
                } else {
                    $em = $this->container->get('doctrine.orm.entity_manager');
                    $billingInfo->setSubscriptionStatus(0);

                    $user->setRoles(array('ROLE_DISABLED_ADMIN'));
                    $user->setDisabled(1);

                    $em->persist($user);
                    $em->persist($billingInfo);
                    $em->flush();

                    return new RedirectResponse($this->router->generate('account_show', array('id' => $user->getId())));
                }
            } else {
                return new RedirectResponse( $this->router->generate( 'sonata_user_admin_security_logout' ) );
            }
        }

        if ($this->security->isGranted('ROLE_DISABLED_ADMIN')) {
            return new RedirectResponse($this->router->generate('account_show', array('id' => $user->getId())));
        }
        $response = new RedirectResponse($this->router->generate($url));

        return $response;
    }

    private function getUsersByRole($users, $role)
    {
        $finalUsers = array();

        foreach($users as $key => $user){
            $roles = $user->getRoles();
            if(in_array($role, $roles)){
                $finalUsers[] = $user;
            }
        }

        return $finalUsers;
    }


    private function checkPayment($user, $ADNService)
    {
        //$ADNService->ADNGetSettledBatchList();
    }

    private function isAdminDisabled($user) {
        $company = $user->getCompany();
        $users = $company->getUsers();
        $disabledAdmin = $this->getUsersByRole($users, 'ROLE_DISABLED_ADMIN');
        return isset($disabledAdmin);
    }

}