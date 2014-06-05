<div class="context-block">
    <div class="box-header">
        <div class="box-tc">
            <div class="box-ml">
                <div class="box-mr">
                    <div class="box-tl">
                        <div class="box-tr">
                            <h1 class="context-title">&nbsp;{'MultiSafepay Transactions'|i18n( 'extension/multisafepay' )} ({$total_count})</h1>
                            <div class="header-subline"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box-ml">
        <div class="box-mr">
            <div class="box-content">

                <div class="content-navigation-childlist">
                    <table class="list" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>{'ID'|i18n( 'extension/multisafepay' )}</th>
                                <th>{'Amount'|i18n( 'extension/multisafepay' )}</th>
                                <th>{'Status'|i18n( 'extension/multisafepay' )}</th>
                                <th>{'Customer IP'|i18n( 'extension/multisafepay' )}</th>
                                <th>{'Started'|i18n( 'extension/multisafepay' )}</th>
                                <th>{'Updated'|i18n( 'extension/multisafepay' )}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $transactions as $transaction sequence array( 'bgdark', 'bglight' ) as $style }
                                <tr class="{$style}">
                                    <td><a href="{concat( 'multisafepay/view_transaction/', $transaction.id )|ezurl( 'no' )}">{$transaction.id}</a></td>
                                    <td>{$transaction.amount_formatted} {$transaction.t_currency}</td>
                                    <td>{$transaction.status}</td>
                                    <td>{$transaction.c_ipaddress}</td>
                                    <td>{$transaction.created|datetime( 'custom', '%d.%m.%Y %H:%i:%s' )}</td>
                                    <td>{$transaction.updated|datetime( 'custom', '%d.%m.%Y %H:%i:%s' )}</td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {include
        uri='design:navigator/google.tpl'
        page_uri='multisafepay/transactions'
        item_count=$total_count
        view_parameters=hash( 'limit', $limit, 'offset', $offset )
        item_limit=$limit
    }

</div>
