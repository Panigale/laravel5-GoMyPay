<?php
/**
 * Author: Panigale
 * Date: 2018/1/16
 * Time: 上午11:11
 */

namespace Panigale\GoMyPay;


use Panigale\GoMyPay\Service\ReceivePayment;

class GoMyPay
{
    use ReceivePayment;

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
        return $this->receive();
    }

    public function redirect($user ,$amount ,$no ,$creditCard)
    {
        $tradeCode = config('gomypay.tradeCode');
        $storeCode = config('gomypay.storeCode');

        return [
            'e_orderno'     => $no,
            'e_url'         => config('gomypay.callbackUrl'),
            'e_no'          => $storeCode,
            'e_storename'   => config('app.name'),
            'e_mode'        => 9,
            'e_money'       => $amount,
            'e_cardno'      =>  $this->hashCardNo($creditCard->number, $creditCard->expiry, $creditCard->cvv),
            'str_check'     => $this->getCheckValue($tradeCode ,$no ,$storeCode ,$amount),
            'e_name'        => $user->fullName,
            'e_telm'        => $user->phone,
            'e_email'       => $user->email,
            'e_info'        => config('gomypay.title'),
            'e_backend_url' => config('gomypay.backendUrl')
        ];
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
}