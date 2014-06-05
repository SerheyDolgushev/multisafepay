<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    05 Jun 2014
 * */
$transaction = MultiSafepayTransaction::fetch( (int) $Params['TransactionID'] );
if( $transaction instanceof MultiSafepayTransaction === false ) {
    return $Params['Module']->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}

$tpl = eZTemplate::factory();
$tpl->setVariable( 'transaction', $transaction );

$Result['content']         = $tpl->fetch( 'design:multisafepay/transactions/view.tpl' );
$Result['navigation_part'] = eZINI::instance( 'multisafepay.ini' )->variable( 'NavigationParts', 'Transactions' );
$Result['path']            = array(
    array(
        'text' => ezpI18n::tr( 'extension/multisafepay', 'MultiSafepay Transaction details' ),
        'url'  => false
    )
);
