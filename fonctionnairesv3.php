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
    
    
    
    class fonctionnairesv3_dossier_fonctionnairePage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Dossier Fonctionnaire');
            $this->SetMenuLabel('Dossier Fonctionnaire');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dossier_fonctionnaire`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID', true, true, true),
                    new StringField('Nom de fichier', true),
                    new StringField('Dossier', true),
                    new StringField('Sous dossier', true),
                    new StringField('Téléchargement', true)
                )
            );
            $this->dataset->AddLookupField('Dossier', 'dossier_fonct', new StringField('Nom_Dossier'), new StringField('Nom_Dossier', false, false, false, false, 'Dossier_Nom_Dossier', 'Dossier_Nom_Dossier_dossier_fonct'), 'Dossier_Nom_Dossier_dossier_fonct');
            $this->dataset->AddLookupField('Sous dossier', 'sous_dossiers_fonct', new StringField('Nom_Sous_Doss'), new StringField('Nom_Sous_Doss', false, false, false, false, 'Sous dossier_Nom_Sous_Doss', 'Sous dossier_Nom_Sous_Doss_sous_dossiers_fonct'), 'Sous dossier_Nom_Sous_Doss_sous_dossiers_fonct');
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
                new FilterColumn($this->dataset, 'ID', 'ID', 'ID'),
                new FilterColumn($this->dataset, 'Nom de fichier', 'Nom de fichier', 'Nom De Fichier'),
                new FilterColumn($this->dataset, 'Dossier', 'Dossier_Nom_Dossier', 'Dossier'),
                new FilterColumn($this->dataset, 'Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'Sous Dossier'),
                new FilterColumn($this->dataset, 'Téléchargement', 'Téléchargement', 'Téléchargement')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID'])
                ->addColumn($columns['Nom de fichier'])
                ->addColumn($columns['Dossier'])
                ->addColumn($columns['Sous dossier'])
                ->addColumn($columns['Téléchargement']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Nom de fichier')
                ->setOptionsFor('Dossier')
                ->setOptionsFor('Sous dossier');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['ID'],
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
            
            $main_editor = new TextEdit('nom_de_fichier_edit');
            
            $filterBuilder->addColumn(
                $columns['Nom de fichier'],
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
            
            $main_editor = new DynamicCombobox('dossier_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv3_dossier_fonctionnaire_Dossier_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Dossier', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv3_dossier_fonctionnaire_Dossier_search');
            
            $text_editor = new TextEdit('Dossier');
            
            $filterBuilder->addColumn(
                $columns['Dossier'],
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
            
            $main_editor = new DynamicCombobox('sous_dossier_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Sous dossier', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search');
            
            $text_editor = new TextEdit('Sous dossier');
            
            $filterBuilder->addColumn(
                $columns['Sous dossier'],
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
            
            $main_editor = new TextEdit('Téléchargement');
            
            $filterBuilder->addColumn(
                $columns['Téléchargement'],
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
            // View column for Nom de fichier field
            //
            $column = new TextViewColumn('Nom de fichier', 'Nom de fichier', 'Nom De Fichier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Dossier field
            //
            $column = new TextViewColumn('Dossier', 'Dossier_Nom_Dossier', 'Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Sous_Doss field
            //
            $column = new TextViewColumn('Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'Sous Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Téléchargement field
            //
            $column = new DownloadExternalDataColumn('Téléchargement', 'Téléchargement', 'Téléchargement', $this->dataset, '');
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Nom de fichier field
            //
            $column = new TextViewColumn('Nom de fichier', 'Nom de fichier', 'Nom De Fichier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Dossier field
            //
            $column = new TextViewColumn('Dossier', 'Dossier_Nom_Dossier', 'Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Sous_Doss field
            //
            $column = new TextViewColumn('Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'Sous Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Téléchargement field
            //
            $column = new DownloadExternalDataColumn('Téléchargement', 'Téléchargement', 'Téléchargement', $this->dataset, '');
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Nom de fichier field
            //
            $editor = new TextEdit('nom_de_fichier_edit');
            $editColumn = new CustomEditColumn('Nom De Fichier', 'Nom de fichier', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Dossier field
            //
            $editor = new DynamicCombobox('dossier_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dossier_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_doss', true, true, true),
                    new StringField('Nom_Dossier', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Dossier', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Dossier', 'Dossier', 'Dossier_Nom_Dossier', 'edit_fonctionnairesv3_dossier_fonctionnaire_Dossier_search', $editor, $this->dataset, $lookupDataset, 'Nom_Dossier', 'Nom_Dossier', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Sous dossier field
            //
            $editor = new DynamicCombobox('sous_dossier_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sous_dossiers_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_sous_Doss', true, true, true),
                    new StringField('Nom_Sous_Doss', true),
                    new IntegerField('ID_Doss', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Sous_Doss', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sous Dossier', 'Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'edit_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search', $editor, $this->dataset, $lookupDataset, 'Nom_Sous_Doss', 'Nom_Sous_Doss', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Téléchargement field
            //
            $editor = new ImageUploader('téléchargement_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Téléchargement', 'Téléchargement', $editor, $this->dataset, false, false, 'C:\xampp\htdocs\test\external_data\doc', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Nom de fichier field
            //
            $editor = new TextEdit('nom_de_fichier_edit');
            $editColumn = new CustomEditColumn('Nom De Fichier', 'Nom de fichier', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Dossier field
            //
            $editor = new DynamicCombobox('dossier_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dossier_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_doss', true, true, true),
                    new StringField('Nom_Dossier', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Dossier', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Dossier', 'Dossier', 'Dossier_Nom_Dossier', 'multi_edit_fonctionnairesv3_dossier_fonctionnaire_Dossier_search', $editor, $this->dataset, $lookupDataset, 'Nom_Dossier', 'Nom_Dossier', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Sous dossier field
            //
            $editor = new DynamicCombobox('sous_dossier_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sous_dossiers_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_sous_Doss', true, true, true),
                    new StringField('Nom_Sous_Doss', true),
                    new IntegerField('ID_Doss', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Sous_Doss', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sous Dossier', 'Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'multi_edit_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search', $editor, $this->dataset, $lookupDataset, 'Nom_Sous_Doss', 'Nom_Sous_Doss', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Téléchargement field
            //
            $editor = new ImageUploader('téléchargement_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Téléchargement', 'Téléchargement', $editor, $this->dataset, false, false, 'C:\xampp\htdocs\test\external_data\doc', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(true);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Nom de fichier field
            //
            $editor = new TextEdit('nom_de_fichier_edit');
            $editColumn = new CustomEditColumn('Nom De Fichier', 'Nom de fichier', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Dossier field
            //
            $editor = new DynamicCombobox('dossier_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dossier_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_doss', true, true, true),
                    new StringField('Nom_Dossier', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Dossier', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Dossier', 'Dossier', 'Dossier_Nom_Dossier', 'insert_fonctionnairesv3_dossier_fonctionnaire_Dossier_search', $editor, $this->dataset, $lookupDataset, 'Nom_Dossier', 'Nom_Dossier', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Sous dossier field
            //
            $editor = new DynamicCombobox('sous_dossier_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sous_dossiers_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_sous_Doss', true, true, true),
                    new StringField('Nom_Sous_Doss', true),
                    new IntegerField('ID_Doss', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Sous_Doss', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Sous Dossier', 'Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'insert_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search', $editor, $this->dataset, $lookupDataset, 'Nom_Sous_Doss', 'Nom_Sous_Doss', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Téléchargement field
            //
            $editor = new ImageUploader('téléchargement_edit');
            $editor->SetShowImage(false);
            $editColumn = new UploadFileToFolderColumn('Téléchargement', 'Téléchargement', $editor, $this->dataset, false, false, 'C:\xampp\htdocs\test\external_data\doc', '%original_file_name%', $this->OnFileUpload, false);
            $editColumn->SetReplaceUploadedFileIfExist(true);
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
            // View column for Nom de fichier field
            //
            $column = new TextViewColumn('Nom de fichier', 'Nom de fichier', 'Nom De Fichier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Dossier field
            //
            $column = new TextViewColumn('Dossier', 'Dossier_Nom_Dossier', 'Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Sous_Doss field
            //
            $column = new TextViewColumn('Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'Sous Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Téléchargement field
            //
            $column = new DownloadExternalDataColumn('Téléchargement', 'Téléchargement', 'Téléchargement', $this->dataset, '');
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Nom de fichier field
            //
            $column = new TextViewColumn('Nom de fichier', 'Nom de fichier', 'Nom De Fichier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Dossier field
            //
            $column = new TextViewColumn('Dossier', 'Dossier_Nom_Dossier', 'Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Sous_Doss field
            //
            $column = new TextViewColumn('Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'Sous Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Téléchargement field
            //
            $column = new DownloadExternalDataColumn('Téléchargement', 'Téléchargement', 'Téléchargement', $this->dataset, '');
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Nom de fichier field
            //
            $column = new TextViewColumn('Nom de fichier', 'Nom de fichier', 'Nom De Fichier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Dossier field
            //
            $column = new TextViewColumn('Dossier', 'Dossier_Nom_Dossier', 'Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Sous_Doss field
            //
            $column = new TextViewColumn('Sous dossier', 'Sous dossier_Nom_Sous_Doss', 'Sous Dossier', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Téléchargement field
            //
            $column = new DownloadExternalDataColumn('Téléchargement', 'Téléchargement', 'Téléchargement', $this->dataset, '');
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
            $this->setPrintListRecordAvailable(true);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setModalViewSize(Modal::SIZE_LG);
            $this->setModalFormSize(Modal::SIZE_LG);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
            $grid->SetInsertClientEditorValueChangedScript('if (sender.getFieldName() === \'Dossier\') {
                var dossier = sender.getData();
                editors[\'Sous dossier\']
                    .setData(null)
                    .setEnabled(dossier);
            
                if (dossier) {
                    editors[\'Sous dossier\'].setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Doss: dossier.fields.ID_doss
                            }
                        };
                    });
                }
            }');
            
            $grid->SetInsertClientFormLoadedScript('function initSousDossierQuery() {
                var dossier = editors.Dossier.getData();
                if (dossier) {
                    editors[\'Sous dossier\'].setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Doss: dossier.fields.ID_doss
                            }
                        };
                    });
                }
            }
            
            if (editors.Dossier.getValue()) {
                initSousDossierQuery();
                editors.Dossier.getRootElement().on(\'select2-init\', initSousDossierQuery);
            }
            
            editors[\'Sous dossier\'].setEnabled(editors[\'Sous dossier\'].getValue());');
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dossier_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_doss', true, true, true),
                    new StringField('Nom_Dossier', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Dossier', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv3_dossier_fonctionnaire_Dossier_search', 'Nom_Dossier', 'Nom_Dossier', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sous_dossiers_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_sous_Doss', true, true, true),
                    new StringField('Nom_Sous_Doss', true),
                    new IntegerField('ID_Doss', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Sous_Doss', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search', 'Nom_Sous_Doss', 'Nom_Sous_Doss', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dossier_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_doss', true, true, true),
                    new StringField('Nom_Dossier', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Dossier', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_dossier_fonctionnaire_Dossier_search', 'Nom_Dossier', 'Nom_Dossier', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sous_dossiers_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_sous_Doss', true, true, true),
                    new StringField('Nom_Sous_Doss', true),
                    new IntegerField('ID_Doss', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Sous_Doss', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search', 'Nom_Sous_Doss', 'Nom_Sous_Doss', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sous_dossiers_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_sous_Doss', true, true, true),
                    new StringField('Nom_Sous_Doss', true),
                    new IntegerField('ID_Doss', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Sous_Doss', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search', 'Nom_Sous_Doss', 'Nom_Sous_Doss', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dossier_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_doss', true, true, true),
                    new StringField('Nom_Dossier', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Dossier', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv3_dossier_fonctionnaire_Dossier_search', 'Nom_Dossier', 'Nom_Dossier', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sous_dossiers_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_sous_Doss', true, true, true),
                    new StringField('Nom_Sous_Doss', true),
                    new IntegerField('ID_Doss', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Sous_Doss', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search', 'Nom_Sous_Doss', 'Nom_Sous_Doss', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dossier_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_doss', true, true, true),
                    new StringField('Nom_Dossier', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Dossier', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv3_dossier_fonctionnaire_Dossier_search', 'Nom_Dossier', 'Nom_Dossier', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`sous_dossiers_fonct`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_sous_Doss', true, true, true),
                    new StringField('Nom_Sous_Doss', true),
                    new IntegerField('ID_Doss', true)
                )
            );
            $lookupDataset->setOrderByField('Nom_Sous_Doss', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv3_dossier_fonctionnaire_Sous dossier_search', 'Nom_Sous_Doss', 'Nom_Sous_Doss', null, 20);
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
    
    // OnBeforePageExecute event handler
    
    
    
    class fonctionnairesv3Page extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Gestion des fonctionnaires');
            $this->SetMenuLabel('Gestion des fonctionnaires');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnairesv3`');
            $this->dataset->addFields(
                array(
                    new IntegerField('Numéro', true, true, true),
                    new BlobField('photo'),
                    new StringField('Civilité'),
                    new StringField('Nom'),
                    new StringField('Prenom'),
                    new StringField('Nom_arabe', true),
                    new StringField('Prenom_arabe', true),
                    new StringField('N° CIN'),
                    new StringField('RIB'),
                    new DateField('Date de Naissance'),
                    new DateField('Date de recrutement'),
                    new DateField('Date d\'affectation au CRO'),
                    new StringField('Groupe', true),
                    new StringField('Corps'),
                    new StringField('Grade'),
                    new StringField('Poste de responsabilité'),
                    new StringField('Direction'),
                    new StringField('Division'),
                    new StringField('Service'),
                    new StringField('Situation'),
                    new StringField('N° Tél'),
                    new StringField('Email'),
                    new StringField('Adresse'),
                    new StringField('Matricule Aujour', true),
                    new IntegerField('Solde d\'année précédente', true),
                    new IntegerField('Solde d\'année actuelle', true),
                    new IntegerField('Solde de Congé'),
                    new IntegerField('Age', true),
                    new IntegerField('updated_from_table_nombre_jours_congé', true),
                    new IntegerField('Age', false, false, false, true)
                )
            );
            $this->dataset->AddLookupField('Groupe', 'groupe', new StringField('Groupe'), new StringField('Groupe', false, false, false, false, 'Groupe_Groupe', 'Groupe_Groupe_groupe'), 'Groupe_Groupe_groupe');
            $this->dataset->AddLookupField('Corps', 'corps', new StringField('Libelle'), new StringField('Libelle', false, false, false, false, 'Corps_Libelle', 'Corps_Libelle_corps'), 'Corps_Libelle_corps');
            $this->dataset->AddLookupField('Grade', 'grade', new StringField('Libelle'), new StringField('Libelle', false, false, false, false, 'Grade_Libelle', 'Grade_Libelle_grade'), 'Grade_Libelle_grade');
            $this->dataset->AddLookupField('Direction', 'direction', new StringField('Libelle'), new StringField('Libelle', false, false, false, false, 'Direction_Libelle', 'Direction_Libelle_direction'), 'Direction_Libelle_direction');
            $this->dataset->AddLookupField('Division', 'division', new StringField('Nom_Div'), new StringField('Nom_Div', false, false, false, false, 'Division_Nom_Div', 'Division_Nom_Div_division'), 'Division_Nom_Div_division');
            $this->dataset->AddLookupField('Service', 'service', new StringField('Nom_Serv'), new StringField('Nom_Serv', false, false, false, false, 'Service_Nom_Serv', 'Service_Nom_Serv_service'), 'Service_Nom_Serv_service');
        }
    
        protected function DoPrepare() {
            if (GetApplication()->isGetValueSet('checkCIN')) {
                $CIN = GetApplication()->GetGETValue('checkCIN');
                $sql = "SELECT Numéro FROM fonctionnairesv3 WHERE N° CIN = '$CIN'";
                $result = $this->GetConnection()->fetchAll($sql);   
                echo sizeof($result) > 0 ? true : false;
                exit;                              
            }
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
                new FilterColumn($this->dataset, 'Numéro', 'Numéro', 'ID'),
                new FilterColumn($this->dataset, 'photo', 'photo', 'Photo'),
                new FilterColumn($this->dataset, 'Civilité', 'Civilité', 'Civilité'),
                new FilterColumn($this->dataset, 'Nom', 'Nom', 'Nom'),
                new FilterColumn($this->dataset, 'Nom_arabe', 'Nom_arabe', 'Nom Arabe'),
                new FilterColumn($this->dataset, 'Prenom', 'Prenom', 'Prenom'),
                new FilterColumn($this->dataset, 'Prenom_arabe', 'Prenom_arabe', 'Prenom Arabe'),
                new FilterColumn($this->dataset, 'N° CIN', 'N° CIN', 'N° CIN'),
                new FilterColumn($this->dataset, 'RIB', 'RIB', 'RIB'),
                new FilterColumn($this->dataset, 'Date de Naissance', 'Date de Naissance', 'Date De Naissance'),
                new FilterColumn($this->dataset, 'Date de recrutement', 'Date de recrutement', 'Date De Recrutement'),
                new FilterColumn($this->dataset, 'Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO'),
                new FilterColumn($this->dataset, 'Groupe', 'Groupe_Groupe', 'Groupe'),
                new FilterColumn($this->dataset, 'Corps', 'Corps_Libelle', 'Corps'),
                new FilterColumn($this->dataset, 'Grade', 'Grade_Libelle', 'Grade'),
                new FilterColumn($this->dataset, 'Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité'),
                new FilterColumn($this->dataset, 'Direction', 'Direction_Libelle', 'Direction'),
                new FilterColumn($this->dataset, 'Division', 'Division_Nom_Div', 'Division'),
                new FilterColumn($this->dataset, 'Service', 'Service_Nom_Serv', 'Service'),
                new FilterColumn($this->dataset, 'Situation', 'Situation', 'Situation'),
                new FilterColumn($this->dataset, 'N° Tél', 'N° Tél', 'N° Tél'),
                new FilterColumn($this->dataset, 'Email', 'Email', 'Email'),
                new FilterColumn($this->dataset, 'Adresse', 'Adresse', 'Adresse'),
                new FilterColumn($this->dataset, 'Matricule Aujour', 'Matricule Aujour', 'Matricule Aujour'),
                new FilterColumn($this->dataset, 'Solde d\'année précédente', 'Solde d\'année précédente', 'Solde D\'année Précédente'),
                new FilterColumn($this->dataset, 'Solde d\'année actuelle', 'Solde d\'année actuelle', 'Solde D\'année Actuelle'),
                new FilterColumn($this->dataset, 'Age', 'Age', 'Age'),
                new FilterColumn($this->dataset, 'Solde de Congé', 'Solde de Congé', 'Solde De Congé'),
                new FilterColumn($this->dataset, 'updated_from_table_nombre_jours_congé', 'updated_from_table_nombre_jours_congé', 'Updated From Table Nombre Jours Congé')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Numéro'])
                ->addColumn($columns['photo'])
                ->addColumn($columns['Civilité'])
                ->addColumn($columns['Nom'])
                ->addColumn($columns['Nom_arabe'])
                ->addColumn($columns['Prenom'])
                ->addColumn($columns['Prenom_arabe'])
                ->addColumn($columns['N° CIN'])
                ->addColumn($columns['RIB'])
                ->addColumn($columns['Date de Naissance'])
                ->addColumn($columns['Date de recrutement'])
                ->addColumn($columns['Date d\'affectation au CRO'])
                ->addColumn($columns['Groupe'])
                ->addColumn($columns['Corps'])
                ->addColumn($columns['Grade'])
                ->addColumn($columns['Poste de responsabilité'])
                ->addColumn($columns['Direction'])
                ->addColumn($columns['Division'])
                ->addColumn($columns['Service'])
                ->addColumn($columns['Situation'])
                ->addColumn($columns['N° Tél'])
                ->addColumn($columns['Email'])
                ->addColumn($columns['Adresse'])
                ->addColumn($columns['Matricule Aujour'])
                ->addColumn($columns['Solde d\'année précédente'])
                ->addColumn($columns['Solde d\'année actuelle'])
                ->addColumn($columns['Solde de Congé']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Nom')
                ->setOptionsFor('Prenom')
                ->setOptionsFor('N° CIN')
                ->setOptionsFor('Date de recrutement');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('numéro_edit');
            
            $filterBuilder->addColumn(
                $columns['Numéro'],
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
            
            $main_editor = new TextEdit('photo');
            
            $filterBuilder->addColumn(
                $columns['photo'],
                array(
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new ComboBox('Civilité');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('M', 'M');
            $main_editor->addChoice('Mme', 'Mme');
            
            $multi_value_select_editor = new MultiValueSelect('Civilité');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('Civilité');
            
            $filterBuilder->addColumn(
                $columns['Civilité'],
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
            
            $main_editor = new TextEdit('nom_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Nom'],
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
            
            $main_editor = new TextEdit('nom_arabe_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Nom_arabe'],
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
            
            $main_editor = new TextEdit('prenom_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Prenom'],
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
            
            $main_editor = new TextEdit('prenom_arabe_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Prenom_arabe'],
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
            
            $main_editor = new TextEdit('n°_cin_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['N° CIN'],
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
            
            $main_editor = new TextEdit('rib_edit');
            
            $filterBuilder->addColumn(
                $columns['RIB'],
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
            
            $main_editor = new DateTimeEdit('date_de_naissance_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Date de Naissance'],
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
            
            $main_editor = new DateTimeEdit('date_de_recrutement_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Date de recrutement'],
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
            
            $main_editor = new DateTimeEdit('date_d\'affectation_au_cro_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Date d\'affectation au CRO'],
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
            
            $main_editor = new DynamicCombobox('groupe_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv3_Groupe_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Groupe', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv3_Groupe_search');
            
            $text_editor = new TextEdit('Groupe');
            
            $filterBuilder->addColumn(
                $columns['Groupe'],
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
            
            $main_editor = new DynamicCombobox('corps_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv3_Corps_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Corps', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv3_Corps_search');
            
            $text_editor = new TextEdit('Corps');
            
            $filterBuilder->addColumn(
                $columns['Corps'],
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
            
            $main_editor = new DynamicCombobox('grade_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv3_Grade_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Grade', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv3_Grade_search');
            
            $text_editor = new TextEdit('Grade');
            
            $filterBuilder->addColumn(
                $columns['Grade'],
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
            
            $main_editor = new ComboBox('Poste de responsabilité');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('Chef de service', 'Chef de service');
            $main_editor->addChoice('Chef de division', 'Chef de division');
            $main_editor->addChoice('Directeur', 'Directeur');
            
            $multi_value_select_editor = new MultiValueSelect('Poste de responsabilité');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('Poste de responsabilité');
            
            $filterBuilder->addColumn(
                $columns['Poste de responsabilité'],
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
            
            $main_editor = new DynamicCombobox('direction_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv3_Direction_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Direction', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv3_Direction_search');
            
            $text_editor = new TextEdit('Direction');
            
            $filterBuilder->addColumn(
                $columns['Direction'],
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
            
            $main_editor = new DynamicCombobox('division_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv3_Division_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Division', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv3_Division_search');
            
            $text_editor = new TextEdit('Division');
            
            $filterBuilder->addColumn(
                $columns['Division'],
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
            
            $main_editor = new DynamicCombobox('service_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv3_Service_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Service', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv3_Service_search');
            
            $text_editor = new TextEdit('Service');
            
            $filterBuilder->addColumn(
                $columns['Service'],
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
            
            $main_editor = new TextEdit('situation_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['Situation'],
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
            
            $main_editor = new TextEdit('n°_tél_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['N° Tél'],
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
            
            $main_editor = new TextEdit('email_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Email'],
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
            
            $main_editor = new TextEdit('adresse_edit');
            
            $filterBuilder->addColumn(
                $columns['Adresse'],
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
            
            $main_editor = new TextEdit('matricule_aujour_edit');
            
            $filterBuilder->addColumn(
                $columns['Matricule Aujour'],
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
            
            $main_editor = new TextEdit('solde_d\'année_précédente_edit');
            
            $filterBuilder->addColumn(
                $columns['Solde d\'année précédente'],
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
            
            $main_editor = new TextEdit('solde_d\'année_actuelle_edit');
            
            $filterBuilder->addColumn(
                $columns['Solde d\'année actuelle'],
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
            
            $main_editor = new TextEdit('solde_de_congé_edit');
            
            $filterBuilder->addColumn(
                $columns['Solde de Congé'],
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
            if (GetCurrentUserPermissionsForPage('fonctionnairesv3.dossier_fonctionnaire')->HasViewGrant() && $withDetails)
            {
            //
            // View column for fonctionnairesv3_dossier_fonctionnaire detail
            //
            $column = new DetailColumn(array('Numéro'), 'fonctionnairesv3.dossier_fonctionnaire', 'fonctionnairesv3_dossier_fonctionnaire_handler', $this->dataset, 'Dossier Fonctionnaire');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::DESKTOP);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::DESKTOP);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::DESKTOP);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date de recrutement field
            //
            $column = new DateTimeViewColumn('Date de recrutement', 'Date de recrutement', 'Date De Recrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
            $column->SetOrderable(false);
            $column->setMinimalVisibility(ColumnVisibility::DESKTOP);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::DESKTOP);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Age field
            //
            $column = new NumberViewColumn('Age', 'Age', 'Age', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new TextViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for photo field
            //
            $column = new BlobImageViewColumn('photo', 'photo', 'Photo', $this->dataset, true, 'fonctionnairesv3_photo_handler_view');
            $column->setNullLabel('Aucune Photo');
            $column->SetOrderable(true);
            $column->SetImageHintTemplate('%Nom% %Prenom%');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_arabe field
            //
            $column = new TextViewColumn('Nom_arabe', 'Nom_arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom_arabe field
            //
            $column = new TextViewColumn('Prenom_arabe', 'Prenom_arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for RIB field
            //
            $column = new TextViewColumn('RIB', 'RIB', 'RIB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date de recrutement field
            //
            $column = new DateTimeViewColumn('Date de recrutement', 'Date de recrutement', 'Date De Recrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Groupe field
            //
            $column = new TextViewColumn('Groupe', 'Groupe_Groupe', 'Groupe', $this->dataset);
            $column->setNullLabel('Aucun Groupe');
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->setNullLabel('Aucun Corps');
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->setNullLabel('Aucune Grade');
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->setNullLabel('Aucun Poste de responsabilité');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Direction', 'Direction_Libelle', 'Direction', $this->dataset);
            $column->setNullLabel('Aucune Direction');
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('Division', 'Division_Nom_Div', 'Division', $this->dataset);
            $column->setNullLabel('Aucune Division');
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('Service', 'Service_Nom_Serv', 'Service', $this->dataset);
            $column->setNullLabel('Aucun Service');
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->setNullLabel('aucune Situation');
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->setNullLabel('Aucune Adresse');
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Matricule Aujour field
            //
            $column = new TextViewColumn('Matricule Aujour', 'Matricule Aujour', 'Matricule Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Solde d'année précédente field
            //
            $column = new NumberViewColumn('Solde d\'année précédente', 'Solde d\'année précédente', 'Solde D\'année Précédente', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Solde d'année actuelle field
            //
            $column = new NumberViewColumn('Solde d\'année actuelle', 'Solde d\'année actuelle', 'Solde D\'année Actuelle', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Age field
            //
            $column = new NumberViewColumn('Age', 'Age', 'Age', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new TextViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for photo field
            //
            $editor = new ImageUploader('photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Photo', 'photo', $editor, $this->dataset, false, false, 'fonctionnairesv3_photo_handler_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Civilité field
            //
            $editor = new RadioEdit('civilité_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('M', 'M');
            $editor->addChoice('Mme', 'Mme');
            $editColumn = new CustomEditColumn('Civilité', 'Civilité', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nom field
            //
            $editor = new TextEdit('nom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom', 'Nom', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nom_arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Prenom_arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for N° CIN field
            //
            $editor = new TextEdit('n°_cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° CIN', 'N° CIN', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for RIB field
            //
            $editor = new TextEdit('rib_edit');
            $editColumn = new CustomEditColumn('RIB', 'RIB', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[0-9]+$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de Naissance field
            //
            $editor = new DateTimeEdit('date_de_naissance_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Naissance', 'Date de Naissance', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de recrutement field
            //
            $editor = new DateTimeEdit('date_de_recrutement_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Recrutement', 'Date de recrutement', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date d'affectation au CRO field
            //
            $editor = new DateTimeEdit('date_d\'affectation_au_cro_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date D\'affectation Au CRO', 'Date d\'affectation au CRO', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Groupe field
            //
            $editor = new ComboBox('groupe_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`groupe`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grp', true, true, true),
                    new StringField('Groupe', true)
                )
            );
            $lookupDataset->setOrderByField('Groupe', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Groupe', 
                'Groupe', 
                $editor, 
                $this->dataset, 'Groupe', 'Groupe', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Corps field
            //
            $editor = new DynamicCombobox('corps_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
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
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'edit_fonctionnairesv3_Corps_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Grade field
            //
            $editor = new DynamicCombobox('grade_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'edit_fonctionnairesv3_Grade_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Poste de responsabilité field
            //
            $editor = new RadioEdit('poste_de_responsabilité_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('Chef de service', 'Chef de service');
            $editor->addChoice('Chef de division', 'Chef de division');
            $editor->addChoice('Directeur', 'Directeur');
            $editColumn = new CustomEditColumn('Poste De Responsabilité', 'Poste de responsabilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Direction field
            //
            $editor = new DynamicCombobox('direction_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`direction`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Dir', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Direction', 'Direction', 'Direction_Libelle', 'edit_fonctionnairesv3_Direction_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Division field
            //
            $editor = new DynamicCombobox('division_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Division', 'Division', 'Division_Nom_Div', 'edit_fonctionnairesv3_Division_search', $editor, $this->dataset, $lookupDataset, 'Nom_Div', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Service field
            //
            $editor = new DynamicCombobox('service_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service', 'Service', 'Service_Nom_Serv', 'edit_fonctionnairesv3_Service_search', $editor, $this->dataset, $lookupDataset, 'Nom_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Situation field
            //
            $editor = new TextEdit('situation_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Situation', 'Situation', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for N° Tél field
            //
            $editor = new TextEdit('n°_tél_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° Tél', 'N° Tél', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new EMailValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('EmailValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextEdit('adresse_edit');
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Matricule Aujour field
            //
            $editor = new TextEdit('matricule_aujour_edit');
            $editColumn = new CustomEditColumn('Matricule Aujour', 'Matricule Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[0-9]+$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Solde d'année précédente field
            //
            $editor = new TextEdit('solde_d\'année_précédente_edit');
            $editColumn = new CustomEditColumn('Solde D\'année Précédente', 'Solde d\'année précédente', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Solde d'année actuelle field
            //
            $editor = new TextEdit('solde_d\'année_actuelle_edit');
            $editColumn = new CustomEditColumn('Solde D\'année Actuelle', 'Solde d\'année actuelle', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Solde de Congé field
            //
            $editor = new TextEdit('solde_de_congé_edit');
            $editColumn = new CustomEditColumn('Solde De Congé', 'Solde de Congé', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $editColumn->setAllowListCellEdit(false);
            $editColumn->setAllowSingleViewCellEdit(false);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for photo field
            //
            $editor = new ImageUploader('photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Photo', 'photo', $editor, $this->dataset, false, false, 'fonctionnairesv3_photo_handler_multi_edit');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Civilité field
            //
            $editor = new RadioEdit('civilité_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('M', 'M');
            $editor->addChoice('Mme', 'Mme');
            $editColumn = new CustomEditColumn('Civilité', 'Civilité', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Nom field
            //
            $editor = new TextEdit('nom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom', 'Nom', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Nom_arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Prenom_arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for N° CIN field
            //
            $editor = new TextEdit('n°_cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° CIN', 'N° CIN', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for RIB field
            //
            $editor = new TextEdit('rib_edit');
            $editColumn = new CustomEditColumn('RIB', 'RIB', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[0-9]+$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de Naissance field
            //
            $editor = new DateTimeEdit('date_de_naissance_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Naissance', 'Date de Naissance', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de recrutement field
            //
            $editor = new DateTimeEdit('date_de_recrutement_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Recrutement', 'Date de recrutement', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date d'affectation au CRO field
            //
            $editor = new DateTimeEdit('date_d\'affectation_au_cro_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date D\'affectation Au CRO', 'Date d\'affectation au CRO', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Groupe field
            //
            $editor = new ComboBox('groupe_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`groupe`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grp', true, true, true),
                    new StringField('Groupe', true)
                )
            );
            $lookupDataset->setOrderByField('Groupe', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Groupe', 
                'Groupe', 
                $editor, 
                $this->dataset, 'Groupe', 'Groupe', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Corps field
            //
            $editor = new DynamicCombobox('corps_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
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
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'multi_edit_fonctionnairesv3_Corps_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Grade field
            //
            $editor = new DynamicCombobox('grade_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'multi_edit_fonctionnairesv3_Grade_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Poste de responsabilité field
            //
            $editor = new RadioEdit('poste_de_responsabilité_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('Chef de service', 'Chef de service');
            $editor->addChoice('Chef de division', 'Chef de division');
            $editor->addChoice('Directeur', 'Directeur');
            $editColumn = new CustomEditColumn('Poste De Responsabilité', 'Poste de responsabilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Direction field
            //
            $editor = new DynamicCombobox('direction_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`direction`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Dir', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Direction', 'Direction', 'Direction_Libelle', 'multi_edit_fonctionnairesv3_Direction_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Division field
            //
            $editor = new DynamicCombobox('division_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Division', 'Division', 'Division_Nom_Div', 'multi_edit_fonctionnairesv3_Division_search', $editor, $this->dataset, $lookupDataset, 'Nom_Div', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Service field
            //
            $editor = new DynamicCombobox('service_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service', 'Service', 'Service_Nom_Serv', 'multi_edit_fonctionnairesv3_Service_search', $editor, $this->dataset, $lookupDataset, 'Nom_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Situation field
            //
            $editor = new TextEdit('situation_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Situation', 'Situation', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for N° Tél field
            //
            $editor = new TextEdit('n°_tél_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° Tél', 'N° Tél', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new EMailValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('EmailValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextEdit('adresse_edit');
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Matricule Aujour field
            //
            $editor = new TextEdit('matricule_aujour_edit');
            $editColumn = new CustomEditColumn('Matricule Aujour', 'Matricule Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[0-9]+$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Solde d'année précédente field
            //
            $editor = new TextEdit('solde_d\'année_précédente_edit');
            $editColumn = new CustomEditColumn('Solde D\'année Précédente', 'Solde d\'année précédente', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Solde d'année actuelle field
            //
            $editor = new TextEdit('solde_d\'année_actuelle_edit');
            $editColumn = new CustomEditColumn('Solde D\'année Actuelle', 'Solde d\'année actuelle', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Solde de Congé field
            //
            $editor = new TextEdit('solde_de_congé_edit');
            $editColumn = new CustomEditColumn('Solde De Congé', 'Solde de Congé', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for photo field
            //
            $editor = new ImageUploader('photo_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new FileUploadingColumn('Photo', 'photo', $editor, $this->dataset, false, false, 'fonctionnairesv3_photo_handler_insert');
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetImageFilter(new NullFilter());
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Civilité field
            //
            $editor = new RadioEdit('civilité_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('M', 'M');
            $editor->addChoice('Mme', 'Mme');
            $editColumn = new CustomEditColumn('Civilité', 'Civilité', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nom field
            //
            $editor = new TextEdit('nom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom', 'Nom', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nom_arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Prenom_arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_arabe', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for N° CIN field
            //
            $editor = new TextEdit('n°_cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° CIN', 'N° CIN', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for RIB field
            //
            $editor = new TextEdit('rib_edit');
            $editColumn = new CustomEditColumn('RIB', 'RIB', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[0-9]+$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de Naissance field
            //
            $editor = new DateTimeEdit('date_de_naissance_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Naissance', 'Date de Naissance', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de recrutement field
            //
            $editor = new DateTimeEdit('date_de_recrutement_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Recrutement', 'Date de recrutement', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date d'affectation au CRO field
            //
            $editor = new DateTimeEdit('date_d\'affectation_au_cro_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date D\'affectation Au CRO', 'Date d\'affectation au CRO', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Groupe field
            //
            $editor = new ComboBox('groupe_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`groupe`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grp', true, true, true),
                    new StringField('Groupe', true)
                )
            );
            $lookupDataset->setOrderByField('Groupe', 'ASC');
            $editColumn = new LookUpEditColumn(
                'Groupe', 
                'Groupe', 
                $editor, 
                $this->dataset, 'Groupe', 'Groupe', $lookupDataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Corps field
            //
            $editor = new DynamicCombobox('corps_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
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
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'insert_fonctionnairesv3_Corps_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Grade field
            //
            $editor = new DynamicCombobox('grade_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'insert_fonctionnairesv3_Grade_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Poste de responsabilité field
            //
            $editor = new RadioEdit('poste_de_responsabilité_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('Chef de service', 'Chef de service');
            $editor->addChoice('Chef de division', 'Chef de division');
            $editor->addChoice('Directeur', 'Directeur');
            $editColumn = new CustomEditColumn('Poste De Responsabilité', 'Poste de responsabilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Direction field
            //
            $editor = new DynamicCombobox('direction_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`direction`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Dir', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Direction', 'Direction', 'Direction_Libelle', 'insert_fonctionnairesv3_Direction_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Division field
            //
            $editor = new DynamicCombobox('division_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Division', 'Division', 'Division_Nom_Div', 'insert_fonctionnairesv3_Division_search', $editor, $this->dataset, $lookupDataset, 'Nom_Div', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Service field
            //
            $editor = new DynamicCombobox('service_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Service', 'Service', 'Service_Nom_Serv', 'insert_fonctionnairesv3_Service_search', $editor, $this->dataset, $lookupDataset, 'Nom_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Situation field
            //
            $editor = new TextEdit('situation_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Situation', 'Situation', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for N° Tél field
            //
            $editor = new TextEdit('n°_tél_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° Tél', 'N° Tél', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new EMailValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('EmailValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextEdit('adresse_edit');
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Matricule Aujour field
            //
            $editor = new TextEdit('matricule_aujour_edit');
            $editColumn = new CustomEditColumn('Matricule Aujour', 'Matricule Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $validator = new CustomRegExpValidator('^[0-9]+$', StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RegExpValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Solde d'année précédente field
            //
            $editor = new TextEdit('solde_d\'année_précédente_edit');
            $editColumn = new CustomEditColumn('Solde D\'année Précédente', 'Solde d\'année précédente', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Solde d'année actuelle field
            //
            $editor = new TextEdit('solde_d\'année_actuelle_edit');
            $editColumn = new CustomEditColumn('Solde D\'année Actuelle', 'Solde d\'année actuelle', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Solde de Congé field
            //
            $editor = new TextEdit('solde_de_congé_edit');
            $editColumn = new CustomEditColumn('Solde De Congé', 'Solde de Congé', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $validator = new NumberValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('NumberValidationMessage'), $editColumn->GetCaption()));
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
            // View column for photo field
            //
            $column = new BlobImageViewColumn('photo', 'photo', 'Photo', $this->dataset, true, 'fonctionnairesv3_photo_handler_print');
            $column->setNullLabel('Aucune Photo');
            $column->SetOrderable(true);
            $column->SetImageHintTemplate('%Nom% %Prenom%');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_arabe field
            //
            $column = new TextViewColumn('Nom_arabe', 'Nom_arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom_arabe field
            //
            $column = new TextViewColumn('Prenom_arabe', 'Prenom_arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for RIB field
            //
            $column = new TextViewColumn('RIB', 'RIB', 'RIB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date de recrutement field
            //
            $column = new DateTimeViewColumn('Date de recrutement', 'Date de recrutement', 'Date De Recrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Groupe field
            //
            $column = new TextViewColumn('Groupe', 'Groupe_Groupe', 'Groupe', $this->dataset);
            $column->setNullLabel('Aucun Groupe');
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->setNullLabel('Aucun Corps');
            $column->SetOrderable(false);
            $column->setAlign('center');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->setNullLabel('Aucune Grade');
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->setNullLabel('Aucun Poste de responsabilité');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Direction', 'Direction_Libelle', 'Direction', $this->dataset);
            $column->setNullLabel('Aucune Direction');
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('Division', 'Division_Nom_Div', 'Division', $this->dataset);
            $column->setNullLabel('Aucune Division');
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('Service', 'Service_Nom_Serv', 'Service', $this->dataset);
            $column->setNullLabel('Aucun Service');
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->setNullLabel('aucune Situation');
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->setNullLabel('Aucune Adresse');
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Matricule Aujour field
            //
            $column = new TextViewColumn('Matricule Aujour', 'Matricule Aujour', 'Matricule Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Solde d'année précédente field
            //
            $column = new NumberViewColumn('Solde d\'année précédente', 'Solde d\'année précédente', 'Solde D\'année Précédente', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Solde d'année actuelle field
            //
            $column = new NumberViewColumn('Solde d\'année actuelle', 'Solde d\'année actuelle', 'Solde D\'année Actuelle', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Age field
            //
            $column = new NumberViewColumn('Age', 'Age', 'Age', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new TextViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for photo field
            //
            $column = new BlobImageViewColumn('photo', 'photo', 'Photo', $this->dataset, true, 'fonctionnairesv3_photo_handler_export');
            $column->setNullLabel('Aucune Photo');
            $column->SetOrderable(true);
            $column->SetImageHintTemplate('%Nom% %Prenom%');
            $grid->AddExportColumn($column);
            
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_arabe field
            //
            $column = new TextViewColumn('Nom_arabe', 'Nom_arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom_arabe field
            //
            $column = new TextViewColumn('Prenom_arabe', 'Prenom_arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for RIB field
            //
            $column = new TextViewColumn('RIB', 'RIB', 'RIB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Date de recrutement field
            //
            $column = new DateTimeViewColumn('Date de recrutement', 'Date de recrutement', 'Date De Recrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Groupe field
            //
            $column = new TextViewColumn('Groupe', 'Groupe_Groupe', 'Groupe', $this->dataset);
            $column->setNullLabel('Aucun Groupe');
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->setNullLabel('Aucun Corps');
            $column->SetOrderable(false);
            $column->setAlign('center');
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->setNullLabel('Aucune Grade');
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->setNullLabel('Aucun Poste de responsabilité');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Direction', 'Direction_Libelle', 'Direction', $this->dataset);
            $column->setNullLabel('Aucune Direction');
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('Division', 'Division_Nom_Div', 'Division', $this->dataset);
            $column->setNullLabel('Aucune Division');
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('Service', 'Service_Nom_Serv', 'Service', $this->dataset);
            $column->setNullLabel('Aucun Service');
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->setNullLabel('aucune Situation');
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddExportColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->setNullLabel('Aucune Adresse');
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Matricule Aujour field
            //
            $column = new TextViewColumn('Matricule Aujour', 'Matricule Aujour', 'Matricule Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Solde d'année précédente field
            //
            $column = new NumberViewColumn('Solde d\'année précédente', 'Solde d\'année précédente', 'Solde D\'année Précédente', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Solde d'année actuelle field
            //
            $column = new NumberViewColumn('Solde d\'année actuelle', 'Solde d\'année actuelle', 'Solde D\'année Actuelle', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Age field
            //
            $column = new NumberViewColumn('Age', 'Age', 'Age', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new TextViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_arabe field
            //
            $column = new TextViewColumn('Nom_arabe', 'Nom_arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom_arabe field
            //
            $column = new TextViewColumn('Prenom_arabe', 'Prenom_arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for RIB field
            //
            $column = new TextViewColumn('RIB', 'RIB', 'RIB', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date de recrutement field
            //
            $column = new DateTimeViewColumn('Date de recrutement', 'Date de recrutement', 'Date De Recrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Groupe field
            //
            $column = new TextViewColumn('Groupe', 'Groupe_Groupe', 'Groupe', $this->dataset);
            $column->setNullLabel('Aucun Groupe');
            $column->SetOrderable(false);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->setNullLabel('Aucun Corps');
            $column->SetOrderable(false);
            $column->setAlign('center');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->setNullLabel('Aucune Grade');
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->setNullLabel('Aucun Poste de responsabilité');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Direction', 'Direction_Libelle', 'Direction', $this->dataset);
            $column->setNullLabel('Aucune Direction');
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('Division', 'Division_Nom_Div', 'Division', $this->dataset);
            $column->setNullLabel('Aucune Division');
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('Service', 'Service_Nom_Serv', 'Service', $this->dataset);
            $column->setNullLabel('Aucun Service');
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->setNullLabel('aucune Situation');
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
            $column->SetOrderable(false);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(false);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->setNullLabel('Aucune Adresse');
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Matricule Aujour field
            //
            $column = new TextViewColumn('Matricule Aujour', 'Matricule Aujour', 'Matricule Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Solde d'année précédente field
            //
            $column = new NumberViewColumn('Solde d\'année précédente', 'Solde d\'année précédente', 'Solde D\'année Précédente', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Solde d'année actuelle field
            //
            $column = new NumberViewColumn('Solde d\'année actuelle', 'Solde d\'année actuelle', 'Solde D\'année Actuelle', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Age field
            //
            $column = new NumberViewColumn('Age', 'Age', 'Age', $this->dataset);
            $column->SetOrderable(false);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new TextViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
            $column->SetOrderable(true);
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
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(true);
            $result->setTableCondensed(true);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return '$.ajax({'. "\n" .
            '    url: "count_reload_page.php",'. "\n" .
            '    success: function(dataResult) {'. "\n" .
            '    }'. "\n" .
            '});'. "\n" .
            ''. "\n" .
            ''. "\n" .
            'var appearPerLogin = parseInt($("#notification_2").attr("data-appear_per_login"));'. "\n" .
            ''. "\n" .
            'if (appearPerLogin === 0) {'. "\n" .
            '    var url = "nbr_users_solde_null.php";'. "\n" .
            '    $.ajax({'. "\n" .
            '        url: url,'. "\n" .
            '        dataType: \'json\','. "\n" .
            '        async: false,'. "\n" .
            '        success: function(dataResult) {'. "\n" .
            '            var infos = dataResult;'. "\n" .
            '            infos.forEach(info => {'. "\n" .
            '                var nbr_users = parseInt(info.nbr_users);'. "\n" .
            '                if (nbr_users >= 1) {'. "\n" .
            '                    $(\'#notification_2\').modal(\'show\');'. "\n" .
            '                } else {'. "\n" .
            '                    $(\'#notification_2\').modal(\'hide\');'. "\n" .
            '                }'. "\n" .
            '            });'. "\n" .
            '        }'. "\n" .
            '    });'. "\n" .
            '}'. "\n" .
            ''. "\n" .
            'var countSoldeNull = parseInt($("#notification_3").attr("data-count_solde_null"));'. "\n" .
            ''. "\n" .
            'if (countSoldeNull > 0) {'. "\n" .
            '   $(\'#notification_3\').modal(\'show\');'. "\n" .
            '} else {'. "\n" .
            '  $(\'#notification_3\').modal(\'hide\');'. "\n" .
            '}';
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
            $result->SetTotal('Nom', PredefinedAggregate::$Count);
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
            $this->SetViewFormTitle('Consulter le profil de %Nom% %Prenom%');
            $this->SetEditFormTitle('Modifier le profil de %Nom% %Prenom%');
            $this->SetInsertFormTitle('Ajouter un nouvel fonctionnaire');
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
            $grid->SetInsertClientEditorValueChangedScript('if (sender.getFieldName() === \'Corps\') {
                var corps = sender.getData();
                editors.Grade
                    .setData(null)
                    .setEnabled(corps);
            
                if (corps) {
                    editors.Grade.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Cor: corps.fields.ID_Cor
                            }
                        };
                    });
                }
            }
            
            if (sender.getFieldName() === \'Direction\') {
                var direction = sender.getData();
                editors.Division
                    .setData(null)
                    .setEnabled(direction);
            
                if (direction) {
                    editors.Division.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: direction.fields.ID_Dir
                            }
                        };
                    });
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: direction.fields.ID_Dir
                            }
                        };
                    });
                } else {
                     editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: 0
                            }
                        };
                    });
                }
            }
            
            if (sender.getFieldName() === \'Division\') {
                var division = sender.getData();
                var service = editors.Service.getValue();
            
                editors.Service
                    .setData(null)
                    .setEnabled(division && !service);
            
                if (division) {
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Div: division.fields.ID_Division
                            }
                        };
                    });
                }
            }
            
            if (sender.getFieldName() === \'Service\') {
                var service = sender.getData();
                var division = editors.Division.getValue();
                var direction = editors.Direction.getValue();
                
                if (!division) {
                    editors.Division
                        .setData(null)
                        .setEnabled(!service);
                   if (!direction) {
                      editors.Direction
                          .setData(null)
                          .setEnabled(!service);
                   }
                }
            }
            
            
            
            if (sender.getFieldName() == \'N° CIN\') {
                if (sender.getValue()) {
                    var CINExist = false;
            
                    $.ajax({
                        type: \'GET\',
                        url: \'checkCIN.php\',
                        data: {checkCIN: sender.getValue()},
                        async: false,
                        dataType: \'json\',
                        success: function (dataResult) {
                            CINExist = dataResult;
                        }                                   
                    });
                
                    editors[\'N° CIN\']
                        .setState(CINExist ? \'warning\' : \'success\')
                        .setHint(CINExist ? \'N° CIN \' + sender.getValue() + \' already exists\' : null);
                } else {
                    editors[\'N° CIN\']
                        .setState(\'normal\')
                        .setHint(null);
                }
            }
            
            if (sender.getFieldName() == "Solde d\'année précédente" || sender.getFieldName() == "Solde d\'année actuelle") {
                var soldeAnneePrecedente = editors["Solde d\'année précédente"].getValue();
                var soldeAnneeActuelle = editors["Solde d\'année actuelle"].getValue();
            
                if (soldeAnneePrecedente !== \'\' && soldeAnneeActuelle !== \'\') {
                    var soldeAncien = parseInt(soldeAnneePrecedente);
                    var soldeNouveau = parseInt(soldeAnneeActuelle);
                    var soldeConge = 0;
                    if (soldeAncien > 22) {
                        soldeConge = 44;
                    } else {
                        soldeConge = soldeAncien + soldeNouveau;
                    }
                    editors[\'Solde de Congé\'].setValue(soldeConge);
                }
            }');
            
            $grid->SetEditClientEditorValueChangedScript('if (sender.getFieldName() === \'Corps\') {
                var corps = sender.getData();
                editors.Grade
                    .setData(null)
                    .setEnabled(corps);
            
                if (corps) {
                    editors.Grade.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Cor: corps.fields.ID_Cor
                            }
                        };
                    });
                }
            }
            
            if (sender.getFieldName() === \'Direction\') {
                var direction = sender.getData();
                editors.Division
                    .setData(null)
                    .setEnabled(direction);
            
                if (direction) {
                    editors.Division.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: direction.fields.ID_Dir
                            }
                        };
                    });
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: direction.fields.ID_Dir
                            }
                        };
                    });
                } else {
                     editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: 0
                            }
                        };
                    });
                }
            }
            
            if (sender.getFieldName() === \'Division\') {
                var division = sender.getData();
                var service = editors.Service.getValue();
            
                editors.Service
                    .setData(null)
                    .setEnabled(division && !service);
            
                if (division) {
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Div: division.fields.ID_Division
                            }
                        };
                    });
                }
            }
            
            if (sender.getFieldName() === \'Service\') {
                var service = sender.getData();
                var division = editors.Division.getValue();
                var direction = editors.Direction.getValue();
                
                if (!division) {
                    editors.Division
                        .setData(null)
                        .setEnabled(!service);
                   if (!direction) {
                      editors.Direction
                          .setData(null)
                          .setEnabled(!service);
                   }
                }
            }
            
            
            
            if (sender.getFieldName() == \'N° CIN\') {
                if (sender.getValue()) {
                    var CINExist = false;
            
                    $.ajax({
                        type: \'GET\',
                        url: \'checkCIN.php\',
                        data: {checkCIN: sender.getValue()},
                        async: false,
                        dataType: \'json\',
                        success: function (dataResult) {
                            CINExist = dataResult;
                        }                                   
                    });
                
                    editors[\'N° CIN\']
                        .setState(CINExist ? \'warning\' : \'success\')
                        .setHint(CINExist ? \'N° CIN \' + sender.getValue() + \' already exists\' : null);
                } else {
                    editors[\'N° CIN\']
                        .setState(\'normal\')
                        .setHint(null);
                }
            }
            
            if (sender.getFieldName() == "Solde d\'année précédente" || sender.getFieldName() == "Solde d\'année actuelle") {
                var soldeAnneePrecedente = editors["Solde d\'année précédente"].getValue();
                var soldeAnneeActuelle = editors["Solde d\'année actuelle"].getValue();
            
                if (soldeAnneePrecedente !== \'\' && soldeAnneeActuelle !== \'\') {
                    var soldeAncien = parseInt(soldeAnneePrecedente);
                    var soldeNouveau = parseInt(soldeAnneeActuelle);
                    var soldeConge = 0;
                    if (soldeAncien > 22) {
                        soldeConge = 44;
                    } else {
                        soldeConge = soldeAncien + soldeNouveau;
                    }
                    editors[\'Solde de Congé\'].setValue(soldeConge);
                }
            }');
            
            $grid->SetInsertClientFormLoadedScript('function initGradeQuery() {
                var corps = editors.Corps.getData();
                if (corps) {
                    editors.Grade.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Cor: corps.fields.ID_Cor
                            }
                        };
                    });
                }
            }
            
            if (editors.Corps.getValue()) {
                initGradeQuery();
                editors.Corps.getRootElement().on(\'select2-init\', initGradeQuery);
            }
            
            editors.Grade.setEnabled(editors.Grade.getValue());
            
            function initDivisionQuery() {
                var direction = editors.Direction.getData();
                if (direction) {
                    editors.Division.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: direction.fields.ID_Dir
                            }
                        };
                    });
                }
            }
            
            function initServiceNullQuery() {
                var direction = editors.Direction.getData();
                var division = editors.Division.getData();
                if (!direction && !division) {
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: 0
                            }
                        };
                    });
                }
            }
            
            function initServiceQuery() {
                var direction = editors.Direction.getData();
                var division = editors.Division.getData();
            
                if (direction && !division) {
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: direction.fields.ID_Dir
                            }
                        };
                    });
                } 
                if (direction && division) {
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Div: division.fields.ID_Division
                            }
                        };
                    });
                }  
            }
            
            if (!editors.Direction.getValue()) {
                initServiceNullQuery();
                editors.Direction.getRootElement().on(\'select2-init\', function() {
                    initServiceNullQuery();
                });
            }
            
            if (editors.Direction.getValue()) {
                initDivisionQuery();
                initServiceQuery();
                editors.Direction.getRootElement().on(\'select2-init\', function() {
                    initDivisionQuery();
                    initServiceQuery();
                });
            }
            
            editors.Division.setEnabled(editors.Direction.getValue());
            
            
            function checkCIN() {
                var CINExist = false;
            
                $.ajax({
                    type: \'GET\',
                    url: \'checkCIN.php\',
                    data: {checkCIN: editors[\'N° CIN\'].getValue()},
                    async: false,
                    dataType: \'json\',
                    success: function (dataResult) {
                        CINExist = dataResult;
                    }                                   
                });
                
                editors[\'N° CIN\']
                    .setState(CINExist ? \'warning\' : \'success\')
                    .setHint(CINExist ? \'N° CIN \' + editors[\'N° CIN\'].getValue() + \' already exists\' : null);
            }
            
            editors[\'N° CIN\'].getRootElement().one(\'focusout\', checkCIN);
            
            function updateSoldeDeConge() {
                var soldeAnneePrecedente = editors["Solde d\'année précédente"].getValue();
                var soldeAnneeActuelle = editors["Solde d\'année actuelle"].getValue();
            
                if (soldeAnneePrecedente !== \'\' && soldeAnneeActuelle !== \'\') {
                    var soldeAncien = parseInt(soldeAnneePrecedente);
                    var soldeNouveau = parseInt(soldeAnneeActuelle);
                    var soldeConge = 0;
                    if (soldeAncien > 22) {
                        soldeConge = 44;
                    } else {
                        soldeConge = soldeAncien + soldeNouveau;
                    }
                    editors[\'Solde de Congé\'].setValue(soldeConge);
                }
            }
            
            editors["Solde d\'année précédente"].getRootElement().on(\'change\', updateSoldeDeConge);
            editors["Solde d\'année actuelle"].getRootElement().on(\'change\', updateSoldeDeConge);');
            
            $grid->SetEditClientFormLoadedScript('function initGradeQuery() {
                var corps = editors.Corps.getData();
                if (corps) {
                    editors.Grade.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Cor: corps.fields.ID_Cor
                            }
                        };
                    });
                }
            }
            
            if (editors.Corps.getValue()) {
                initGradeQuery();
                editors.Corps.getRootElement().on(\'select2-init\', initGradeQuery);
            }
            
            editors.Grade.setEnabled(editors.Grade.getValue());
            
            function initDivisionQuery() {
                var direction = editors.Direction.getData();
                if (direction) {
                    editors.Division.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: direction.fields.ID_Dir
                            }
                        };
                    });
                }
            }
            
            function initServiceNullQuery() {
                var direction = editors.Direction.getData();
                var division = editors.Division.getData();
                if (!direction && !division) {
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: 0
                            }
                        };
                    });
                }
            }
            
            function initServiceQuery() {
                var direction = editors.Direction.getData();
                var division = editors.Division.getData();
            
                if (direction && !division) {
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Dir: direction.fields.ID_Dir
                            }
                        };
                    });
                } 
                if (direction && division) {
                    editors.Service.setQueryFunction(function (term) {
                        return {
                            term: term,
                            fields: {
                                ID_Div: division.fields.ID_Division
                            }
                        };
                    });
                }  
            }
            
            if (!editors.Direction.getValue()) {
                initServiceNullQuery();
                editors.Direction.getRootElement().on(\'select2-init\', function() {
                    initServiceNullQuery();
                });
            }
            
            if (editors.Direction.getValue()) {
                initDivisionQuery();
                initServiceQuery();
                editors.Direction.getRootElement().on(\'select2-init\', function() {
                    initDivisionQuery();
                    initServiceQuery();
                });
            }
            
            editors.Division.setEnabled(editors.Direction.getValue());
            
            
            function checkCIN() {
                var CINExist = false;
            
                $.ajax({
                    type: \'GET\',
                    url: \'checkCIN.php\',
                    data: {checkCIN: editors[\'N° CIN\'].getValue()},
                    async: false,
                    dataType: \'json\',
                    success: function (dataResult) {
                        CINExist = dataResult;
                    }                                   
                });
                
                editors[\'N° CIN\']
                    .setState(CINExist ? \'warning\' : \'success\')
                    .setHint(CINExist ? \'N° CIN \' + editors[\'N° CIN\'].getValue() + \' already exists\' : null);
            }
            
            editors[\'N° CIN\'].getRootElement().one(\'focusout\', checkCIN);
            
            function updateSoldeDeConge() {
                var soldeAnneePrecedente = editors["Solde d\'année précédente"].getValue();
                var soldeAnneeActuelle = editors["Solde d\'année actuelle"].getValue();
            
                if (soldeAnneePrecedente !== \'\' && soldeAnneeActuelle !== \'\') {
                    var soldeAncien = parseInt(soldeAnneePrecedente);
                    var soldeNouveau = parseInt(soldeAnneeActuelle);
                    var soldeConge = 0;
                    if (soldeAncien > 22) {
                        soldeConge = 44;
                    } else {
                        soldeConge = soldeAncien + soldeNouveau;
                    }
                    editors[\'Solde de Congé\'].setValue(soldeConge);
                }
            }
            
            editors["Solde d\'année précédente"].getRootElement().on(\'change\', updateSoldeDeConge);
            editors["Solde d\'année actuelle"].getRootElement().on(\'change\', updateSoldeDeConge);');
            
            $grid->setCalculateControlValuesScript('if (editors[\'Date de Naissance\'].getValue()) {
                require([\'moment\'], function(moment) {
                    editors[\'Age\'].setValue(moment().diff(editors[\'Date de Naissance\'].getValue(), \'years\'));
                });
            }');
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new fonctionnairesv3_dossier_fonctionnairePage('fonctionnairesv3_dossier_fonctionnaire', $this, array('ID'), array('Numéro'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('fonctionnairesv3.dossier_fonctionnaire'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('fonctionnairesv3.dossier_fonctionnaire'));
            $detailPage->SetHttpHandlerName('fonctionnairesv3_dossier_fonctionnaire_handler');
            $handler = new PageHTTPHandler('fonctionnairesv3_dossier_fonctionnaire_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'photo', 'fonctionnairesv3_photo_handler_print', new ImageFitByWidthResizeFilter(120));
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'photo', 'fonctionnairesv3_photo_handler_insert', new NullFilter());
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
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv3_Corps_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv3_Grade_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`direction`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Dir', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv3_Direction_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv3_Division_search', 'Nom_Div', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv3_Service_search', 'Nom_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`groupe`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grp', true, true, true),
                    new StringField('Groupe', true)
                )
            );
            $lookupDataset->setOrderByField('Groupe', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_Groupe_search', 'Groupe', 'Groupe', null, 20);
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
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_Corps_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_Grade_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_Grade_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`direction`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Dir', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_Direction_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_Division_search', 'Nom_Div', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv3_Service_search', 'Nom_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'photo', 'fonctionnairesv3_photo_handler_view', new ImageFitByWidthResizeFilter(120));
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'photo', 'fonctionnairesv3_photo_handler_edit', new NullFilter());
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
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv3_Corps_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv3_Grade_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`direction`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Dir', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv3_Direction_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv3_Division_search', 'Nom_Div', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv3_Service_search', 'Nom_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $handler = new ImageHTTPHandler($this->dataset, 'photo', 'fonctionnairesv3_photo_handler_multi_edit', new NullFilter());
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
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv3_Corps_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`grade`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Grad', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true),
                    new IntegerField('ID_Cor')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv3_Grade_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`direction`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Dir', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv3_Direction_search', 'Libelle', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv3_Division_search', 'Nom_Div', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv3_Service_search', 'Nom_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            if ($fieldName === 'Solde de Congé') {
                $joursConge = $fieldData;
                if($joursConge === null) {
                    $fieldText = "NULL";
                } else {
                  $fieldText = $fieldData;
                }
                $dataAttributes = sprintf('data-user_id="%s"', $rowData['Numéro']);
                $customText = '<span class="gradient-cell" ' . $dataAttributes . '>' . $fieldText . '</span>';
            
                $bgColor = 'green'; 
                if ($joursConge <= 22 && $joursConge >= 6) {
                    $bgColor = "green";
                } elseif ($joursConge <= 5 && $joursConge > 0) {
                    $bgColor = 'orange'; 
                } elseif ($joursConge = 0 || $joursConge === null) {
                    $bgColor = "red";
                }
                $customText .= '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var cellElement = document.querySelector(".gradient-cell[data-user_id=\'' . $rowData['Numéro'] . '\']");
                    var parentElement = cellElement.parentNode;
            
                    parentElement.style.backgroundColor = "' . $bgColor . '";
                    if ("' . $bgColor . '" === "orange") {
                           parentElement.style.color = "#34495E";
                    } else {
                          parentElement.style.color = "white";
                    }
                    parentElement.style.textAlign = "center";
                    parentElement.style.margin = "auto";
                });
            </script>';
            
                $handled = true;
            }
            
            if ($fieldName === 'Email') {
               $customText = '<a href=mailto:' . $fieldData .'>' . $fieldData . '</a>';
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
            if ($columnName == 'Nom')
            {
             $customText = '<strong>Total: ' . $totalValue . '</strong>';
             $handled = true;
            }
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
            if ($success) {
             $userId = $page->GetCurrentUserId();
             $currentDateTime = SMDateTime::Now();
             $sql =
             "INSERT INTO activity_log (table_name, action, user_id, log_time) " .
             "VALUES ('$tableName', 'INSERT', $userId, '$currentDateTime');";
             $page->GetConnection()->ExecSQL(sprintf($sql, $userId, $currentDateTime));
            }
            
            if ($success) {
             $message = 'Record added successfully.';
            }
            $messageDisplayTime = 2;
            
            if ($success) {
             $numero = $rowData['Numéro'];
             $sql = "INSERT INTO `phpgen_user_perms` (`user_id`, `page_name`, `perm_name`) VALUES ('$numero', 'demande_congé', 'SELECT'), ('$numero', 'demande_congé', 'INSERT'), ('$numero', 'demande_congé', 'UPDATE'), ('$numero', 'demande_congé', 'DELETE'), ('$numero', 'corps', 'SELECT'), ('$numero', 'grade', 'SELECT'), ('$numero', 'direction', 'SELECT'), ('$numero', 'division', 'SELECT'), ('$numero', 'service', 'SELECT'), ('$numero', 'jours_fériés', 'SELECT'), ('$numero', 'attestation_travail_user', 'SELECT'), ('$numero', 'attestation_travail_user', 'INSERT'), ('$numero', 'attestation_travail_user', 'UPDATE'), ('$numero', 'attestation_travail_user', 'DELETE')";
             $page->GetConnection()->ExecSQL($sql);
             $sql_2 = "DELETE FROM `phpgen_user_perms` WHERE `user_id` = 0";
             $page->GetConnection()->ExecSQL($sql_2);
            }
            
            
                          
                             
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
             $userId = $page->GetCurrentUserId();
             $currentDateTime = SMDateTime::Now();
             $sql =
             "INSERT INTO activity_log (table_name, action, user_id, log_time) " .
             "VALUES ('$tableName', 'UPDATE', $userId, '$currentDateTime');";
             $page->GetConnection()->ExecSQL($sql);
             }
            
            if ($success) {
             $message = 'Record updated successfully.';
            }
            else {
             $message = '<p>Something wrong happened. ' .
             '<a class="alert-link" href="mailto:admin@example.com">' .
             'Contact developers</a> for more info.</p>';
            }
            $messageDisplayTime = 2;
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
             $message = 'Record deleted successfully.';
            }
            else {
             $message = '<p>Something wrong happened. ' .
             '<a class="alert-link" href="mailto:admin@example.com">' .
             'Contact developers</a> for more info.</p>';
            }
            $messageDisplayTime = 2;
            
            if ($success) {
             $userId = $page->GetCurrentUserId();
             $currentDateTime = SMDateTime::Now();
             $sql =
             "INSERT INTO activity_log (table_name, action, user_id, log_time) " .
             "VALUES ('$tableName', 'DELETE', $userId, '$currentDateTime');";
             $page->GetConnection()->ExecSQL(sprintf($sql, $userId, $currentDateTime));
            }
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
            $userId = $this->GetCurrentUserId();
            if ($part == PagePart::Layout) {
                $sql_1 = "SELECT `count_reload_page` FROM `phpgen_users` WHERE `user_id` = 1";
                $count_1 = $this->GetConnection()->ExecScalarSQL($sql_1);
                $queryResult = array();
                $sql_2 = "SELECT `Numéro` as Num, `Nom`, `Prenom` FROM `fonctionnairesv3` WHERE `Solde de Congé` = 0";
                $this->GetConnection()->ExecQueryToArray($sql_2, $queryResult);
                $sql_3 = "SELECT COUNT(*) FROM `fonctionnairesv3` WHERE `Solde de Congé` IS NULL";
                $count_2 = $this->GetConnection()->ExecScalarSQL($sql_3);
                $params['count_solde_null'] = $count_2;
                $params['user_id'] = $userId;
                $params['users'] = $queryResult;
                $params['count_reload_page'] = $count_1;
                $result = 'custom_layout.tpl';
            }
            
            if ($part == PagePart::GridToolbar && $mode == PageMode::ViewAll) {
                $result = 'custom_grid_toolbar.tpl';
            }
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
            $options['filename'] = ($rowData ? $rowData['id'] : 'fonctionnaires') . '.' . $exportType;
            
            if ($exportType == 'pdf') {
             $options['header'] = '{DATE d.m.Y}';
             $options['footer'] = '{PAGENO}';
             $options['margin-top'] = 12;
            }
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
            if ($chart->getId() == 'Age_distribution') {
              $chart->setOptions(
                array(
                  'colors' => array('blue'),
                  'legend' => 'none',
                  'histogram' => array(
                    'bucketSize' => 10
                  ),
                  'hAxis' => array(
                    'title' => 'Age'
                  ),
                  'vAxis' => array(
                    'title' => 'Nombre des fonctionnaires'
                  )    
                )
              );
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
            $layout->setMode(FormLayoutMode::VERTICAL);
            
            if ($mode === 'view') {
                $personalGroup = $layout->addGroup('Informations personnelles', 8);
                $personalGroup->addRow()
                    ->addCol($columns['Civilité'], 4)
                    ->addCol($columns['Nom'], 4)
                    ->addCol($columns['Prenom'], 4);
                $personalGroup->addRow()
                    ->addCol($columns['N° CIN'], 4)
                    ->addCol($columns['Nom_arabe'], 4)
                    ->addCol($columns['Prenom_arabe'], 4);
                $personalGroup->addRow()
                    ->addCol($columns['Date de Naissance'], 4)
                    ->addCol($columns['Date de recrutement'], 4)
                    ->addCol($columns['Date d\'affectation au CRO'], 4);
                $personalGroup->addRow()
                    ->addCol($columns['Age'], 4)
                    ->addCol($columns['RIB'], 4)
                    ->addCol($columns['Matricule Aujour'], 4);
                $layout->addGroup('Photo', 4)->addRow()->addCol($columns['photo']);
            
                $teamGroup = $layout->addGroup('Situation administrative', 12);
                $teamGroup->addRow()
                    ->addCol($columns['Situation'], 6)
                    ->addCol($columns['Groupe'], 6);
                $teamGroup->addRow()
                    ->addCol($columns['Corps'], 4)
                    ->addCol($columns['Grade'], 4)
                    ->addCol($columns['Poste de responsabilité'], 4);
                $teamGroup->addRow()
                    ->addCol($columns['Direction'], 4)
                    ->addCol($columns['Division'], 4)
                    ->addCol($columns['Service'], 4);
                $teamGroup->setInlineStyles('margin-top: 20px;');
                $miscGroup = $layout->addGroup('Coordonnées', 12);
                $miscGroup->addRow()
                    ->addCol($columns['N° Tél'], 4)
                    ->addCol($columns['Email'], 4)
                    ->addCol($columns['Adresse'], 4);
                $miscGroup->setInlineStyles('margin-top: 20px;');
                $Solde = $layout->addGroup('Solde de congé');
                $Solde->addRow()
                    ->addCol($columns['Solde d\'année précédente'], 4)
                    ->addCol($columns['Solde d\'année actuelle'], 4)
                    ->addCol($columns['Solde de Congé'], 4);
            } else if ($mode=='insert' or $mode=='edit') {
                $layout->enableTabs(FormTabsStyle::TABS);
                $personalInfoTab = $layout->addTab('Informations personnelles');
                $personalInfoTab->setMode(FormLayoutMode::VERTICAL);
                $personalGroup = $personalInfoTab->addGroup('Informations personnelles', 8);
                $personalGroup->addRow()
                    ->addCol($columns['Civilité'], 4)
                    ->addCol($columns['Nom'], 4)
                    ->addCol($columns['Prenom'], 4);
                $personalGroup->addRow()
                    ->addCol($columns['N° CIN'], 4)
                    ->addCol($columns['Nom_arabe'], 4)
                    ->addCol($columns['Prenom_arabe'], 4);
                $personalGroup->addRow()
                    ->addCol($columns['Date de Naissance'], 4)
                    ->addCol($columns['Date de recrutement'], 4)
                    ->addCol($columns['Date d\'affectation au CRO'], 4);
                $personalGroup->addRow()
                    ->addCol($columns['RIB'], 8)
                    ->addCol($columns['Matricule Aujour'], 4);
                $personalInfoTab->addGroup('Photo', 4)->addRow()->addCol($columns['photo']);
                $attributsTab = $layout->addTab('Situation administrative');
                $attributsTab->setMode(FormLayoutMode::VERTICAL);
                $teamGroup = $attributsTab->addGroup('Situation administrative', 12);
                $teamGroup->addRow()
                    ->addCol($columns['Groupe'], 4)
                    ->addCol($columns['Corps'], 4)
                    ->addCol($columns['Grade'], 4);
                $teamGroup->addRow()
                    ->addCol($columns['Poste de responsabilité'], 6)
                    ->addCol($columns['Situation'], 6);
                $teamGroup->addRow()->addCol($columns['Direction'], 12);
                $teamGroup->addRow()->addCol($columns['Division'], 12);
                $teamGroup->addRow()->addCol($columns['Service'], 12);
                $contact = $layout->addTab('Coordonnées');
                $miscGroup = $contact->addGroup('Coordonnées', 12);
                $miscGroup->addRow()
                    ->addCol($columns['N° Tél'], 4)
                    ->addCol($columns['Email'], 4)
                    ->addCol($columns['Adresse'], 4);
                $Solde = $layout->addTab('Solde de congé');
                $Solde->setMode(FormLayoutMode::VERTICAL);
                $SoldeCongé = $Solde->addGroup('Solde de congé', 12);
                $SoldeCongé->addRow()
                    ->addCol($columns['Solde d\'année précédente'], 4)
                    ->addCol($columns['Solde d\'année actuelle'], 4)
                    ->addCol($columns['Solde de Congé'], 4);       
            }
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
            if ($fieldName == 'Age') {
                $dateOfBirth = new DateTime($rowData['Date de Naissance']);
                $dateInterval = $dateOfBirth->diff(new DateTime());
                $value = $dateInterval->format('%y');
            }
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
        $Page = new fonctionnairesv3Page("fonctionnairesv3", "fonctionnairesv3.php", GetCurrentUserPermissionsForPage("fonctionnairesv3"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("fonctionnairesv3"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
