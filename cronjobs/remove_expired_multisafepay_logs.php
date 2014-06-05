<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    03 Jun 2014
 * */
$cli->output( 'Starting removing expired MultiSafepay logs' );

$p = array(
    'date' => array( '<=', time() - MultiSafepayLogItem::getExpiryTime() )
);
eZPersistentObject::removeObject( MultiSafepayLogItem::definition(), $p );

$cli->output( 'Expired logs are removed' );
