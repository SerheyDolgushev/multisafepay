<div>
    <h3>{$log.date|datetime( 'custom', '%d.%m.%Y %H:%i:%s' )}, {$log.ip} [{$log.url}] {$log.duration} {'sec.'|i18n( 'extension/multisafepay' )}</h3>

    <div class="panel-group" id="accordion-{$log.id}">
        {if $log.request}
            {include uri='design:multisafepay/logs/collapse_part.tpl' id=concat( '1-', $log.id ) title='Request' content=$log.request}
        {/if}
        {if $log.response}
            {include uri='design:multisafepay/logs/collapse_part.tpl' id=concat( '2-', $log.id ) title='Response' content=$log.response}
        {/if}
        {if $log.error}
            {include uri='design:multisafepay/logs/collapse_part.tpl' css_class='danger' id=concat( '3-', $log.id ) title='Error' content=$log.error}
        {/if}
        {include uri='design:multisafepay/logs/collapse_part.tpl' id=concat( '4-', $log.id ) title='Backtrace' content=$log.backtrace_output}
    </div>
</div>
<hr>