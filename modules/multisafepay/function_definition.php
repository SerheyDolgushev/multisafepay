<?php

/**
 * @package MultiSafepay
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    05 Jun 2014
 * */
$FunctionList = array(
    'fetch_transaction' => array(
        'name'           => 'fetch_transaction',
        'call_method'    => array(
            'class'  => 'MultiSafepayTemplateFetchFunctions',
            'method' => 'fetchTransaction'
        ),
        'parameter_type' => 'standard',
        'parameters'     => array(
            array(
                'name'     => 'order_id',
                'type'     => 'int',
                'required' => true
            )
        )
    )
);
