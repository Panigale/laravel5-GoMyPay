<?php
/**
 * Author: Panigale
 * Date: 2018/1/15
 * Time: 下午2:06
 */
return [

    // your store name.
    'storeName' => env('GOMYPAY_STORE_NAME'),

    // store code.
    'storeCode'   => env('GOMYPAY_STORE_CODE'),

    // trade code.
    'tradeCode'   => env('GOMYPAY_TRADE_CODE'),

    // custom callback url.
    'callbackUrl' => env('GOMYPAY_CALLBACK_URL'),

    // custom backend url.
    'backendUrl'  => env('GOMYPAY_BACKEND_URL'),

    // payment title.
    'title' => env('GOMYPAY_TITILE'),

    'user' => [
        'name' => 'name'
    ]
];