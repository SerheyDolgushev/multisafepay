<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    05 Jun 2014
 * */
eZPaymentGatewayType::registerGateway(
    MultiSafepayRedirectGateway::TYPE_MULTI_SAFEPAY, 'MultiSafepayRedirectGateway', MultiSafepayRedirectGateway::name()
);
