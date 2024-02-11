<textarea
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "editors/editor_options.tpl", 'smarty_include_vars' => array('Editor' => $this->_tpl_vars['Editor'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    class="html_wysiwyg"
    ><?php echo $this->_tpl_vars['Editor']->GetValue(); ?>

</textarea>
<div class="html-templates" style="display: none;">
    <?php $_from = $this->_tpl_vars['Editor']->getTemplates(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['HTMLTemplate']):
?>
        <div data-template-name="<?php echo $this->_tpl_vars['HTMLTemplate']->name; ?>
"><?php echo $this->_tpl_vars['HTMLTemplate']->html; ?>
</div>
    <?php endforeach; endif; unset($_from); ?>
</div>