<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use ZesharCRM\Bundle\CoreBundle\Enum\ActivityStatus;

use Sonata\AdminBundle\Controller\CRUDController as CRUDController;
use ZesharCRM\Bundle\CoreBundle\Enum\BillingSubscriptionProducts;
use ZesharCRM\Bundle\CoreBundle\Enum\BillingSubscriptionStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\CreditCardTypes;

use Symfony\Component\HttpFoundation\Request;

class AccountCRUDController extends CRUDController
{

    /**
     * Create action.
     *
     * @return Response
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function createAction()
    {
        // the key used to lookup the template
        $templateKey = 'edit';

        if (false === $this->admin->isGranted('CREATE')) {
            throw new AccessDeniedException();
        }

        $object = $this->admin->getNewInstance();

        $this->admin->setSubject($object);

        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
        $form->setData($object);

        if ($this->getRestMethod() == 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {
                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }

                try {
                    $object = $this->admin->create($object);

                    if ($this->isXmlHttpRequest()) {
                        return $this->renderJson(array(
                            'result'   => 'ok',
                            'objectId' => $this->admin->getNormalizedIdentifier($object),
                        ));
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->admin->trans(
                            'flash_create_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch (ModelManagerException $e) {
                    //$this->logModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->admin->trans(
                            'flash_create_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ($this->isPreviewRequested()) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());


        $menuBuilder = $this->container->get('zeshar_crm_core.menu_builder');
        $menu = $menuBuilder->createMainMenu($this->get('request'));

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form'   => $view,
            'object' => $object,
            'menu' => $menu
        ));
    }

    public function showAction($id = null)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

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

        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFormTheme());


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
