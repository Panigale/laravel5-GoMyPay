<?php
/**
 * Author: Panigale
 * Date: 2020/6/22
 * Time: 4:08 下午
 */

namespace Panigale\GoMyPay\Contracts;


interface GoMyPayContract
{
    /**
     * trade type
     *
     * creditCard:0、storeBarcode:2、WebATM:3、virtualAccount:4、Subscription:5
     * storeCode:6、linePay:7
     *
     * @return int
     */
    public function type() : int ;

    /**
     * pay mode enable；2
     *
     * @return int
     */
    public function payMode() : int ;

    /**
     * 顧客編號
     *
     * @return mixed
     */
    public function customerId();

    /**
     * 訂單編號
     *
     * @return mixed
     */
    public function orderNo();

    /**
     * 交易金額
     *
     * @return int
     */
    public function amount() : int;

    /**
     * 購買人姓名
     *
     * @return string
     */
    public function buyerName() :string ;

    /**
     * 購買人電話
     *
     * @return string
     */
    public function buyerTel() : string ;

    /**
     * 購買人電子郵件
     *
     * @return string
     */
    public function buyerEmail() : string ;

    /**
     * 購買項目
     *
     * @return string
     */
    public function itemName() : string ;
}