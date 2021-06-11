<?php
/**
 * Author: Panigale
 * Date: 2020/6/22
 * Time: 5:13 下午
 */

namespace Panigale\GoMyPay\Service\Traits;


trait GoMyPayConfig
{
    /**
     * your gomypay trade code.
     *
     * @var
     */
    protected $tradeCode;

    /**
     * your gomypay store code
     *
     * @var
     */
    protected $storeCode;

    /**
     * return url
     *
     * @var
     */
    protected $callbackUrl;

    /**
     * backend notification url
     *
     * @var
     */
    protected $backendUrl;

    private $actionUrlV2 = 'https://n.gomypay.asia/ShuntClass.aspx';

    private $developerUrl = 'https://n.gomypay.asia/TestShuntClass.aspx';

    /**
     * load config
     */
    protected function loadConfig()
    {
        $this->storeCode = config('gomypay.storeCode');
        $this->tradeCode = config('gomypay.tradeCode');
        $this->callbackUrl = config('gomypay.callbackUrl');
        $this->backendUrl = config('gomypay.backendUrl');
    }

    public function actionUrl()
    {
        return config('gomypay.developerMode') ? $this->developerUrl : $this->actionUrlV2;
    }
}