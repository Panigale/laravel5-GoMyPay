<?php
/**
 * Author: Panigale
 * Date: 2020/6/22
 * Time: 3:59 下午
 */

namespace Panigale\GoMyPay\Service\V2\Payments;


use Panigale\GoMyPay\Service\V2\Payment;

class StoreBarcode extends Payment
{
    public function type(): int
    {
        return 2;
    }
}