<?php ob_start(); ?>

<?php if ($this->_tpl_vars['Authentication']['canManageUsers']): ?>
<div id="pg-admin-create-user-dialog" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span aria-hidden="true">&times;</span></span></button>
                <h4 class="modal-title"><?php echo $this->_tpl_vars['Captions']->GetMessageString('CreateUser'); ?>
</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="newuser-username"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Name'); ?>
</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="newuser-username" name="name" data-bind="value: newUser.name" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="newuser-password"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Password'); ?>
</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" id="newuser-password" name="password" data-bind="value: newUser.password" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="newuser-confirmed-password"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ConfirmPassword'); ?>
</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="password" id="newuser-confirmed-password" name="confirmedPassword" data-bind="value: newUser.confirmedPassword" />
                        </div>
                    </div>

                    <?php if ($this->_tpl_vars['Authentication']['EmailBasedFeaturesEnabled']): ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="newuser-email"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Email'); ?>
</label>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" id="newuser-email" name="email" data-bind="value: newUser.email" />
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <div class="alert alert-warning" id="newuser-confirmed-password-error">
                            <p><?php echo $this->_tpl_vars['Captions']->GetMessageString('ConfirmedPasswordError'); ?>
</p>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal" id="close-create-user-dialog"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Close'); ?>
</a>
                <a href="#" class="btn btn-primary" id="save-create-user-dialog"><?php echo $this->_tpl_vars['Captions']->GetMessageString('CreateUser'); ?>
</a>
            </div>
        </div>
    </div>
</div>

<div id="pg-admin-edit-user-dialog" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <?php if ($this->_tpl_vars['Authentication']['EmailBasedFeaturesEnabled']): ?>
                        <?php echo $this->_tpl_vars['Captions']->GetMessageString('EditUser'); ?>

                    <?php else: ?>
                        <?php echo $this->_tpl_vars['Captions']->GetMessageString('RenameUser'); ?>

                    <?php endif; ?>
                </h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="user-username"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Name'); ?>
</label>
                            <div class="col-sm-9">
                                <input class="form-control" id="user-username" type="text" name="id" data-bind="value: editUser.name" />
                            </div>
                        </div>

                        <?php if ($this->_tpl_vars['Authentication']['EmailBasedFeaturesEnabled']): ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="user-email"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Email'); ?>
</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" id="user-email" name="email" data-bind="value: editUser.email" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="user-status"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Status'); ?>
</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="user-status" name="status" data-bind="value: editUser.status">
                                    <option value="0"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Ok'); ?>
</option>
                                    <option value="1"><?php echo $this->_tpl_vars['Captions']->GetMessageString('AccountVerificationRequired'); ?>
</option>
                                    <option value="2"><?php echo $this->_tpl_vars['Captions']->GetMessageString('PasswordResetRequested'); ?>
</option>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                    </fieldset>
                </form>
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal" id="close-edit-user-dialog"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Close'); ?>
</a>
                <a href="#" class="btn btn-primary" id="save-edit-user-dialog"><?php echo $this->_tpl_vars['Captions']->GetMessageString('SaveChanges'); ?>
</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page_header.tpl", 'smarty_include_vars' => array('pageTitle' => $this->_tpl_vars['Captions']->GetMessageString('AdministrationPanel'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if ($this->_tpl_vars['Authentication']['canManageUsers']): ?>
<div class="addition-block">
    <div class="btn-toolbar">
        <div class="btn-group">
            <button class="btn btn-default add-user" data-bind="click: invokeAddUserDialog">
                <i class="icon-user-add"></i>
                <?php echo $this->_tpl_vars['Captions']->GetMessageString('AddUser'); ?>

            </button>
        </div>
    </div>
</div>
<?php endif; ?>

<table class="table">

    <thead>
        <tr class="header">
            <th><?php echo $this->_tpl_vars['Captions']->GetMessageString('Actions'); ?>
</th>
            <th><?php echo $this->_tpl_vars['Captions']->GetMessageString('Username'); ?>
</th>
        </tr>
    </thead>

<?php echo '
    <tbody data-bind="template: { name: \'usersRowTemplate\', foreach: usersOnCurrentPage }">
    <script type="text/html" id="usersRowTemplate">

        <tr class="pg-row users-row">
            <td>
                <span data-bind="css: { expanded: grantsExpanded() == true }">
                    <button class="btn btn-default" title="Show user grants"
                            data-bind="click: toggleGrantsExpanded, css: { expanded: grantsExpanded() == true }">
                        <i class="icon-permissions"></i>
                        '; ?>
<span class="hidden-xs"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Permissions'); ?>
<?php echo '</span>
                    </button>
                </span>

                '; ?>
<?php if ($this->_tpl_vars['Authentication']['canManageUsers']): ?><?php echo '
                <button class="btn btn-default" title="Rename user"
                        data-bind="click: function() { PhpGenAdmin.adminPanelViewModel.invokeEditUserDialog($data); }, visible: editable">
                    <i class="icon-edit"></i>
                    '; ?>

                        <span class="hidden-xs">
                            <?php if ($this->_tpl_vars['Authentication']['EmailBasedFeaturesEnabled']): ?>
                                <?php echo $this->_tpl_vars['Captions']->GetMessageString('EditUser'); ?>

                            <?php else: ?>
                                <?php echo $this->_tpl_vars['Captions']->GetMessageString('Rename'); ?>

                            <?php endif; ?>
                        </span>
                    <?php echo '
                </button>

                <button class="btn btn-default" title="Change user password"
                        data-bind="click: function() { PhpGenAdmin.adminPanelViewModel.invokeChangeUserPasswordDialog($data); }, visible: editable">
                    <i class="icon-password-change"></i>
                    '; ?>
<span class="hidden-xs"><?php echo $this->_tpl_vars['Captions']->GetMessageString('ChangePassword'); ?>
</span><?php echo '
                </button>

                <button class="btn btn-default" title="Delete user"
                        data-bind="click: function() { PhpGenAdmin.adminPanelViewModel.invokeRemoveUserDialog($data); }, visible: editable">
                    <i class="icon-user-delete"></i>
                    '; ?>
<span class="hidden-xs"><?php echo $this->_tpl_vars['Captions']->GetMessageString('Delete'); ?>
</span><?php echo '
                </button>
                '; ?>
<?php endif; ?><?php echo '

            </td>

            <td class="user-name"><span data-bind="text: name"></span></td>
        </tr>

        <tr>
            <td colspan="2" data-bind="visible: grantsExpanded">
                <div class="loading-panel" data-bind="visible: !grantsLoaded()">
                    <div class="loading-panel-content">'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('LoadingDots'); ?>
<?php echo '</div>
                </div>
                <table class="table" data-bind="visible: grantsLoaded()">
                    <thead>
                    <tr class="header">
                        <th>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('PageName'); ?>
<?php echo '</th>
                        <th>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('Admin'); ?>
<?php echo '</th>
                        <th>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('Select'); ?>
<?php echo '</th>
                        <th>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('Update'); ?>
<?php echo '</th>
                        <th>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('Insert'); ?>
<?php echo '</th>
                        <th>'; ?>
<?php echo $this->_tpl_vars['Captions']->GetMessageString('Delete'); ?>
<?php echo '</th>
                    </tr>
                    </thead>
                    <tbody data-bind="template: { name: \'userGrantsTemplate\', foreach: grants }"></tbody>
                </table>
            </td>
        </tr>

    </script>

    <script type="text/html" id="userGrantsTemplate">
        <tr data-bind="css: {warning: isApplication()}">
            <td class="page-caption"><span data-bind="text: caption"></span></td>
            <td class="page-grant"><input type="checkbox" data-bind="checked: adminGrant" /></td>
            <td class="page-grant"><input type="checkbox" data-bind="checked: selectGrant" /></td>
            <td class="page-grant"><input type="checkbox" data-bind="checked: updateGrant" /></td>
            <td class="page-grant"><input type="checkbox" data-bind="checked: insertGrant" /></td>
            <td class="page-grant"><input type="checkbox" data-bind="checked: deleteGrant" /></td>
        </tr>
    </script>
    </tbody>
'; ?>

</table>

<script type="text/javascript">
    <?php echo '
        window.PhpGenAdmin = {CurrentUsers: '; ?>
<?php echo $this->_tpl_vars['Users']; ?>
<?php echo ', EmailBasedFeaturesEnabled: '; ?>
<?php if ($this->_tpl_vars['Authentication']['EmailBasedFeaturesEnabled']): ?>true<?php else: ?>false<?php endif; ?><?php echo '};
    '; ?>

</script>

<?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('ContentBlock', ob_get_contents());ob_end_clean(); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['LayoutTemplateName'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>