<?php

/**
 * @package MultiSafepay
 * @class   MultiSafepayAPI
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    03 Jun 2014
 * */
class MultiSafepayAPI extends MultiSafepay {

    public $plugin_name = 'eZPublish connect';
    public $version     = '06-2014';

    public function xmlPost( $url, $request_xml, $verify_peer = false ) {
        $startTime = microtime( true );
        $reply_xml = parent::xmlPost( $url, $request_xml, $verify_peer );

        $error = null;
        if( (int) $this->error_code != 0 ) {
            $error = $this->error_code . ': ' . $this->error;
        }

        if( $error === null ) {
            $xml = simplexml_load_string( $reply_xml );
            if( strtolower( (string) $xml->attributes()->result ) != 'ok' ) {
                $error = (string) $xml->error->code . ': ' . (string) $xml->error->description;
            }
        }

        $log = new MultiSafepayLogItem();
        $log->setAttribute( 'transaction_id', $this->transaction['id'] );
        $log->setAttribute( 'url', $this->api_url );
        $log->setAttribute( 'duration', microtime( true ) - $startTime );
        $log->setAttribute( 'error', $error );
        $log->setAttribute( 'request', MultiSafepayLogItem::transformXML( $request_xml ) );
        $log->setAttribute( 'response', MultiSafepayLogItem::transformXML( $reply_xml ) );
        $log->store();

        return $reply_xml;
    }

}
