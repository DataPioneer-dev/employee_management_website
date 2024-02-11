<?php if ($this->_tpl_vars['DataGrid']['FilterBuilder']->hasColumns()): ?>
    <div class="btn-group">
        <button type="button" class="btn btn-default js-filter-builder-open" title="<?php if ($this->_tpl_vars['IsActiveFilterEmpty']): ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('CreateFilter'); ?>
<?php else: ?><?php echo $this->_tpl_vars['Captions']->GetMessageString('EditFilter'); ?>
<?php endif; ?>">
            <i class="icon-filter-alt"></i>
        </button>
    </div>
<?php endif; ?>
