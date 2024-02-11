<?php if ($this->_tpl_vars['chart']['generateTooltipFunctionCode']): ?>
<?php echo '
window[\'chartData_'; ?>
<?php echo $this->_tpl_vars['uniqueId']; ?>
<?php echo '\'].generateTooltip = function (row, size, value) {
    var table = window[\'chartData_'; ?>
<?php echo $this->_tpl_vars['uniqueId']; ?>
<?php echo '\'].dataTable;
    '; ?>
<?php echo $this->_tpl_vars['chart']['generateTooltipFunctionCode']; ?>
<?php echo '
}
'; ?>

<?php endif; ?>