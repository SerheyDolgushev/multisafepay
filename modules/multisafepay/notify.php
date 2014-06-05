<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    03 Jun 2014
 * */
$http           = eZHTTPTool::instance();
$error          = null;
$transactiondID = $http->getVariable( 'transactionid', -1 );
$isRedirected   = (bool) $http->getVariable( 'redirect', false );

$transaction = MultiSafepayTransaction::fetchByTransactionID( $transactiondID );
if( $transaction instanceof MultiSafepayTransaction === false ) {
    $error = 'Wrong transaction ID';
}

if( $transaction instanceof MultiSafepayTransaction ) {
    try {
        $transaction->updateStatus();
    } catch( Exception $e ) {
        $error = $e->getMessage() . ' (' . $e->getCode() . ')';
    }
}

if( $isRedirected ) {
    $transaction->updatePaymentObject();
    return $Params['Module']->redirectTo( 'shop/orderview/' . $transaction->attribute( 'order_id' ) );
}

$response = $error === null ? 'ok' : 'Error: ' . $error;
echo $response;
eZExecution::cleanExit();

