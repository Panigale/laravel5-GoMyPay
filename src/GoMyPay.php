<?php
/**
 * Author: Panigale
 * Date: 2018/1/16
 * Time: 上午11:11
 */

namespace Panigale\GoMyPay;


use Panigale\GoMyPay\Factories\GoMyPayFactory;
use Panigale\GoMyPay\Service\GoMyPayEntity;
use Panigale\GoMyPay\Service\GoMyPayOnline;
use Panigale\GoMyPay\Service\ReceivePayment;

class GoMyPay
{
    use ReceivePayment;

    public function __construct()
    {
        $version = config('gomypay.version');
    }

    /**
     * create GoMyPay payment method.
     *
     * @param $paymentType
     * @return Service\GoMyPayEntity|Service\GoMyPayOnline
     */
    public static function payBy($paymentType)
    {
        return PaymentFactory::create($paymentType)->setPayBy($paymentType);
    }

    public function done()
    {
        if(config('gomypay.version') === 'v2')
            return $this->receiveV2();

        return $this->receive();
    }

    public function successResponse()
    {
        /**
         * 如果沒有 OrderType 這個參數，代表非信用卡交易
         */
        $gomypay = request()->has('OrderType') ? new GoMyPayOnline() : new GoMyPayEntity();

        return $gomypay->successResponse();
    }

    /**
     * @param $user
     * @param $amount
     * @param $no
     * @param $paymentMethod
     * @param $creditCard
     * @return array|mixed
     * @throws \Exception
     */
    public function redirect($user ,$amount ,$no ,$paymentMethod ,$creditCard)
    {
        $tradeCode = config('gomypay.tradeCode');
        $storeCode = config('gomypay.storeCode');
        $userNameAttribute = config('gomypay.user.name');
        $email = $user->email;
        $phone = $user->phone;
        $name = $user->$userNameAttribute;

        if(config('gomypay.version') === 'v2')
            return $this->redirectV2($user ,$amount ,$no ,$paymentMethod ,$creditCard);

        if($paymentMethod === 'credit card')
            return [
                'e_orderno'     => $no,
                'e_url'         => config('gomypay.callbackUrl'),
                'e_no'          => $storeCode,
                'e_storename'   => config('app.name'),
                'e_mode'        => 9,
                'e_money'       => $amount,
                'e_cardno'      =>  $this->hashCardNo($creditCard['number'], $creditCard['expiry'], $creditCard['cvv']),
                'str_check'     => $this->getCheckValue($tradeCode ,$no ,$storeCode ,$amount),
                'e_name'        => $name,
                'e_telm'        => $phone,
                'e_email'       => $email,
                'e_info'        => config('gomypay.title'),
                'e_backend_url' => config('gomypay.backendUrl'),
                'actionUrl' => 'https://gomypay.asia/Shopping/creditpay.asp'
            ];

        $entityPayment = new GoMyPayEntity();

        return $entityPayment->withPaymentNo($no)
                            ->withAmount($amount)
                            ->setPayBy($paymentMethod)
                            ->withUser($name ,$user->email ,$user->phone)
                            ->redirect();
    }

    /**
     * 組合交易檢查碼
     *
     * @param $tradeCode
     * @param $tradeNo
     * @param $storeCode
     * @param $amount
     * @return string
     */
    public function getCheckValue($tradeCode ,$orderNo, $storeCode, $amount)
    {
        return md5($orderNo . $storeCode . $amount . $tradeCode);
    }

    /**
     * base64編碼信用卡資訊
     *
     * @param string $cvv
     * @param string $expiry
     * @param string $cardNo
     * @return string
     */
    private function hashCardNo($number ,$expiry ,$cvv)
    {
        return base64_encode($cvv . $expiry . $number);
    }

    private function redirectV2($user, $amount, $no, $paymentMethod, $creditCard)
    {
        $handler = GoMyPayFactory::handler($paymentMethod);

        $handler->setCustomer($user);
        
        if($creditCard){
            $handler->payByCreditCard($creditCard);
        }

        return $handler->pay($amount ,$no);
    }
}