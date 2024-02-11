<div class="form-tabs-container">
    <ul class="nav <?php echo $this->_tpl_vars['NavStyle']; ?>
" role="tablist">
        <?php $_from = $this->_tpl_vars['Grid']['FormLayout']->getNonEmptyTabs(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Tabs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Tabs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['TabNum'] => $this->_tpl_vars['Tab']):
        $this->_foreach['Tabs']['iteration']++;
?>
            <?php $this->assign('TabId', ($this->_tpl_vars['Grid']['FormId'])."_tab".($this->_tpl_vars['TabNum'])); ?>
            <li role="presentation" <?php if (($this->_foreach['Tabs']['iteration'] <= 1)): ?>class="active"<?php endif; ?>>
                <a href="#<?php echo $this->_tpl_vars['TabId']; ?>
" aria-controls="<?php echo $this->_tpl_vars['TabId']; ?>
" role="tab" data-toggle="<?php echo $this->_tpl_vars['TabType']; ?>
">
                    <?php echo $this->_tpl_vars['Tab']->getName(); ?>

                </a>
            </li>
        <?php endforeach; endif; unset($_from); ?>
    </ul>
</div>

<div class="tab-content">
    <?php $_from = $this->_tpl_vars['Grid']['FormLayout']->getNonEmptyTabs(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Tabs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Tabs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['TabNum'] => $this->_tpl_vars['Tab']):
        $this->_foreach['Tabs']['iteration']++;
?>
        <?php $this->assign('TabId', ($this->_tpl_vars['Grid']['FormId'])."_tab".($this->_tpl_vars['TabNum'])); ?>
        <div id="<?php echo $this->_tpl_vars['TabId']; ?>
" class="tab-pane<?php if (($this->_foreach['Tabs']['iteration'] <= 1)): ?> active in<?php endif; ?>" role="tabpanel">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_sheet_layout.tpl', 'smarty_include_vars' => array('FormSheet' => $this->_tpl_vars['Tab'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
    <?php endforeach; endif; unset($_from); ?>
</div>