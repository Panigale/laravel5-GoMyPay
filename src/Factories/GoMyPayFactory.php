<?php
/**
 * Author: Panigale
 * Date: 2020/6/22
 * Time: 4:50 下午
 */

namespace Panigale\GoMyPay\Factories;


class GoMyPayFactory
{
    public static function handler($payment)
    {
        $namespace = "Panigale\GoMyPay\Service\V2\Payments\\".ucfirst(camel_case($payment));

        return app()->make($namespace);
    }

    public static function makeHandlerByType(int $typeNum)
    {
        $type = '';

        switch ($typeNum){
            case 0:
                $type = 'creditCard';
            case 2:
                $type = 'StoreBarcode';
            case 4:
                $type = 'virtualAccount';
            case 5:
                $type = 'subscription';
            case 6:
                $type = 'storeCode';
            case 7:
                $type = 'linePay';
        }

        $namespace = "Panigale\GoMyPay\Service\V2\Payments\\".ucfirst(camel_case($type));

        return app()->make($namespace);
    }
}