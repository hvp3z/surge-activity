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

class BillingCRUDController extends CRUDController
{
    public function showAction($id = null)
    {

        $id = $this->get('request')->get($this->admin->getIdParameter());

        $user = $this->container->get('security.context')->getToken()->getUser();

        $object = $this->admin->getObject($id);

        if ($object->getCreator()->getId() != $user->getId()) {
            throw new AccessDeniedException();
        }

        if (false === $this->admin->isGranted('VIEW', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        $form = $this->admin->getForm();
        $form->setData($object);
        $formView = $form->createView();

        $products = $this->getDoctrine()->getManager()->getRepository('ZesharCRMCoreBundle:Product')->findAll();
        $productArr = array();

        if(!empty($products)) {
            foreach($products as $key=>$product) {
                $productArr[$key]['id'] = $product->getId();
                $productArr[$key]['name'] = $product->getName();
                $productArr[$key]['mRate'] = $product->getMonthlyRate();
                $productArr[$key]['yRate'] = $product->getYearlyRate();
            }
        }


        return $this->render($this->admin->getTemplate('show'), array(
            'action'   => 'show',
            'object'   => $object,
            'products' => $productArr,
            'statuses' => BillingSubscriptionStatus::getHumanTitlesMap(),
            'cards' => CreditCardTypes::getHumanTitlesMap(),
            'form' => $formView,
            'elements' => $this->admin->getShow()
        ));
    }
}