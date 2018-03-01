<?php
/**
 * Author: Panigale
 * Date: 2018/3/1
 * Time: 下午4:10
 */

namespace Panigale\GoMyPay\Service;


trait ReceivePayment
{
    protected function receive()
    {
        $orderType = request('OrderType');

        /**
         * 如果沒有 OrderType 這個參數，代表非信用卡交易
         */
        $gomypay = is_null($orderType) ? new GoMyPayOnline() : new GoMyPayEntity();

        return $gomypay->done($orderType);
    }
}