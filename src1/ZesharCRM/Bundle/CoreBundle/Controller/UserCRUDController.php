<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use ZesharCRM\Bundle\CoreBundle\Entity\User;

class UserCRUDController extends CRUDController
{

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

        if ($this->getRestMethod()== 'POST') {
            $form->submit($this->get('request'));

            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ($isFormValid && (!$this->isInPreviewMode() || $this->isPreviewApproved())) {

                if (false === $this->admin->isGranted('CREATE', $object)) {
                    throw new AccessDeniedException();
                }

                /** @var $em \Doctrine\ORM\EntityManager */
                $em = $this->getDoctrine()->getManager();

                $creator = $this->getLoggedInUser();
                $billingInfo = $creator->getBillingInfo();
                $licence = 1;
                if(!empty($billingInfo)){
                    $billingInfo = $billingInfo[0];
                    $licence = $billingInfo->getLicense();
                }
                $company = $creator->getCompany();

                $users = count($company->getUsers());

                if($users < $licence){
                    $object->setCompany($company);
                    $this->admin->create($object);
                    $this->addFlash('sonata_flash_success', $this->admin->trans('flash_create_success', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));
                }else{
                    $this->addFlash('sonata_flash_error', 'Sorry, you have exceeded the limit of participants in the system.');
                    $view = $form->createView();

                    // set the theme for the current Admin Form
                    $this->get('twig')->getExtension('form')->renderer->setTheme($view, $this->admin->getFormTheme());
                    return $this->render($this->admin->getTemplate($templateKey), array(
                        'action' => 'create',
                        'form'   => $view,
                        'object' => $object,
                    ));
                }

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array(
                        'result' => 'ok',
                        'objectId' => $this->admin->getNormalizedIdentifier($object)
                    ));
                }

                // redirect to edit mode
                return $this->redirectTo($object);
            }

            // show an error message if the form failed validation
            if (!$isFormValid) {
                if (!$this->isXmlHttpRequest()) {
                    $this->addFlash('sonata_flash_error', $this->admin->trans('flash_create_error', array('%name%' => $this->admin->toString($object)), 'SonataAdminBundle'));
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

        return $this->render($this->admin->getTemplate($templateKey), array(
            'action' => 'create',
            'form'   => $view,
            'object' => $object,
        ));
    }


    /**
     * execute a batch delete
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     *
     * @param \Sonata\AdminBundle\Datagrid\ProxyQueryInterface $query
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function batchActionDelete(ProxyQueryInterface $query)
    {
        if (false === $this->admin->isGranted('DELETE')) {
            throw new AccessDeniedException();
        }

        $modelManager = $this->admin->getModelManager();

        $parameters = $query->getParameters();
        $em = $this->getDoctrine()->getManager();

        if($parameters){
            if(count($parameters) > 1){
                $text = 'Users have ';
            }else{
                $text = 'User has ';
            }
            foreach($parameters as $key=>$param){
                $userId = $param->getValue();
                $user = $em->getRepository('ZesharCRM\Bundle\CoreBundle\Entity\User')->findOneBy(array('id' => $userId));
                /** @var $user User */
                if($user){
                    $user->setEnabled(false);
                    $user->setLocked(true);
                    $em->persist($user);
                }
            }
            $em->flush();
            $this->addFlash('sonata_flash_success', $text.'been locked!');
        }

        return new RedirectResponse($this->admin->generateUrl('list', array('filter' => $this->admin->getFilterParameters())));
    }

    private function getLoggedInUser()
    {
        if ($user = $this->container->get('security.context')->getToken()->getUser()) {
            return $user;
        }
        return NULL;
    }

}
