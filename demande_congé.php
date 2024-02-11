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
    
    
    
    class demande_congéPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Demandes de congé');
            $this->SetMenuLabel('Demandes de congé');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`demande_congé`');
            $this->dataset->addFields(
                array(
                    new IntegerField('demande_id', true, true, true),
                    new IntegerField('user_id', true),
                    new DateField('Date de demande', true),
                    new DateField('Date de départ', true),
                    new IntegerField('Nombre de jours demandés', true),
                    new DateField('Date de retour', true),
                    new StringField('Type', true),
                    new IntegerField('Autorisation de sortie du territoire national'),
                    new StringField('Demande', true),
                    new StringField('Status', true),
                    new StringField('Cause', true)
                )
            );
            $this->dataset->AddLookupField('Cause', '`gestion_congé_exceptionnelle`', new StringField('Cause'), new StringField('Cause', false, false, false, false, 'Cause_Cause', 'Cause_Cause_gestion_congé_exceptionnelle'), 'Cause_Cause_gestion_congé_exceptionnelle');
        }
    
        protected function DoPrepare() {
            // handling parameters and executing the query
            if (GetApplication()->IsGETValueSet('demandeID') && GetApplication()->IsGETValueSet('status')) {
                $id = GetApplication()->GetGETValue('demandeID');
                $stat = GetApplication()->GetGETValue('status');
                $sql = "UPDATE demande_congé SET `Status`='$stat' WHERE demande_id='$id'";
                $this->GetConnection()->ExecSQL($sql);
                echo json_encode(array("status" => $stat));
                exit;
            }
            
            function addBackslashAfterSingleQuote($inputString) {
                return str_replace("'", "\\'", $inputString);
            }
            
            if (GetApplication()->isGetValueSet('Cause')) {
                $Cause = addBackslashAfterSingleQuote(GetApplication()->GetGETValue('Cause'));
                
                $sql = "SELECT Période FROM gestion_congé_exceptionnelle WHERE Cause = '$Cause'";
                $queryResult = $this->GetConnection()->ExecScalarSQL($sql);
            
                if (!empty($queryResult)) {
                    $result = array(
                        'nbr_jours' => $queryResult
                    );
            
                    echo json_encode($result);
                    exit;
                } else {
                    $result = array(
                    );
            
                    echo json_encode($result);
                    exit;
                  }
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
                new FilterColumn($this->dataset, 'user_id', 'user_id', 'User Id'),
                new FilterColumn($this->dataset, 'demande_id', 'demande_id', 'Demande Id'),
                new FilterColumn($this->dataset, 'Date de demande', 'Date de demande', 'Date De Demande'),
                new FilterColumn($this->dataset, 'Date de départ', 'Date de départ', 'Date De Départ'),
                new FilterColumn($this->dataset, 'Type', 'Type', 'Type'),
                new FilterColumn($this->dataset, 'Cause', 'Cause_Cause', 'Cause'),
                new FilterColumn($this->dataset, 'Nombre de jours demandés', 'Nombre de jours demandés', 'Nombre De Jours Demandés'),
                new FilterColumn($this->dataset, 'Date de retour', 'Date de retour', 'Date De Retour'),
                new FilterColumn($this->dataset, 'Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National'),
                new FilterColumn($this->dataset, 'Demande', 'Demande', 'Demande'),
                new FilterColumn($this->dataset, 'Status', 'Status', 'Status')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['demande_id'])
                ->addColumn($columns['Date de demande'])
                ->addColumn($columns['Date de départ'])
                ->addColumn($columns['Type'])
                ->addColumn($columns['Cause'])
                ->addColumn($columns['Nombre de jours demandés'])
                ->addColumn($columns['Date de retour'])
                ->addColumn($columns['Autorisation de sortie du territoire national'])
                ->addColumn($columns['Demande'])
                ->addColumn($columns['Status']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Date de demande')
                ->setOptionsFor('Date de départ')
                ->setOptionsFor('Date de retour');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
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
            
            $main_editor = new DateTimeEdit('date_de_départ_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Date de départ'],
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
            
            $main_editor = new ComboBox('Type');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice('Annuelle', 'Annuelle');
            $main_editor->addChoice('Exceptionnelle', 'Exceptionnelle');
            
            $multi_value_select_editor = new MultiValueSelect('Type');
            $multi_value_select_editor->setChoices($main_editor->getChoices());
            
            $text_editor = new TextEdit('Type');
            
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
            
            $main_editor = new DynamicCombobox('cause_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_demande_congé_Cause_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Cause', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_demande_congé_Cause_search');
            
            $text_editor = new TextEdit('Cause');
            
            $filterBuilder->addColumn(
                $columns['Cause'],
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
            
            $main_editor = new TextEdit('nombre_de_jours_demandés_edit');
            
            $filterBuilder->addColumn(
                $columns['Nombre de jours demandés'],
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
            
            $main_editor = new DateTimeEdit('date_de_retour_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['Date de retour'],
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
            
            $main_editor = new ComboBox('Autorisation de sortie du territoire national');
            $main_editor->SetAllowNullValue(false);
            $main_editor->addChoice(true, $this->GetLocalizerCaptions()->GetMessageString('True'));
            $main_editor->addChoice(false, $this->GetLocalizerCaptions()->GetMessageString('False'));
            
            $filterBuilder->addColumn(
                $columns['Autorisation de sortie du territoire national'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
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
            
            $main_editor = new TextEdit('Status');
            
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
            // View column for Date de départ field
            //
            $column = new DateTimeViewColumn('Date de départ', 'Date de départ', 'Date De Départ', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nombre de jours demandés field
            //
            $column = new NumberViewColumn('Nombre de jours demandés', 'Nombre de jours demandés', 'Nombre De Jours Demandés', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date de retour field
            //
            $column = new DateTimeViewColumn('Date de retour', 'Date de retour', 'Date De Retour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
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
            $column->setInlineStyles('if (Status == \'En cours\') { background: red; }');
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
            // View column for Date de départ field
            //
            $column = new DateTimeViewColumn('Date de départ', 'Date de départ', 'Date De Départ', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Cause field
            //
            $column = new TextViewColumn('Cause', 'Cause_Cause', 'Cause', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nombre de jours demandés field
            //
            $column = new NumberViewColumn('Nombre de jours demandés', 'Nombre de jours demandés', 'Nombre De Jours Demandés', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date de retour field
            //
            $column = new DateTimeViewColumn('Date de retour', 'Date de retour', 'Date De Retour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
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
            $column->setInlineStyles('if (Status == \'En cours\') { background: red; }');
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
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de départ field
            //
            $editor = new DateTimeEdit('date_de_départ_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Départ', 'Date de départ', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Type field
            //
            $editor = new RadioEdit('type_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('Annuelle', 'Annuelle');
            $editor->addChoice('Exceptionnelle', 'Exceptionnelle');
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Cause field
            //
            $editor = new DynamicCombobox('cause_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`gestion_congé_exceptionnelle`');
            $lookupDataset->addFields(
                array(
                    new StringField('Cause', true),
                    new IntegerField('Période')
                )
            );
            $lookupDataset->setOrderByField('Cause', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cause', 'Cause', 'Cause_Cause', 'edit_demande_congé_Cause_search', $editor, $this->dataset, $lookupDataset, 'Cause', 'Cause', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nombre de jours demandés field
            //
            $editor = new TextEdit('nombre_de_jours_demandés_edit');
            $editColumn = new CustomEditColumn('Nombre De Jours Demandés', 'Nombre de jours demandés', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de retour field
            //
            $editor = new DateTimeEdit('date_de_retour_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Retour', 'Date de retour', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Autorisation de sortie du territoire national field
            //
            $editor = new CheckBox('autorisation_de_sortie_du_territoire_national_edit');
            $editColumn = new CustomEditColumn('Autorisation De Sortie Du Territoire National', 'Autorisation de sortie du territoire national', $editor, $this->dataset);
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
            $editor = new TextAreaEdit('status_edit', 50, 8);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
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
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de départ field
            //
            $editor = new DateTimeEdit('date_de_départ_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Départ', 'Date de départ', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Type field
            //
            $editor = new RadioEdit('type_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('Annuelle', 'Annuelle');
            $editor->addChoice('Exceptionnelle', 'Exceptionnelle');
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Cause field
            //
            $editor = new DynamicCombobox('cause_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`gestion_congé_exceptionnelle`');
            $lookupDataset->addFields(
                array(
                    new StringField('Cause', true),
                    new IntegerField('Période')
                )
            );
            $lookupDataset->setOrderByField('Cause', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cause', 'Cause', 'Cause_Cause', 'multi_edit_demande_congé_Cause_search', $editor, $this->dataset, $lookupDataset, 'Cause', 'Cause', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Nombre de jours demandés field
            //
            $editor = new TextEdit('nombre_de_jours_demandés_edit');
            $editColumn = new CustomEditColumn('Nombre De Jours Demandés', 'Nombre de jours demandés', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de retour field
            //
            $editor = new DateTimeEdit('date_de_retour_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Retour', 'Date de retour', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Autorisation de sortie du territoire national field
            //
            $editor = new CheckBox('autorisation_de_sortie_du_territoire_national_edit');
            $editColumn = new CustomEditColumn('Autorisation De Sortie Du Territoire National', 'Autorisation de sortie du territoire national', $editor, $this->dataset);
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
            $editor = new TextAreaEdit('status_edit', 50, 8);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_ID%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for demande_id field
            //
            $editor = new TextEdit('demande_id_edit');
            $editColumn = new CustomEditColumn('Demande Id', 'demande_id', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de demande field
            //
            $editor = new DateTimeEdit('date_de_demande_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Demande', 'Date de demande', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de départ field
            //
            $editor = new DateTimeEdit('date_de_départ_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Départ', 'Date de départ', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Type field
            //
            $editor = new RadioEdit('type_edit');
            $editor->SetDisplayMode(RadioEdit::InlineMode);
            $editor->addChoice('Annuelle', 'Annuelle');
            $editor->addChoice('Exceptionnelle', 'Exceptionnelle');
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Cause field
            //
            $editor = new DynamicCombobox('cause_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`gestion_congé_exceptionnelle`');
            $lookupDataset->addFields(
                array(
                    new StringField('Cause', true),
                    new IntegerField('Période')
                )
            );
            $lookupDataset->setOrderByField('Cause', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cause', 'Cause', 'Cause_Cause', 'insert_demande_congé_Cause_search', $editor, $this->dataset, $lookupDataset, 'Cause', 'Cause', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nombre de jours demandés field
            //
            $editor = new TextEdit('nombre_de_jours_demandés_edit');
            $editColumn = new CustomEditColumn('Nombre De Jours Demandés', 'Nombre de jours demandés', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de retour field
            //
            $editor = new DateTimeEdit('date_de_retour_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Date De Retour', 'Date de retour', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Autorisation de sortie du territoire national field
            //
            $editor = new CheckBox('autorisation_de_sortie_du_territoire_national_edit');
            $editColumn = new CustomEditColumn('Autorisation De Sortie Du Territoire National', 'Autorisation de sortie du territoire national', $editor, $this->dataset);
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
            $editor = new TextAreaEdit('status_edit', 50, 8);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $editColumn->SetReadOnly(true);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('En cours');
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
            // View column for Date de départ field
            //
            $column = new DateTimeViewColumn('Date de départ', 'Date de départ', 'Date De Départ', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Cause field
            //
            $column = new TextViewColumn('Cause', 'Cause_Cause', 'Cause', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nombre de jours demandés field
            //
            $column = new NumberViewColumn('Nombre de jours demandés', 'Nombre de jours demandés', 'Nombre De Jours Demandés', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date de retour field
            //
            $column = new DateTimeViewColumn('Date de retour', 'Date de retour', 'Date De Retour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
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
            $column->setInlineStyles('if (Status == \'En cours\') { background: red; }');
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
            // View column for Date de départ field
            //
            $column = new DateTimeViewColumn('Date de départ', 'Date de départ', 'Date De Départ', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Cause field
            //
            $column = new TextViewColumn('Cause', 'Cause_Cause', 'Cause', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nombre de jours demandés field
            //
            $column = new NumberViewColumn('Nombre de jours demandés', 'Nombre de jours demandés', 'Nombre De Jours Demandés', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Date de retour field
            //
            $column = new DateTimeViewColumn('Date de retour', 'Date de retour', 'Date De Retour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
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
            $column->setInlineStyles('if (Status == \'En cours\') { background: red; }');
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for user_id field
            //
            $column = new NumberViewColumn('user_id', 'user_id', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for demande_id field
            //
            $column = new NumberViewColumn('demande_id', 'demande_id', 'Demande Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date de demande field
            //
            $column = new DateTimeViewColumn('Date de demande', 'Date de demande', 'Date De Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date de départ field
            //
            $column = new DateTimeViewColumn('Date de départ', 'Date de départ', 'Date De Départ', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Cause field
            //
            $column = new TextViewColumn('Cause', 'Cause_Cause', 'Cause', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nombre de jours demandés field
            //
            $column = new NumberViewColumn('Nombre de jours demandés', 'Nombre de jours demandés', 'Nombre De Jours Demandés', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date de retour field
            //
            $column = new DateTimeViewColumn('Date de retour', 'Date de retour', 'Date De Retour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
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
            $column->setInlineStyles('if (Status == \'En cours\') { background: red; }');
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
            return 'var url = "SoldeCongé.php";'. "\n" .
            ''. "\n" .
            'var requestData = {'. "\n" .
            '    userID: parseInt($("#notification").attr("data-user_id"))'. "\n" .
            '};'. "\n" .
            ''. "\n" .
            '$.ajax({'. "\n" .
            '           url: url,'. "\n" .
            '           dataType: \'json\','. "\n" .
            '           data: requestData,'. "\n" .
            '           async: false,'. "\n" .
            '           success: function(dataResult) {'. "\n" .
            '               var infos = dataResult;'. "\n" .
            '               infos.forEach(info => {'. "\n" .
            '                   Solde = parseInt(info.Solde);'. "\n" .
            '               });'. "\n" .
            '               if (Solde == 0) {'. "\n" .
            '                  $(\'#notification\').modal(\'show\');'. "\n" .
            '               } else { $(\'#notification\').modal(\'hide\');}'. "\n" .
            '           }'. "\n" .
            '});'. "\n" .
            ''. "\n" .
            'function prepareInlineButtons() {'. "\n" .
            '    $(\'button.inline-button\').click(function() {'. "\n" .
            '        var button = $(this);'. "\n" .
            '        var changetext = button.siblings(\'td[data-column-name="Demande"]\');'. "\n" .
            '        var demandeId = button.data(\'demande_id\');'. "\n" .
            '        var newstatus = \'\';'. "\n" .
            '        '. "\n" .
            '        if (button.hasClass(\'annuler-button\')) {'. "\n" .
            '            newstatus = \'Annulée\'; '. "\n" .
            '        }'. "\n" .
            '        '. "\n" .
            '        if (newstatus !== \'\') {'. "\n" .
            '            $.getJSON('. "\n" .
            '                location.href,'. "\n" .
            '                {'. "\n" .
            '                    demandeID: demandeId,'. "\n" .
            '                    status: newstatus'. "\n" .
            '                },'. "\n" .
            '                function (dataFromServer) {'. "\n" .
            '                    button.data(\'status\', dataFromServer.status);'. "\n" .
            '                    if (dataFromServer.status === newstatus) {'. "\n" .
            '                        changetext.text(newstatus);'. "\n" .
            '                    }'. "\n" .
            '                    location.reload();  '. "\n" .
            '                }'. "\n" .
            '            );'. "\n" .
            '        }'. "\n" .
            '    });'. "\n" .
            '}'. "\n" .
            ''. "\n" .
            ''. "\n" .
            'prepareInlineButtons();'. "\n" .
            ''. "\n" .
            'var requestData_4 = {'. "\n" .
            '    userID: parseInt($("#notification_4").attr("data-user_id"))'. "\n" .
            '};'. "\n" .
            ''. "\n" .
            'if (requestData.userID !== null) {'. "\n" .
            '    $.ajax({'. "\n" .
            '        url: url,'. "\n" .
            '        dataType: \'json\','. "\n" .
            '        data: requestData,'. "\n" .
            '        async: false,'. "\n" .
            '        success: function(dataResult) {'. "\n" .
            '            var infos = dataResult;'. "\n" .
            '            infos.forEach(info => {'. "\n" .
            '                var SoldeCongé = parseInt(info.Solde);'. "\n" .
            '                if (isNaN(SoldeCongé)) {'. "\n" .
            '                    $(\'#notification_4\').modal(\'show\');'. "\n" .
            '                } else {'. "\n" .
            '                    $(\'#notification_4\').modal(\'hide\');'. "\n" .
            '                }'. "\n" .
            '            });'. "\n" .
            '        }'. "\n" .
            '    });'. "\n" .
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
            $result->SetTotal('Nombre de jours demandés', PredefinedAggregate::$Sum);
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
            $grid->SetInsertClientValidationScript('/*require([\'moment\'], function(moment) {
            dateDepart = moment(fieldValues[\'Date de départ\'], \'DD-MM-YYYY\');
            dateDemande = moment(fieldValues[\'Date de demande\'], \'DD-MM-YYYY\');
            if (parseInt(dateDepart.month()) < parseInt(dateDemande.month())) {
               console.log(parseInt(dateDepart.month()));
               errorInfo.SetMessage(\'Date de départ doit être après la date de demande\');
               return false;
            } else if (parseInt(dateDepart.month()) === parseInt(dateDemande.month()) && parseInt(dateDepart.date()) < parseInt(dateDemande.date())) {
                      console.log(parseInt(dateDepart.date()));
                      errorInfo.SetMessage(\'Date de départ doit être après la date de demande\');
                      return false;
            }
            })*/');
            
            $grid->SetEditClientValidationScript('/*require([\'moment\'], function(moment) {
            dateDepart = moment(fieldValues[\'Date de départ\'], \'DD-MM-YYYY\');
            dateDemande = moment(fieldValues[\'Date de demande\'], \'DD-MM-YYYY\');
            if (parseInt(dateDepart.month()) < parseInt(dateDemande.month())) {
               console.log(parseInt(dateDepart.month()));
               errorInfo.SetMessage(\'Date de départ doit être après la date de demande\');
               return false;
            } else if (parseInt(dateDepart.month()) === parseInt(dateDemande.month()) && parseInt(dateDepart.date()) < parseInt(dateDemande.date())) {
                      console.log(parseInt(dateDepart.date()));
                      errorInfo.SetMessage(\'Date de départ doit être après la date de demande\');
                      return false;
            }
            })*/');
            
            $grid->SetInsertClientEditorValueChangedScript('if (sender.getFieldName() === \'Date de départ\') {
                if (sender.getValue()) {
                    require([\'moment\'], function(moment) {
                        var DateNonValide = false;
                        if (moment(editors[\'Date de départ\'].getValue(), \'DD-MM-YYYY\') >= moment(editors[\'Date de demande\'].getValue(), \'DD-MM-YYYY\')) {
                            DateNonValide = false;
                        } else {
                            DateNonValide = true;
                        }
                        
                        editors[\'Date de départ\']
                            .setState(DateNonValide ? \'warning\' : \'success\')
                            .setHint(DateNonValide ? \'La date de départ doit être après la date de demande\' : null);
                    });
                } else {
                    editors[\'Date de départ\']
                        .setState(\'normal\')
                        .setHint(null);
                }
            }
            
            if (sender.getFieldName() === \'Nombre de jours demandés\') {
                if (sender.getValue()) {
                    var url_php = "SoldeCongé.php";
                    var dataRequest = {
                         userID: parseInt(editors[\'user_id\'].getValue())
                    };
                    $.ajax({
                        url: url_php,
                        type: \'POST\',
                        dataType: \'json\',
                        data: dataRequest,
                        async: false,
                        success: function(dataResult) {
                            var infos = dataResult;
                            var NombreJoursNonValide = false;
                            infos.forEach(info => {
                                if (parseInt(info.Solde) - parseInt(sender.getValue()) < 0) {
                                    NombreJoursNonValide = true;
                                }
                            });
                            editors[\'Nombre de jours demandés\']
                                .setState(NombreJoursNonValide ? \'warning\' : \'success\')
                                .setHint(NombreJoursNonValide ? \'Vous avez atteint le nombre maximum de jours de congés alloués pour cette année\' : null);
                        }
                    });
                } else {
                    editors[\'Nombre de jours demandés\']
                        .setState(\'normal\')
                        .setHint(null);
                }
            }
            
            if (sender.getFieldName() === \'Type\') {
                var isExcep = editors.Type.getValue() === \'Exceptionnelle\';
                editors.Cause.setVisible(isExcep).setRequired(isExcep);
            }
            
            if (sender.getFieldName() === \'Cause\') {
              var cause = sender.getValue();
              $.getJSON(
                location.href, 
                {
                  Cause: cause
                }, 
                function (data) {
                  if (\'nbr_jours\' in data) {
                    editors[\'Nombre de jours demandés\'].setValue(parseInt(data.nbr_jours)).setReadonly(true);
                  } else {
                    editors[\'Nombre de jours demandés\'].setValue(\'\');
                  }
                }
              );
            }
            
            /*if (sender.getFieldName() === \'Type\') {
                var dataRequest = {
                    userID: parseInt(editors[\'user_id\'].getValue())
                };
                $.ajax({
                    url: "SoldeCongé.php", 
                    type: \'POST\',
                    dataType: \'json\',
                    data: dataRequest,
                    async: false,
                    success: function(dataResult) {
                        var infos = dataResult;
                            infos.forEach(info => {
                                if (parseInt(info.Solde) === 0) { 
                                    editors[\'Type\'].removeItem(\'Annuelle\', \'Annuelle\');
                                    editors[\'Type\'].setValue("Exceptionnelle");
                                }
                            });
                        }
                    });
            }*/
            
            
            if (sender.getFieldName() == \'Type\') {
                var type = sender.getValue();
                if (type === \'Annuelle\') {
                    editors[\'Nombre de jours demandés\'].setData(null).setEnabled(true);
                }
            }');
            
            $grid->SetEditClientEditorValueChangedScript('if (sender.getFieldName() === \'Date de départ\') {
                if (sender.getValue()) {
                    require([\'moment\'], function(moment) {
                        var DateNonValide = false;
                        if (moment(editors[\'Date de départ\'].getValue(), \'DD-MM-YYYY\') >= moment(editors[\'Date de demande\'].getValue(), \'DD-MM-YYYY\')) {
                            DateNonValide = false;
                        } else {
                            DateNonValide = true;
                        }
                        
                        editors[\'Date de départ\']
                            .setState(DateNonValide ? \'warning\' : \'success\')
                            .setHint(DateNonValide ? \'La date de départ doit être après la date de demande\' : null);
                    });
                } else {
                    editors[\'Date de départ\']
                        .setState(\'normal\')
                        .setHint(null);
                }
            }
            
            if (sender.getFieldName() === \'Nombre de jours demandés\') {
                if (sender.getValue()) {
                    var url_php = "SoldeCongé.php";
                    var dataRequest = {
                         userID: parseInt(editors[\'user_id\'].getValue())
                    };
                    $.ajax({
                        url: url_php,
                        type: \'POST\',
                        dataType: \'json\',
                        data: dataRequest,
                        async: false,
                        success: function(dataResult) {
                            var infos = dataResult;
                            var NombreJoursNonValide = false;
                            infos.forEach(info => {
                                if (parseInt(info.Solde) - parseInt(sender.getValue()) < 0) {
                                    NombreJoursNonValide = true;
                                }
                            });
                            editors[\'Nombre de jours demandés\']
                                .setState(NombreJoursNonValide ? \'warning\' : \'success\')
                                .setHint(NombreJoursNonValide ? \'Vous avez atteint le nombre maximum de jours de congés alloués pour cette année\' : null);
                        }
                    });
                } else {
                    editors[\'Nombre de jours demandés\']
                        .setState(\'normal\')
                        .setHint(null);
                }
            }
            
            if (sender.getFieldName() === \'Type\') {
                var isExcep = editors.Type.getValue() === \'Exceptionnelle\';
                editors.Cause.setVisible(isExcep).setRequired(isExcep);
            }');
            
            $grid->SetInsertClientFormLoadedScript('function checkDate() {
                if (editors[\'Date de départ\'].getValue()) {
                    require([\'moment\'], function(moment) {
                        var DateNonValide = false;
                        if (moment(editors[\'Date de départ\'].getValue(), \'DD-MM-YYYY\') >= moment(editors[\'Date de demande\'].getValue(), \'DD-MM-YYYY\')) {
                            DateNonValide = false;
                        } else {
                            DateNonValide = true;
                        }
                        editors[\'Date de départ\']
                            .setState(DateNonValide ? \'warning\' : \'success\')
                            .setHint(DateNonValide ? \'Date de départ doit être après la date de demande\' : null);
                    });
                }
            }
            
            editors[\'Date de départ\'].getRootElement().one(\'focusout\', checkDate);
            
            function checkNombreJours() {
                if (editors[\'Nombre de jours demandés\'].getValue()) {
                    var url_php = "SoldeCongé.php";
                    var dataRequest = {
                         userID: parseInt(editors[\'user_id\'].getValue())
                    };
                    $.ajax({
                        url: url_php,
                        type: \'POST\',
                        dataType: \'json\',
                        data: dataRequest,
                        async: false,
                        success: function(dataResult) {
                            var infos = dataResult;
                            var NombreJoursNonValide = false;
                            infos.forEach(info => {
                                if (parseInt(info.Solde) - parseInt(editors[\'Nombre de jours demandés\'].getValue()) < 0) {
                                    NombreJoursNonValide = true;
                                }
                            });
                            editors[\'Nombre de jours demandés\']
                                .setState(NombreJoursNonValide ? \'warning\' : \'success\')
                                .setHint(NombreJoursNonValide ? \'Vous avez atteint le nombre maximum de jours de congés alloués pour cette année\' : null);
                        }
                    });
                }
            }
            
            editors[\'Nombre de jours demandés\'].getRootElement().on(\'focusout\', checkNombreJours);
            
            
            var dataRequest = {
                 userID: parseInt(editors[\'user_id\'].getValue())
            };
            $.ajax({
                url: "SoldeCongé.php", 
                type: \'POST\',
                dataType: \'json\',
                data: dataRequest,
                async: false,
                success: function(dataResult) {
                     var infos = dataResult;
                          infos.forEach(info => {
                               if (parseInt(info.Solde) === 0) { 
                                   editors.Type.removeItem("Annuelle", "Annuelle");
                               }
                          });
                     }
                });
            
            
            var isExcep = editors.Type.getValue() === \'Exceptionnelle\';
            editors.Cause.setVisible(isExcep).setRequired(isExcep);');
            
            $grid->SetEditClientFormLoadedScript('function checkDate() {
                if (editors[\'Date de départ\'].getValue()) {
                    require([\'moment\'], function(moment) {
                        var DateNonValide = false;
                        if (moment(editors[\'Date de départ\'].getValue(), \'DD-MM-YYYY\') >= moment(editors[\'Date de demande\'].getValue(), \'DD-MM-YYYY\')) {
                            DateNonValide = false;
                        } else {
                            DateNonValide = true;
                        }
                        editors[\'Date de départ\']
                            .setState(DateNonValide ? \'warning\' : \'success\')
                            .setHint(DateNonValide ? \'Date de départ doit être après la date de demande\' : null);
                    });
                }
            }
            
            editors[\'Date de départ\'].getRootElement().one(\'focusout\', checkDate);
            
            function checkNombreJours() {
                if (editors[\'Nombre de jours demandés\'].getValue()) {
                    var url_php = "SoldeCongé.php";
                    var dataRequest = {
                         userID: parseInt(editors[\'user_id\'].getValue())
                    };
                    $.ajax({
                        url: url_php,
                        type: \'POST\',
                        dataType: \'json\',
                        data: dataRequest,
                        async: false,
                        success: function(dataResult) {
                            var infos = dataResult;
                            var NombreJoursNonValide = false;
                            infos.forEach(info => {
                                if (parseInt(info.Solde) - parseInt(editors[\'Nombre de jours demandés\'].getValue()) < 0) {
                                    NombreJoursNonValide = true;
                                }
                            });
                            editors[\'Nombre de jours demandés\']
                                .setState(NombreJoursNonValide ? \'warning\' : \'success\')
                                .setHint(NombreJoursNonValide ? \'Vous avez atteint le nombre maximum de jours de congés alloués pour cette année\' : null);
                        }
                    });
                }
            }
            
            editors[\'Nombre de jours demandés\'].getRootElement().on(\'focusout\', checkNombreJours);
            
            var isExcep = editors.Type.getValue() === \'Exceptionnelle\';
            editors.Cause.setVisible(isExcep).setRequired(isExcep);');
            
            $grid->setCalculateControlValuesScript('if (editors[\'Date de départ\'].getValue()) {
              require([\'moment\'], function(moment) {
                var dateDepart = moment(editors[\'Date de départ\'].getValue(), \'DD-MM-YYYY\');
                var nombreJoursDemandes = parseInt(editors[\'Nombre de jours demandés\'].getValue());
            
                var dateRetour = moment(dateDepart, \'DD-MM-YYYY\');
                
                var url = \'j_fériés.php\';
            
                var requestData = {
                    start_date: dateDepart.format(\'DD-MM-YYYY\')
                };
                
                $.ajax({
                    url: url,
                    type: \'POST\',
                    data: requestData,
                    dataType: \'json\',
                    async: false,
                    success: function(dataResult) {
                        var holidays = dataResult;
                        var i = 1;
                        while (i <= nombreJoursDemandes) {
                            if (dateRetour.isoWeekday() !== 6 && dateRetour.isoWeekday() !== 7) { 
                                var isHoliday = false;
                                holidays.forEach(holiday => {
                                    if (dateRetour.isSame(moment(holiday.Date_depart, \'DD-MM-YYYY\'), \'day\')) {
                                        for (var j = 0; j < parseInt(holiday.nombres_jours); j++) {
                                            dateRetour.add(1, \'days\');
                                        }
                                        isHoliday = true;
                                    }
                                });
                                if (!isHoliday) {
                                    dateRetour.add(1, \'days\');
                                    i++; 
                                }
                            } else {
                                dateRetour.add(1, \'days\');
                            }
                        }
                        while (dateRetour.isoWeekday() === 6 || dateRetour.isoWeekday() === 7) {
                            dateRetour.add(1, \'days\');
                        }
                        
                        holidays.forEach(holiday => {
                            if (dateRetour.isSame(moment(holiday.Date_depart, \'DD-MM-YYYY\'), \'day\')) {
                                for (var j = 0; j < parseInt(holiday.nombres_jours); j++) {
                                    dateRetour.add(1, \'days\');
                                }
                            }
                        });
                        
                        editors[\'Date de retour\'].setValue(dateRetour.format(\'DD-MM-YYYY\'));
                    }
                });
              });
            }');
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`gestion_congé_exceptionnelle`');
            $lookupDataset->addFields(
                array(
                    new StringField('Cause', true),
                    new IntegerField('Période')
                )
            );
            $lookupDataset->setOrderByField('Cause', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_demande_congé_Cause_search', 'Cause', 'Cause', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`gestion_congé_exceptionnelle`');
            $lookupDataset->addFields(
                array(
                    new StringField('Cause', true),
                    new IntegerField('Période')
                )
            );
            $lookupDataset->setOrderByField('Cause', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_demande_congé_Cause_search', 'Cause', 'Cause', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`gestion_congé_exceptionnelle`');
            $lookupDataset->addFields(
                array(
                    new StringField('Cause', true),
                    new IntegerField('Période')
                )
            );
            $lookupDataset->setOrderByField('Cause', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_demande_congé_Cause_search', 'Cause', 'Cause', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`gestion_congé_exceptionnelle`');
            $lookupDataset->addFields(
                array(
                    new StringField('Cause', true),
                    new IntegerField('Période')
                )
            );
            $lookupDataset->setOrderByField('Cause', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_demande_congé_Cause_search', 'Cause', 'Cause', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
            $command_sql = sprintf('SELECT ' .
                                   'CASE WHEN Direction = "" THEN 0 ELSE 1 END + ' .
                                   'CASE WHEN Division = "" THEN 0 ELSE 1 END + ' .
                                   'CASE WHEN Service = "" THEN 0 ELSE 1 END AS non_empty_columns_count ' .
                           'FROM fonctionnairesv3 WHERE `Numéro` = %d', $rowData['user_id']);
            $result = $this->GetConnection()->fetchAll($command_sql);
            $N = $result[0]['non_empty_columns_count'] + 1;
            $command_sql_2 = sprintf('SELECT `Validée par Chef Service`, `Validée par Chef Division`, `Validée par Directeur`, `Validée par Admin` FROM `demande_validée` WHERE `user_id` = %d', $rowData['user_id']);
            $result_2 = $this->GetConnection()->fetchAll($command_sql_2);
            if (!empty($result_2)) {
                $row_2 = $result_2[0];
                $isSeen = [];
                if ($row_2['Validée par Chef Service'] != null) {
                    $isSeen[] = 'Validée par Chef Service';
                }
                if ($row_2['Validée par Chef Division'] != null) {
                    $isSeen[] = 'Validée par Chef Division';
                }
                if ($row_2['Validée par Directeur'] != null) {
                    $isSeen[] = 'Validée par Directeur';
                }
                if ($row_2['Validée par Admin'] != null) {
                    $isSeen[] = 'Validée par Admin';
                }
                if ($fieldName === 'Status') {
                    switch ($fieldData) {
                        case 'En cours':
                            $customText = '<span class="status-cell yellow">' . $fieldData . '</span>';
                            $j = count($isSeen);
                            for ($i = 0; $i < $N; $i++) {
                                if ($i < $j) {
                                   $decision = $row_2[$isSeen[$i]];
                                   if ($decision == 1) {
                                      $customText .= '<span class="pg-row-checkbox checked"></span>';
                                   } else {
                                     $customText .= '<span class="pg-row-checkbox"></span>';
                                   }
                                   continue;
                                }
                                $customText .= '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>';
                            }
                            break;
                        case 'Accéptée':
                            $customText = '<span class="status-cell green">' . $fieldData . '</span>';
                            break;
                        case 'Rejetée':
                            $customText = '<span class="status-cell red">' . $fieldData . '</span>';
                            break;
                        case 'Annulée':
                            $customText = '<span class="status-cell red">' . $fieldData . '</span>';
                            break;
                        default:
                            break;
                    }
            
                    $handled = true;
                }
            }
                
            if ($fieldName == 'Demande') {
                $dataAttributes = sprintf('data-demande_id="%s"', $rowData['demande_id']);
                $customText .= '<button class="btn btn-default inline-button" ' . 
                    $dataAttributes . ' style="align-text: center;" onclick="handleDownloadAttestationConge(this)">Télécharger la demande</button>';
                switch ($rowData['Status']) {
                       case 'Accéptée':
                            if ($rowData['Date de départ'] > date('Y-m-d')) {
                                $customText .= '<button class="btn btn-default inline-button annuler-button" ' . 
                                    $dataAttributes . ' style="align-text: center; margin-left: 15px;" onclick="">Annuler la demande</button>';
                            }
                            break;
                       case 'En cours':
                            if ($rowData['Date de départ'] > date('Y-m-d')) {
                                $customText .= '<button class="btn btn-default inline-button annuler-button" ' . 
                                    $dataAttributes . ' style="align-text: center; margin-left: 15px;" onclick="">Annuler la demande</button>';
                            }   
                            break;
                       default:
                            break;
                }
                
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
            if ($columnName == 'Nombre de jours demandés') {
                $userID = $this->GetCurrentUserId();
                $sql = "SELECT `Solde de Congé` FROM `fonctionnairesv3` WHERE `Numéro` = '$userID'";
                $Solde = $this->GetConnection()->ExecScalarSQL($sql);
                if (intval($Solde) === 1) {
                   $JourText = ' jour';
                } else {
                  $JourText = ' jours';
                }
                
                if ($Solde === null) {
                   $SoldeText = "NULL";
                } else {
                  $SoldeText = $Solde . $JourText;
                }
                $customText = '<strong class="total-cell">Votre Solde de Congé: <br>' . $SoldeText . '</strong>';
            
            
                if ($Solde <= 44 && $Solde >= 6) {
                    $bgColor = "green";
                } elseif ($Solde == 0 || $Solde == null) {
                    $bgColor = 'red';
                } elseif ($Solde <= 5 && $Solde > 0) {
                    $bgColor = 'orange'; 
                }
            
                $customText .= '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        var childElement = document.querySelector(".total-cell");
                        var parentElement = childElement.parentNode;
            
                        parentElement.style.backgroundColor = "' . $bgColor . '";
                        if ("' . $bgColor . '" === "orange") {
                           parentElement.style.color = "#34495E";
                        } else {
                          parentElement.style.color = "white";
                          }
                          
                        var Solde = parseInt("' . $Solde . '");
                        if (Solde == 0) {
                           $("#notification").modal("show");
                        } else {
                          $("#notification").modal("hide");
                          }
                    });
                </script>';
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
             $message = 'Record processed successfully.';
            }
            /*else {
             $message = '<p>Something wrong happened. ' .
             '<a class="alert-link" href="mailto:admin@example.com">' .
             'Contact developers</a> for more info.</p>';
            }*/
            $messageDisplayTime = 2;
            
            if ($success) {
             $userId = $page->GetCurrentUserId();
             $currentDateTime = SMDateTime::Now();
             $sql =
             "INSERT INTO activity_log (table_name, action, user_id, log_time) " .
             "VALUES ('$tableName', 'INSERT', $userId, '$currentDateTime');";
             $page->GetConnection()->ExecSQL(sprintf($sql, $userId, $currentDateTime));
            }
            
            $temoin = true;
            $j = 1;
            if ($success) {
               $sql_3 = "SELECT column_name FROM information_schema.columns WHERE table_name = 'demande_congé_map'";
               $result = $page->GetConnection()->fetchALL($sql_3);
               if (!empty($result)) {
                  $N = count($result);
                  $sql_4 = "INSERT INTO demande_congé_map (";
                  foreach ($result as $row) {
                          if ($j != $N) {
                             $sql_4 = $sql_4 . "`" . $row['column_name'] . "`" . ", ";
                             $j++;
                          } else {
                             $sql_4 = $sql_4 . "`" . $row['column_name'] . "`" . ")";
                          }
                  }
                  for ($i = 0; $i < $N; $i++) {
                      if ($i == 0) {
                             $sql_4 = $sql_4 . " VALUES (" . $rowData['user_id'] . ", ";
                      } elseif ($i == 1) {
                         $sql_4 = $sql_4 . $rowData['demande_id'] . ", ";
                      } else {
                        if ($i != $N - 1) {
                             $sql_4 = $sql_4 . "'En cours', ";
                        } else {
                          $sql_4 = $sql_4 . "'En cours')";
                        };
                      }
                  }
                  $page->GetConnection()->ExecSQL($sql_4);
               }
            }
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
            if ($success) {
             // Check if record data was modified
             $dataMofified =
             $oldRowData['Date de demande'] !== $rowData['Date de demande'] ||
             $oldRowData['Date de départ'] !== $rowData['Date de départ'] ||
             $oldRowData['Nombre de jours demandés'] !== $rowData['Nombre de jours demandés'] ||
             $oldRowData['Status'] !== $rowData['Status'];
             if ($dataMofified) {
             $userId = $page->GetCurrentUserId();
             $currentDateTime = SMDateTime::Now();
             $sql =
             "INSERT INTO activity_log (table_name, action, user_id, log_time) " .
             "VALUES ('$tableName', 'UPDATE', $userId, '$currentDateTime');";
             $page->GetConnection()->ExecSQL($sql);
             }
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
            if ($part == PagePart::Layout) {
                $userId = $this->GetCurrentUserId();
                $params['user_id'] = $userId;
                $result = 'custom_layout.tpl';
            }
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
            $list = ['Validée par Chef Service', 'Validée par Chef Division', 'Validée par Directeur', 'Validée par Admin'];
            $sql = 'SELECT COUNT(*) AS count FROM demande_congé';
            $result = $this->GetConnection()->fetchAll($sql);
            if (!empty($result)) {
               $count = $result[0]['count'];
               for($i = 0; $i < $count; $i++) {
                      $sql_1 = sprintf('SELECT user_id FROM demande_congé LIMIT 1 OFFSET %d', $i);
                      $result_1 = $this->GetConnection()->fetchAll($sql_1);
                      $userId = $result_1[0]['user_id'];
                      
                      $sql_2 = sprintf('SELECT ' .
                                   'CASE WHEN Direction = "" THEN 0 ELSE 1 END + ' .
                                   'CASE WHEN Division = "" THEN 0 ELSE 1 END + ' .
                                   'CASE WHEN Service = "" THEN 0 ELSE 1 END AS non_empty_columns_count ' .
                           'FROM fonctionnairesv3 WHERE `Numéro` = %d', $userId);
                      $result_2 = $this->GetConnection()->fetchAll($sql_2);
                      $N = $result_2[0]['non_empty_columns_count'] + 1;
                      
                      $sql_3 = sprintf('SELECT ' .
                                   'CASE WHEN `Validée par Chef Service` IS NULL THEN 0 ELSE 1 END + ' .
                                   'CASE WHEN `Validée par Chef Division` IS NULL THEN 0 ELSE 1 END + ' .
                                   'CASE WHEN `Validée par Directeur` IS NULL THEN 0 ELSE 1 END + ' .
                                   'CASE WHEN `Validée par Admin` IS NULL THEN 0 ELSE 1 END AS non_empty_columns_count ' .
                           'FROM `demande_validée` WHERE `user_id` = %d', $userId);
                      $result_3 = $this->GetConnection()->fetchAll($sql_3);
                      $M = $result_3[0]['non_empty_columns_count'];
                      
                      if ($N == $M) {
                         $sql_4 = sprintf('SELECT `Validée par Chef Service`, `Validée par Chef Division`, `Validée par Directeur`, `Validée par Admin` FROM `demande_validée` WHERE `user_id` = %d', $userId);
                         $result_4 = $this->GetConnection()->fetchAll($sql_4);
                         $row_4 = $result_4[0];
                         for($i = 0; $i < 4; $i++) {
                                $elem = $row_4[$list[$i]];
                                if ($elem != null) {
                                   if ($elem == 0) {
                                      $sql_5 = sprintf('UPDATE `demande_congé` SET `Status` = "Rejetée" WHERE `user_id` = %d', $userId);
                                      $this->$GetConnection()->ExecSQL($sql_5);
                                      exit;
                                   }
                                }
                         }
                         $sql_6 = sprintf('UPDATE `demande_congé` SET `Status` = "Accéptée" WHERE `user_id` = %d', $userId);
                         $this->$GetConnection()->ExecSQL($sql_6);
                      }
               }
            }
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
            if ($fieldName == 'Date De Retour') {
                $first_day = new DateTime($rowData['Date De Départ']);
                $requestedDays = $rowData['Nombre De Jours Demandés'];
                $queryResult = array();
                $sql = "SELECT Date_départ, nombres_jours FROM jours_fériés";
                $this->GetConnection()->ExecQueryToArray($sql, $queryResult);
                
            
                for ($i = 0; $i < $requestedDays; $i++) {
                    $first_day->add(new DateInterval('P1D'));
                    foreach ($queryResult as $row) {
                        if ($first_day->format('d-m-Y') === DateTime::createFromFormat('d-m-Y', $row['Date_départ'])) {
                            for ($k = 0; $k < intval($row['nombres_jours']); $k++) {
                                $first_day->add(new DateInterval('P1D'));
                            }
                        }
                        if ($first_day->format('D') === 'Sat' || $first_day->format('D') === 'Sun') {
                            $first_day->add(new DateInterval('P1D'));
                        }
                    }
                        
                }
                $value = $first_day->format('d-m-Y');
            }
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
            $userId = $page->GetCurrentUserId();
             
            $sql = 'user_id = %d';
            $usingCondition = sprintf($sql, $userId);
            
            $allowEdit = ($rowData['Status'] == 'En cours');
            $allowDelete = ($rowData['Status'] == 'En cours');
            
            $handled = true;
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new demande_congéPage("demande_congé", "demande_congé.php", GetCurrentUserPermissionsForPage("demande_congé"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("demande_congé"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
