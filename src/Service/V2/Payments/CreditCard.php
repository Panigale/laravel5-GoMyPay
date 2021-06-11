<?php
/**
 * Author: Panigale
 * Date: 2020/6/22
 * Time: 3:59 下午
 */

namespace Panigale\GoMyPay\Service\V2\Payments;


use Panigale\GoMyPay\Service\V2\Payment;

class CreditCard extends Payment
{
    protected $creditCard;
    /**
     * @var int
     */
    protected $installment;

    public function type(): int
    {
        return 0;
    }

    public function payByCreditCard($creditCard, $installment = 0)
    {
        $this->setCreditCard($creditCard);
        $this->setInstallment($installment);

        return $this;
    }

    public function pay($amount ,$no)
    {
        $this->amount = $amount;
        $this->orderNo = $no;
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
            'CardNo'       => $this->creditCardNum(),
            'ExpireDate'   => $this->creditCardExpiry(),
            'CVV'          => $this->creditCardCVV(),
            'TransMode'    => $this->transMode(),
            'Installment'  => $this->installment(),
            'actionUrl'    => $this->actionUrl(),
            'Return_url'   => $this->callbackUrl,
            'Callback_Url' => $this->backendUrl
        ];
    }

    public function transMode()
    {
        return $this->installment > 0 ? 2 : 1;
    }

    public function cardNum()
    {
        return 'number';
    }

    public function expiry()
    {
        return 'expiry';
    }

    public function cvv()
    {
        return 'cvv';
    }

    private function setCreditCard($creditCard)
    {
        $this->creditCard = $creditCard;

        return $this;
    }

    private function creditCard()
    {
        return $this->creditCard;
    }

    private function creditCardNum()
    {
        $creditCard = $this->creditCard();
        $cardNum = $this->cardNum();

        return is_array($creditCard) ? $creditCard[$cardNum] : $creditCard->$cardNum;
    }

    private function creditCardExpiry()
    {
        $creditCard = $this->creditCard();
        $expiry = $this->expiry();

        return is_array($creditCard) ? $creditCard[$expiry] : $creditCard->$expiry;
    }

    private function creditCardCVV()
    {
        $creditCard = $this->creditCard();
        $expiry = $this->cvv();

        return is_array($creditCard) ? $creditCard[$expiry] : $creditCard->$expiry;
    }

    private function setInstallment(int $installment)
    {
        $this->installment = $installment;
    }

    public function installment()
    {
        return $this->installment;
    }
}