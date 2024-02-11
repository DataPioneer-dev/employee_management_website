<?php if ($this->_tpl_vars['DataGrid']['ActionsPanelAvailable']): ?>
    <div class="addition-block js-actions">
        <div class="btn-toolbar addition-block-left pull-left">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_add_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_multi_upload_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_refresh_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_export_print_rss_buttons.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_selection_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="btn-group">
                <button class="btn btn-default" data-toggle="modal" data-target="#importation">
                    <svg class="icon-import" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024">
                        <path d="M736 448l-256 256-256-256h160v-384h192v384zM480 704h-480v256h960v-256h-480zM896 832h-128v-64h128v64z" fill="#000"/>
                    </svg>
                    <span class="visible-lg-inline">importer</span>
                </button>
            </div>
        </div>

        <?php if (! $this->_tpl_vars['isInline']): ?>
            <div class="addition-block-right pull-right">
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_filter_builder_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_sort_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_settings_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/grid_toolbar_description_button.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "list/quick_filter.tpl", 'smarty_include_vars' => array('filter' => $this->_tpl_vars['DataGrid']['QuickFilter'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($this->_tpl_vars['GridViewMode'] == 'card'): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/column_filters.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php echo $this->_tpl_vars['GridBeforeFilterStatus']; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/grid_filters_status.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/messages.tpl', 'smarty_include_vars' => array('type' => 'danger','dismissable' => true,'messages' => $this->_tpl_vars['DataGrid']['ErrorMessages'],'displayTime' => $this->_tpl_vars['DataGrid']['MessageDisplayTime'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'common/messages.tpl', 'smarty_include_vars' => array('type' => 'success','dismissable' => true,'messages' => $this->_tpl_vars['DataGrid']['Messages'],'displayTime' => $this->_tpl_vars['DataGrid']['MessageDisplayTime'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="js-grid-message-container"></div>