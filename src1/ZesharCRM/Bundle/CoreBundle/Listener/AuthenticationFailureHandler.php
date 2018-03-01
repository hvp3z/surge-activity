<?php

namespace ZesharCRM\Bundle\CoreBundle\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\HttpUtils;

class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler {

    public function __construct( HttpKernelInterface $httpKernel, HttpUtils $httpUtils, array $options, LoggerInterface $logger = null ) {
        parent::__construct( $httpKernel, $httpUtils, $options, $logger );
    }

    public function onAuthenticationFailure( Request $request, AuthenticationException $exception ) {
        if( $request->isXmlHttpRequest() ) {
            $response = new JsonResponse( array( 'success' => false, 'message' => $exception->getMessage() ) );
        } else {
            $response = parent::onAuthenticationFailure( $request, $exception );
        }
        return $response;
    }
}