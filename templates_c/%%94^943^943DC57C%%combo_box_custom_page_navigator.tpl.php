<div class="nav">
    <?php echo $this->_tpl_vars['PageNavigator']->GetCaption(); ?>
:
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php $_from = $this->_tpl_vars['PageNavigatorPages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['PageNavigatorPage']):
?>
                <?php if ($this->_tpl_vars['PageNavigatorPage']->IsCurrent()): ?> <?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageCaption(); ?>
 <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <?php $_from = $this->_tpl_vars['PageNavigatorPages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['PageNavigatorPage']):
?>
                <li<?php if ($this->_tpl_vars['PageNavigatorPage']->IsCurrent()): ?> class="active"<?php endif; ?>>
                    <a href="<?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageLink(); ?>
"><?php echo $this->_tpl_vars['PageNavigatorPage']->GetPageCaption(); ?>
</a>
                </li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
</div>