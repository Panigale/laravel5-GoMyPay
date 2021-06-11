<?php
/**
 * Author: Panigale
 * Date: 2020/6/22
 * Time: 4:05 下午
 */

namespace Panigale\GoMyPay\Service\V2\Payments;


use Panigale\GoMyPay\Service\V2\Payment;

class LinePay extends Payment
{
    public function type(): int
    {
        return 7;
    }
}