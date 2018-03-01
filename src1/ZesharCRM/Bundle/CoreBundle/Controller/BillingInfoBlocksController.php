<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Admin\AdminInterface;
use ZesharCRM\Bundle\CoreBundle\Entity\BillingInfo;
use ZesharCRM\Bundle\CoreBundle\Entity\CreditCard;
use ZesharCRM\Bundle\CoreBundle\Entity\PaymentHistory;
use Doctrine\ORM\EntityRepository;
use DateInterval;

class BillingInfoBlocksController extends Controller
{
    
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

    public function editBillingInfoAction(Request $request)
    {
        $response_data_arr = array('message' => '');
        $status_code = 200;
        $validation = true;

        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();

        $effectiveDate = \DateTime::createFromFormat('M d, Y', $params['effectiveDate']);
        $expirationDate = \DateTime::createFromFormat('M d, Y', $params['expirationDate']);

        $creditExpirationDate = \DateTime::createFromFormat('m/Y', $params['creditCardExpirationMonth'] . '/' . $params['creditCardExpirationYear']);



        /** @var $billingInfo BillingInfo */
        $billingInfo = $em->getRepository('ZesharCRMCoreBundle:BillingInfo')->findOneBy(array('id' => $request->get('billingId')));

        /** @var $credit CreditCard */
        $credit = $em->getRepository('ZesharCRMCoreBundle:CreditCard')->findOneBy(array('owner' => $billingInfo->getCreator()->getId()));
        $product = $em->getRepository('ZesharCRMCoreBundle:Product')->findOneBy(array('id' => $params['subscriptionProduct']));


        $credit
            ->setExpirationDate($creditExpirationDate)
            ->setAddress($params['creditCardAddress'])
            ->setCity($params['creditCardCity'])
            ->setName($params['creditCardName'])
            ->setNumber($params['creditCardNumber'])
            ->setState($params['creditCardState'])
            ->setZipCode($params['creditCardZip'])
            ->setType($params['creditCardType'])
        ;

        $qb = $em
            ->createQueryBuilder()
            ->select('p')
            ->from('ZesharCRMCoreBundle:PaymentHistory', 'p')
            ->andWhere('p.creator = :creator')
            ->orderBy('p.date', 'DESC')
            ->setParameters(array('creator' => $billingInfo->getCreator()->getId()));
        $payments = $qb->getQuery()->getResult();

        $amount = $params['credit'];

        if ($billingInfo->getCredit() > $params['credit']){
            $status_code = 200;
            $this->addFlash('sonata_flash_error', 'Please delete users to decrease the number of licenses.');
        }elseif($billingInfo->getCredit() != $params['credit']
            || $billingInfo->getFrequency() != $params['frequency']
            || $billingInfo->getLicense() != $params['license']
            || $billingInfo->getSubscriptionProduct() != $params['subscriptionProduct'] ) {

            $ADNService = $this->container->get('zeshar_crm_core.adn');
            $subscriptionId = $billingInfo->getSubscriptionId();
            $subscription = $ADNService->ADNUpdateSubscription(
                $subscriptionId,
                $amount,
                false,
                array(
                    'billingInfo' => $billingInfo,
                    'lastPayment' => current($payments),
                    'frequency' => $params['frequency']
                )
            );

            if ($subscription['success']) {
                //$expirationDate = strtotime('+' . $subscription['trialOccur'] . ' day', strtotime('now'));
                $date = new \DateTime('today');
                $expirationDate = $date->add(new DateInterval('P'.$subscription['trialOccur'].'D'));
                $billingInfo
                    ->setEffectiveDate(new \DateTime('today'))
                    ->setExpirationDate($expirationDate)
                    ->setLicense($params['license'])
                    ->setCredit($params['credit'])
                    ->setSubscriptionProduct($product)
                    ->setFrequency($params['frequency'])
                ;

                $payment = $this->savePayment(
                    $billingInfo->getCreator(),
                    $billingInfo,
                    'Update subscription by credit card',
                    $subscription['trialOccur'],
                    $subscription['trial']
                );

                $em->persist($billingInfo);
            } else {
                $status_code = 400;
                $response_data_arr['message'][] = $subscription['message'];
            }
        }
        $em->persist($credit);
        $em->flush();

        return new Response();
    }

    public function editCompanyAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $params = $request->request->all();

        $company = $em->getRepository('ZesharCRMCoreBundle:Company')->findOneBy(array('id' => $params['companyId']));

        if ($company) {
            $company
                ->setFirstAddress($params['firstAddr'])
                ->setSecondAddress($params['secondAddr'])
                ->setCity($params['city'])
                ->setState($params['state'])
                ->setpostalCode($params['postalCode'])
            ;
            $em->persist($company);
            $em->flush();
        }

        return new Response();
    }


    public function editContactAction(Request $request)
    {
        $response_data_arr = array('message' => '');
        $status_code = 200;
        $validation = true;

        $em = $this->getDoctrine()->getManager();
        $userManager = $this->container->get('fos_user.user_manager');
        $params = $request->request->all();

        $contact = $em->getRepository('ZesharCRMCoreBundle:User')->findOneBy(array('id' => $params['userId']));

        // check email and username as unique key
        //

        $isUniqueUserName = $em->getRepository('ZesharCRMCoreBundle:User')->findBy(array('username' => $params['username']));
        $isUniqueEmail = $em->getRepository('ZesharCRMCoreBundle:User')->findBy(array('email' => $params['email']));

        if (!empty($isUniqueUserName)) {
            if ($isUniqueUserName[0]->getId() != $contact->getId()) {
                $response_data_arr['message'] .= 'This username already exists! Please, try another one. ';
                $status_code = 400;
                $validation = false;
            }
        }

        if (!empty($isUniqueEmail)) {
            if ($isUniqueEmail[0]->getId() != $contact->getId()) {
                $response_data_arr['message'] .= 'This email already exists! Please, try another one. ';
                $status_code = 400;
                $validation = false;
            }
        }

        if ($contact && $validation) {
            $contact->setFirstName($params['firstName']);
            $contact->setLastName($params['lastName']);
            $contact->setUsername($params['username']);
            $contact->setEmail($params['email']);

            if (!empty($params['password'])) {
               $contact->setPlainPassword($params['password']);
            }
            $userManager->updateUser($contact, true);
            $em->persist($contact);
            $em->flush();
        }

        $response_data = json_encode($response_data_arr);
        $response = new Response($response_data, $status_code, array('Content-Type' => 'application/json'));
        return $response;
    }

    public function acceptPaymentAction(Request $request)
    {
        $response_data_arr = array('message' => array());
        $status_code = 200;
        $validation = true;
        $em = $this->getDoctrine()->getManager();

        $params = $request->request->all();

        // Charge Credit Card - Authorize and Capture
        $ADNService = $this->container->get('zeshar_crm_core.adn');
        $trans = $ADNService->ADNApplyPayTransaction($params);

        $response_data_arr['success'] = $trans['success'];

        $user = $em->getRepository('ZesharCRMCoreBundle:User')->findOneBy(array('id' => $params['userId']));
        $userBillingInfo = $em->getRepository('ZesharCRMCoreBundle:BillingInfo')->findOneBy(array('creator' => $params['userId']));

        if(!$trans['success']){
            $status_code = 400;
        }else{
            $userBillingInfo->setSubscriptionStatus(1);
            $payment = $this->savePayment($user, $userBillingInfo, 'First payment by credit card.');
            $em->persist($userBillingInfo);

            $em->flush();

            // edit subscription data

            $subscriptionId = $userBillingInfo->getSubscriptionId();
            $subscription = $ADNService->ADNUpdateSubscription($subscriptionId);

            // update user
            $accountController = $this->get('zeshar_crm_core.account_controller');
            $userData = $accountController->updateUser($user, $this->container->get('fos_user.user_manager'), $em );

            // send email to user with his account credentials
            $this->sendEmail($userData);
        }

        $response_data_arr['message'][] = $trans['message'];

        $response_data = json_encode($response_data_arr);
        $response = new Response($response_data, $status_code, array('Content-Type' => 'application/json'));
        return $response;
    }


    public function disableAccountAction(Request $request)
    {
        $response_data_arr = array('success' => false, 'message' => array());
        $status_code = 200;
        $validation = true;
        $em = $this->getDoctrine()->getManager();

        $params = $request->request->all();

        // Charge Credit Card - Authorize and Capture
        $ADNService = $this->container->get('zeshar_crm_core.adn');

        $user = $em->getRepository('ZesharCRMCoreBundle:User')->findOneBy(array('id' => $params['userId']));
        $userBillingInfo = $em->getRepository('ZesharCRMCoreBundle:BillingInfo')->findOneBy(array('creator' => $params['userId']));
        $subscriptionId = $userBillingInfo->getSubscriptionId();

        // cancel subscription
        $subscription = $ADNService->ADNCancelSubscription($subscriptionId);

        $response_data_arr['success'] = $subscription['success'];

        if(!$subscription['success']){
            $status_code = 400;
        }else{
            // update user
            $userBillingInfo->setSubscriptionStatus(0);
            $user->setDisabled(1);
//            $user->setRoles(array('ROLE_DISABLED_ADMIN'));
//
            $em->persist($userBillingInfo);
            $em->persist($user);
//
            $em->flush();

            // send email to user with his account credentials
            $this->sendEmail(array('user' => $user), 'Your surgeActivity account has been disabled.');
        }

        $response_data_arr['message'][] = $subscription['message'];

        $response_data = json_encode($response_data_arr);
        $response = new Response($response_data, $status_code, array('Content-Type' => 'application/json'));
        return $response;
    }


    public function updatePaymentHistoryAction(Request $request)
    {
        // Get the subscription ID if it is available.
        // Otherwise $subscription_id will be set to zero.
        $subscriptionId = (int) $_POST['x_subscription_id'];

        // Check to see if we got a valid subscription ID.
        // If so, do something with it.
        if ($subscriptionId){
            // find user with this subscriptionId (billingInfo)

            $em = $this->getDoctrine()->getManager();
            $billingInfo = $this->getDoctrine()->getRepository('ZesharCRMCoreBundle:BillingInfo')->findOneBy(array('subscriptionId' => $subscriptionId));
            if(!empty($billingInfo)){
                $user = $billingInfo->getCreator();
            }

            // Get the response code. 1 is success, 2 is decline, 3 is error
            $responseCode = (int) $_POST['x_response_code'];

            // Get the reason code. 8 is expired card.
            $reasonCode = (int) $_POST['x_response_reason_code'];

            if ($responseCode == 1 && isset($user)){
                // Approved!

                $payment = $this->savePayment($user, $billingInfo, 'Scheduled payment by credit card.');
                $em->flush();

                // Some useful fields might include:
                // $authorization_code = $_POST['x_auth_code'];
                // $avs_verify_result  = $_POST['x_avs_code'];
                // $transaction_id     = $_POST['x_trans_id'];
                // $customer_id        = $_POST['x_cust_id'];
            }
            else if ($responseCode == 2)
            {
                // Declined
            }
            else if ($responseCode == 3 && $reasonCode == 8)
            {
                // An expired card
            }
            else
            {
                // Other error
            }
        }

        return new Response();
    }


    private function savePayment($user, $userBillingInfo, $description, $trialOccur = null, $trial = null)
    {
        $payment = new PaymentHistory();
        $payment->setCreator($user);
        $payment->setDescription($description);
        $payment->setDate(new \DateTime('today'));

        if(is_null($trialOccur)){
            if(!$userBillingInfo->getFrequency()){
                //months
                $trialOccur = 31;
            }else{
                //years
                $trialOccur = 356;
            }
        }

        $payment->setTrialOccurrences($trialOccur);

        if(!is_null($trial)){
            $payment->setAmount($trial);
        }else{
            $payment->setAmount($userBillingInfo->getCredit());
        }

        $this->getDoctrine()->getManager()->persist($payment);

        return $payment;
    }

    private function validateZipcode($zipCode)
    {
        if (preg_match("/^([0-9]{5})(-[0-9]{4})?$/i", $zipCode)) {
            return true;
        } else {
            return false;
        }
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
