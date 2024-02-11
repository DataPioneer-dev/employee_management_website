<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'parity', 'export/pdf_grid.tpl', 12, false),array('function', 'n', 'export/pdf_grid.tpl', 15, false),array('function', 'attr', 'export/pdf_grid.tpl', 15, false),)), $this); ?>
<?php echo '<table border="1" cellpadding="0" cellspacing="0"><thead><tr>'; ?><?php $_from = $this->_tpl_vars['TableHeader']['Cells']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Cell']):
?><?php echo '<th>'; ?><?php echo $this->_tpl_vars['Cell']['Caption']; ?><?php echo '</th>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</tr></thead><tbody>'; ?><?php $_from = $this->_tpl_vars['Rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['Rows'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['Rows']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['Row']):
        $this->_foreach['Rows']['iteration']++;
?><?php echo '<tr class="'; ?><?php echo smarty_function_parity(array('name' => 'Rows'), $this);?><?php echo '">'; ?><?php $_from = $this->_tpl_vars['TableHeader']['Cells']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Cell']):
?><?php echo '<td'; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php echo smarty_function_attr(array('name' => 'align','value' => $this->_tpl_vars['Row'][$this->_tpl_vars['Cell']['Name']]['Align']), $this);?><?php echo ''; ?><?php echo smarty_function_n(array(), $this);?><?php echo ''; ?><?php echo smarty_function_attr(array('name' => 'style','value' => $this->_tpl_vars['Row'][$this->_tpl_vars['Cell']['Name']]['Style']), $this);?><?php echo '>'; ?><?php echo $this->_tpl_vars['Row'][$this->_tpl_vars['Cell']['Name']]['Value']; ?><?php echo '</td>'; ?><?php endforeach; endif; unset($_from); ?><?php echo '</tr>'; ?><?php endforeach; endif; unset($_from); ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'list/totals.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo '</tbody></table>'; ?>