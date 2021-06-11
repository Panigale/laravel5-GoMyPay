<?php
/**
 * Author: Panigale
 * Date: 2020/6/22
 * Time: 4:08 下午
 */

namespace Panigale\GoMyPay\Service\V2;


use Panigale\GoMyPay\Contracts\GoMyPayContract;
use Panigale\GoMyPay\Service\Traits\GoMyPayConfig;

class Payment implements GoMyPayContract
{
    use GoMyPayConfig;

    /**
     * @var
     */
    protected $orderNo;
    protected $amount;
    protected $itemName;

    protected $customer;

    public function __construct()
    {
        $this->loadConfig();
    }

    /**
     * trade type
     *
     * creditCard:0、storeBarcode:2、WebATM:3、virtualAccount:4、Subscription:5
     * storeCode:6、linePay:7
     *
     * @return int
     */
    public function type(): int
    {
        // TODO: Implement type() method.
    }

    /**
     * pay mode enable；2
     *
     * @return int
     */
    public function payMode(): int
    {
        return 2;
    }

    /**
     * 顧客編號
     *
     * @return mixed
     */
    public function customerId()
    {
        return 'id';
    }

    /**
     * 訂單編號
     *
     * @return mixed
     */
    public function orderNo()
    {
        return $this->orderNo;
    }

    public function pay($amount ,$no)
    {
        $this->amount = $amount;
        $this->orderNo = $no;
        $name = $this->buyerName();
        $name = $this->buyerName();
        $tel = $this->buyerTel();
        $email = $this->buyerEmail();

        return [
            'Send_Type'    => $this->type(),
            'Pay_Mode_No'  => $this->payMode(),
            'CustomerId'   => $this->storeCode,
            'Order_No'     => $this->orderNo(),
            'Amount'       => $this->amount(),
            'TransCode'    => '00',
            'Buyer_Name'   => $this->customer->$name,
            'Buyer_Telm'   => $this->customer->$tel,
            'Buyer_Mail'   => $this->customer->$email,
            'Buyer_Memo'   => $this->itemName(), 
            'actionUrl'    => $this->actionUrl(),
            'Return_url'   => $this->callbackUrl,
            'Callback_Url' => $this->backendUrl
        ];
    }

    /**
     * 交易金額
     *
     * @return int
     */
    public function amount() : int
    {
        return $this->amount;
    }

    /**
     * 購買人姓名
     *
     * @return string
     */
    public function buyerName(): string
    {
        return 'name';
    }

    /**
     * 購買人電話
     *
     * @return string
     */
    public function buyerTel(): string
    {
        return 'phone';
    }

    /**
     * 購買人電子郵件
     *
     * @return string
     */
    public function buyerEmail(): string
    {
        return 'email';
    }

    /**
     * 購買項目
     *
     * @return string
     */
    public function itemName(): string
    {
        return config('gomypay.title');
        return $this->itemName;
    }

    public function setCustomer($user)
    {
        $this->customer = $user;

        return $this;
    }

    public function done()
    {
        $request = request();
        $goMyPayNo = $request->OrderID;
        $amount = (int)$request->e_money;
        $orderNo = $request->e_orderno;
        $bankResponse = $request->ret_msg;

        return [
            'serviceNo' => $goMyPayNo,
            'payAmount' => $amount,
            'payed' => $this->hasPayed(),
            'no'        => $orderNo,
            'response'  => $bankResponse
        ];
    }

    private function hasPayed()
    {
        return request()->result;
    }
}