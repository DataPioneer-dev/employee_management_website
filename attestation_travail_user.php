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
    
    
    
    class attestation_travail_userPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Demande d\'attestation de travail');
            $this->SetMenuLabel('Demande d\'attestation de travail');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`attestation_travail_user`');
            $this->dataset->addFields(
                array(
                    new IntegerField('Id_attestation', true, true, true),
                    new IntegerField('Id_user', true),
                    new DateField('Date de demande', true),
                    new StringField('Langue', true),
                    new StringField('Demande', true),
                    new StringField('Status', true)
                )
            );
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
                new FilterColumn($this->dataset, 'Id_attestation', 'Id_attestation', 'Id Attestation'),
                new FilterColumn($this->dataset, 'Id_user', 'Id_user', 'Id User'),
                new FilterColumn($this->dataset, 'Date de demande', 'Date de demande', 'Date De Demande'),
                new FilterColumn($this->dataset, 'Langue', 'Langue', 'Langue'),
                new FilterColumn($this->dataset, 'Demande', 'Demande', 'Demande'),
                new FilterColumn($this->dataset, 'Status', 'Status', 'Status')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Id_attestation'])
                ->addColumn($columns['Id_user'])
                ->addColumn($columns['Date de demande'])
                ->addColumn($columns['Langue'])
                ->addColumn($columns['Demande'])
                ->addColumn($columns['Status']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Date de demande');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_attestation_edit');
            
            $filterBuilder->addColumn(
                $columns['Id_attestation'],
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
            
            $main_editor = new TextEdit('id_user_edit');
            
            $filterBuilder->addColumn(
                $columns['Id_user'],
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
            
            $main_editor = new DateTimeEdit('date_de_demande_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Date de demande'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('Langue');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('French', 'Français');
            $main_editor->addChoice('Arabic', 'Arabe');
            
            $multi_value_select_editor = new MultiValueSelect('Langue');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('Langue');
            
            $filterBuilder->addColumn(
                $columns['Langue'],
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
            
            $main_editor = new TextEdit('Demande');
            
            $filterBuilder->addColumn(
                $columns['Demande'],
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
            
            $main_editor = new TextEdit('status_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Status'],
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
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_RIGHT);
            
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
            // View column for Date de demande field
            //
            $column = new DateTimeViewColumn('Date de demande', 'Date de demande', 'Date De Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Langue field
            //
            $column = new TextViewColumn('Langue', 'Langue', 'Langue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Demande field
            //
            $column = new TextViewColumn('Demande', 'Demande', 'Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Date de demande field
            //
            $column = new DateTimeViewColumn('Date de demande', 'Date de demande', 'Date De Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Langue field
            //
            $column = new TextViewColumn('Langue', 'Langue', 'Langue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Demande field
            //
            $column = new TextViewColumn('Demande', 'Demande', 'Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Date de demande field
            //
            $editor = new DateTimeEdit('date_de_demande_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Demande', 'Date de demande', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Langue field
            //
            $editor = new RadioEdit('langue_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('French', 'Français');
            $editor->addChoice('Arabic', 'Arabe');
            $editColumn = new CustomEditColumn('Langue', 'Langue', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Demande field
            //
            $editor = new TextAreaEdit('demande_edit', 50, 8);
            $editColumn = new CustomEditColumn('Demande', 'Demande', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Status field
            //
            $editor = new TextEdit('status_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Date de demande field
            //
            $editor = new DateTimeEdit('date_de_demande_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Demande', 'Date de demande', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Langue field
            //
            $editor = new RadioEdit('langue_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('French', 'Français');
            $editor->addChoice('Arabic', 'Arabe');
            $editColumn = new CustomEditColumn('Langue', 'Langue', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Demande field
            //
            $editor = new TextAreaEdit('demande_edit', 50, 8);
            $editColumn = new CustomEditColumn('Demande', 'Demande', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Status field
            //
            $editor = new TextEdit('status_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Id_attestation field
            //
            $editor = new TextEdit('id_attestation_edit');
            $editColumn = new CustomEditColumn('Id Attestation', 'Id_attestation', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Id_user field
            //
            $editor = new TextEdit('id_user_edit');
            $editColumn = new CustomEditColumn('Id User', 'Id_user', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_ID%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de demande field
            //
            $editor = new DateTimeEdit('date_de_demande_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Demande', 'Date de demande', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Langue field
            //
            $editor = new RadioEdit('langue_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('French', 'Français');
            $editor->addChoice('Arabic', 'Arabe');
            $editColumn = new CustomEditColumn('Langue', 'Langue', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Demande field
            //
            $editor = new TextAreaEdit('demande_edit', 50, 8);
            $editColumn = new CustomEditColumn('Demande', 'Demande', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Status field
            //
            $editor = new TextEdit('status_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('En cours de signature');
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
            // View column for Date de demande field
            //
            $column = new DateTimeViewColumn('Date de demande', 'Date de demande', 'Date De Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Langue field
            //
            $column = new TextViewColumn('Langue', 'Langue', 'Langue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Demande field
            //
            $column = new TextViewColumn('Demande', 'Demande', 'Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Date de demande field
            //
            $column = new DateTimeViewColumn('Date de demande', 'Date de demande', 'Date De Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Langue field
            //
            $column = new TextViewColumn('Langue', 'Langue', 'Langue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Demande field
            //
            $column = new TextViewColumn('Demande', 'Demande', 'Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Date de demande field
            //
            $column = new DateTimeViewColumn('Date de demande', 'Date de demande', 'Date De Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Langue field
            //
            $column = new TextViewColumn('Langue', 'Langue', 'Langue', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Demande field
            //
            $column = new TextViewColumn('Demande', 'Demande', 'Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
               $result->SetAllowDeleteSelected(true);
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
            $result->setUseModalMultiEdit(true);
            $result->setTableBordered(true);
            $result->setTableCondensed(true);
            $result->setReloadPageAfterAjaxOperation(true);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
    
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
            $this->AddOperationsColumns($result);
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
            $this->setModalViewSize(Modal::SIZE_LG);
            $this->setModalFormSize(Modal::SIZE_LG);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            $userId = $this->GetCurrentUserId(); 
            
            if ($fieldName === 'Status') {
                    switch ($fieldData) {
                        case 'En cours de signature':
                            $customText = '<span class="status-cell yellow">' . $fieldData . '</span>';
                            break;
                        case 'Signée':
                            $customText = '<span class="status-cell green">' . $fieldData . '</span>';
                            break;
                        default:
                            break;
                    }
            
                    $handled = true;
            }
                
            if ($fieldName == 'Demande') {
                $dataAttributes = sprintf('data-demande_id="%s" data-user_id="%s" data-lang="%s"', $rowData['Id_attestation'], $userId, $rowData['Langue']);
                $customText .= '<button class="btn btn-default inline-button" ' . 
                    $dataAttributes . ' style="align-text: center;" onclick="handleDownloadDemandeAttestationTravail(this)">Télécharger la demande</button>';
                $handled = true;
            }
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
            $userId = $page->GetCurrentUserId();
             
            $sql = 'id_user = %d';
            $usingCondition = sprintf($sql, $userId);
            
            $allowEdit = ($rowData['Status'] != 'Signée');
            $allowDelete = ($rowData['Status'] != 'Signée');
            
            $handled = true;
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new attestation_travail_userPage("attestation_travail_user", "attestation_travail_user.php", GetCurrentUserPermissionsForPage("attestation_travail_user"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("attestation_travail_user"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
