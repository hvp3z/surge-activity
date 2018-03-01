<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ZesharCRM\Bundle\CoreBundle\Event\CustomEvent;
use ZesharCRM\Bundle\CoreBundle\Enum\OperationType;
use ZesharCRM\Bundle\CoreBundle\Enum\ProductType;
use ZesharCRM\Bundle\CoreBundle\Entity\Product;
use Symfony\Component\HttpFoundation\RedirectResponse;


class ProductController extends Controller
{

    public function indexAction(Request $request)
    {
        $params = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        $ids = $params['id'];
        $names = $params['name'];
        $types = $params['type'];
        $mRates = $params['mRate'];
        $yRates = $params['yRate'];

        if(!empty($names)){
            for($i = 0; $i < count($names); $i++){
                if(!empty($ids[$i])){
                    $product = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Product')->findOneBy(array('id' => $ids[$i]));
                }else{
                    $product = new Product();
                }
                if(!empty($names[$i])) {
                    $product->setName($names[$i]);
                    $product->setProductType($types[$i]);
                    $product->setMonthlyRate($mRates[$i]);
                    $product->setYearlyRate($yRates[$i]);
                    $em->persist($product);
                    $em->flush();
                }
            }
        }

        if(in_array('ROLE_ULTRA_ADMIN',$this->getUser()->getRoles())){
//            $products = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Product')->findAll();
//            return $this->render('ZesharCRMCoreBundle:Dashboard:ultra-index.html.twig', array('products' => $products, 'productTypes' => ProductType::getHumanTitlesMap() ));
            $url = 'dashboard';
            $response = new RedirectResponse($this->container->get('router')->generate($url));
            return $response;
        }
    }

    public function deleteAction($id = null, Request $request)
    {
        $response_data_arr = array('message' => array(), 'success' => true);
        $status_code = 200;
        $em = $this->getDoctrine()->getManager();

        if($id){
            $product = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:Product')->findOneBy(array('id' => $id));
            $em->remove($product);
            $em->flush();
        }else{
            $status_code = 400;
            $response_data_arr['success'] = false;
        }


        $response_data = json_encode($response_data_arr);
        $response = new Response($response_data, $status_code, array('Content-Type' => 'application/json'));
        return $response;
    }
}
