<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class notificationPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Notification');
            $this->SetMenuLabel('Notification');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`notification`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID_Notif', true, true, true),
                    new StringField('Type', true),
                    new StringField('Message', true),
                    new IntegerField('Statut', true),
                    new IntegerField('ID_Utilis'),
                    new IntegerField('Flag')
                )
            );
            $this->dataset->AddLookupField('ID_Utilis', 'fonctionnaires', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'ID_Utilis_Nom_Utilis', 'ID_Utilis_Nom_Utilis_fonctionnaires'), 'ID_Utilis_Nom_Utilis_fonctionnaires');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'ID_Notif', 'ID_Notif', 'ID Notif'),
                new FilterColumn($this->dataset, 'Type', 'Type', 'Type'),
                new FilterColumn($this->dataset, 'Message', 'Message', 'Message'),
                new FilterColumn($this->dataset, 'Statut', 'Statut', 'Statut'),
                new FilterColumn($this->dataset, 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis'),
                new FilterColumn($this->dataset, 'Flag', 'Flag', 'Flag')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_Notif'])
                ->addColumn($columns['Type'])
                ->addColumn($columns['Message'])
                ->addColumn($columns['Statut'])
                ->addColumn($columns['ID_Utilis'])
                ->addColumn($columns['Flag']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('ID_Utilis');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_notif_edit');
            
            $filterBuilder->addColumn(
                $columns['ID_Notif'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('type_edit');
            $main_editor->SetMaxLength(15);
            
            $filterBuilder->addColumn(
                $columns['Type'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('Message');
            
            $filterBuilder->addColumn(
                $columns['Message'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('statut_edit');
            
            $filterBuilder->addColumn(
                $columns['Statut'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_utilis_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_notification_ID_Utilis_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Utilis', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_notification_ID_Utilis_search');
            
            $text_editor = new TextEdit('ID_Utilis');
            
            $filterBuilder->addColumn(
                $columns['ID_Utilis'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('flag_edit');
            
            $filterBuilder->addColumn(
                $columns['Flag'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetModalGridViewHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new AjaxOperation(OPERATION_COPY,
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'),
                    $this->GetLocalizerCaptions()->GetMessageString('Copy'), $this->dataset,
                    $this->GetModalGridCopyHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for ID_Notif field
            //
            $column = new NumberViewColumn('ID_Notif', 'ID_Notif', 'ID Notif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Message field
            //
            $column = new TextViewColumn('Message', 'Message', 'Message', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Statut field
            //
            $column = new NumberViewColumn('Statut', 'Statut', 'Statut', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Flag field
            //
            $column = new NumberViewColumn('Flag', 'Flag', 'Flag', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for ID_Notif field
            //
            $column = new NumberViewColumn('ID_Notif', 'ID_Notif', 'ID Notif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Message field
            //
            $column = new TextViewColumn('Message', 'Message', 'Message', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Statut field
            //
            $column = new NumberViewColumn('Statut', 'Statut', 'Statut', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Flag field
            //
            $column = new NumberViewColumn('Flag', 'Flag', 'Flag', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Type field
            //
            $editor = new TextEdit('type_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Message field
            //
            $editor = new TextAreaEdit('message_edit', 50, 8);
            $editColumn = new CustomEditColumn('Message', 'Message', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Statut field
            //
            $editor = new TextEdit('statut_edit');
            $editColumn = new CustomEditColumn('Statut', 'Statut', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ID_Utilis field
            //
            $editor = new DynamicCombobox('id_utilis_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnaires`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Utilis', true, true, true),
                    new StringField('Nom_Utilis'),
                    new StringField('Prenom'),
                    new StringField('CIN'),
                    new StringField('Phone'),
                    new StringField('Email'),
                    new StringField('Adresse'),
                    new StringField('Fonction'),
                    new DateField('Date_Naiss'),
                    new IntegerField('Jrs_Total'),
                    new IntegerField('Jrs_Rest'),
                    new StringField('Password'),
                    new StringField('Username'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Serv'),
                    new IntegerField('Cadre'),
                    new IntegerField('Grade'),
                    new StringField('Aujour'),
                    new StringField('Nom_Arabe'),
                    new StringField('Prenom_Arabe'),
                    new IntegerField('Corps'),
                    new IntegerField('ChefServ'),
                    new IntegerField('ChefDiv'),
                    new IntegerField('Superviseur_Serv'),
                    new StringField('Sexe'),
                    new StringField('Admin')
                )
            );
            $lookupDataset->setOrderByField('Nom_Utilis', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'edit_notification_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Flag field
            //
            $editor = new TextEdit('flag_edit');
            $editColumn = new CustomEditColumn('Flag', 'Flag', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Type field
            //
            $editor = new TextEdit('type_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Message field
            //
            $editor = new TextAreaEdit('message_edit', 50, 8);
            $editColumn = new CustomEditColumn('Message', 'Message', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Statut field
            //
            $editor = new TextEdit('statut_edit');
            $editColumn = new CustomEditColumn('Statut', 'Statut', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ID_Utilis field
            //
            $editor = new DynamicCombobox('id_utilis_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnaires`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Utilis', true, true, true),
                    new StringField('Nom_Utilis'),
                    new StringField('Prenom'),
                    new StringField('CIN'),
                    new StringField('Phone'),
                    new StringField('Email'),
                    new StringField('Adresse'),
                    new StringField('Fonction'),
                    new DateField('Date_Naiss'),
                    new IntegerField('Jrs_Total'),
                    new IntegerField('Jrs_Rest'),
                    new StringField('Password'),
                    new StringField('Username'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Serv'),
                    new IntegerField('Cadre'),
                    new IntegerField('Grade'),
                    new StringField('Aujour'),
                    new StringField('Nom_Arabe'),
                    new StringField('Prenom_Arabe'),
                    new IntegerField('Corps'),
                    new IntegerField('ChefServ'),
                    new IntegerField('ChefDiv'),
                    new IntegerField('Superviseur_Serv'),
                    new StringField('Sexe'),
                    new StringField('Admin')
                )
            );
            $lookupDataset->setOrderByField('Nom_Utilis', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'multi_edit_notification_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Flag field
            //
            $editor = new TextEdit('flag_edit');
            $editColumn = new CustomEditColumn('Flag', 'Flag', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Type field
            //
            $editor = new TextEdit('type_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Message field
            //
            $editor = new TextAreaEdit('message_edit', 50, 8);
            $editColumn = new CustomEditColumn('Message', 'Message', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Statut field
            //
            $editor = new TextEdit('statut_edit');
            $editColumn = new CustomEditColumn('Statut', 'Statut', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ID_Utilis field
            //
            $editor = new DynamicCombobox('id_utilis_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnaires`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Utilis', true, true, true),
                    new StringField('Nom_Utilis'),
                    new StringField('Prenom'),
                    new StringField('CIN'),
                    new StringField('Phone'),
                    new StringField('Email'),
                    new StringField('Adresse'),
                    new StringField('Fonction'),
                    new DateField('Date_Naiss'),
                    new IntegerField('Jrs_Total'),
                    new IntegerField('Jrs_Rest'),
                    new StringField('Password'),
                    new StringField('Username'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Serv'),
                    new IntegerField('Cadre'),
                    new IntegerField('Grade'),
                    new StringField('Aujour'),
                    new StringField('Nom_Arabe'),
                    new StringField('Prenom_Arabe'),
                    new IntegerField('Corps'),
                    new IntegerField('ChefServ'),
                    new IntegerField('ChefDiv'),
                    new IntegerField('Superviseur_Serv'),
                    new StringField('Sexe'),
                    new StringField('Admin')
                )
            );
            $lookupDataset->setOrderByField('Nom_Utilis', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'insert_notification_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Flag field
            //
            $editor = new TextEdit('flag_edit');
            $editColumn = new CustomEditColumn('Flag', 'Flag', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for ID_Notif field
            //
            $column = new NumberViewColumn('ID_Notif', 'ID_Notif', 'ID Notif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Message field
            //
            $column = new TextViewColumn('Message', 'Message', 'Message', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Statut field
            //
            $column = new NumberViewColumn('Statut', 'Statut', 'Statut', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Flag field
            //
            $column = new NumberViewColumn('Flag', 'Flag', 'Flag', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for ID_Notif field
            //
            $column = new NumberViewColumn('ID_Notif', 'ID_Notif', 'ID Notif', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Message field
            //
            $column = new TextViewColumn('Message', 'Message', 'Message', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Statut field
            //
            $column = new NumberViewColumn('Statut', 'Statut', 'Statut', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Flag field
            //
            $column = new NumberViewColumn('Flag', 'Flag', 'Flag', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Message field
            //
            $column = new TextViewColumn('Message', 'Message', 'Message', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Statut field
            //
            $column = new NumberViewColumn('Statut', 'Statut', 'Statut', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Flag field
            //
            $column = new NumberViewColumn('Flag', 'Flag', 'Flag', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
        
        public function GetEnableModalGridEdit() { return true; }
        
        protected function GetEnableModalGridDelete() { return true; }
        
        public function GetEnableModalGridCopy() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(false);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnaires`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Utilis', true, true, true),
                    new StringField('Nom_Utilis'),
                    new StringField('Prenom'),
                    new StringField('CIN'),
                    new StringField('Phone'),
                    new StringField('Email'),
                    new StringField('Adresse'),
                    new StringField('Fonction'),
                    new DateField('Date_Naiss'),
                    new IntegerField('Jrs_Total'),
                    new IntegerField('Jrs_Rest'),
                    new StringField('Password'),
                    new StringField('Username'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Serv'),
                    new IntegerField('Cadre'),
                    new IntegerField('Grade'),
                    new StringField('Aujour'),
                    new StringField('Nom_Arabe'),
                    new StringField('Prenom_Arabe'),
                    new IntegerField('Corps'),
                    new IntegerField('ChefServ'),
                    new IntegerField('ChefDiv'),
                    new IntegerField('Superviseur_Serv'),
                    new StringField('Sexe'),
                    new StringField('Admin')
                )
            );
            $lookupDataset->setOrderByField('Nom_Utilis', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_notification_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnaires`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Utilis', true, true, true),
                    new StringField('Nom_Utilis'),
                    new StringField('Prenom'),
                    new StringField('CIN'),
                    new StringField('Phone'),
                    new StringField('Email'),
                    new StringField('Adresse'),
                    new StringField('Fonction'),
                    new DateField('Date_Naiss'),
                    new IntegerField('Jrs_Total'),
                    new IntegerField('Jrs_Rest'),
                    new StringField('Password'),
                    new StringField('Username'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Serv'),
                    new IntegerField('Cadre'),
                    new IntegerField('Grade'),
                    new StringField('Aujour'),
                    new StringField('Nom_Arabe'),
                    new StringField('Prenom_Arabe'),
                    new IntegerField('Corps'),
                    new IntegerField('ChefServ'),
                    new IntegerField('ChefDiv'),
                    new IntegerField('Superviseur_Serv'),
                    new StringField('Sexe'),
                    new StringField('Admin')
                )
            );
            $lookupDataset->setOrderByField('Nom_Utilis', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_notification_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnaires`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Utilis', true, true, true),
                    new StringField('Nom_Utilis'),
                    new StringField('Prenom'),
                    new StringField('CIN'),
                    new StringField('Phone'),
                    new StringField('Email'),
                    new StringField('Adresse'),
                    new StringField('Fonction'),
                    new DateField('Date_Naiss'),
                    new IntegerField('Jrs_Total'),
                    new IntegerField('Jrs_Rest'),
                    new StringField('Password'),
                    new StringField('Username'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Serv'),
                    new IntegerField('Cadre'),
                    new IntegerField('Grade'),
                    new StringField('Aujour'),
                    new StringField('Nom_Arabe'),
                    new StringField('Prenom_Arabe'),
                    new IntegerField('Corps'),
                    new IntegerField('ChefServ'),
                    new IntegerField('ChefDiv'),
                    new IntegerField('Superviseur_Serv'),
                    new StringField('Sexe'),
                    new StringField('Admin')
                )
            );
            $lookupDataset->setOrderByField('Nom_Utilis', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_notification_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnaires`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Utilis', true, true, true),
                    new StringField('Nom_Utilis'),
                    new StringField('Prenom'),
                    new StringField('CIN'),
                    new StringField('Phone'),
                    new StringField('Email'),
                    new StringField('Adresse'),
                    new StringField('Fonction'),
                    new DateField('Date_Naiss'),
                    new IntegerField('Jrs_Total'),
                    new IntegerField('Jrs_Rest'),
                    new StringField('Password'),
                    new StringField('Username'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Serv'),
                    new IntegerField('Cadre'),
                    new IntegerField('Grade'),
                    new StringField('Aujour'),
                    new StringField('Nom_Arabe'),
                    new StringField('Prenom_Arabe'),
                    new IntegerField('Corps'),
                    new IntegerField('ChefServ'),
                    new IntegerField('ChefDiv'),
                    new IntegerField('Superviseur_Serv'),
                    new StringField('Sexe'),
                    new StringField('Admin')
                )
            );
            $lookupDataset->setOrderByField('Nom_Utilis', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_notification_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new notificationPage("notification", "notification.php", GetCurrentUserPermissionsForPage("notification"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("notification"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
