<?php

namespace ZesharCRM\Bundle\CoreBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Symfony\Component\Validator\Constraints\DateTime;

define("AUTHORIZENET_LOG_FILE", "phplog");

class ADNService
{

    /** @var ContainerInterface  */
    private $container;
    /** @var EntityManager  */
    private $em;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $container->get('doctrine.orm.entity_manager');
    }

    public function ADNAuthentication($user, $params = array())
    {
        $message = '';
        $responseArr = array('success' => false, 'message' => '');

        /** @var $userBillingInfo \ZesharCRM\Bundle\CoreBundle\Entity\BillingInfo */
        $userBillingInfo = $this->em->getRepository('ZesharCRMCoreBundle:BillingInfo')->findOneBy(array('creator' => $user->getId()));

        // Common setup for API credentials
        $merchantAuthentication = $this->setMerchantAuthentication();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($params['cardNumber']);
        $creditCard->setCardCode($params['cardCode']);
        $creditCard->setExpirationDate($params['year']."-".$params['month']);
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);
        $refId = 'ref' . time();

        // Create a transaction
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authOnlyTransaction");
        $transactionRequestType->setAmount($userBillingInfo->getCredit());
        $transactionRequestType->setPayment($paymentOne);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest( $transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);

        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
//var_dump($response);

        if ($response != null)
        {
            $tresponse = $response->getTransactionResponse();
//var_dump($tresponse);die;
            if (($tresponse != null) && ($tresponse->getResponseCode()=="1") )
            {
                $responseArr['authCode'] = $tresponse->getAuthCode();
                $responseArr['transId'] = $tresponse->getTransId();
                $responseArr['success'] = true;
            }
            else
            {
                $responseArr['message'] = "Charge Credit Card ERROR :  Invalid response. Authentication";
            }
        }
        else
        {
            $responseArr['message'] = "Charge Credit card Null response returned";
        }

        return $responseArr;
    }


    public function ADNApplyPayTransaction($params)
    {
        $message = '';
        $responseArr = array('success' => false, 'message' => '');

        /** @var $user \ZesharCRM\Bundle\CoreBundle\Entity\User */
        $user = $this->em->getRepository('ZesharCRMCoreBundle:User')->findOneBy(array('id' => $params['userId']));

        /** @var $userCreditCard \ZesharCRM\Bundle\CoreBundle\Entity\CreditCard */
        $userCreditCard = $this->em->getRepository('ZesharCRMCoreBundle:CreditCard')->findOneBy(array('owner' => $params['userId']));

        /** @var $userBillingInfo \ZesharCRM\Bundle\CoreBundle\Entity\BillingInfo */
        $userBillingInfo = $this->em->getRepository('ZesharCRMCoreBundle:BillingInfo')->findOneBy(array('creator' => $params['userId']));


        // Common setup for API credentials
        $merchantAuthentication = $this->setMerchantAuthentication();
        $refId = 'ref' . time();

        $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
        $profileToCharge->setCustomerProfileId($userCreditCard->getProfileId());
        $paymentProfile = new AnetAPI\PaymentProfileType();
        $paymentProfile->setPaymentProfileId($userCreditCard->getPaymentProfileId());
        $profileToCharge->setPaymentProfile($paymentProfile);
        $transId = $userCreditCard->getTransId();


        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("priorAuthCaptureTransaction");
        $transactionRequestType->setRefTransId($transId);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransactionRequest($transactionRequestType);

        $controller = new AnetController\CreateTransactionController($request);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if ($response != null)
        {
            $tresponse = $response->getTransactionResponse();
            if (($tresponse != null) && ($tresponse->getResponseCode()=="1") )
            {
                $responseArr['message'] =  "Charge Customer Profile APPROVED";
                $responseArr['authCode'] = $tresponse->getAuthCode();
                $responseArr['transId'] = $tresponse->getTransId();
                $responseArr['success'] = true;
            }
            elseif (($tresponse != null) && ($tresponse->getResponseCode()=="2") )
            {
                $responseArr['message'] =  "ERROR" . "\n";
            }
            elseif (($tresponse != null) && ($tresponse->getResponseCode()=="4") )
            {
                $responseArr['message'] =  "ERROR: HELD FOR REVIEW:"  . "\n";
            }
        }
        else
        {
            $responseArr['message'] = "no response returned";
        }

        return $responseArr;
    }


    public function ADNCreateCustomerProfile($user, $params = array())
    {
        $message = '';
        $responseArr = array('success' => false, 'message' => '');

        $merchantAuthentication = $this->setMerchantAuthentication();
        $refId = 'ref' . time();

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($params['cardNumber']);
        $creditCard->setCardCode($params['cardCode']);
        $creditCard->setExpirationDate($params['year'].'-'.$params['month']);
        $paymentCreditCard = new AnetAPI\PaymentType();
        $paymentCreditCard->setCreditCard($creditCard);

        // Create the Bill To info
        $billto = new AnetAPI\CustomerAddressType();
        $billto->setFirstName($params['cardFirstName']);
        $billto->setLastName($params['cardLastName']);
        $billto->setCompany($params['companyName']);
        $billto->setAddress($params['address1']." ".$params['address2']);
        $billto->setCity($params['city']);
        $billto->setState($params['state']);
        $billto->setZip($params['postalCode']);
        $billto->setCountry($params['country']);

        $paymentprofile = new AnetAPI\CustomerPaymentProfileType();

        $paymentprofile->setCustomerType('individual');
        $paymentprofile->setBillTo($billto);
        $paymentprofile->setPayment($paymentCreditCard);
//        $paymentprofile->setTaxId()
        $paymentprofiles[] = $paymentprofile;
        $customerprofile = new AnetAPI\CustomerProfileType();
        $customerprofile->setDescription("Payment");
        $merchantCustomerId = time().rand(1,150);
        $customerprofile->setMerchantCustomerId($merchantCustomerId);
        $customerprofile->setEmail($params['email']);
        $customerprofile->setPaymentProfiles($paymentprofiles);

        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId( $refId);
        $request->setProfile($customerprofile);
        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            $responseArr['profileId'] = $response->getCustomerProfileId();
            $responseArr['paymentProfileId'] = $response->getCustomerPaymentProfileIdList()[0];
            $responseArr['refId'] = $refId;
            $responseArr['success'] = true;
        }
        else
        {
            $responseArr['message'] = "ERROR :  Invalid response. Create customer profile.";
            $responseArr['message'] .= "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText() . "\n";

        }

        return $responseArr;
    }


    public function ADNCreateSubscription($user, $params, $setTodayDate = true)
    {
        $message = '';
        $responseArr = array('success' => false, 'message' => '');


        date_default_timezone_set($params['timeZone']);
        // Common Set Up for API Credentials
        $merchantAuthentication = $this->setMerchantAuthentication();
        $refId = 'ref' . time();

        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName("Sample Subscription");

        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();

        if($params['frequency'] == 0){
            $userInterval = '31';
            $unit = 'days';
        }else{
            $userInterval = '12';
            $unit = 'months';
        }

        $interval->setLength($userInterval);
        $interval->setUnit($unit);

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        if($setTodayDate){
            $paymentSchedule->setStartDate(new \DateTime('today'));
        }else{
            $paymentSchedule->setStartDate(new \DateTime($params['year'].'-'.$params['month'].-'28'));
        }
        $paymentSchedule->setTrialOccurrences($userInterval);
        $paymentSchedule->setTotalOccurrences('9999');

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setTrialAmount($params['amount']);
        $subscription->setAmount($params['amount']);

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($params['cardNumber']);
        $creditCard->setExpirationDate($params['year'].'-'.$params['month']);

        $payment = new AnetAPI\PaymentType();
        $payment->setCreditCard($creditCard);

        $subscription->setPayment($payment);

        $billTo = new AnetAPI\NameAndAddressType();
        $billTo->setFirstName($params['cardFirstName']);
        $billTo->setLastName($params['cardLastName']);

        $subscription->setBillTo($billTo);

        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);

        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            $responseArr['message'] =  "SUCCESS: Subscription has been created";
            $responseArr['subscriptionId'] = $response->getSubscriptionId();
            $responseArr['success'] = true;
        }
        else
        {
            $responseArr['message'] = "ERROR :  Invalid response";
            $responseArr['message'] .= "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText();
        }

        return $responseArr;
    }


    public function ADNUpdateSubscription($subscriptionId, $amount = null, $changeDate = true, $params = array())
    {
        $message = '';
        $responseArr = array('success' => false, 'message' => '','trialOccur' => null, 'trial' => null);

        // Common Set Up for API Credentials
        $merchantAuthentication = $this->setMerchantAuthentication();
        $refId = 'ref' . time();

        // update subscription

        $subscription = new AnetAPI\ARBSubscriptionType();
        $paymentSchedule = new AnetAPI\PaymentScheduleType();

        if($amount){
            //$date = $params['lastPayment']->getDate();
            //$dateStr = $date->format('Y-m-d H:i:s');

            $lastPaymentDate = $params['lastPayment']->getDate()->getTimestamp();

            $billingFrequency = $params['frequency'];

            $nowDate = strtotime('now');

            $dateDiff = $nowDate - $lastPaymentDate;
            $paidDays = floor($dateDiff/(60*60*24));

            if(!$billingFrequency){
                //months
                $frequency = 31;
                $userInterval = 31;
                $unit = 'days';
            }else{
                //years
                $frequency = 12;
                $userInterval = 12;
                $unit = 'months';
            }
            $trialOccurrences = $frequency;
            $trialAmount = $amount;

            $howManyDays = $params['lastPayment']->getTrialOccurrences();

            $fullMonthsOrYears = $howManyDays ? intval($paidDays / $howManyDays) : 0;

            $paidDaysInThisMonthOrYear = $paidDays - ($fullMonthsOrYears * $howManyDays);
            $restDaysInThisMonthOrYear = $howManyDays - $paidDaysInThisMonthOrYear;

            $prevAmount = $params['lastPayment']->getAmount();

            if($paidDaysInThisMonthOrYear > 0){
                // we should recount payment for this month or year
                //$balance = (($howManyDays - $paidDaysInThisMonthOrYear) * $prevAmount) / $howManyDays;

                $restPayment = $howManyDays ? ($restDaysInThisMonthOrYear * $prevAmount) / $howManyDays : 0;
                $restNewPayment = $howManyDays ? ($restDaysInThisMonthOrYear * $amount) / $howManyDays : 0;

                if($restNewPayment > $restPayment){
                    // он увеличил кол-во пользователей, сумма увеличилась за остаток месяца или года
                    $needPayment = $restNewPayment - $restPayment;
                    $trialAmount = round($needPayment, 2);
                }else{
                    // деньги мы ему не вернем, но со след. в след. платеж он будет платить меньше
                    $trialAmount = 0;
                }

                $trialOccurrences = $restDaysInThisMonthOrYear;
            }else{
                $restNewPayment = ($restDaysInThisMonthOrYear * $amount) / $frequency;
                $needPayment = $restNewPayment - $prevAmount;
                if($needPayment > 0) {
                    $trialAmount = $needPayment;
                }else{
                    $trialAmount = 0;
                }

                $trialOccurrences = $restDaysInThisMonthOrYear;
            }

            if($unit == 'months'){
                $trialOccurrences = round($restDaysInThisMonthOrYear/31);
            }

            $paymentSchedule->setTrialOccurrences($trialOccurrences);
            $paymentSchedule->setTotalOccurrences('9999');

            $subscription->setPaymentSchedule($paymentSchedule);
            $subscription->setTrialAmount(round($trialAmount));
            $subscription->setAmount($amount);

            $responseArr['trialOccur'] = $trialOccurrences;
            $responseArr['trial'] = round($trialAmount);
        }

        if($changeDate){
            $paymentSchedule->setStartDate(new \DateTime('today'));
        }

        $request = new AnetAPI\ARBUpdateSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);
        $request->setSubscription($subscription);

        $controller = new AnetController\ARBUpdateSubscriptionController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") )
        {
            $responseArr['message'] =  "SUCCESS" . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText();
            $responseArr['success'] = true;
        }
        else
        {
            $responseArr['message'] = "ERROR :  Invalid response";
            $responseArr['message'] .= "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText();
        }

        return $responseArr;
    }


    public function ADNGetSubscription($user, $billingInfo, $params = array())
    {
        $message = '';
        $responseArr = array('success' => false, 'message' => '');

        $merchantAuthentication = $this->setMerchantAuthentication();
        $refId = 'ref' . time();

        // Creating the API Request with required parameters
        $request = new AnetAPI\ARBGetSubscriptionStatusRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($billingInfo->getSubscriptionId());

        // Controller
        $controller = new AnetController\ARBGetSubscriptionStatusController($request);

        // Getting the response
        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if ($response != null)
        {
            if($response->getMessages()->getResultCode() == "Ok")
            {
                // Success
                $responseArr['message'] = 'SUCCESS: GetSubscription';
                // Displaying the details
                $responseArr['subscriptionStatus'] = $response->getStatus();
                $responseArr['success'] = true;
            }
            else
            {
                // Error
                $responseArr['message'] = "ERROR :  Invalid response ";
                $responseArr['message'] .= "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText();

            }
        }
        else
        {
            // Failed to get response
            $responseArr['message'] = "Null Response Error";
        }

        return $responseArr;
    }


    public function ADNCancelSubscription($subscriptionId)
    {
        $message = '';
        $responseArr = array('success' => false, 'message' => '');

        // Common Set Up for API Credentials
        $merchantAuthentication = $this->setMerchantAuthentication();
        $refId = 'ref' . time();

        $request = new AnetAPI\ARBCancelSubscriptionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscriptionId($subscriptionId);

        $controller = new AnetController\ARBCancelSubscriptionController($request);

        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
        {
            $responseArr['message'] =  "SUCCESS" . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText();
            $responseArr['success'] = true;
        }
        else
        {
            $responseArr['message'] =  "ERROR :  Invalid response";
            $responseArr['message'] .= "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText();

        }

        return $responseArr;
    }


    public function ADNGetSettledBatchList()
    {
        $message = '';
        $responseArr = array('success' => false, 'message' => '');

        // Common Set Up for API Credentials
        $merchantAuthentication = $this->setMerchantAuthentication();
        $refId = 'ref' . time();

        $request = new AnetAPI\GetSettledBatchListRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setIncludeStatistics(true);

        $controller = new AnetController\GetSettledBatchListController ($request);

        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
        {
            foreach($response->getBatchList() as $batch)
            {
                echo "\n\n";
                echo "Batch ID: " . $batch->getBatchId() . "\n";
                echo "Batch settled on (UTC): " . $batch->getSettlementTimeUTC()->format('r') . "\n";
                echo "Batch settled on (Local): " . $batch->getSettlementTimeLocal()->format('r') . "\n";
                echo "Batch settlement state: " . $batch->getSettlementState() . "\n";
                echo "Batch market type: " . $batch->getMarketType() . "\n";
                echo "Batch product: " . $batch->getProduct() . "\n";
                foreach($batch->getStatistics() as $statistics)
                {
                    echo "Account type: ".$statistics->getAccountType()."\n";
                    echo "Total charge amount: ".$statistics->getChargeAmount()."\n";
                    echo "Charge count: ".$statistics->getChargeCount()."\n";
                    echo "Refund amount: ".$statistics->getRefundAmount()."\n";
                    echo "Refund count: ".$statistics->getRefundCount()."\n";
                    echo "Void count: ".$statistics->getVoidCount()."\n";
                    echo "Decline count: ".$statistics->getDeclineCount()."\n";
                    echo "Error amount: ".$statistics->getErrorCount()."\n";
                }
            }
        }
        else
        {
            echo "ERROR :  Invalid response\n";
            echo "Response : " . $response->getMessages()->getMessage()[0]->getCode() . "  " .$response->getMessages()->getMessage()[0]->getText() . "\n";

        }
        return $responseArr;
    }


    private function setMerchantAuthentication()
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName( $this->container->getParameter('ADN_LOGIN_ID') );
        $merchantAuthentication->setTransactionKey( $this->container->getParameter('ADN_TRANSACTION_KEY') );

        return $merchantAuthentication;
    }

}

// NOTES:

// Well, It is Secure Socket Layer , mainly used to keep sensitive information sent across the Internet Encrypted so that only the intended recipient can understand it. TO Remove SSL : navigate to lib/net/authorize/util/HttpClient.php Line no 68 or nearby add the following
// curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, FALSE)
