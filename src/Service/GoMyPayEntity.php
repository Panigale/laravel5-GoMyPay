<?php
/**
 * Author: Panigale
 * Date: 2018/1/15
 * Time: 下午4:50
 */

namespace Panigale\GoMyPay\Service;


use Exception;
use Illuminate\Http\Request;
use Panigale\GoMyPay\Service\Entity\EntityFactory;

class GoMyPayEntity extends BaseSetting implements GoMyPayContract
{
    /**
     * GoMyPayOnline constructor.
     */
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

    /**
     * @param null $paymentType
     * @return array|mixed
     * @throws Exception
     */
    public function done($paymentType = null)
    {
        $request = request();

        return [
            'paymentType' => $request->OrderType,
            'serviceNo'   => $request->OrderID,
            'no'          => $request->CustomerOrderID,
            'payAccount'  => $request->PayAccount,
            'payed'      => $this->hasPayed(),
            'payAmount'   => $request->PayAmount,
            'payDate'     => $request->PayDate
        ];
//        return EntityFactory::create($paymentType)->callback(request()->all());
    }

    protected function payed()
    {
        return 'Status';
    }



    /**
     * create trade fields
     *
     * @return array|mixed
     * @throws Exception
     */
    public function redirect()
    {
        $attributes = [
            'Customer_no'     => $this->storeCode,
            'CustomerOrderID' => $this->paymentNo,
            'OrderType'       => $this->getPaymentType(),
            'Amount'          => $this->amount,
            'BuyerName'       => $this->username,
            'BuyerEmail'      => $this->email,
            'BuyerTelm'       => $this->phone,
            'CallBackUrl'     => $this->backendUrl,
            'str_check'       => $this->tradeCode,
            'actionUrl'       => $this->getActionUrl()
        ];

        if ($this->payBy === 'Web ATM')
            $attributes = array_merge($attributes, [
                'ReturnUrl' => $this->callbackUrl,
            ]);

        return $attributes;
    }

    /**
     * get action url
     *
     * @return mixed|string
     */
    public function getActionUrl()
    {
        return "https://gomypay.asia/Cathaybk/Cathaybk_pay.asp";
    }

    /**
     * get payment type code.
     *
     * 1. Web-ATM 2. 虛擬帳號繳費 3. 超商條碼代收
     *
     * @return int
     * @throws Exception
     */
    private function getPaymentType()
    {
        $tradeType = $this->payBy;

        switch ($tradeType) {
            case 'Web ATM':
                return 1;
            case 'virtual account':
                return 2;
            case 'barcode':
                return 3;
            default:
                throw new Exception('not allow payment type.');
        }
    }
}