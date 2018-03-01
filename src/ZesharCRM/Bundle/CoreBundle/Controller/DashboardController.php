<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\ProductType;

class DashboardController extends Controller
{

    protected $sonata;

    protected $widget;

    public function indexAction(Request $request)
    {
        if (in_array('ROLE_DISABLED_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirect($this->generateUrl('account_show', array('id' => $this->getUser()->getId())));
        }
        $session = $request->getSession();
        $session->remove('successMsg');
        $widgets= $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Widget')->findAll();

        $persons = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:User')->findByRole('ROLE_SALES_PERSON');

        if (in_array('ROLE_SUPER_ADMIN',$this->getUser()->getRoles())) {
            $userName = '';
        } else {
            $userName = $this->getUser()->getUsername();
        }

        if(in_array('ROLE_ULTRA_ADMIN',$this->getUser()->getRoles())){
            $products = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Product')->findAll();
            return $this->render('ZesharCRMCoreBundle:Dashboard:ultra-index.html.twig', array('products' => $products,'productTypes' => ProductType::getHumanTitlesMap() ));
        }

        return $this->render('ZesharCRMCoreBundle:Dashboard:index.html.twig', array('widgets' => $widgets, 'userName' => $userName, 'persons' => $persons));
    }

    public function loadWidgetAction(Request $request)
    {
        $result = array();
        $persons = array();
        if (in_array('ROLE_SUPER_ADMIN',$this->getUser()->getRoles())) {
            $persons = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:User')->findByRole('ROLE_SALES_PERSON');
        }
        if ($request->request->get('key') == 'load') {
            $widgetsData = @unserialize($this->getUser()->getWidgetsData());
            if ($widgetsData) {
                foreach ($widgetsData as $widget) {
                    if($widget['id'] == 'Opportunities List'){
                        $entity = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Widget')->findOneBy(array('title' => $widget['id']));
                        $item = array();
                        $item['title'] = $entity->getTitle();
                        $item['height'] = $entity->getHeight();
                        $item['width'] = $entity->getWidth();
                        $item['x'] = $widget['x'];
                        $item['y'] = $widget['y'];
                        $item['user'] = $widget['user'];
                        $user = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:User')->findOneBy(array('username' => $widget['user']));
                        if (!$user) { // load curremt logged in user
                            $user = $this->get('security.context')->getToken()->getUser();
                        }
                        $widgetService = $this->get($entity->getServiceId());
                        $show = $widgetService->render($user,$persons);
                        $item['data'] = $show;
                        array_push($result,$item);
                    }
                }
            }
        } else {
            $value = $request->request->get('value');
            $entity = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Widget')->findOneBy(array('title' => $value['name']));
            $item = array();
            $item['title'] = $entity->getTitle();
            $item['height'] = $entity->getHeight();
            $item['width'] = $entity->getWidth();
            $user = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:User')->findOneBy(array('username' => $value['user']));
            if (!$user) { // load curremt logged in user
                $user = $this->get('security.context')->getToken()->getUser();
            }

            if ($widget = $this->get($entity->getServiceId())) {
                $show = $widget->render($user,$persons);
                $item['data'] = $show;
            }
            array_push($result,$item);
        }
        $response = new Response(json_encode($result));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function saveWidgetAction(Request $request)
    {
        $key = $request->request->get('key',false);
        if ($key) {
            $json = json_decode($request->request->get('value',''),true);
            $this->admin = $this->container->get('sonata.admin.pool')->getAdminByAdminCode('sonata.user.admin.user');
            $object = $this->admin->getObject($this->getUser()->getId());
            $object->setWidgetsData(serialize($json));
            $this->admin->update($object);
        }
        return new Response($request->request->get('value',''));
    }

    public function showBlockWidgetAction()
    {
        $blockWidget = '';
        $persons = array();
        $widgetsData = array();
        $productType = ProductType::BASIC;

        $user = $this->get('security.context')->getToken()->getUser();
        $company = $user->getCompany();
        $admins = $company->getUsers();
        if(!empty($admins)){
            $admin = $admins[0];
            $billingInfo = $admin->getBillingInfo();
            if(!empty($billingInfo)){
                $billingInfo = $billingInfo[0];
                $productType = $billingInfo->getSubscriptionProduct()->getProductType();
            }
        }

        if(ProductType::BASIC == $productType){
            $widgetsData = array(
                'zeshar_crm_core.widget.activity'
            );
        }else{
            $widgetsData = array('zeshar_crm_core.widget.activity' ,/*'zeshar_crm_core.widget.contacted', */ 'zeshar_crm_core.widget.oneMoreActivity',/*'zeshar_crm_core.widget.complete', */ 'zeshar_crm_core.widget.target','zeshar_crm_goals.widget.performance','zeshar_crm_core.widget.need');
        }

        foreach ($widgetsData as $value) {
            if($this->get('security.context')->getToken()){
                $user = $this->get('security.context')->getToken()->getUser();
                $widgetService = $this->get($value);
                $blockWidget .= $widgetService->render($user,$persons);
            }
        }
        return new Response($blockWidget);
    }
}
