<?php

/**
 * @package MultiSafepay
 * @class   MultiSafepayLogItem
 * @author  Serhey Dolgushev <dolgushev.serhey@gmail.com>
 * @date    04 Jun 2014
 * */
class MultiSafepayTransaction extends eZPersistentObject {

    private $ini   = null;
    private $cache = array(
        'user'  => null,
        'order' => null
    );

    public function __construct( $row = array() ) {
        $this->eZPersistentObject( $row );

        $this->ini = eZINI::instance( 'multisafepay.ini' );

        if( $this->attribute( 'id' ) === null ) {
            $this->setDefaultAttributes();
        }
    }

    private function setDefaultAttributes() {
        $this->setAttribute( 'user_id', eZUser::currentUserID() );

        $allowedCurrencies = $this->ini->variable( 'General', 'AllowedCurrencies' );
        $this->setAttribute( 't_currency', $allowedCurrencies[0] );

        $this->setAttribute( 't_gateway', $this->ini->variable( 'General', 'Gateway' ) );
        $this->setAttribute( 'm_account_id', $this->ini->variable( 'General', 'AccountID' ) );
        $this->setAttribute( 'm_site_id', $this->ini->variable( 'General', 'SiteID' ) );
        $this->setAttribute( 'm_secure_code', $this->ini->variable( 'General', 'SiteSecureCode' ) );

        $urls = array(
            'm_notification_url' => 'NotifyURL',
            'm_cancel_url'       => 'CancelURL',
            'm_redirect_url'     => 'RedirectURL'
        );
        foreach( $urls as $attr => $setting ) {
            $url = $this->ini->variable( 'General', $setting );
            eZURI::transformURI( $url, false, 'full' );
            $this->setAttribute( $attr, $url );
        }
    }

    public static function definition() {
        return array(
            'fields'              => array(
                // General fields
                'id'                 => array(
                    'name'     => 'id',
                    'datatype' => 'integer',
                    'default'  => 0,
                    'required' => true
                ),
                'ewallet_id'         => array(
                    'name'     => 'ewalletID',
                    'datatype' => 'integer',
                    'default'  => null,
                    'required' => false
                ),
                'status'             => array(
                    'name'     => 'status',
                    'datatype' => 'string',
                    'default'  => 'initialized',
                    'required' => false
                ),
                'created'            => array(
                    'name'     => 'created',
                    'datatype' => 'integer',
                    'default'  => time(),
                    'required' => true
                ),
                'updated'            => array(
                    'name'     => 'updated',
                    'datatype' => 'integer',
                    'default'  => time(),
                    'required' => true
                ),
                'order_id'           => array(
                    'name'     => 'orderID',
                    'datatype' => 'integer',
                    'default'  => null,
                    'required' => true
                ),
                'user_id'            => array(
                    'name'     => 'userID',
                    'datatype' => 'integer',
                    'default'  => null,
                    'required' => true
                ),
                'signature'          => array(
                    'name'     => 'signature',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'ga_account'         => array(
                    'name'     => 'GAAccount',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'error_code'         => array(
                    'name'     => 'error_code',
                    'datatype' => 'integer',
                    'default'  => null,
                    'required' => false
                ),
                'error_description'  => array(
                    'name'     => 'errorDescription',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                // Transaction fields
                't_id'               => array(
                    'name'     => 'tID',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => true
                ),
                't_currency'         => array(
                    'name'     => 'tCurrency',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => true
                ),
                't_amount'           => array(
                    'name'     => 'tAmount',
                    'datatype' => 'integer',
                    'default'  => null,
                    'required' => true
                ),
                't_description'      => array(
                    'name'     => 'tDescription',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                't_var1'             => array(
                    'name'     => 'tVar1',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                't_var2'             => array(
                    'name'     => 'tVar2',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                't_var3'             => array(
                    'name'     => 'tVar3',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                't_items'            => array(
                    'name'     => 'tItems',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => true
                ),
                't_manual'           => array(
                    'name'     => 'tManual',
                    'datatype' => 'integer',
                    'default'  => 0,
                    'required' => false
                ),
                't_gateway'          => array(
                    'name'     => 'tGateway',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => true
                ),
                't_daysactive'       => array(
                    'name'     => 'tDaysactive',
                    'datatype' => 'integer',
                    'default'  => null,
                    'required' => false
                ),
                't_payment_url'      => array(
                    'name'     => 'tPaymentURL',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => true
                ),
                // Merchant fields
                'm_account_id'       => array(
                    'name'     => 'mAccountID',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'm_site_id'          => array(
                    'name'     => 'mSiteID',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'm_secure_code'      => array(
                    'name'     => 'mSecureCode',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'm_notification_url' => array(
                    'name'     => 'mNotificationURL',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'm_cancel_url'       => array(
                    'name'     => 'mCancelURL',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'm_redirect_url'     => array(
                    'name'     => 'mRedirectURL',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'm_close_window'     => array(
                    'name'     => 'mCloseWindow',
                    'datatype' => 'integer',
                    'default'  => 1,
                    'required' => false
                ),
                // Customer fields
                'c_locale'           => array(
                    'name'     => 'cLocale',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_ipaddress'        => array(
                    'name'     => 'cIPAddress',
                    'datatype' => 'string',
                    'default'  => eZSys::clientIP(),
                    'required' => false
                ),
                'c_forwardedip'      => array(
                    'name'     => 'cForwardedIP',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_firstname'        => array(
                    'name'     => 'cFirstMame',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_lastname'         => array(
                    'name'     => 'cLastMame',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_address1'         => array(
                    'name'     => 'cAddress1',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_address2'         => array(
                    'name'     => 'cAddress2',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_housenumber'      => array(
                    'name'     => 'cHouseNumber',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_zipcode'          => array(
                    'name'     => 'cZipCode',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_city'             => array(
                    'name'     => 'cCity',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_state'            => array(
                    'name'     => 'cState',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_country'          => array(
                    'name'     => 'cCountry',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_phone'            => array(
                    'name'     => 'cPhone',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_email'            => array(
                    'name'     => 'cEmail',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_currency'         => array(
                    'name'     => 'cCurrency',
                    'datatype' => 'string',
                    'default'  => null,
                    'required' => false
                ),
                'c_amount'           => array(
                    'name'     => 'cAmount',
                    'datatype' => 'integer',
                    'default'  => null,
                    'required' => false
                ),
                'c_exchange_rate'    => array(
                    'name'     => 'cExchangeRate',
                    'datatype' => 'float',
                    'default'  => null,
                    'required' => false
                )
            ),
            'function_attributes' => array(
                'amount_formatted' => 'getAmountFormatted',
                'user'             => 'getUser',
                'order'            => 'getOrder',
                'view_attributes'  => 'getViewAttributes',
                'log_items'        => 'getLogItems'
            ),
            'keys'                => array( 'id' ),
            'sort'                => array( 'id' => 'desc' ),
            'increment_key'       => 'id',
            'class_name'          => __CLASS__,
            'name'                => 'multisafepay_transactions'
        );
    }

    public function getUser() {
        if(
            $this->cache['user'] === null && $this->attribute( 'user_id' ) !== null
        ) {
            $user = eZContentObject::fetch( $this->attribute( 'user_id' ) );
            if( $user instanceof eZContentObject ) {
                $this->cache['user'] = $user;
            }
        }

        return $this->cache['user'];
    }

    public function getOrder() {
        if(
            $this->cache['order'] === null && $this->attribute( 'order_id' ) !== null
        ) {
            $order = eZOrder::fetch( $this->attribute( 'order_id' ) );
            if( $order instanceof eZOrder ) {
                $this->cache['order'] = $order;
            }
        }

        return $this->cache['order'];
    }

    public function getAmountFormatted() {
        return number_format( $this->attribute( 't_amount' ) / 100, 2, '.', '' );
    }

    public function getViewAttributes() {
        return array(
            array(
                'name'  => 'General',
                'attrs' => array(
                    'id'                => 'ID',
                    'ewallet_id'        => 'eWallet ID',
                    'status'            => 'Status',
                    'created'           => 'Created',
                    'updated'           => 'Updated',
                    'order_id'          => 'Order ID',
                    'user_id'           => 'User ID',
                    'signature'         => 'Signature',
                    'ga_account'        => 'GA Account',
                    'error_code'        => 'Error Code',
                    'error_description' => 'Error Description'
                )
            ),
            array(
                'name'  => 'Transaction',
                'attrs' => array(
                    't_id'          => 'ID',
                    't_currency'    => 'Currency',
                    't_amount'      => 'Amount',
                    't_description' => 'Description',
                    't_var1'        => 'Var1',
                    't_var2'        => 'Var2',
                    't_var3'        => 'Var3',
                    't_items'       => 'Items',
                    't_manual'      => 'Is manual',
                    't_gateway'     => 'Gateway',
                    't_daysactive'  => 'Days active',
                    't_payment_url' => 'Payment_url'
                )
            ),
            array(
                'name'  => 'Merchant',
                'attrs' => array(
                    'm_account_id'       => 'Account ID',
                    'm_site_id'          => 'Site ID',
                    'm_secure_code'      => 'Secure code',
                    'm_notification_url' => 'Notification URL',
                    'm_cancel_url'       => 'Cancel URL',
                    'm_redirect_url'     => 'Redirect URL',
                    'm_close_window'     => 'Close window'
                )
            ),
            array(
                'name'  => 'Customer',
                'attrs' => array(
                    'c_locale'        => 'Locale',
                    'c_ipaddress'     => 'IP Address',
                    'c_forwardedip'   => 'Forwarded IP Address',
                    'c_firstname'     => 'Firstname',
                    'c_lastname'      => 'Lastname',
                    'c_address1'      => 'Address line 1',
                    'c_address2'      => 'Address line 2',
                    'c_housenumber'   => 'House number',
                    'c_zipcode'       => 'ZIP',
                    'c_city'          => 'City',
                    'c_state'         => 'State',
                    'c_country'       => 'Country',
                    'c_phone'         => 'Phone',
                    'c_email'         => 'EMail',
                    'c_amount'        => 'Amount',
                    'c_currency'      => 'Currency',
                    'c_exchange_rate' => 'Exchange rate'
                )
            )
        );
    }

    public function getLogItems() {
        return eZPersistentObject::fetchObjectList(
                MultiSafepayLogItem::definition(), null, array( 'transaction_id' => $this->attribute( 't_id' ) )
        );
    }

    public static function fetch( $id ) {
        return eZPersistentObject::fetchObject(
                self::definition(), null, array( 'id' => $id ), true
        );
    }

    public static function fetchByTransactionID( $transactionID ) {
        return eZPersistentObject::fetchObject(
                self::definition(), null, array( 't_id' => $transactionID ), true
        );
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

    public function store( $fieldFilters = null ) {
        $this->setAttribute( 'updated', time() );

        eZPersistentObject::storeObject( $this, $fieldFilters );

        // Generate transactionID
        if( $this->attribute( 't_id' ) === null ) {
            $this->setAttribute( 't_id', $this->ini->variable( 'General', 'TransactionIDPrefix' ) . $this->attribute( 'id' ) );
            eZPersistentObject::storeObject( $this, $fieldFilters );
        }
    }

    public function readOrderData( eZOrder $order ) {
        $items             = null;
        $description       = ezpI18n::tr(
                'extension/multisafepay', 'Order #%order_id', null, array( '%order_id' => $order->attribute( 'order_nr' ) )
        );
        $productCollection = $order->attribute( 'productcollection' );
        if( $productCollection instanceof eZProductCollection ) {
            $products = $productCollection->itemList( false );
            foreach( $products as $product ) {
                $items .= '<li>' . $product['name'] . ' (x' . $product['item_count'] . ')</li>';
            }
            $items = '<br/><ul>' . $items . '</ul>';
        }

        $this->setAttribute( 'order_id', $order->attribute( 'id' ) );
        $this->setAttribute( 't_amount', $order->attribute( 'total_inc_vat' ) * 100 );
        if( $productCollection instanceof eZProductCollection ) {
            $this->setAttribute( 't_currency', $productCollection->attribute( 'currency_code' ) );
        }
        $this->setAttribute( 't_description', $description );
        $this->setAttribute( 't_items', $items );
        $this->setAttribute( 'm_redirect_url', str_replace( 'ORDER_ID', $order->attribute( 'id' ), $this->attribute( 'm_redirect_url' ) ) );
        $this->setAttribute( 'c_locale', eZLocale::instance()->attribute( 'http_locale_code' ) );

        $map      = array(
            'c_firstname' => 'first_name',
            'c_lastname'  => 'last_name',
            'c_address1'  => 'address1',
            'c_address2'  => 'address2',
            'c_zipcode'   => 'zip',
            'c_city'      => 'city',
            'c_state'     => 'state',
            'c_phone'     => 'phone',
            'c_email'     => 'email'
        );
        $userData = $order->attribute( 'account_information' );
        foreach( $map as $attr => $key ) {
            if( isset( $userData[$key] ) ) {
                $this->setAttribute( $attr, $userData[$key] );
            }
        }

        $country = isset( $userData['country'] ) ? $userData['country'] : null;
        if( empty( $country ) === false && strlen( $country ) !== 2 ) {
            $c = eZCountryType::fetchCountry( $country, 'Alpha3' );
            if( is_array( $c ) && isset( $c['Alpha2'] ) ) {
                $country = $c['Alpha2'];
            }
        }
        if( strlen( $country ) === 2 ) {
            $this->setAttribute( 'c_country', $country );
        }

        $this->store();
    }

    public function getPaymentURL() {
        $url = $this->attribute( 't_payment_url' );
        if( $url !== null ) {
            return $url;
        }

        $api = $this->getAPI();
        $map = array(
            'merchant'    => array(
                'account_id'       => 'm_account_id',
                'site_id'          => 'm_site_id',
                'site_code'        => 'm_secure_code',
                'notification_url' => 'm_notification_url',
                'cancel_url'       => 'm_cancel_url',
                'redirect_url'     => 'm_redirect_url',
                'close_window'     => 'm_close_window'
            ),
            'customer'    => array(
                'locale'      => 'c_locale',
                'ipaddress'   => 'c_ipaddress',
                'forwardedip' => 'c_forwardedip',
                'firstname'   => 'c_firstname',
                'lastname'    => 'c_lastname',
                'address1'    => 'c_address1',
                'address2'    => 'c_address2',
                'housenumber' => 'c_housenumber',
                'zipcode'     => 'c_zipcode',
                'city'        => 'c_city',
                'state'       => 'c_state',
                'country'     => 'c_country',
                'phone'       => 'c_phone',
                'email'       => 'c_email'
            ),
            'transaction' => array(
                'id'          => 't_id',
                'currency'    => 't_currency',
                'amount'      => 't_amount',
                'description' => 't_description',
                'var1'        => 't_var1',
                'var2'        => 't_var2',
                'var3'        => 't_var3',
                'items'       => 't_items',
                'manual'      => 't_manual',
                'daysactive'  => 't_daysactive',
                'gateway'     => 't_gateway'
            )
        );

        foreach( $map as $prop => $fields ) {
            $section = array();
            foreach( $fields as $key => $attr ) {
                $section[$key] = $this->attribute( $attr );
            }
            $api->$prop = $section;
        }


        $api->merchant['close_window'] = (bool) $api->merchant['close_window'] ? 'true' : 'false';
        $api->transaction['manual']    = (bool) $api->transaction['manual'] ? 'true' : 'false';

        $url = $api->startTransaction();
        if( $api->error ) {
            $this->setAttribute( 'error_code', $api->error_code );
            $this->setAttribute( 'error_description', $api->error );
            $this->store();
            throw new Exception( $api->error, $api->error_code );
        }

        $this->setAttribute( 't_payment_url', $url );
        $this->store();
        return $this->attribute( 't_payment_url' );
    }

    public function updateStatus() {
        $api = $this->getAPI();

        $api->merchant['account_id'] = $this->attribute( 'm_account_id' );
        $api->merchant['site_id']    = $this->attribute( 'm_site_id' );
        $api->merchant['site_code']  = $this->attribute( 'm_secure_code' );
        $api->transaction['id']      = $this->attribute( 't_id' );

        $status = $api->getStatus();

        if( $api->error ) {
            $this->setAttribute( 'error_code', $api->error_code );
            $this->setAttribute( 'error_description', $api->error );
            $this->store();
            throw new Exception( $api->error, $api->error_code );
        }

        if( strlen( $this->attribute( 't_gateway' ) ) === 0 ) {
            $this->setAttribute( 't_gateway', $api->details['paymentdetails']['type'] );
        }

        $this->setAttribute( 'status', $status );
        $this->setAttribute( 'c_amount', $api->details['customer']['amount'] );
        $this->setAttribute( 'c_currency', $api->details['customer']['currency'] );
        $this->setAttribute( 'ewallet_id', $api->details['ewallet']['id'] );
        $this->store();
    }

    protected function getAPI() {
        $api       = new MultiSafepayAPI();
        $api->test = strtolower( $this->ini->variable( 'General', 'Live' ) ) != 'yes';
        return $api;
    }

    public function updatePaymentObject() {
        if( $this->attribute( 'status' ) !== 'completed' ) {
            return false;
        }

        $order = $this->attribute( 'order' );
        if( $order instanceof eZOrder === false ) {
            return false;
        }

        $this->setOrdersSA( $order );

        $paymentObject     = eZPaymentObject::fetchByOrderID( $order->attribute( 'id' ) );
        $xrowPaymentObject = xrowPaymentObject::fetchByOrderID( $order->attribute( 'id' ) );
        if( $xrowPaymentObject instanceof xrowPaymentObject === false ) {
            $workflowProcessID = $paymentObject instanceof eZPaymentObject ? $paymentObject->attribute( 'workflowprocess_id' ) : 0;
            $xrowPaymentObject = xrowPaymentObject::createNew( $workflowProcessID, $order->attribute( 'id' ), 'MultiSafepayRedirect' );
        } else {
            $xrowPaymentObject->setAttribute( 'payment_string', 'MultiSafepayRedirect' );
        }
        if( $xrowPaymentObject instanceof xrowPaymentObject ) {
            $xrowPaymentObject->approve();
            $xrowPaymentObject->store();
        }

        if( class_exists( 'xrowECommerce' ) ) {
            $xmlString = $order->attribute( 'data_text_1' );
            if( $xmlString !== null ) {
                $doc = new DOMDocument();
                $doc->loadXML( $xmlString );

                $invoice = $doc->createElement( xrowECommerce::ACCOUNT_KEY_PAYMENTMETHOD, MultiSafepayRedirectGateway::TYPE_MULTI_SAFEPAY );
                $doc->documentElement->appendChild( $invoice );

                $order->setAttribute( 'data_text_1', $doc->saveXML() );
                $order->store();
            }
        }

        if( $paymentObject instanceof eZPaymentObject ) {
            $paymentObject->approve();
            $paymentObject->store();
            eZPaymentObject::continueWorkflow( $paymentObject->attribute( 'workflowprocess_id' ) );
        }
    }

    protected function setOrdersSA( eZOrder $order ) {
        $defaultHost = eZINI::instance()->variable( 'SiteSettings', 'SiteURL' );

        // Get orders siteaccess
        $sa    = null;
        $items = eZOrderItem::fetchListByType( $order->attribute( 'id' ), 'siteaccess' );
        if( count( $items ) > 0 ) {
            $sa = $items[0]->attribute( 'description' );
        }

        // Set host of the order`s siteaccess
        if( $sa === null ) {
            $host = $defaultHost;
        } else {
            $host = eZINI::getSiteAccessIni( $sa, 'site.ini' )->variable( 'SiteSettings', 'SiteURL' );
        }
        eZINI::instance()->setVariable( 'SiteSettings', 'SiteURL', $host );

        // Set SA path
        $tmp                         = explode( '/', $host );
        eZSys::instance()->IndexFile = '/' . end( $tmp );
    }

}
