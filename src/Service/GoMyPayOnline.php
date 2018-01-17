<?php
/**
 * Author: Panigale
 * Date: 2018/1/15
 * Time: 下午4:01
 */

namespace Panigale\GoMyPay\Service;


class GoMyPayOnline extends BaseSetting implements GoMyPayContract
{
    protected $backendUrl;

    private $cardNumber = null;

    private $cardExpiry = null;

    private $cardCVV = null;

    public function __construct()
    {
        $this->init();
    }

    /**
     * init
     */
    private function init()
    {
        $this->loadConfig();
    }

    public function getResult()
    {

    }

    public function done()
    {
        // TODO: Implement done() method.
    }

    /**
     * create payment.
     *
     * @return mixed
     */
    public function create()
    {
        return [
            'e_orderno'     => $this->paymentNo ?: uniqid(),
            'e_url'         => $this->callbackUrl,
            'e_no'          => $this->storeCode,
            'e_storename'   => config('gomypay.storeName'),
            'e_mode'        => 9,
            'e_money'       => $this->amount,
            'e_cardno'      => $this->getHashCardNo(),
            'str_check'     => $this->getCheckValue($this->paymentNo ,$this->storeCode ,$this->amount ,$this->tradeCode),
            'e_name'        => $this->username,
            'e_telm'        => $this->phone,
            'e_email'       => $this->email,
            'e_info'        => config('gomypay.title'),
            'e_backend_url' => $this->backendUrl
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
    private function getCheckValue($tradeCode ,$orderNo, $storeCode, $amount)
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
    private function getHashCardNo()
    {
        return base64_encode($this->cardCVV . $this->cardExpiry . $this->cardNumber);
    }

    /**
     * set trade credit information.
     *
     * @param $cardNumber
     * @param $expiry
     * @param $cvv
     * @return $this
     */
    public function withCard($cardNumber ,$expiry ,$cvv)
    {
        $this->setCardNumber($cardNumber)
             ->setCardExpiry($expiry)
             ->setCardCVV($cvv);

        return $this;
    }

    /**
     * set credit card number
     *
     * @param $cardNumber
     * @return $this
     */
    private function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * set credit card expiry.
     *
     * @param $expiry
     * @return $this
     */
    private function setCardExpiry($expiry)
    {
        $this->cardExpiry = $expiry;

        return $this;
    }

    /**
     * set credit card cvv.
     *
     * @param $cvv
     * @return $this
     */
    private function setCardCVV($cvv)
    {
        $this->cardCVV = $cvv;

        return $this;
    }
}