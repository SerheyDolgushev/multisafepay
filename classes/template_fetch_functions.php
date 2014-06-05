<?php

/**
 * @package MultiSafepay
 * @class   MultiSafepayTemplateFetchFunctions
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    05 Jun 2014
 * */
class MultiSafepayTemplateFetchFunctions {

    public function fetchTransaction( $orderID ) {
        $transaction = eZPersistentObject::fetchObject(
                MultiSafepayTransaction::definition(), null, array( 'order_id' => $orderID ), true
        );

        return array( 'result' => $transaction );
    }

}
