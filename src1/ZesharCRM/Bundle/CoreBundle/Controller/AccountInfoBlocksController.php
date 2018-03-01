<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Admin\AdminInterface;
use ZesharCRM\Bundle\CoreBundle\Entity\BillingInfo;
use ZesharCRM\Bundle\CoreBundle\Entity\CreditCard;
use ZesharCRM\Bundle\CoreBundle\Entity\User;
use ZesharCRM\Bundle\CoreBundle\Entity\Company;
use ZesharCRM\Bundle\CoreBundle\Enum\CompanyIndustries;
use ZesharCRM\Bundle\CoreBundle\Enum\BillingSubscriptionStatus;
use ZesharCRM\Bundle\CoreBundle\Enum\BillingSubscriptionProducts;
use ZesharCRM\Bundle\CoreBundle\Enum\CreditCardTypes;
use Sonata\AdminBundle\Controller\CRUDController as CRUDController;


class AccountInfoBlocksController extends Controller
{
    private $user;
    private $company;
    private $billingInfo;
    private $creditCard;
    
    public function indexAction(Request $request)
    {
        $action = $request->get('action');
        $method = $action . 'Action';
        if (method_exists($this, $method)) {
            $this->getDoctrine()->getManager()->getFilters()->disable('lead_subject_filter');
            return $this->$method($request);
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
    }

    public function showFormAction()
    {
        return $this->render('ZesharCRMCoreBundle:CRUD:account_create.html.twig');
    }


    public function getFormDataAction()
    {
        $response_data_arr = array('message' => '');
        $status_code = 200;

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

        $response_data_arr['products'] = $productArr;
        $response_data_arr['statuses'] = BillingSubscriptionStatus::getHumanTitlesMap();
        $response_data_arr['cards'] = CreditCardTypes::getHumanTitlesMap();
        $response_data_arr['industries'] = CompanyIndustries::getHumanTitlesMap();

        $response_data = json_encode($response_data_arr);
        $response = new Response($response_data, $status_code, array('Content-Type' => 'application/json'));
        return $response;
    }


    public function createAccountAction(Request $request)
    {
        $response_data_arr = array('message' => array());
        $status_code = 200;
        $validation = true;
        $isFailed = false;

        $session = $request->getSession();
        $params = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        // validate all the fields
        // check email, username and company name as unique key

        $isUniqueUserName = $em->getRepository('ZesharCRMCoreBundle:User')->findBy(array('usernameCanonical' => strtolower($params['userName'])));
        $isUniqueEmail = $em->getRepository('ZesharCRMCoreBundle:User')->findBy(array('email' => $params['email']));
        $isUniqueCompanyName = $em->getRepository('ZesharCRMCoreBundle:Company')->findBy(array('name' => $params['companyName']));

        if (!empty($isUniqueUserName)) {
            $response_data_arr['message'][] = 'This username already exists! Please, try another one. ';
            $validation = false;
        }
        if (!empty($isUniqueEmail)) {
            $response_data_arr['message'][] = 'This email already exists! Please, try another one. ';
            $validation = false;
        }
        if (!empty($isUniqueCompanyName)) {
            $response_data_arr['message'][] = 'This company name already exists! Please, try another one. ';
            $validation = false;
        }

        if($validation) {
            // add new company to the database
            $this->company = $this->saveCompany($params);
            // add new user to the database
            $this->user = $this->saveUser($params);
            // add new billing plan to the database
            $this->billingInfo = $this->saveBillingInfo($params);
            // add new credit card to the database
            $this->creditCard = $this->saveCreditCard($params);
            $em->flush();

            // Charge Credit Card - Authorize and Capture
            $ADNService = $this->container->get('zeshar_crm_core.adn');

            $auth = $ADNService->ADNAuthentication($this->user, $params);

            if($auth['success']){
                $profile = $ADNService->ADNCreateCustomerProfile($this->user, $params);

                if($profile['success']) {
                    //$subscription = $ADNService->ADNCancelSubscription(3071464);
                    $subscription = $ADNService->ADNCreateSubscription($this->user, $params, false);

                    if ($subscription['success']) {
                        $this->creditCard->setAuthCode($auth['authCode']);
                        $this->creditCard->setTransId($auth['transId']);
                        $this->creditCard->setProfileId($profile['profileId']);
                        $this->creditCard->setPaymentProfileId($profile['paymentProfileId']);
                        $this->creditCard->setRefId($profile['refId']);

                        $this->billingInfo->setSubscriptionId((int)$subscription['subscriptionId']);

                        $em->persist($this->creditCard);
                        $em->persist($this->billingInfo);

                        $session->set('successMsg', 'Thank you very much!
                                                         We have received your signup request. You will get an e-mail
                                                         with credentials as soon as the request is processed.
                                     ');
                    } else {
                        $isFailed = true;
                    }
                }else{
                    $isFailed = true;
                }
            }else{
                $isFailed = true;
            }
        }else{
            $isFailed = true;
        }

        if($isFailed){
            $this->removeEntities($em);
            $status_code = 400;
            if(isset($auth['message'])){
                $response_data_arr['message'][] = $auth['message'];
            }
            if(isset($subscription['message'])){
                $response_data_arr['message'][] = $subscription['message'];
            }
            if(isset($profile['message'])){
                $response_data_arr['message'][] = $profile['message'];
            }
        }
        $em->flush();

        $response_data_arr['message'] = array_filter($response_data_arr['message']);

        $response_data = json_encode($response_data_arr);
        $response = new Response($response_data, $status_code, array('Content-Type' => 'application/json'));
        return $response;
    }


    public function editAccountAction(Request $request)
    {
        $response_data_arr = array('message' => array());
        $status_code = 200;
        $validation = true;

        $session = $request->getSession();
        $params = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        if($validation) {
            $user = $this->get('security.context')->getToken()->getUser();

            // Charge Credit Card - Authorize and Capture
            $ADNService = $this->container->get('zeshar_crm_core.adn');

                $subscription = $ADNService->ADNCreateSubscription($user, $params);
                if($subscription['success']){
                    // update user credit card

                    $this->user = $user;

                    $updatedCreditCard = array();
                    $creditCards = $user->getCreditCards();
                    if(!empty($creditCards)){
                        $creditCard = $creditCards[0];
                        $updatedCreditCard = $this->saveCreditCard($params, $creditCard);
                    }

                    $updatedBillingInfo = array();
                    $billingInfo = $em->getRepository('ZesharCRMCoreBundle:BillingInfo')->findOneBy(array('creator' => $user->getId()));
                    if(!empty($billingInfo)){
                        $updatedBillingInfo = $this->saveBillingInfo($params, $billingInfo);
                        $updatedBillingInfo->setSubscriptionStatus(1);
                        $updatedBillingInfo->setSubscriptionId($subscription['subscriptionId']);
                    }

                    $user->setRoles(array('ROLE_SUPER_ADMIN'));
                    $user->setDisabled(0);

                    $em->persist($user);
                    $em->persist($updatedCreditCard);
                    $em->persist($updatedBillingInfo);

                    $em->flush();

//                    $token = new AnonymousToken($providerKey, 'anon.');
//                    $this->get('security.context')->setToken($token);
//                    $this->get('request')->getSession()->invalidate();

                    $session->set('successMsg', 'Thank you very much for payment! ');
                }else{
                    $response_data_arr['message'][] = $subscription['message'];
                    $status_code = 400;
                }

        }else{
            $status_code = 400;
        }

        if($status_code == 200){
            return $this->redirect( $this->generateUrl( 'sonata_user_admin_security_logout' ) );
        }

        $response_data_arr['message'] = array_filter($response_data_arr['message']);

        $response_data = json_encode($response_data_arr);
        $response = new Response($response_data, $status_code, array('Content-Type' => 'application/json'));
        return $response;
    }


    private function validateZipcode($zipCode)
    {
        if (preg_match("/^([0-9]{5})(-[0-9]{4})?$/i", $zipCode)) {
            return true;
        } else {
            return false;
        }
    }

    private function saveCompany($params)
    {
        $company = new Company();
        $company->setName($params['companyName']);
        $company->setPhoneNumber($params['phone']);
        $company->setPhoneExt($params['ext']);
        $company->setFirstAddress($params['address1']);
        $company->setSecondAddress($params['address2']);
        $company->setCountry($params['country']);
        $company->setCity($params['city']);
        $company->setState($params['state']);
        $company->setPostalCode($params['postalCode']);
        $company->setIndustry($params['industry']);

        $this->getDoctrine()->getManager()->persist($company);

        return $company;
    }


    private function saveUser($params)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $user = new User();
        $user->setEnabled(0);
        $user->setFirstName($params['firstName']);
        $user->setLastName($params['lastName']);
        $user->setUsername($params['userName']);
        $user->setEmail($params['email']);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $user->setCompany($this->company);
        $user->setPlainPassword($this->getPassword());
        $userManager->updateUser($user, true);

        $this->getDoctrine()->getManager()->persist($user);

        return $user;
    }


    public function updateUser($user, $um, $em)
    {
        $password = $this->getPassword();

        $user->setEnabled(1);
        $user->setPlainPassword($password);
        $um->updateUser($user, true);

        $em->persist($user);

        return array('user' => $user, 'password' => $password);
    }

    private function saveBillingInfo($params, $billingInfo = null)
    {
        if(!$billingInfo){
            $billingInfo = new BillingInfo();
        }

        $date = new \DateTime('today');

        $product = $this->getDoctrine()->getManager()->getRepository('ZesharCRMCoreBundle:Product')->findOneBy(array('id' => $params['product']));

        if($params['frequency'] == 0) {
            $date->modify('+1 month');
        }else{
            $date->modify('+1 year');
        }

        $billingInfo->setLicense($params['usersNumber']);
        $billingInfo->setSubscriptionStatus(0);
        $billingInfo->setSubscriptionProduct($product);
        $billingInfo->setFrequency($params['frequency']);
        $billingInfo->setCreator($this->user);
        $billingInfo->setEffectiveDate(new \DateTime('today'));
        $billingInfo->setExpirationDate($date);
        $billingInfo->setCredit($params['amount']);

        $this->getDoctrine()->getManager()->persist($billingInfo);

        return $billingInfo;
    }

    private function saveCreditCard($params, $card = null)
    {
        if(!$card){
            $card = new CreditCard();
        }

        $month = $params['month'];
        $year = $params['year'];

        $date = new \DateTime();
        $date->setDate($year, $month, 1);

        $card->setName($params['cardFirstName'].' '.$params['cardLastName']);
        $card->setNumber(substr($params['cardNumber'],-4,4));
        $card->setType($params['cardType']);
        $card->setTimeZone($params['timeZone']);
        $card->setExpirationDate($date);
        $card->setOwner($this->user);

        $this->getDoctrine()->getManager()->persist($card);

        return $card;
    }

    private function removeEntities($em)
    {
        if(!is_null($this->user)){
            $em->remove($this->user);
        }
        if(!is_null($this->company)){
            $em->remove($this->company);
        }
        if(!is_null($this->billingInfo)){
            $em->remove($this->billingInfo);
        }
        if(!is_null($this->creditCard)){
            $em->remove($this->creditCard);
        }
    }

    public function getPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}
