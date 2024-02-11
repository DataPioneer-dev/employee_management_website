<?php if ($this->_tpl_vars['Totals']): ?>
    <tr>
        <?php $_from = $this->_tpl_vars['Totals']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['Total']):
?>
            <td <?php if ($this->_tpl_vars['Total']['Align'] != null): ?> align="<?php echo $this->_tpl_vars['Total']['Align']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['Total']['Value']; ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
<?php endif; ?>