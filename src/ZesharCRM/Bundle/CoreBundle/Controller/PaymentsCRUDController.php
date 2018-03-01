<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ZesharCRM\Bundle\CoreBundle\Enum\BillingSubscriptionProducts;
use ZesharCRM\Bundle\CoreBundle\Enum\BillingSubscriptionStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\CreditCardTypes;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;

class PaymentsCRUDController extends CRUDController
{

}