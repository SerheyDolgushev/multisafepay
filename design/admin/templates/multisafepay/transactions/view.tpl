{ezcss_load( array( 'bootstrap.css', 'helpers.css' ) )}
{ezscript_load( array( 'collapse.js' ) )}

<div class="context-block">
    <div class="box-header">
        <div class="box-ml">
            <h1 class="context-title">{'MultiSafepay Transaction details'|i18n( 'extension/multisafepay' )}</h1>
            <div class="header-mainline"></div>
        </div>
    </div>

    <div class="box-bc">
        <div class="box-ml">
            <div class="box-content">
                <div class="context-attributes">

                    {def
                        $date_attrs  = array( 'created', 'updated' )
                        $bool_attrs  = array( 't_manual', 'm_close_window' )
                        $url_attrs   = array( 'redirect_url', 'm_notification_url', 'm_cancel_url', 'm_redirect_url' )
                        $price_attrs = array( 't_amount', 'c_amount' )
                    }
                    {foreach $transaction.view_attributes as $group}
                        <table class="list" cellspacing="0">
                            <tr>
                                <th><label>{$group.name|i18n( 'extension/multisafepay' )}</label></th>
                            </tr>
                            <tr>
                                <td>
                                    {foreach $group.attrs as $attr => $attr_name}
                                        <div class="block">
                                            <label>{$attr_name|i18n( 'extension/multisafepay' )}:</label>
                                            {if $date_attrs|contains( $attr )}
                                                {$transaction.$attr|datetime( 'custom', '%d.%m.%Y %H:%i:%s' )}
                                            {elseif $bool_attrs|contains( $attr )}
                                                {if $transaction.$attr}{'Yes'|i18n( 'extension/multisafepay' )}{else}{'No'|i18n( 'extension/multisafepay' )}{/if}
                                            {elseif $url_attrs|contains( $attr )}
                                                {if $transaction.$attr}
                                                    <a href="{$transaction.$attr}">{$transaction.$attr}</a>
                                                {else}
                                                    {'Empty'|i18n( 'extension/multisafepay' )}
                                                {/if}
                                            {elseif $price_attrs|contains( $attr )}
                                                {$transaction.$attr|div( 100 )|l10n( 'clean_currency' )} 
                                            {elseif eq( $attr, 'order_id' )}
                                                {if $transaction.order}
                                                    <a href="{concat( 'shop/orderview/', $transaction.order_id )|ezurl( 'no' )}">{$transaction.order.order_nr}</a>
                                                {else}
                                                    {$transaction.order_id} 
                                                {/if}
                                            {elseif eq( $attr, 'user_id' )}
                                                {if $transaction.user}
                                                    <a href="{$transaction.user.main_node|ezurl( 'no' )}">{$transaction.user.name}</a>
                                                {else}
                                                    {$transaction.user_id} 
                                                {/if}
                                            {elseif eq( $attr, 't_items' )}
                                                {$transaction.t_items|wash}
                                            {else}
                                                {$transaction.$attr}
                                            {/if}
                                        </div>
                                    {/foreach}
                                </td>
                            </tr>
                        </table>
                    {/foreach}
                    <table class="list" cellspacing="0">
                        <tr>
                            <th><label>{'Log messages'|i18n( 'extension/multisafepay' )}</label></th>
                        </tr>
                        <tr>
                            <td>
                                <div class="bootstrap-wrapper">
                                    {if $transaction.log_items|count}
                                        {foreach $transaction.log_items as $log_item}
                                            {include uri='design:multisafepay/logs/log_item.tpl' log=$log_item}
                                        {/foreach}
                                    {else}
                                        {'None'|i18n( 'extension/multisafepay' )}
                                    {/if}
                                </div>
                            </td>
                        </tr>
                    </table>
                                
                </div>
            </div>
        </div>
    </div>
</div>