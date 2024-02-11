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

    
    
    class grade_ID_CorModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`corps`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for ID_Cor field
            //
            $column = new NumberViewColumn('ID_Cor', 'ID_Cor', 'ID Cor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class gradePage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Grade');
            $this->SetMenuLabel('Grade');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $this->dataset->AddLookupField('ID_Cor', 'corps', new IntegerField('ID_Cor'), new IntegerField('ID_Cor', false, false, false, false, 'ID_Cor_ID_Cor', 'ID_Cor_ID_Cor_corps'), 'ID_Cor_ID_Cor_corps');
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
                new FilterColumn($this->dataset, 'ID_Grad', 'ID_Grad', 'ID Grad'),
                new FilterColumn($this->dataset, 'Libelle', 'Libelle', 'Libelle'),
                new FilterColumn($this->dataset, 'Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe'),
                new FilterColumn($this->dataset, 'ID_Cor', 'ID_Cor_ID_Cor', 'ID Cor')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_Grad'])
                ->addColumn($columns['Libelle'])
                ->addColumn($columns['Libelle_Arabe'])
                ->addColumn($columns['ID_Cor']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('ID_Cor');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_grad_edit');
            
            $filterBuilder->addColumn(
                $columns['ID_Grad'],
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
            
            $main_editor = new TextEdit('libelle_edit');
            
            $filterBuilder->addColumn(
                $columns['Libelle'],
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
            
            $main_editor = new TextEdit('libelle_arabe_edit');
            
            $filterBuilder->addColumn(
                $columns['Libelle_Arabe'],
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
            
            $main_editor = new DynamicCombobox('id_cor_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->setFormatSelection('return item.formatted_value;');
            $main_editor->setFormatResult('return item.formatted_value;');
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_grade_ID_Cor_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Cor', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_grade_ID_Cor_search');
            
            $text_editor = new TextEdit('ID_Cor');
            
            $filterBuilder->addColumn(
                $columns['ID_Cor'],
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
            // View column for ID_Grad field
            //
            $column = new NumberViewColumn('ID_Grad', 'ID_Grad', 'ID Grad', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ID_Cor field
            //
            $column = new TextViewColumn('ID_Cor', 'ID_Cor_ID_Cor', 'ID Cor', $this->dataset);
            $column->SetOrderable(false);
            $column->setLookupRecordModalViewHandlerName(grade_ID_CorModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for ID_Grad field
            //
            $column = new NumberViewColumn('ID_Grad', 'ID_Grad', 'ID Grad', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ID_Cor field
            //
            $column = new TextViewColumn('ID_Cor', 'ID_Cor_ID_Cor', 'ID Cor', $this->dataset);
            $column->SetOrderable(false);
            $column->setLookupRecordModalViewHandlerName(grade_ID_CorModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for ID_Cor field
            //
            $editor = new DynamicCombobox('id_cor_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $editor->setFormatSelection('return item.formatted_value;');
            $editor->setFormatResult('return item.formatted_value;');
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`corps`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('ID_Cor', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Cor', 'ID_Cor', 'ID_Cor_ID_Cor', 'edit_grade_ID_Cor_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'ID_Cor', '%ID_Cor% ( pour le Corps %Libelle% )');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Libelle field
            //
            $editor = new TextEdit('libelle_edit');
            $editColumn = new CustomEditColumn('Libelle', 'Libelle', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Libelle_Arabe field
            //
            $editor = new TextEdit('libelle_arabe_edit');
            $editColumn = new CustomEditColumn('Libelle Arabe', 'Libelle_Arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Libelle field
            //
            $editor = new TextEdit('libelle_edit');
            $editColumn = new CustomEditColumn('Libelle', 'Libelle', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Libelle_Arabe field
            //
            $editor = new TextEdit('libelle_arabe_edit');
            $editColumn = new CustomEditColumn('Libelle Arabe', 'Libelle_Arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ID_Cor field
            //
            $editor = new DynamicCombobox('id_cor_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $editor->setFormatSelection('return item.formatted_value;');
            $editor->setFormatResult('return item.formatted_value;');
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`corps`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('ID_Cor', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Cor', 'ID_Cor', 'ID_Cor_ID_Cor', 'multi_edit_grade_ID_Cor_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'ID_Cor', '%ID_Cor% ( pour le Corps %Libelle% )');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for ID_Cor field
            //
            $editor = new DynamicCombobox('id_cor_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $editor->setFormatSelection('return item.formatted_value;');
            $editor->setFormatResult('return item.formatted_value;');
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`corps`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('ID_Cor', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Cor', 'ID_Cor', 'ID_Cor_ID_Cor', 'insert_grade_ID_Cor_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'ID_Cor', '%ID_Cor% ( pour le Corps %Libelle% )');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Libelle field
            //
            $editor = new TextEdit('libelle_edit');
            $editColumn = new CustomEditColumn('Libelle', 'Libelle', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Libelle_Arabe field
            //
            $editor = new TextEdit('libelle_arabe_edit');
            $editColumn = new CustomEditColumn('Libelle Arabe', 'Libelle_Arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            // View column for ID_Grad field
            //
            $column = new NumberViewColumn('ID_Grad', 'ID_Grad', 'ID Grad', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ID_Cor field
            //
            $column = new TextViewColumn('ID_Cor', 'ID_Cor_ID_Cor', 'ID Cor', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for ID_Grad field
            //
            $column = new NumberViewColumn('ID_Grad', 'ID_Grad', 'ID Grad', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for ID_Cor field
            //
            $column = new TextViewColumn('ID_Cor', 'ID_Cor_ID_Cor', 'ID Cor', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for ID_Cor field
            //
            $column = new TextViewColumn('ID_Cor', 'ID_Cor_ID_Cor', 'ID Cor', $this->dataset);
            $column->SetOrderable(false);
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
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`corps`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('ID_Cor', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_grade_ID_Cor_search', 'ID_Cor', 'ID_Cor', '%ID_Cor% ( pour le Corps %Libelle% )', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`corps`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('ID_Cor', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_grade_ID_Cor_search', 'ID_Cor', 'ID_Cor', '%ID_Cor% ( pour le Corps %Libelle% )', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`corps`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('ID_Cor', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_grade_ID_Cor_search', 'ID_Cor', 'ID_Cor', '%ID_Cor% ( pour le Corps %Libelle% )', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`corps`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('ID_Cor', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_grade_ID_Cor_search', 'ID_Cor', 'ID_Cor', '%ID_Cor% ( pour le Corps %Libelle% )', 20);
            GetApplication()->RegisterHTTPHandler($handler);
            new grade_ID_CorModalViewPage($this, GetCurrentUserPermissionsForPage('grade.ID_Cor'));
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
            if ($chart->getId() === 'Grade_M_Mme') {
            $options = array(
                    'theme' => 'maximazed',
                    'chartArea' => array(
                        'width' => '80%',
                        'height' => '75%'
                    ),
                    'vAxis' => array(
                        'format' => '0'
                    ),
            );
            $chart->setOptions($options);
            }
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
        $Page = new gradePage("grade", "grade.php", GetCurrentUserPermissionsForPage("grade"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("grade"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
