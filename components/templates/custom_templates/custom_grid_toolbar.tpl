{if $DataGrid.ActionsPanelAvailable}
    <div class="addition-block js-actions">
        <div class="btn-toolbar addition-block-left pull-left">
            {include file="list/grid_toolbar_add_button.tpl"}
            {include file="list/grid_toolbar_multi_upload_button.tpl"}
            {include file="list/grid_toolbar_refresh_button.tpl"}
            {include file="list/grid_toolbar_export_print_rss_buttons.tpl"}
            {include file="list/grid_toolbar_selection_button.tpl"}
            <div class="btn-group">
                <button class="btn btn-default" data-toggle="modal" data-target="#importation">
                    <svg class="icon-import" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024">
                        <path d="M736 448l-256 256-256-256h160v-384h192v384zM480 704h-480v256h960v-256h-480zM896 832h-128v-64h128v64z" fill="#000"/>
                    </svg>
                    <span class="visible-lg-inline">importer</span>
                </button>
            </div>
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

{include file='list/grid_filters_status.tpl'}

{include file='common/messages.tpl' type='danger' dismissable=true messages=$DataGrid.ErrorMessages displayTime=$DataGrid.MessageDisplayTime}
{include file='common/messages.tpl' type='success' dismissable=true messages=$DataGrid.Messages displayTime=$DataGrid.MessageDisplayTime}

<div class="js-grid-message-container"></div>