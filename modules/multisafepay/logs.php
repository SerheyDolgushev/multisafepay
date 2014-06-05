<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    01 Jun 2014
 * */
$http          = eZHTTPTool::instance();
$defaultFilter = array(
    'error'          => null,
    'ip'             => eZSys::clientIP(),
    'transaction_id' => null,
    'request'        => null,
    'response'       => null
);
$filter        = $http->sessionVariable( 'multisafepay_filter', $defaultFilter );


if( $http->hasVariable( 'filter' ) ) {
    $filter = array_merge( $filter, (array) $http->variable( 'filter' ) );
}
$http->setSessionVariable( 'multisafepay_filter', $filter );

$customConds = null;
$conditions  = array();

if( strlen( $filter['error'] ) !== 0 ) {
    if( (bool) $filter['error'] ) {
        $customConds .= ' AND error IS NOT NULL';
    } else {
        $customConds .= ' AND error IS NULL';
    }
}

if( strlen( $filter['ip'] ) !== 0 ) {
    $conditions['ip'] = array( 'like', '%' . $filter['ip'] . '%' );
}
if( strlen( $filter['transaction_id'] ) !== 0 ) {
    $conditions['transaction_id'] = $filter['transaction_id'];
}
if( strlen( $filter['request'] ) !== 0 ) {
    $conditions['request'] = array( 'like', '%' . $filter['request'] . '%' );
}
if( strlen( $filter['response'] ) !== 0 ) {
    $conditions['response'] = array( 'like', '%' . $filter['response'] . '%' );
}

if( count( $conditions ) === 0 ) {
    $conditions  = null;
    $customConds = ' WHERE 1 ' . $customConds;
}

$params      = $Params['Module']->UserParameters;
$offset      = isset( $params['offset'] ) ? (int) $params['offset'] : 0;
$limit       = isset( $params['limit'] ) ? (int) $params['limit'] : 20;
$limitations = array(
    'limit'  => $limit,
    'offset' => $offset
);

$tpl = eZTemplate::factory();
$tpl->setVariable( 'logs', MultiSafepayLogItem::fetchList( $conditions, $limitations, $customConds ) );
$tpl->setVariable( 'filter', $filter );
$tpl->setVariable( 'offset', $offset );
$tpl->setVariable( 'limit', $limit );
$tpl->setVariable( 'total_count', MultiSafepayLogItem::countAll( $conditions, $customConds ) );

$Result['content']         = $tpl->fetch( 'design:multisafepay/logs/show.tpl' );
$Result['navigation_part'] = eZINI::instance( 'multisafepay.ini' )->variable( 'NavigationParts', 'Logs' );
$Result['path']            = array(
    array(
        'text' => ezpI18n::tr( 'extension/multisafepay', 'MultiSafepay Logs' ),
        'url'  => false
    )
);
