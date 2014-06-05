<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    01 Jun 2014
 * */
$orderID = 1;

$transaction = new MultiSafepayTransaction();
$transaction->setAttribute( 'order_id', $orderID );
$transaction->setAttribute( 't_amount', 1000 );
$transaction->setAttribute( 't_currency', 'EUR' );
$transaction->setAttribute( 't_description', 'Some description' );
$transaction->setAttribute( 't_items', '<br/><ul><li>Product 1 (x2)</li><li>Product 2 (x1)</li></ul>' );
$transaction->setAttribute( 'c_locale', 'en_GB' );
$transaction->setAttribute( 'c_country', 'GB' );
$transaction->setAttribute( 'c_email', 'dolgushev.serhey@gmail.com' );
$transaction->setAttribute( 'm_redirect_url', str_replace( 'ORDER_ID', $orderID, $transaction->attribute( 'm_redirect_url' ) ) );
$transaction->store();

try {
    $url = $transaction->getPaymentURL();
} catch( Exception $e ) {
    return $Params['Module']->redirectTo( 'multisafepay/error/' . $transaction->attribute( 'id' ) );
}

header( 'Location:' . $url );
eZExecution::cleanExit();
