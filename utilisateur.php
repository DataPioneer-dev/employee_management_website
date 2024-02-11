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
    
    
    
    class utilisateur_demande_attestationPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Demande Attestation');
            $this->SetMenuLabel('Demande Attestation');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`demande_attestation`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID_Attes', true, true, true),
                    new StringField('Etat', true),
                    new DateField('Date_Dmd', true),
                    new IntegerField('ID_Utilis', true),
                    new IntegerField('Statut', true),
                    new IntegerField('Flag')
                )
            );
            $this->dataset->AddLookupField('ID_Utilis', 'utilisateur', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'ID_Utilis_Nom_Utilis', 'ID_Utilis_Nom_Utilis_utilisateur'), 'ID_Utilis_Nom_Utilis_utilisateur');
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
                new FilterColumn($this->dataset, 'ID_Attes', 'ID_Attes', 'ID Attes'),
                new FilterColumn($this->dataset, 'Etat', 'Etat', 'Etat'),
                new FilterColumn($this->dataset, 'Date_Dmd', 'Date_Dmd', 'Date Dmd'),
                new FilterColumn($this->dataset, 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis'),
                new FilterColumn($this->dataset, 'Statut', 'Statut', 'Statut'),
                new FilterColumn($this->dataset, 'Flag', 'Flag', 'Flag')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_Attes'])
                ->addColumn($columns['Etat'])
                ->addColumn($columns['Date_Dmd'])
                ->addColumn($columns['ID_Utilis'])
                ->addColumn($columns['Statut'])
                ->addColumn($columns['Flag']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Date_Dmd')
                ->setOptionsFor('ID_Utilis');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_attes_edit');
            
            $filterBuilder->addColumn(
                $columns['ID_Attes'],
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
            
            $main_editor = new TextEdit('etat_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['Etat'],
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
            
            $main_editor = new DateTimeEdit('date_dmd_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Date_Dmd'],
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
            
            $main_editor = new DynamicCombobox('id_utilis_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_demande_attestation_ID_Utilis_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Utilis', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_demande_attestation_ID_Utilis_search');
            
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for ID_Attes field
            //
            $column = new NumberViewColumn('ID_Attes', 'ID_Attes', 'ID Attes', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
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
            // View column for ID_Attes field
            //
            $column = new NumberViewColumn('ID_Attes', 'ID_Attes', 'ID Attes', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
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
            // Edit column for Etat field
            //
            $editor = new TextEdit('etat_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Etat', 'Etat', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date_Dmd field
            //
            $editor = new DateTimeEdit('date_dmd_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Dmd', 'Date_Dmd', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'edit_utilisateur_demande_attestation_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
            // Edit column for Etat field
            //
            $editor = new TextEdit('etat_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Etat', 'Etat', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date_Dmd field
            //
            $editor = new DateTimeEdit('date_dmd_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Dmd', 'Date_Dmd', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'multi_edit_utilisateur_demande_attestation_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
            // Edit column for Etat field
            //
            $editor = new TextEdit('etat_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Etat', 'Etat', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date_Dmd field
            //
            $editor = new DateTimeEdit('date_dmd_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Dmd', 'Date_Dmd', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'insert_utilisateur_demande_attestation_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
            // View column for ID_Attes field
            //
            $column = new NumberViewColumn('ID_Attes', 'ID_Attes', 'ID Attes', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for ID_Attes field
            //
            $column = new NumberViewColumn('ID_Attes', 'ID_Attes', 'ID Attes', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
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
        protected function GetEnableModalGridDelete() { return true; }
    
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
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_demande_attestation_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_demande_attestation_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_demande_attestation_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_demande_attestation_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
    
    
    
    class utilisateur_demande_congePage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Demande Conge');
            $this->SetMenuLabel('Demande Conge');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`demande_conge`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID_Dem', true, true, true),
                    new DateField('Date_Depart', true),
                    new IntegerField('Nbr_Jrs', true),
                    new DateField('Date_Fin', true),
                    new StringField('Etat', true),
                    new IntegerField('ID_Utilis', true),
                    new DateField('Date_Dmd'),
                    new IntegerField('Flag')
                )
            );
            $this->dataset->AddLookupField('ID_Utilis', 'utilisateur', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'ID_Utilis_Nom_Utilis', 'ID_Utilis_Nom_Utilis_utilisateur'), 'ID_Utilis_Nom_Utilis_utilisateur');
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
                new FilterColumn($this->dataset, 'ID_Dem', 'ID_Dem', 'ID Dem'),
                new FilterColumn($this->dataset, 'Date_Depart', 'Date_Depart', 'Date Depart'),
                new FilterColumn($this->dataset, 'Nbr_Jrs', 'Nbr_Jrs', 'Nbr Jrs'),
                new FilterColumn($this->dataset, 'Date_Fin', 'Date_Fin', 'Date Fin'),
                new FilterColumn($this->dataset, 'Etat', 'Etat', 'Etat'),
                new FilterColumn($this->dataset, 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis'),
                new FilterColumn($this->dataset, 'Date_Dmd', 'Date_Dmd', 'Date Dmd'),
                new FilterColumn($this->dataset, 'Flag', 'Flag', 'Flag')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_Dem'])
                ->addColumn($columns['Date_Depart'])
                ->addColumn($columns['Nbr_Jrs'])
                ->addColumn($columns['Date_Fin'])
                ->addColumn($columns['Etat'])
                ->addColumn($columns['ID_Utilis'])
                ->addColumn($columns['Date_Dmd'])
                ->addColumn($columns['Flag']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Date_Depart')
                ->setOptionsFor('Date_Fin')
                ->setOptionsFor('ID_Utilis')
                ->setOptionsFor('Date_Dmd');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_dem_edit');
            
            $filterBuilder->addColumn(
                $columns['ID_Dem'],
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
            
            $main_editor = new DateTimeEdit('date_depart_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Date_Depart'],
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
            
            $main_editor = new TextEdit('nbr_jrs_edit');
            
            $filterBuilder->addColumn(
                $columns['Nbr_Jrs'],
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
            
            $main_editor = new DateTimeEdit('date_fin_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Date_Fin'],
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
            
            $main_editor = new TextEdit('etat_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['Etat'],
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
            
            $main_editor = new DynamicCombobox('id_utilis_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_demande_conge_ID_Utilis_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Utilis', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_demande_conge_ID_Utilis_search');
            
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
            
            $main_editor = new DateTimeEdit('date_dmd_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Date_Dmd'],
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for ID_Dem field
            //
            $column = new NumberViewColumn('ID_Dem', 'ID_Dem', 'ID Dem', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date_Depart field
            //
            $column = new DateTimeViewColumn('Date_Depart', 'Date_Depart', 'Date Depart', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nbr_Jrs field
            //
            $column = new NumberViewColumn('Nbr_Jrs', 'Nbr_Jrs', 'Nbr Jrs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date_Fin field
            //
            $column = new DateTimeViewColumn('Date_Fin', 'Date_Fin', 'Date Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
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
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
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
            // View column for ID_Dem field
            //
            $column = new NumberViewColumn('ID_Dem', 'ID_Dem', 'ID Dem', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Depart field
            //
            $column = new DateTimeViewColumn('Date_Depart', 'Date_Depart', 'Date Depart', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nbr_Jrs field
            //
            $column = new NumberViewColumn('Nbr_Jrs', 'Nbr_Jrs', 'Nbr Jrs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Fin field
            //
            $column = new DateTimeViewColumn('Date_Fin', 'Date_Fin', 'Date Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
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
            // Edit column for Date_Depart field
            //
            $editor = new DateTimeEdit('date_depart_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Depart', 'Date_Depart', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nbr_Jrs field
            //
            $editor = new TextEdit('nbr_jrs_edit');
            $editColumn = new CustomEditColumn('Nbr Jrs', 'Nbr_Jrs', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date_Fin field
            //
            $editor = new DateTimeEdit('date_fin_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Fin', 'Date_Fin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Etat field
            //
            $editor = new TextEdit('etat_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Etat', 'Etat', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'edit_utilisateur_demande_conge_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date_Dmd field
            //
            $editor = new DateTimeEdit('date_dmd_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Dmd', 'Date_Dmd', $editor, $this->dataset);
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
            // Edit column for Date_Depart field
            //
            $editor = new DateTimeEdit('date_depart_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Depart', 'Date_Depart', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Nbr_Jrs field
            //
            $editor = new TextEdit('nbr_jrs_edit');
            $editColumn = new CustomEditColumn('Nbr Jrs', 'Nbr_Jrs', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date_Fin field
            //
            $editor = new DateTimeEdit('date_fin_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Fin', 'Date_Fin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Etat field
            //
            $editor = new TextEdit('etat_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Etat', 'Etat', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'multi_edit_utilisateur_demande_conge_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date_Dmd field
            //
            $editor = new DateTimeEdit('date_dmd_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Dmd', 'Date_Dmd', $editor, $this->dataset);
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
            // Edit column for Date_Depart field
            //
            $editor = new DateTimeEdit('date_depart_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Depart', 'Date_Depart', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nbr_Jrs field
            //
            $editor = new TextEdit('nbr_jrs_edit');
            $editColumn = new CustomEditColumn('Nbr Jrs', 'Nbr_Jrs', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date_Fin field
            //
            $editor = new DateTimeEdit('date_fin_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Fin', 'Date_Fin', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Etat field
            //
            $editor = new TextEdit('etat_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Etat', 'Etat', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'insert_utilisateur_demande_conge_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date_Dmd field
            //
            $editor = new DateTimeEdit('date_dmd_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Dmd', 'Date_Dmd', $editor, $this->dataset);
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
            // View column for ID_Dem field
            //
            $column = new NumberViewColumn('ID_Dem', 'ID_Dem', 'ID Dem', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Depart field
            //
            $column = new DateTimeViewColumn('Date_Depart', 'Date_Depart', 'Date Depart', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nbr_Jrs field
            //
            $column = new NumberViewColumn('Nbr_Jrs', 'Nbr_Jrs', 'Nbr Jrs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Fin field
            //
            $column = new DateTimeViewColumn('Date_Fin', 'Date_Fin', 'Date Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
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
            // View column for ID_Dem field
            //
            $column = new NumberViewColumn('ID_Dem', 'ID_Dem', 'ID Dem', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Depart field
            //
            $column = new DateTimeViewColumn('Date_Depart', 'Date_Depart', 'Date Depart', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for Nbr_Jrs field
            //
            $column = new NumberViewColumn('Nbr_Jrs', 'Nbr_Jrs', 'Nbr Jrs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Fin field
            //
            $column = new DateTimeViewColumn('Date_Fin', 'Date_Fin', 'Date Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
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
            // View column for Date_Depart field
            //
            $column = new DateTimeViewColumn('Date_Depart', 'Date_Depart', 'Date Depart', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nbr_Jrs field
            //
            $column = new NumberViewColumn('Nbr_Jrs', 'Nbr_Jrs', 'Nbr Jrs', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date_Fin field
            //
            $column = new DateTimeViewColumn('Date_Fin', 'Date_Fin', 'Date Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Etat field
            //
            $column = new TextViewColumn('Etat', 'Etat', 'Etat', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date_Dmd field
            //
            $column = new DateTimeViewColumn('Date_Dmd', 'Date_Dmd', 'Date Dmd', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
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
        protected function GetEnableModalGridDelete() { return true; }
    
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
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_demande_conge_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_demande_conge_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_demande_conge_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_demande_conge_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
    
    
    
    class utilisateur_filePage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('File');
            $this->SetMenuLabel('File');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`file`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID_File', true, true, true),
                    new StringField('Nom_File'),
                    new IntegerField('Size_File'),
                    new IntegerField('ID_Utilis')
                )
            );
            $this->dataset->AddLookupField('ID_Utilis', 'utilisateur', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'ID_Utilis_Nom_Utilis', 'ID_Utilis_Nom_Utilis_utilisateur'), 'ID_Utilis_Nom_Utilis_utilisateur');
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
                new FilterColumn($this->dataset, 'ID_File', 'ID_File', 'ID File'),
                new FilterColumn($this->dataset, 'Nom_File', 'Nom_File', 'Nom File'),
                new FilterColumn($this->dataset, 'Size_File', 'Size_File', 'Size File'),
                new FilterColumn($this->dataset, 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_File'])
                ->addColumn($columns['Nom_File'])
                ->addColumn($columns['Size_File'])
                ->addColumn($columns['ID_Utilis']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('ID_Utilis');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_file_edit');
            
            $filterBuilder->addColumn(
                $columns['ID_File'],
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
            
            $main_editor = new TextEdit('Nom_File');
            
            $filterBuilder->addColumn(
                $columns['Nom_File'],
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
            
            $main_editor = new TextEdit('size_file_edit');
            
            $filterBuilder->addColumn(
                $columns['Size_File'],
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
            $main_editor->SetHandlerName('filter_builder_utilisateur_file_ID_Utilis_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Utilis', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_file_ID_Utilis_search');
            
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
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for ID_File field
            //
            $column = new NumberViewColumn('ID_File', 'ID_File', 'ID File', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_File field
            //
            $column = new TextViewColumn('Nom_File', 'Nom_File', 'Nom File', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Size_File field
            //
            $column = new NumberViewColumn('Size_File', 'Size_File', 'Size File', $this->dataset);
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
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for ID_File field
            //
            $column = new NumberViewColumn('ID_File', 'ID_File', 'ID File', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_File field
            //
            $column = new TextViewColumn('Nom_File', 'Nom_File', 'Nom File', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Size_File field
            //
            $column = new NumberViewColumn('Size_File', 'Size_File', 'Size File', $this->dataset);
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
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Nom_File field
            //
            $editor = new TextAreaEdit('nom_file_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nom File', 'Nom_File', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Size_File field
            //
            $editor = new TextEdit('size_file_edit');
            $editColumn = new CustomEditColumn('Size File', 'Size_File', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'edit_utilisateur_file_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Nom_File field
            //
            $editor = new TextAreaEdit('nom_file_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nom File', 'Nom_File', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Size_File field
            //
            $editor = new TextEdit('size_file_edit');
            $editColumn = new CustomEditColumn('Size File', 'Size_File', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'multi_edit_utilisateur_file_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Nom_File field
            //
            $editor = new TextAreaEdit('nom_file_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nom File', 'Nom_File', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Size_File field
            //
            $editor = new TextEdit('size_file_edit');
            $editColumn = new CustomEditColumn('Size File', 'Size_File', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'insert_utilisateur_file_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
            // View column for ID_File field
            //
            $column = new NumberViewColumn('ID_File', 'ID_File', 'ID File', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_File field
            //
            $column = new TextViewColumn('Nom_File', 'Nom_File', 'Nom File', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Size_File field
            //
            $column = new NumberViewColumn('Size_File', 'Size_File', 'Size File', $this->dataset);
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
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for ID_File field
            //
            $column = new NumberViewColumn('ID_File', 'ID_File', 'ID File', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_File field
            //
            $column = new TextViewColumn('Nom_File', 'Nom_File', 'Nom File', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Size_File field
            //
            $column = new NumberViewColumn('Size_File', 'Size_File', 'Size File', $this->dataset);
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
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Nom_File field
            //
            $column = new TextViewColumn('Nom_File', 'Nom_File', 'Nom File', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Size_File field
            //
            $column = new NumberViewColumn('Size_File', 'Size_File', 'Size File', $this->dataset);
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
        protected function GetEnableModalGridDelete() { return true; }
    
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
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_file_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_file_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_file_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_file_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
    
    
    
    class utilisateur_notificationPage extends DetailPage
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
            $this->dataset->AddLookupField('ID_Utilis', 'utilisateur', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'ID_Utilis_Nom_Utilis', 'ID_Utilis_Nom_Utilis_utilisateur'), 'ID_Utilis_Nom_Utilis_utilisateur');
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
            $main_editor->SetHandlerName('filter_builder_utilisateur_notification_ID_Utilis_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Utilis', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_notification_ID_Utilis_search');
            
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'edit_utilisateur_notification_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'multi_edit_utilisateur_notification_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'insert_utilisateur_notification_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
        protected function GetEnableModalGridDelete() { return true; }
    
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
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_notification_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_notification_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_notification_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_notification_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
    
    
    
    class utilisateur_soldePage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Solde');
            $this->SetMenuLabel('Solde');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`solde`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID_Sold', true, true, true),
                    new IntegerField('Solde_AP', true),
                    new IntegerField('Solde_AA', true),
                    new IntegerField('ID_Utilis', true)
                )
            );
            $this->dataset->AddLookupField('ID_Utilis', 'utilisateur', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'ID_Utilis_Nom_Utilis', 'ID_Utilis_Nom_Utilis_utilisateur'), 'ID_Utilis_Nom_Utilis_utilisateur');
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
                new FilterColumn($this->dataset, 'ID_Sold', 'ID_Sold', 'ID Sold'),
                new FilterColumn($this->dataset, 'Solde_AP', 'Solde_AP', 'Solde AP'),
                new FilterColumn($this->dataset, 'Solde_AA', 'Solde_AA', 'Solde AA'),
                new FilterColumn($this->dataset, 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'ID Utilis')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_Sold'])
                ->addColumn($columns['Solde_AP'])
                ->addColumn($columns['Solde_AA'])
                ->addColumn($columns['ID_Utilis']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('ID_Utilis');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_sold_edit');
            
            $filterBuilder->addColumn(
                $columns['ID_Sold'],
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
            
            $main_editor = new TextEdit('solde_ap_edit');
            
            $filterBuilder->addColumn(
                $columns['Solde_AP'],
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
            
            $main_editor = new TextEdit('solde_aa_edit');
            
            $filterBuilder->addColumn(
                $columns['Solde_AA'],
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
            $main_editor->SetHandlerName('filter_builder_utilisateur_solde_ID_Utilis_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Utilis', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_solde_ID_Utilis_search');
            
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
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for ID_Sold field
            //
            $column = new NumberViewColumn('ID_Sold', 'ID_Sold', 'ID Sold', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Solde_AP field
            //
            $column = new NumberViewColumn('Solde_AP', 'Solde_AP', 'Solde AP', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Solde_AA field
            //
            $column = new NumberViewColumn('Solde_AA', 'Solde_AA', 'Solde AA', $this->dataset);
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
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for ID_Sold field
            //
            $column = new NumberViewColumn('ID_Sold', 'ID_Sold', 'ID Sold', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Solde_AP field
            //
            $column = new NumberViewColumn('Solde_AP', 'Solde_AP', 'Solde AP', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Solde_AA field
            //
            $column = new NumberViewColumn('Solde_AA', 'Solde_AA', 'Solde AA', $this->dataset);
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
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Solde_AP field
            //
            $editor = new TextEdit('solde_ap_edit');
            $editColumn = new CustomEditColumn('Solde AP', 'Solde_AP', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Solde_AA field
            //
            $editor = new TextEdit('solde_aa_edit');
            $editColumn = new CustomEditColumn('Solde AA', 'Solde_AA', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'edit_utilisateur_solde_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Solde_AP field
            //
            $editor = new TextEdit('solde_ap_edit');
            $editColumn = new CustomEditColumn('Solde AP', 'Solde_AP', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Solde_AA field
            //
            $editor = new TextEdit('solde_aa_edit');
            $editColumn = new CustomEditColumn('Solde AA', 'Solde_AA', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'multi_edit_utilisateur_solde_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Solde_AP field
            //
            $editor = new TextEdit('solde_ap_edit');
            $editColumn = new CustomEditColumn('Solde AP', 'Solde_AP', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Solde_AA field
            //
            $editor = new TextEdit('solde_aa_edit');
            $editColumn = new CustomEditColumn('Solde AA', 'Solde_AA', $editor, $this->dataset);
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
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('ID Utilis', 'ID_Utilis', 'ID_Utilis_Nom_Utilis', 'insert_utilisateur_solde_ID_Utilis_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
            // View column for ID_Sold field
            //
            $column = new NumberViewColumn('ID_Sold', 'ID_Sold', 'ID Sold', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Solde_AP field
            //
            $column = new NumberViewColumn('Solde_AP', 'Solde_AP', 'Solde AP', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Solde_AA field
            //
            $column = new NumberViewColumn('Solde_AA', 'Solde_AA', 'Solde AA', $this->dataset);
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
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for ID_Sold field
            //
            $column = new NumberViewColumn('ID_Sold', 'ID_Sold', 'ID Sold', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Solde_AP field
            //
            $column = new NumberViewColumn('Solde_AP', 'Solde_AP', 'Solde AP', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Solde_AA field
            //
            $column = new NumberViewColumn('Solde_AA', 'Solde_AA', 'Solde AA', $this->dataset);
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
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Solde_AP field
            //
            $column = new NumberViewColumn('Solde_AP', 'Solde_AP', 'Solde AP', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Solde_AA field
            //
            $column = new NumberViewColumn('Solde_AA', 'Solde_AA', 'Solde AA', $this->dataset);
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
        protected function GetEnableModalGridDelete() { return true; }
    
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
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_solde_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_solde_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_solde_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_solde_ID_Utilis_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
    
    
    
    class utilisateur_utilisateurPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Utilisateur');
            $this->SetMenuLabel('Utilisateur');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
            $this->dataset->addFields(
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
            $this->dataset->AddLookupField('ID_Div', 'division', new IntegerField('ID_Division'), new StringField('Nom_Div', false, false, false, false, 'ID_Div_Nom_Div', 'ID_Div_Nom_Div_division'), 'ID_Div_Nom_Div_division');
            $this->dataset->AddLookupField('ID_Serv', 'service', new IntegerField('ID_Serv'), new StringField('Nom_Serv', false, false, false, false, 'ID_Serv_Nom_Serv', 'ID_Serv_Nom_Serv_service'), 'ID_Serv_Nom_Serv_service');
            $this->dataset->AddLookupField('Cadre', 'cadre', new IntegerField('ID_Cadr'), new StringField('Libelle', false, false, false, false, 'Cadre_Libelle', 'Cadre_Libelle_cadre'), 'Cadre_Libelle_cadre');
            $this->dataset->AddLookupField('Grade', 'grade', new IntegerField('ID_Grad'), new StringField('Libelle', false, false, false, false, 'Grade_Libelle', 'Grade_Libelle_grade'), 'Grade_Libelle_grade');
            $this->dataset->AddLookupField('Corps', 'corps', new IntegerField('ID_Cor'), new StringField('Libelle', false, false, false, false, 'Corps_Libelle', 'Corps_Libelle_corps'), 'Corps_Libelle_corps');
            $this->dataset->AddLookupField('Superviseur_Serv', 'utilisateur', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'Superviseur_Serv_Nom_Utilis', 'Superviseur_Serv_Nom_Utilis_utilisateur'), 'Superviseur_Serv_Nom_Utilis_utilisateur');
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
                new FilterColumn($this->dataset, 'ID_Utilis', 'ID_Utilis', 'ID Utilis'),
                new FilterColumn($this->dataset, 'Nom_Utilis', 'Nom_Utilis', 'Nom Utilis'),
                new FilterColumn($this->dataset, 'Prenom', 'Prenom', 'Prenom'),
                new FilterColumn($this->dataset, 'CIN', 'CIN', 'CIN'),
                new FilterColumn($this->dataset, 'Phone', 'Phone', 'Phone'),
                new FilterColumn($this->dataset, 'Email', 'Email', 'Email'),
                new FilterColumn($this->dataset, 'Adresse', 'Adresse', 'Adresse'),
                new FilterColumn($this->dataset, 'Fonction', 'Fonction', 'Fonction'),
                new FilterColumn($this->dataset, 'Date_Naiss', 'Date_Naiss', 'Date Naiss'),
                new FilterColumn($this->dataset, 'Jrs_Total', 'Jrs_Total', 'Jrs Total'),
                new FilterColumn($this->dataset, 'Jrs_Rest', 'Jrs_Rest', 'Jrs Rest'),
                new FilterColumn($this->dataset, 'Password', 'Password', 'Password'),
                new FilterColumn($this->dataset, 'Username', 'Username', 'Username'),
                new FilterColumn($this->dataset, 'ID_Div', 'ID_Div_Nom_Div', 'ID Div'),
                new FilterColumn($this->dataset, 'ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv'),
                new FilterColumn($this->dataset, 'Cadre', 'Cadre_Libelle', 'Cadre'),
                new FilterColumn($this->dataset, 'Grade', 'Grade_Libelle', 'Grade'),
                new FilterColumn($this->dataset, 'Aujour', 'Aujour', 'Aujour'),
                new FilterColumn($this->dataset, 'Nom_Arabe', 'Nom_Arabe', 'Nom Arabe'),
                new FilterColumn($this->dataset, 'Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe'),
                new FilterColumn($this->dataset, 'Corps', 'Corps_Libelle', 'Corps'),
                new FilterColumn($this->dataset, 'ChefServ', 'ChefServ', 'Chef Serv'),
                new FilterColumn($this->dataset, 'ChefDiv', 'ChefDiv', 'Chef Div'),
                new FilterColumn($this->dataset, 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv'),
                new FilterColumn($this->dataset, 'Sexe', 'Sexe', 'Sexe'),
                new FilterColumn($this->dataset, 'Admin', 'Admin', 'Admin')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_Utilis'])
                ->addColumn($columns['Nom_Utilis'])
                ->addColumn($columns['Prenom'])
                ->addColumn($columns['CIN'])
                ->addColumn($columns['Phone'])
                ->addColumn($columns['Email'])
                ->addColumn($columns['Adresse'])
                ->addColumn($columns['Fonction'])
                ->addColumn($columns['Date_Naiss'])
                ->addColumn($columns['Jrs_Total'])
                ->addColumn($columns['Jrs_Rest'])
                ->addColumn($columns['Password'])
                ->addColumn($columns['Username'])
                ->addColumn($columns['ID_Div'])
                ->addColumn($columns['ID_Serv'])
                ->addColumn($columns['Cadre'])
                ->addColumn($columns['Grade'])
                ->addColumn($columns['Aujour'])
                ->addColumn($columns['Nom_Arabe'])
                ->addColumn($columns['Prenom_Arabe'])
                ->addColumn($columns['Corps'])
                ->addColumn($columns['ChefServ'])
                ->addColumn($columns['ChefDiv'])
                ->addColumn($columns['Superviseur_Serv'])
                ->addColumn($columns['Sexe'])
                ->addColumn($columns['Admin']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Date_Naiss')
                ->setOptionsFor('ID_Div')
                ->setOptionsFor('ID_Serv')
                ->setOptionsFor('Cadre')
                ->setOptionsFor('Grade')
                ->setOptionsFor('Corps')
                ->setOptionsFor('Superviseur_Serv');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_utilis_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nom_utilis_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Nom_Utilis'],
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
            
            $main_editor = new TextEdit('cin_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['CIN'],
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
            
            $main_editor = new TextEdit('phone_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['Phone'],
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
            
            $main_editor = new TextEdit('Adresse');
            
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
            
            $main_editor = new TextEdit('Fonction');
            
            $filterBuilder->addColumn(
                $columns['Fonction'],
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
            
            $main_editor = new DateTimeEdit('date_naiss_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Date_Naiss'],
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
            
            $main_editor = new TextEdit('jrs_total_edit');
            
            $filterBuilder->addColumn(
                $columns['Jrs_Total'],
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
            
            $main_editor = new TextEdit('jrs_rest_edit');
            
            $filterBuilder->addColumn(
                $columns['Jrs_Rest'],
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
            
            $main_editor = new TextEdit('Password');
            
            $filterBuilder->addColumn(
                $columns['Password'],
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
            
            $main_editor = new TextEdit('username_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['Username'],
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
            
            $main_editor = new DynamicCombobox('id_div_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_ID_Div_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Div', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_ID_Div_search');
            
            $text_editor = new TextEdit('ID_Div');
            
            $filterBuilder->addColumn(
                $columns['ID_Div'],
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
            
            $main_editor = new DynamicCombobox('id_serv_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_ID_Serv_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Serv', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_ID_Serv_search');
            
            $text_editor = new TextEdit('ID_Serv');
            
            $filterBuilder->addColumn(
                $columns['ID_Serv'],
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
            
            $main_editor = new DynamicCombobox('cadre_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_Cadre_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Cadre', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_Cadre_search');
            
            $text_editor = new TextEdit('Cadre');
            
            $filterBuilder->addColumn(
                $columns['Cadre'],
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
            $main_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_Grade_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Grade', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_Grade_search');
            
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
            
            $main_editor = new TextEdit('aujour_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Aujour'],
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
                $columns['Nom_Arabe'],
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
                $columns['Prenom_Arabe'],
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
            
            $main_editor = new DynamicCombobox('corps_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_Corps_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Corps', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_Corps_search');
            
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
            
            $main_editor = new TextEdit('chefserv_edit');
            
            $filterBuilder->addColumn(
                $columns['ChefServ'],
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
            
            $main_editor = new TextEdit('chefdiv_edit');
            
            $filterBuilder->addColumn(
                $columns['ChefDiv'],
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
            
            $main_editor = new DynamicCombobox('superviseur_serv_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_Superviseur_Serv_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Superviseur_Serv', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_utilisateur_Superviseur_Serv_search');
            
            $text_editor = new TextEdit('Superviseur_Serv');
            
            $filterBuilder->addColumn(
                $columns['Superviseur_Serv'],
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
            
            $main_editor = new TextEdit('sexe_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Sexe'],
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
            
            $main_editor = new TextEdit('admin_edit');
            $main_editor->SetMaxLength(30);
            
            $filterBuilder->addColumn(
                $columns['Admin'],
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
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for ID_Utilis field
            //
            $column = new NumberViewColumn('ID_Utilis', 'ID_Utilis', 'ID Utilis', $this->dataset);
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
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
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
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for ID_Utilis field
            //
            $column = new NumberViewColumn('ID_Utilis', 'ID_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Nom_Utilis field
            //
            $editor = new TextEdit('nom_utilis_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Utilis', 'Nom_Utilis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for CIN field
            //
            $editor = new TextEdit('cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('CIN', 'CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Phone field
            //
            $editor = new TextEdit('phone_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Phone', 'Phone', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextAreaEdit('adresse_edit', 50, 8);
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Fonction field
            //
            $editor = new TextAreaEdit('fonction_edit', 50, 8);
            $editColumn = new CustomEditColumn('Fonction', 'Fonction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date_Naiss field
            //
            $editor = new DateTimeEdit('date_naiss_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Naiss', 'Date_Naiss', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Jrs_Total field
            //
            $editor = new TextEdit('jrs_total_edit');
            $editColumn = new CustomEditColumn('Jrs Total', 'Jrs_Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Jrs_Rest field
            //
            $editor = new TextEdit('jrs_rest_edit');
            $editColumn = new CustomEditColumn('Jrs Rest', 'Jrs_Rest', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Password field
            //
            $editor = new TextAreaEdit('password_edit', 50, 8);
            $editColumn = new CustomEditColumn('Password', 'Password', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Username field
            //
            $editor = new TextEdit('username_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Username', 'Username', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ID_Div field
            //
            $editor = new DynamicCombobox('id_div_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'edit_utilisateur_utilisateur_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ID_Serv field
            //
            $editor = new DynamicCombobox('id_serv_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'edit_utilisateur_utilisateur_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Cadre field
            //
            $editor = new DynamicCombobox('cadre_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'edit_utilisateur_utilisateur_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'edit_utilisateur_utilisateur_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextEdit('aujour_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Aujour', 'Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nom_Arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Prenom_Arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'edit_utilisateur_utilisateur_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ChefServ field
            //
            $editor = new TextEdit('chefserv_edit');
            $editColumn = new CustomEditColumn('Chef Serv', 'ChefServ', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ChefDiv field
            //
            $editor = new TextEdit('chefdiv_edit');
            $editColumn = new CustomEditColumn('Chef Div', 'ChefDiv', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Superviseur_Serv field
            //
            $editor = new DynamicCombobox('superviseur_serv_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'edit_utilisateur_utilisateur_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Sexe field
            //
            $editor = new TextEdit('sexe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sexe', 'Sexe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Admin field
            //
            $editor = new TextEdit('admin_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Admin', 'Admin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Nom_Utilis field
            //
            $editor = new TextEdit('nom_utilis_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Utilis', 'Nom_Utilis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for CIN field
            //
            $editor = new TextEdit('cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('CIN', 'CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Phone field
            //
            $editor = new TextEdit('phone_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Phone', 'Phone', $editor, $this->dataset);
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
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextAreaEdit('adresse_edit', 50, 8);
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Fonction field
            //
            $editor = new TextAreaEdit('fonction_edit', 50, 8);
            $editColumn = new CustomEditColumn('Fonction', 'Fonction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date_Naiss field
            //
            $editor = new DateTimeEdit('date_naiss_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Naiss', 'Date_Naiss', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Jrs_Total field
            //
            $editor = new TextEdit('jrs_total_edit');
            $editColumn = new CustomEditColumn('Jrs Total', 'Jrs_Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Jrs_Rest field
            //
            $editor = new TextEdit('jrs_rest_edit');
            $editColumn = new CustomEditColumn('Jrs Rest', 'Jrs_Rest', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Password field
            //
            $editor = new TextAreaEdit('password_edit', 50, 8);
            $editColumn = new CustomEditColumn('Password', 'Password', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Username field
            //
            $editor = new TextEdit('username_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Username', 'Username', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ID_Div field
            //
            $editor = new DynamicCombobox('id_div_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'multi_edit_utilisateur_utilisateur_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ID_Serv field
            //
            $editor = new DynamicCombobox('id_serv_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'multi_edit_utilisateur_utilisateur_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Cadre field
            //
            $editor = new DynamicCombobox('cadre_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'multi_edit_utilisateur_utilisateur_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'multi_edit_utilisateur_utilisateur_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextEdit('aujour_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Aujour', 'Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Nom_Arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Prenom_Arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_Arabe', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'multi_edit_utilisateur_utilisateur_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ChefServ field
            //
            $editor = new TextEdit('chefserv_edit');
            $editColumn = new CustomEditColumn('Chef Serv', 'ChefServ', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ChefDiv field
            //
            $editor = new TextEdit('chefdiv_edit');
            $editColumn = new CustomEditColumn('Chef Div', 'ChefDiv', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Superviseur_Serv field
            //
            $editor = new DynamicCombobox('superviseur_serv_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'multi_edit_utilisateur_utilisateur_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Sexe field
            //
            $editor = new TextEdit('sexe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sexe', 'Sexe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Admin field
            //
            $editor = new TextEdit('admin_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Admin', 'Admin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Nom_Utilis field
            //
            $editor = new TextEdit('nom_utilis_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Utilis', 'Nom_Utilis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CIN field
            //
            $editor = new TextEdit('cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('CIN', 'CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Phone field
            //
            $editor = new TextEdit('phone_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Phone', 'Phone', $editor, $this->dataset);
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
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextAreaEdit('adresse_edit', 50, 8);
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Fonction field
            //
            $editor = new TextAreaEdit('fonction_edit', 50, 8);
            $editColumn = new CustomEditColumn('Fonction', 'Fonction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date_Naiss field
            //
            $editor = new DateTimeEdit('date_naiss_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Naiss', 'Date_Naiss', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Jrs_Total field
            //
            $editor = new TextEdit('jrs_total_edit');
            $editColumn = new CustomEditColumn('Jrs Total', 'Jrs_Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Jrs_Rest field
            //
            $editor = new TextEdit('jrs_rest_edit');
            $editColumn = new CustomEditColumn('Jrs Rest', 'Jrs_Rest', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Password field
            //
            $editor = new TextAreaEdit('password_edit', 50, 8);
            $editColumn = new CustomEditColumn('Password', 'Password', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Username field
            //
            $editor = new TextEdit('username_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Username', 'Username', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ID_Div field
            //
            $editor = new DynamicCombobox('id_div_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'insert_utilisateur_utilisateur_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ID_Serv field
            //
            $editor = new DynamicCombobox('id_serv_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'insert_utilisateur_utilisateur_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Cadre field
            //
            $editor = new DynamicCombobox('cadre_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'insert_utilisateur_utilisateur_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'insert_utilisateur_utilisateur_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextEdit('aujour_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Aujour', 'Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nom_Arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Prenom_Arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_Arabe', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'insert_utilisateur_utilisateur_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ChefServ field
            //
            $editor = new TextEdit('chefserv_edit');
            $editColumn = new CustomEditColumn('Chef Serv', 'ChefServ', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ChefDiv field
            //
            $editor = new TextEdit('chefdiv_edit');
            $editColumn = new CustomEditColumn('Chef Div', 'ChefDiv', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Superviseur_Serv field
            //
            $editor = new DynamicCombobox('superviseur_serv_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'insert_utilisateur_utilisateur_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Sexe field
            //
            $editor = new TextEdit('sexe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sexe', 'Sexe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Admin field
            //
            $editor = new TextEdit('admin_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Admin', 'Admin', $editor, $this->dataset);
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
            // View column for ID_Utilis field
            //
            $column = new NumberViewColumn('ID_Utilis', 'ID_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for ID_Utilis field
            //
            $column = new NumberViewColumn('ID_Utilis', 'ID_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
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
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
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
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_utilisateur_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_utilisateur_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_utilisateur_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_utilisateur_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_utilisateur_Corps_search', 'ID_Cor', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_utilisateur_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_utilisateur_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_utilisateur_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_utilisateur_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_utilisateur_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_utilisateur_Corps_search', 'ID_Cor', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_utilisateur_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_utilisateur_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_utilisateur_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_utilisateur_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_utilisateur_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_utilisateur_Corps_search', 'ID_Cor', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_utilisateur_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_utilisateur_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_utilisateur_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_utilisateur_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_utilisateur_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_utilisateur_Corps_search', 'ID_Cor', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_utilisateur_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
    
    
    
    class utilisateurPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Utilisateur');
            $this->SetMenuLabel('Utilisateur');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
            $this->dataset->addFields(
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
            $this->dataset->AddLookupField('ID_Div', 'division', new IntegerField('ID_Division'), new StringField('Nom_Div', false, false, false, false, 'ID_Div_Nom_Div', 'ID_Div_Nom_Div_division'), 'ID_Div_Nom_Div_division');
            $this->dataset->AddLookupField('ID_Serv', 'service', new IntegerField('ID_Serv'), new StringField('Nom_Serv', false, false, false, false, 'ID_Serv_Nom_Serv', 'ID_Serv_Nom_Serv_service'), 'ID_Serv_Nom_Serv_service');
            $this->dataset->AddLookupField('Cadre', 'cadre', new IntegerField('ID_Cadr'), new StringField('Libelle', false, false, false, false, 'Cadre_Libelle', 'Cadre_Libelle_cadre'), 'Cadre_Libelle_cadre');
            $this->dataset->AddLookupField('Grade', 'grade', new IntegerField('ID_Grad'), new StringField('Libelle', false, false, false, false, 'Grade_Libelle', 'Grade_Libelle_grade'), 'Grade_Libelle_grade');
            $this->dataset->AddLookupField('Corps', 'corps', new IntegerField('ID_Cor'), new StringField('Libelle', false, false, false, false, 'Corps_Libelle', 'Corps_Libelle_corps'), 'Corps_Libelle_corps');
            $this->dataset->AddLookupField('Superviseur_Serv', 'utilisateur', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'Superviseur_Serv_Nom_Utilis', 'Superviseur_Serv_Nom_Utilis_utilisateur'), 'Superviseur_Serv_Nom_Utilis_utilisateur');
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
                new FilterColumn($this->dataset, 'ID_Utilis', 'ID_Utilis', 'ID Utilis'),
                new FilterColumn($this->dataset, 'Nom_Utilis', 'Nom_Utilis', 'Nom Utilis'),
                new FilterColumn($this->dataset, 'Prenom', 'Prenom', 'Prenom'),
                new FilterColumn($this->dataset, 'CIN', 'CIN', 'CIN'),
                new FilterColumn($this->dataset, 'Phone', 'Phone', 'Phone'),
                new FilterColumn($this->dataset, 'Email', 'Email', 'Email'),
                new FilterColumn($this->dataset, 'Adresse', 'Adresse', 'Adresse'),
                new FilterColumn($this->dataset, 'Fonction', 'Fonction', 'Fonction'),
                new FilterColumn($this->dataset, 'Date_Naiss', 'Date_Naiss', 'Date Naiss'),
                new FilterColumn($this->dataset, 'Jrs_Total', 'Jrs_Total', 'Jrs Total'),
                new FilterColumn($this->dataset, 'Jrs_Rest', 'Jrs_Rest', 'Jrs Rest'),
                new FilterColumn($this->dataset, 'Password', 'Password', 'Password'),
                new FilterColumn($this->dataset, 'Username', 'Username', 'Username'),
                new FilterColumn($this->dataset, 'ID_Div', 'ID_Div_Nom_Div', 'ID Div'),
                new FilterColumn($this->dataset, 'ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv'),
                new FilterColumn($this->dataset, 'Cadre', 'Cadre_Libelle', 'Cadre'),
                new FilterColumn($this->dataset, 'Grade', 'Grade_Libelle', 'Grade'),
                new FilterColumn($this->dataset, 'Aujour', 'Aujour', 'Aujour'),
                new FilterColumn($this->dataset, 'Nom_Arabe', 'Nom_Arabe', 'Nom Arabe'),
                new FilterColumn($this->dataset, 'Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe'),
                new FilterColumn($this->dataset, 'Corps', 'Corps_Libelle', 'Corps'),
                new FilterColumn($this->dataset, 'ChefServ', 'ChefServ', 'Chef Serv'),
                new FilterColumn($this->dataset, 'ChefDiv', 'ChefDiv', 'Chef Div'),
                new FilterColumn($this->dataset, 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv'),
                new FilterColumn($this->dataset, 'Sexe', 'Sexe', 'Sexe'),
                new FilterColumn($this->dataset, 'Admin', 'Admin', 'Admin')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_Utilis'])
                ->addColumn($columns['Nom_Utilis'])
                ->addColumn($columns['Prenom'])
                ->addColumn($columns['CIN'])
                ->addColumn($columns['Phone'])
                ->addColumn($columns['Email'])
                ->addColumn($columns['Adresse'])
                ->addColumn($columns['Fonction'])
                ->addColumn($columns['Date_Naiss'])
                ->addColumn($columns['Jrs_Total'])
                ->addColumn($columns['Jrs_Rest'])
                ->addColumn($columns['Password'])
                ->addColumn($columns['Username'])
                ->addColumn($columns['ID_Div'])
                ->addColumn($columns['ID_Serv'])
                ->addColumn($columns['Cadre'])
                ->addColumn($columns['Grade'])
                ->addColumn($columns['Aujour'])
                ->addColumn($columns['Nom_Arabe'])
                ->addColumn($columns['Prenom_Arabe'])
                ->addColumn($columns['Corps'])
                ->addColumn($columns['ChefServ'])
                ->addColumn($columns['ChefDiv'])
                ->addColumn($columns['Superviseur_Serv'])
                ->addColumn($columns['Sexe'])
                ->addColumn($columns['Admin']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Date_Naiss')
                ->setOptionsFor('ID_Div')
                ->setOptionsFor('ID_Serv')
                ->setOptionsFor('Cadre')
                ->setOptionsFor('Grade')
                ->setOptionsFor('Corps')
                ->setOptionsFor('Superviseur_Serv');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_utilis_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nom_utilis_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Nom_Utilis'],
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
            
            $main_editor = new TextEdit('cin_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['CIN'],
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
            
            $main_editor = new TextEdit('phone_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['Phone'],
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
            
            $main_editor = new TextEdit('Adresse');
            
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
            
            $main_editor = new TextEdit('Fonction');
            
            $filterBuilder->addColumn(
                $columns['Fonction'],
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
            
            $main_editor = new DateTimeEdit('date_naiss_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Date_Naiss'],
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
            
            $main_editor = new TextEdit('jrs_total_edit');
            
            $filterBuilder->addColumn(
                $columns['Jrs_Total'],
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
            
            $main_editor = new TextEdit('jrs_rest_edit');
            
            $filterBuilder->addColumn(
                $columns['Jrs_Rest'],
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
            
            $main_editor = new TextEdit('Password');
            
            $filterBuilder->addColumn(
                $columns['Password'],
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
            
            $main_editor = new TextEdit('username_edit');
            $main_editor->SetMaxLength(20);
            
            $filterBuilder->addColumn(
                $columns['Username'],
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
            
            $main_editor = new DynamicCombobox('id_div_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_ID_Div_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Div', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_ID_Div_search');
            
            $text_editor = new TextEdit('ID_Div');
            
            $filterBuilder->addColumn(
                $columns['ID_Div'],
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
            
            $main_editor = new DynamicCombobox('id_serv_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_ID_Serv_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Serv', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_ID_Serv_search');
            
            $text_editor = new TextEdit('ID_Serv');
            
            $filterBuilder->addColumn(
                $columns['ID_Serv'],
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
            
            $main_editor = new DynamicCombobox('cadre_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_Cadre_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Cadre', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_Cadre_search');
            
            $text_editor = new TextEdit('Cadre');
            
            $filterBuilder->addColumn(
                $columns['Cadre'],
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
            $main_editor->SetHandlerName('filter_builder_utilisateur_Grade_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Grade', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_Grade_search');
            
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
            
            $main_editor = new TextEdit('aujour_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['Aujour'],
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
                $columns['Nom_Arabe'],
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
                $columns['Prenom_Arabe'],
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
            
            $main_editor = new DynamicCombobox('corps_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_Corps_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Corps', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_Corps_search');
            
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
            
            $main_editor = new TextEdit('chefserv_edit');
            
            $filterBuilder->addColumn(
                $columns['ChefServ'],
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
            
            $main_editor = new TextEdit('chefdiv_edit');
            
            $filterBuilder->addColumn(
                $columns['ChefDiv'],
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
            
            $main_editor = new DynamicCombobox('superviseur_serv_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_utilisateur_Superviseur_Serv_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Superviseur_Serv', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_utilisateur_Superviseur_Serv_search');
            
            $text_editor = new TextEdit('Superviseur_Serv');
            
            $filterBuilder->addColumn(
                $columns['Superviseur_Serv'],
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
            
            $main_editor = new TextEdit('sexe_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Sexe'],
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
            
            $main_editor = new TextEdit('admin_edit');
            $main_editor->SetMaxLength(30);
            
            $filterBuilder->addColumn(
                $columns['Admin'],
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
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
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
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionsForPage('utilisateur.demande_attestation')->HasViewGrant() && $withDetails)
            {
            //
            // View column for utilisateur_demande_attestation detail
            //
            $column = new DetailColumn(array('ID_Utilis'), 'utilisateur.demande_attestation', 'utilisateur_demande_attestation_handler', $this->dataset, 'Demande Attestation');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('utilisateur.demande_conge')->HasViewGrant() && $withDetails)
            {
            //
            // View column for utilisateur_demande_conge detail
            //
            $column = new DetailColumn(array('ID_Utilis'), 'utilisateur.demande_conge', 'utilisateur_demande_conge_handler', $this->dataset, 'Demande Conge');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('utilisateur.file')->HasViewGrant() && $withDetails)
            {
            //
            // View column for utilisateur_file detail
            //
            $column = new DetailColumn(array('ID_Utilis'), 'utilisateur.file', 'utilisateur_file_handler', $this->dataset, 'File');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('utilisateur.notification')->HasViewGrant() && $withDetails)
            {
            //
            // View column for utilisateur_notification detail
            //
            $column = new DetailColumn(array('ID_Utilis'), 'utilisateur.notification', 'utilisateur_notification_handler', $this->dataset, 'Notification');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('utilisateur.solde')->HasViewGrant() && $withDetails)
            {
            //
            // View column for utilisateur_solde detail
            //
            $column = new DetailColumn(array('ID_Utilis'), 'utilisateur.solde', 'utilisateur_solde_handler', $this->dataset, 'Solde');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('utilisateur.utilisateur')->HasViewGrant() && $withDetails)
            {
            //
            // View column for utilisateur_utilisateur detail
            //
            $column = new DetailColumn(array('ID_Utilis'), 'utilisateur.utilisateur', 'utilisateur_utilisateur_handler', $this->dataset, 'Utilisateur');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for ID_Utilis field
            //
            $column = new NumberViewColumn('ID_Utilis', 'ID_Utilis', 'ID Utilis', $this->dataset);
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
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
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
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for ID_Utilis field
            //
            $column = new NumberViewColumn('ID_Utilis', 'ID_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Nom_Utilis field
            //
            $editor = new TextEdit('nom_utilis_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Utilis', 'Nom_Utilis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for CIN field
            //
            $editor = new TextEdit('cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('CIN', 'CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Phone field
            //
            $editor = new TextEdit('phone_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Phone', 'Phone', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Email field
            //
            $editor = new TextEdit('email_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Email', 'Email', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextAreaEdit('adresse_edit', 50, 8);
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Fonction field
            //
            $editor = new TextAreaEdit('fonction_edit', 50, 8);
            $editColumn = new CustomEditColumn('Fonction', 'Fonction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date_Naiss field
            //
            $editor = new DateTimeEdit('date_naiss_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Naiss', 'Date_Naiss', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Jrs_Total field
            //
            $editor = new TextEdit('jrs_total_edit');
            $editColumn = new CustomEditColumn('Jrs Total', 'Jrs_Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Jrs_Rest field
            //
            $editor = new TextEdit('jrs_rest_edit');
            $editColumn = new CustomEditColumn('Jrs Rest', 'Jrs_Rest', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Password field
            //
            $editor = new TextAreaEdit('password_edit', 50, 8);
            $editColumn = new CustomEditColumn('Password', 'Password', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Username field
            //
            $editor = new TextEdit('username_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Username', 'Username', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ID_Div field
            //
            $editor = new DynamicCombobox('id_div_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'edit_utilisateur_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ID_Serv field
            //
            $editor = new DynamicCombobox('id_serv_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'edit_utilisateur_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Cadre field
            //
            $editor = new DynamicCombobox('cadre_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'edit_utilisateur_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'edit_utilisateur_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextEdit('aujour_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Aujour', 'Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nom_Arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Prenom_Arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'edit_utilisateur_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ChefServ field
            //
            $editor = new TextEdit('chefserv_edit');
            $editColumn = new CustomEditColumn('Chef Serv', 'ChefServ', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for ChefDiv field
            //
            $editor = new TextEdit('chefdiv_edit');
            $editColumn = new CustomEditColumn('Chef Div', 'ChefDiv', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Superviseur_Serv field
            //
            $editor = new DynamicCombobox('superviseur_serv_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'edit_utilisateur_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Sexe field
            //
            $editor = new TextEdit('sexe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sexe', 'Sexe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Admin field
            //
            $editor = new TextEdit('admin_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Admin', 'Admin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Nom_Utilis field
            //
            $editor = new TextEdit('nom_utilis_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Utilis', 'Nom_Utilis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for CIN field
            //
            $editor = new TextEdit('cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('CIN', 'CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Phone field
            //
            $editor = new TextEdit('phone_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Phone', 'Phone', $editor, $this->dataset);
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
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextAreaEdit('adresse_edit', 50, 8);
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Fonction field
            //
            $editor = new TextAreaEdit('fonction_edit', 50, 8);
            $editColumn = new CustomEditColumn('Fonction', 'Fonction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date_Naiss field
            //
            $editor = new DateTimeEdit('date_naiss_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Naiss', 'Date_Naiss', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Jrs_Total field
            //
            $editor = new TextEdit('jrs_total_edit');
            $editColumn = new CustomEditColumn('Jrs Total', 'Jrs_Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Jrs_Rest field
            //
            $editor = new TextEdit('jrs_rest_edit');
            $editColumn = new CustomEditColumn('Jrs Rest', 'Jrs_Rest', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Password field
            //
            $editor = new TextAreaEdit('password_edit', 50, 8);
            $editColumn = new CustomEditColumn('Password', 'Password', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Username field
            //
            $editor = new TextEdit('username_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Username', 'Username', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ID_Div field
            //
            $editor = new DynamicCombobox('id_div_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'multi_edit_utilisateur_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ID_Serv field
            //
            $editor = new DynamicCombobox('id_serv_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'multi_edit_utilisateur_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Cadre field
            //
            $editor = new DynamicCombobox('cadre_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'multi_edit_utilisateur_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'multi_edit_utilisateur_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextEdit('aujour_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Aujour', 'Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Nom_Arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Prenom_Arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_Arabe', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'multi_edit_utilisateur_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ChefServ field
            //
            $editor = new TextEdit('chefserv_edit');
            $editColumn = new CustomEditColumn('Chef Serv', 'ChefServ', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for ChefDiv field
            //
            $editor = new TextEdit('chefdiv_edit');
            $editColumn = new CustomEditColumn('Chef Div', 'ChefDiv', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Superviseur_Serv field
            //
            $editor = new DynamicCombobox('superviseur_serv_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'multi_edit_utilisateur_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Sexe field
            //
            $editor = new TextEdit('sexe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sexe', 'Sexe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Admin field
            //
            $editor = new TextEdit('admin_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Admin', 'Admin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Nom_Utilis field
            //
            $editor = new TextEdit('nom_utilis_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Utilis', 'Nom_Utilis', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Prenom field
            //
            $editor = new TextEdit('prenom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom', 'Prenom', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for CIN field
            //
            $editor = new TextEdit('cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('CIN', 'CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Phone field
            //
            $editor = new TextEdit('phone_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Phone', 'Phone', $editor, $this->dataset);
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
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Adresse field
            //
            $editor = new TextAreaEdit('adresse_edit', 50, 8);
            $editColumn = new CustomEditColumn('Adresse', 'Adresse', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Fonction field
            //
            $editor = new TextAreaEdit('fonction_edit', 50, 8);
            $editColumn = new CustomEditColumn('Fonction', 'Fonction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date_Naiss field
            //
            $editor = new DateTimeEdit('date_naiss_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date Naiss', 'Date_Naiss', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Jrs_Total field
            //
            $editor = new TextEdit('jrs_total_edit');
            $editColumn = new CustomEditColumn('Jrs Total', 'Jrs_Total', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Jrs_Rest field
            //
            $editor = new TextEdit('jrs_rest_edit');
            $editColumn = new CustomEditColumn('Jrs Rest', 'Jrs_Rest', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Password field
            //
            $editor = new TextAreaEdit('password_edit', 50, 8);
            $editColumn = new CustomEditColumn('Password', 'Password', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Username field
            //
            $editor = new TextEdit('username_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Username', 'Username', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ID_Div field
            //
            $editor = new DynamicCombobox('id_div_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'insert_utilisateur_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ID_Serv field
            //
            $editor = new DynamicCombobox('id_serv_edit', $this->CreateLinkBuilder());
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
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'insert_utilisateur_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Cadre field
            //
            $editor = new DynamicCombobox('cadre_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'insert_utilisateur_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'insert_utilisateur_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextEdit('aujour_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Aujour', 'Aujour', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nom_Arabe field
            //
            $editor = new TextEdit('nom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom Arabe', 'Nom_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Prenom_Arabe field
            //
            $editor = new TextEdit('prenom_arabe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prenom Arabe', 'Prenom_Arabe', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'insert_utilisateur_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ChefServ field
            //
            $editor = new TextEdit('chefserv_edit');
            $editColumn = new CustomEditColumn('Chef Serv', 'ChefServ', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for ChefDiv field
            //
            $editor = new TextEdit('chefdiv_edit');
            $editColumn = new CustomEditColumn('Chef Div', 'ChefDiv', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Superviseur_Serv field
            //
            $editor = new DynamicCombobox('superviseur_serv_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'insert_utilisateur_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Sexe field
            //
            $editor = new TextEdit('sexe_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Sexe', 'Sexe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Admin field
            //
            $editor = new TextEdit('admin_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Admin', 'Admin', $editor, $this->dataset);
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
            // View column for ID_Utilis field
            //
            $column = new NumberViewColumn('ID_Utilis', 'ID_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for ID_Utilis field
            //
            $column = new NumberViewColumn('ID_Utilis', 'ID_Utilis', 'ID Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for CIN field
            //
            $column = new TextViewColumn('CIN', 'CIN', 'CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Phone field
            //
            $column = new TextViewColumn('Phone', 'Phone', 'Phone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Email field
            //
            $column = new TextViewColumn('Email', 'Email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Jrs_Total field
            //
            $column = new NumberViewColumn('Jrs_Total', 'Jrs_Total', 'Jrs Total', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Jrs_Rest field
            //
            $column = new NumberViewColumn('Jrs_Rest', 'Jrs_Rest', 'Jrs Rest', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Password field
            //
            $column = new TextViewColumn('Password', 'Password', 'Password', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Username field
            //
            $column = new TextViewColumn('Username', 'Username', 'Username', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Div field
            //
            $column = new TextViewColumn('ID_Div', 'ID_Div_Nom_Div', 'ID Div', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for ChefServ field
            //
            $column = new NumberViewColumn('ChefServ', 'ChefServ', 'Chef Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for ChefDiv field
            //
            $column = new NumberViewColumn('ChefDiv', 'ChefDiv', 'Chef Div', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'Superviseur Serv', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
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
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
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
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
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
            $detailPage = new utilisateur_demande_attestationPage('utilisateur_demande_attestation', $this, array('ID_Utilis'), array('ID_Utilis'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('utilisateur.demande_attestation'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('utilisateur.demande_attestation'));
            $detailPage->SetHttpHandlerName('utilisateur_demande_attestation_handler');
            $handler = new PageHTTPHandler('utilisateur_demande_attestation_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new utilisateur_demande_congePage('utilisateur_demande_conge', $this, array('ID_Utilis'), array('ID_Utilis'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('utilisateur.demande_conge'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('utilisateur.demande_conge'));
            $detailPage->SetHttpHandlerName('utilisateur_demande_conge_handler');
            $handler = new PageHTTPHandler('utilisateur_demande_conge_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new utilisateur_filePage('utilisateur_file', $this, array('ID_Utilis'), array('ID_Utilis'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('utilisateur.file'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('utilisateur.file'));
            $detailPage->SetHttpHandlerName('utilisateur_file_handler');
            $handler = new PageHTTPHandler('utilisateur_file_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new utilisateur_notificationPage('utilisateur_notification', $this, array('ID_Utilis'), array('ID_Utilis'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('utilisateur.notification'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('utilisateur.notification'));
            $detailPage->SetHttpHandlerName('utilisateur_notification_handler');
            $handler = new PageHTTPHandler('utilisateur_notification_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new utilisateur_soldePage('utilisateur_solde', $this, array('ID_Utilis'), array('ID_Utilis'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('utilisateur.solde'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('utilisateur.solde'));
            $detailPage->SetHttpHandlerName('utilisateur_solde_handler');
            $handler = new PageHTTPHandler('utilisateur_solde_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new utilisateur_utilisateurPage('utilisateur_utilisateur', $this, array('Superviseur_Serv'), array('ID_Utilis'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('utilisateur.utilisateur'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('utilisateur.utilisateur'));
            $detailPage->SetHttpHandlerName('utilisateur_utilisateur_handler');
            $handler = new PageHTTPHandler('utilisateur_utilisateur_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_Corps_search', 'ID_Cor', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_utilisateur_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_Corps_search', 'ID_Cor', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_utilisateur_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_Corps_search', 'ID_Cor', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_utilisateur_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`division`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Division', true, true, true),
                    new StringField('Nom_Div', true),
                    new IntegerField('CodeDiv'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`service`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Serv', true, true, true),
                    new StringField('Nom_Serv', true),
                    new IntegerField('ID_Div'),
                    new IntegerField('CodeServ'),
                    new IntegerField('Supervisor'),
                    new StringField('Nom_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
                )
            );
            $lookupDataset->setOrderByField('Libelle', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_Corps_search', 'ID_Cor', 'Libelle', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`utilisateur`');
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_utilisateur_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
        $Page = new utilisateurPage("utilisateur", "utilisateur.php", GetCurrentUserPermissionsForPage("utilisateur"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("utilisateur"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
