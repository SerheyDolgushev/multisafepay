{ezcss_load( array( 'bootstrap.css', 'helpers.css' ) )}
{ezscript_load( array( 'collapse.js' ) )}

<div class="bootstrap-wrapper">
    <h2 class="h3 u-margin-t-m">{'MultiSafepay Logs'|i18n( 'extension/multisafepay' )} ({$total_count})</h2>

    <form class="panel panel-primary" action="{'multisafepay/logs'|ezurl( 'no' )}" method="get">
        <div class="panel-heading">
            <h3 class="panel-title">{'Filter logs'|i18n( 'extension/multisafepay' )}</h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-2">{'Transaction ID'|i18n( 'extension/multisafepay' )}:</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" value="{$filter.transaction_id}" name="filter[transaction_id]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">{'Error'|i18n( 'extension/multisafepay' )}:</label>
                    <div class="col-lg-10">
                        <select class="form-control" name="filter[error]">
                            <option value="">{'- Not selected -'|i18n( 'extension/multisafepay' )}</option>
                            <option value="1"{if eq( $filter.error, '1' )} selected="selected"{/if}>{'Yes'|i18n( 'extension/multisafepay' )}</option>
                            <option value="0"{if eq( $filter.error, '0' )} selected="selected"{/if}>{'No'|i18n( 'extension/multisafepay' )}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">{'IP'|i18n( 'extension/multisafepay' )}:</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" value="{$filter.ip}" name="filter[ip]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">{'Request filter'|i18n( 'extension/multisafepay' )}:</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" value="{$filter.request}" name="filter[request]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">{'Response filter'|i18n( 'extension/multisafepay' )}:</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" value="{$filter.response}" name="filter[response]">
                    </div>
                </div>
                <div class="form-group u-margin-b-n">
                    <div class="col-lg-10 col-lg-offset-2">
                        <input class="btn btn-primary" type="submit" value="{'Filter'|i18n( 'extension/multisafepay' )}" />
                    </div>
                </div>
            </div>

        </div>
    </form>

    {include
        uri='design:navigator/google.tpl'
        page_uri='multisafepay/logs'
        item_count=$total_count
        view_parameters=hash( 'limit', $limit, 'offset', $offset )
        item_limit=$limit
    }
    {foreach $logs as $log}
        {include uri='design:multisafepay/logs/log_item.tpl' log=$log}
    {/foreach}
    {include
        uri='design:navigator/google.tpl'
        page_uri='multisafepay/logs'
        item_count=$total_count
        view_parameters=hash( 'limit', $limit, 'offset', $offset )
        item_limit=$limit
    }
</div>