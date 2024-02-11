<div class="input-checkbox">
    <input
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        type="checkbox"
        value="on"
        <?php if ($this->_tpl_vars['Editor']->isChecked()): ?>
            checked="checked"
        <?php endif; ?>
        <?php if ($this->_tpl_vars['Editor']->GetReadonly()): ?>
            onClick="return false"
        <?php endif; ?>>
</div>