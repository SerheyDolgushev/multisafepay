<?php

/**
 * @package MultiSafepay
 * @class   MultiSafepayLogItem
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    05 Jun 2014
 * */
class MultiSafepayRedirectGateway extends eZRedirectGateway {

    const AUTOMATIC_STATUS   = false;
    const TYPE_MULTI_SAFEPAY = 'multifafepay';

    public function __construct() {
        $this->logger = self::getLogHandler();
    }

    public static function getLogHandler() {
        return eZPaymentLogger::CreateForAdd( 'var/log/multifafepay.log' );
    }

    public function createPaymentObject( $processID, $orderID ) {
        $this->logger->writeTimedString( 'MultiSafepayRedirectGateway::createPaymentObject' );
        return eZPaymentObject::createNew( $processID, $orderID, self::TYPE_MULTI_SAFEPAY );
    }

    public function createRedirectionUrl( $process ) {
        $this->logger->writeTimedString( 'MultiSafepayRedirectGateway::createRedirectionUrl' );

        $processParams = $process->attribute( 'parameter_list' );
        $order         = eZOrder::fetch( $processParams['order_id'] );

        $transaction = new MultiSafepayTransaction();
        $transaction->store();
        $transaction->readOrderData( $order );

        try {
            $url = $transaction->getPaymentURL();
        } catch( Exception $e ) {
            $url = 'multisafepay/error/' . $transaction->attribute( 'id' );
            eZURI::transformURI( $redirectURL, false, 'full' );
        }

        return $url;
    }

    public static function name() {
        return 'Multi Safepay';
    }

    public static function costs() {
        return 0.00;
    }

}
