{if $DataGrid.ActionsPanelAvailable}
    <div class="addition-block js-actions">
        <div class="btn-toolbar addition-block-left pull-left">
            {include file="list/grid_toolbar_add_button.tpl"}
            {include file="list/grid_toolbar_multi_upload_button.tpl"}
            {include file="list/grid_toolbar_refresh_button.tpl"}
            {include file="list/grid_toolbar_export_print_rss_buttons.tpl"}
            {include file="list/grid_toolbar_selection_button.tpl"}
        </div>

        {if not $isInline}
            <div class="addition-block-right pull-right">
                {include file="list/grid_toolbar_filter_builder_button.tpl"}
                {include file="list/grid_toolbar_sort_button.tpl"}
                {include file="list/grid_toolbar_settings_button.tpl"}
                {include file="list/grid_toolbar_description_button.tpl"}
            </div>
            {include file="list/quick_filter.tpl" filter=$DataGrid.QuickFilter}
        {/if}
    </div>
{/if}

{if $GridViewMode == 'card'}
    {include file='list/column_filters.tpl'}
{/if}

{* The string below is retained for compatibility *}
{$GridBeforeFilterStatus}

{* Custom Code *}
{include file='custom_templates/custom_advanced_filter.tpl'}

{capture assign=FilterStatus}
    {if $DemandeCongeFilterActive}
        <div class="filter-status-value filter-status-value-custom-filter" title="{$DemandeCongeFilterAsString}">
            <svg viewBox="0 0 48 48" class="svg-icon filter-status-value-icon">
                <use xlink:href="#icon-custom-filter"></use>
            </svg>
            <span class="filter-status-value-expr">{$DemandeCongeFilterAsString}</span>
            <div class="filter-status-value-controls">
                <a href="#" class="js-reset-custom-filter" title="{$Captions->GetMessageString('ResetFilter')}">
                    <i class="icon-remove"></i>
                </a>
            </div>
        </div>
    {/if}
{/capture}
{* /Custom Code *}

{include file='list/grid_filters_status.tpl'}

{include file='common/messages.tpl' GridMessages=$DataGrid}

<div class="js-grid-message-container"></div>