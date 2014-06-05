<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    05 Jun 2014
 * */
$params      = $Params['Module']->UserParameters;
$offset      = isset( $params['offset'] ) ? (int) $params['offset'] : 0;
$limit       = isset( $params['limit'] ) ? (int) $params['limit'] : 50;
$limitations = array(
    'limit'  => $limit,
    'offset' => $offset
);

$tpl = eZTemplate::factory();
$tpl->setVariable( 'transactions', MultiSafepayTransaction::fetchList( null, $limitations ) );
$tpl->setVariable( 'offset', $offset );
$tpl->setVariable( 'limit', $limit );
$tpl->setVariable( 'total_count', MultiSafepayTransaction::countAll() );

$Result['content']         = $tpl->fetch( 'design:multisafepay/transactions/list.tpl' );
$Result['navigation_part'] = eZINI::instance( 'multisafepay.ini' )->variable( 'NavigationParts', 'Transactions' );
$Result['path']            = array(
    array(
        'text' => ezpI18n::tr( 'extension/multisafepay', 'MultiSafepay Transactions' ),
        'url'  => false
    )
);
