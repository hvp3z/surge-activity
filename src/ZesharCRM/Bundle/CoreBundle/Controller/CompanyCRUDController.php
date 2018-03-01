<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use ZesharCRM\Bundle\CoreBundle\Enum\ActivityStatus;

use Sonata\AdminBundle\Controller\CRUDController as CRUDController;

use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyCRUDController extends CRUDController
{
    public function listAction()
    {

        $session = $this->get('request')->getSession();
        $session->remove('successMsg');

        if (false === $this->admin->isGranted('LIST')) {
            throw new AccessDeniedException();
        }

        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());

        return $this->render($this->admin->getTemplate('list'), array(
            'action'     => 'list',
            'form'       => $formView,
            'datagrid'   => $datagrid,
            'csrf_token' => $this->getCsrfToken('sonata.batch'),
        ));
    }

    /**
     * Execute a batch delete.
     *
     * @param ProxyQueryInterface $query
     *
     * @return RedirectResponse
     *
     * @throws AccessDeniedException If access is not granted
     */
    public function batchActionDelete(ProxyQueryInterface $query)
    {
        if (false === $this->admin->isGranted('DELETE')) {
            throw new AccessDeniedException();
        }

        $modelManager = $this->admin->getModelManager();
        try {
            $modelManager->batchDelete($this->admin->getClass(), $query);
            $this->addFlash('sonata_flash_success', 'flash_batch_delete_success');
        } catch (ModelManagerException $e) {
            $this->logModelManagerException($e);
            $this->addFlash('sonata_flash_error', 'flash_batch_delete_error');
        }

        return new RedirectResponse($this->admin->generateUrl(
            'list',
            array('filter' => $this->admin->getFilterParameters())
        ));
    }

    /**
     * Delete action.
     *
     * @param int|string|null $id
     *
     * @return Response|RedirectResponse
     *
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function deleteAction($id)
    {
        $id     = $this->get('request')->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('DELETE', $object)) {
            throw new AccessDeniedException();
        }

        if ($this->getRestMethod() == 'DELETE') {
            // check the csrf token
            $this->validateCsrfToken('sonata.delete');

            // Charge Credit Card - Authorize and Capture
            $ADNService = $this->container->get('zeshar_crm_core.adn');

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('ZesharCRMCoreBundle:User')->findOneBy(array('company' => $id));
            $userBillingInfo = $em->getRepository('ZesharCRMCoreBundle:BillingInfo')->findOneBy(array('creator' => $user->getId()));
            $subscriptionId = $userBillingInfo->getSubscriptionId();

            // cancel subscription
            $subscription = $ADNService->ADNCancelSubscription($subscriptionId);

            $response_data_arr['success'] = $subscription['success'];


            if($subscription['success']){
                // send email to user with his account credentials
                $this->sendEmail(array('user' => $user), 'Your surgeActivity account has been disabled.');
            }

            try {
                $this->admin->delete($object);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'ok'));
                }

                $this->addFlash(
                    'sonata_flash_success',
                    $this->admin->trans(
                        'flash_delete_success',
                        array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                        'SonataAdminBundle'
                    )
                );
            } catch (ModelManagerException $e) {
                $this->logModelManagerException($e);

                if ($this->isXmlHttpRequest()) {
                    return $this->renderJson(array('result' => 'error'));
                }

                $this->addFlash(
                    'sonata_flash_error',
                    $this->admin->trans(
                        'flash_delete_error',
                        array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                        'SonataAdminBundle'
                    )
                );
            }

            return $this->redirectTo($object);
        }

        return $this->render($this->admin->getTemplate('delete'), array(
            'object'     => $object,
            'action'     => 'delete',
            'csrf_token' => $this->getCsrfToken('sonata.delete'),
        ));
    }


    private function sendEmail($data, $body = null)
    {
        $user = $data['user'];

        if($body){
            $text = $body;
        }else{
            $password = $data['password'];
            $text = '
                        Your credentials for SurgeActivity CRM system are :
                        Login: '.$user->getUsername().'
                        Password: '.$password.'
                        SurgeActivity CRM Link: http://crm.surgeactivity.com
                     '
            ;
        }


        $message = \Swift_Message::newInstance()
            ->setFrom('donotreply@surgeactivity.com')
            ->setTo($user->getEmail())
            ->setSubject('SurgeActivity Credentials')
            ->setBody($text)
        ;

        $this->get('mailer')->send($message);
    }

}
