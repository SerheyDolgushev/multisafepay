<?php

/**
 * @package MultiSafepay
 * @class   MultiSafepayLogItem
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    03 Jun 2014
 * */
class MultiSafepayLogItem extends eZPersistentObject {

    public function __construct( array $row = null ) {
        parent::__construct( $row );

        if( $this->attribute( 'id' ) === null ) {
            $skipClasses = array( 'eZModule', 'eZProcess', __CLASS__ );
            $bt          = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
            foreach( $bt as $i => $call ) {
                // remove calls for current class and index.php
                if( isset( $call['class'] ) === false || in_array( $call['class'], $skipClasses ) ) {
                    unset( $bt[$i] );
                }
            }

            $baseDir = getcwd() . '/';
            foreach( $bt as $call ) {
                $backtrace[] = array(
                    'file'     => isset( $call['file'] ) ? str_replace( $baseDir, '', $call['file'] ) : null,
                    'line'     => isset( $call['line'] ) ? $call['line'] : null,
                    'function' => isset( $call['function'] ) ? $call['function'] : null,
                    'class'    => isset( $call['class'] ) ? $call['class'] : null,
                    'type'     => isset( $call['type'] ) ? $call['type'] : null,
                );
            }

            $this->setAttribute( 'backtrace', array_reverse( $backtrace ) );
        } else {
            // Unserialize backtrace
            $this->setAttribute( 'backtrace', unserialize( $this->attribute( 'backtrace' ) ) );
        }
    }

    public function __get( $attr ) {
        return null;
    }

    public static function definition() {
        return array(
            'fields'              => array(
                'id'             => array(
                    'name'     => 'ID',
                    'datatype' => 'integer',
                    'default'  => 0,
                    'required' => true
                ),
                'transaction_id' => array(
                    'name'     => 'TransactionID',
                    'datatype' => 'string',
                    'default'  => 0,
                    'required' => true
                ),
                'date'           => array(
                    'name'     => 'Date',
                    'datatype' => 'integer',
                    'default'  => time(),
                    'required' => true
                ),
                'url'            => array(
                    'name'     => 'URL',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'duration'       => array(
                    'name'     => 'Duration',
                    'datatype' => 'float',
                    'default'  => 0,
                    'required' => false
                ),
                'error'          => array(
                    'name'     => 'Error',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'request'        => array(
                    'name'     => 'Request',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'response'       => array(
                    'name'     => 'Response',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'backtrace'      => array(
                    'name'     => 'Backtrace',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'ip'             => array(
                    'name'     => 'IP',
                    'datatype' => 'string',
                    'default'  => \eZSys::clientIP(),
                    'required' => false
                )
            ),
            'function_attributes' => array(
                'backtrace_output' => 'getBacktraceOutput'
            ),
            'keys'                => array( 'id' ),
            'sort'                => array( 'id' => 'desc' ),
            'increment_key'       => 'id',
            'class_name'          => __CLASS__,
            'name'                => 'multisafepay_logs'
        );
    }

    public function getBacktraceOutput() {
        return var_export( $this->attribute( 'backtrace' ), true );
    }

    public function store( $fieldFilters = null ) {
        $this->setAttribute( 'backtrace', serialize( $this->attribute( 'backtrace' ) ) );
        eZPersistentObject::storeObject( $this, $fieldFilters );
        $this->setAttribute( 'backtrace', unserialize( $this->attribute( 'backtrace' ) ) );
    }

    public static function fetchList( $conditions = null, $limitations = null, $custom_conds = null ) {
        return eZPersistentObject::fetchObjectList(
                static::definition(), null, $conditions, null, $limitations, true, false, null, null, $custom_conds
        );
    }

    public static function countAll( $conditions = null, $custom_conds = null ) {
        $customFields = array( array( 'operation' => 'COUNT( * )', 'name' => 'row_count' ) );
        $rows         = eZPersistentObject::fetchObjectList(
                static::definition(), null, $conditions, null, null, false, false, $customFields, null, $custom_conds
        );
        return $rows[0]['row_count'];
    }

    public static function transformXML( $xmlString ) {
        if( empty( $xmlString ) ) {
            return null;
        }

        $dom                     = new \DOMDocument();
        $dom->formatOutput       = true;
        $dom->preserveWhiteSpace = false;
        @$dom->loadXML( $xmlString );
        return $dom->saveXML();
    }

    public static function getExpiryTime() {
        return eZINI::instance( 'multisafepay.ini' )->variable( 'General', 'LogsExpiryTime' );
    }

}
