<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    01 Jun 2014
 * */
$Module = array(
    'name'            => 'MultiSafepay Payment Gateway',
    'variable_params' => true
);

$ViewList = array(
    'test'             => array(
        'functions' => array( 'pay' ),
        'script'    => 'test.php',
        'params'    => array()
    ),
    'error'            => array(
        'functions' => array( 'pay' ),
        'script'    => 'error.php',
        'params'    => array( 'TransactionID' )
    ),
    'notify'           => array(
        'functions' => array( 'pay' ),
        'script'    => 'notify.php',
        'params'    => array()
    ),
    'logs'             => array(
        'functions' => array( 'logs' ),
        'script'    => 'logs.php',
        'params'    => array()
    ),
    'transactions'     => array(
        'functions' => array( 'transactions' ),
        'script'    => 'transactions.php',
        'params'    => array()
    ),
    'view_transaction' => array(
        'functions' => array( 'transactions' ),
        'script'    => 'view_transaction.php',
        'params'    => array( 'TransactionID' )
    )
);

$FunctionList = array(
    'pay'          => array(),
    'transactions' => array(),
    'logs'         => array()
);
