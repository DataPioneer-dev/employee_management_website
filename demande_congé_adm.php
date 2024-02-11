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
    
    
    
    class demande_congé_admPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Gestion des demandes de congé');
            $this->SetMenuLabel('Gestion des demandes de congé');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`demande_congé_adm`');
            $this->dataset->addFields(
                array(
                    new IntegerField('user_id', true),
                    new StringField('Prénom'),
                    new StringField('Nom'),
                    new IntegerField('demande_id', true, true, true),
                    new DateField('Date de demande'),
                    new DateField('Date de départ'),
                    new IntegerField('Nombre de jours demandés'),
                    new DateField('Date de retour'),
                    new StringField('Type', true),
                    new IntegerField('Autorisation de sortie du territoire national'),
                    new StringField('Status'),
                    new IntegerField('Solde de Congé'),
                    new StringField('Cause', true)
                )
            );
        }
    
        protected function DoPrepare() {
            $chef_id = $this->GetCurrentUserId();
            if (GetApplication()->IsGETValueSet('demandeID') && GetApplication()->IsGETValueSet('status') && GetApplication()->IsGETValueSet('userID')) {
                $userID = GetApplication()->GetGETValue('userID');
                $id = GetApplication()->GetGETValue('demandeID');
                $stat = GetApplication()->GetGETValue('status');
                $sql_1 = sprintf('SELECT Prenom, Nom FROM fonctionnairesv3 WHERE `Numéro` = %d', $chef_id);
                $result_1 = $this->GetConnection()->fetchAll($sql_1);
                $chef_prenom = $result_1[0]['Prenom'];
                $chef_nom = $resulat[0]['Nom'];
                $column_name = $chef_prenom . '-' . $chef_nom . '-' . $chef_id;
                $sql = "UPDATE demande_congé_map SET `" . $column_name . "`=" . $stat . " WHERE demande_id=" . $id . " AND user_id=" . $userID;
                $this->GetConnection()->ExecSQL($sql);
            }
            
            $isChefDivision = false;
            $isDirecteur = false;
            $isChefService = false;
            $isAdmin = false;
            
            $chef_Id = $this->GetCurrentUserId();
            if ($chef_Id != 1) {
               $sql = 'SELECT Direction, Division, Service FROM fonctionnairesv3 WHERE `Numéro` = %d';
               $result_1 = $this->GetConnection()->fetchAll(sprintf($sql, $chef_Id));
                       if (!empty($result_1)) {
                          $row = $result_1[0];
                          $direction = $row['Direction'];
                          $division = $row['Division'];
                          $service = $row['Service'];
                          if (empty($service)) {
                             if (empty($division)) {
                                if (!empty($direction)) {
                                   $isDirecteur = true;
                                }
                             } else {
                               $isChefDivision = true;
                             }
                          } else {
                            $isChefService = true;
                          }
                       }
            } else {
              $isAdmin = true;
            }
            
            if (GetApplication()->IsGETValueSet('userID') && GetApplication()->IsGETValueSet('status')) {
                $userID = GetApplication()->GetGETValue('userID');
                $status = GetApplication()->GetGETValue('status');
                if ($isChefService) {
                   if ($status == "Accéptée") {
                      $sql = sprintf('UPDATE demande_validée SET `Validée par Chef Service`=1 WHERE user_id=%d', $userID);
                   } elseif ($status == "Rejetée") {
                     $sql = sprintf('UPDATE demande_validée SET `Validée par Chef Service`=0 WHERE user_id=%d', $userID);
                   }
                }
                
                if ($isChefDivision) {
                   if ($status == "Accéptée") {
                      $sql = sprintf('UPDATE demande_validée SET `Validée par Chef Division`=1 WHERE user_id=%d', $userID);
                   } elseif ($status == "Rejetée") {
                     $sql = sprintf('UPDATE demande_validée SET `Validée par Chef Division`=0 WHERE user_id=%d', $userID);
                   }
                }
                
                if ($isDirecteur) {
                   if ($status == "Accéptée") {
                      $sql = sprintf('UPDATE demande_validée SET `Validée par Directeur`=1 WHERE user_id=%d', $userID);
                   } elseif ($status == "Rejetée") {
                     $sql = sprintf('UPDATE demande_validée SET `Validée par Directeur`=0 WHERE user_id=%d', $userID);
                   }
                }
                
                if ($isAdmin) {
                   if ($status == "Accéptée") {
                      $sql = sprintf('UPDATE demande_validée SET `Validée par Admin`=1 WHERE user_id=%d', $userID);
                   } elseif ($status == "Rejetée") {
                     $sql = sprintf('UPDATE demande_validée SET `Validée par Admin`=0 WHERE user_id=%d', $userID);
                   }
                }
                
                $this->GetConnection()->ExecSQL($sql);
                echo json_encode(array("status" => $stat));
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
                new FilterColumn($this->dataset, 'user_id', 'user_id', 'User Id'),
                new FilterColumn($this->dataset, 'Prénom', 'Prénom', 'Prénom'),
                new FilterColumn($this->dataset, 'Nom', 'Nom', 'Nom'),
                new FilterColumn($this->dataset, 'demande_id', 'demande_id', 'Demande Id'),
                new FilterColumn($this->dataset, 'Date de demande', 'Date de demande', 'Date De Demande'),
                new FilterColumn($this->dataset, 'Date de départ', 'Date de départ', 'Date De Départ'),
                new FilterColumn($this->dataset, 'Nombre de jours demandés', 'Nombre de jours demandés', 'Nombre De Jours Demandés'),
                new FilterColumn($this->dataset, 'Date de retour', 'Date de retour', 'Date De Retour'),
                new FilterColumn($this->dataset, 'Type', 'Type', 'Type'),
                new FilterColumn($this->dataset, 'Cause', 'Cause', 'Cause'),
                new FilterColumn($this->dataset, 'Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National'),
                new FilterColumn($this->dataset, 'Status', 'Status', 'Status'),
                new FilterColumn($this->dataset, 'Solde de Congé', 'Solde de Congé', 'Solde De Congé')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['user_id'])
                ->addColumn($columns['Prénom'])
                ->addColumn($columns['Nom'])
                ->addColumn($columns['demande_id'])
                ->addColumn($columns['Date de demande'])
                ->addColumn($columns['Date de départ'])
                ->addColumn($columns['Nombre de jours demandés'])
                ->addColumn($columns['Date de retour'])
                ->addColumn($columns['Type'])
                ->addColumn($columns['Cause'])
                ->addColumn($columns['Autorisation de sortie du territoire national'])
                ->addColumn($columns['Status'])
                ->addColumn($columns['Solde de Congé']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Prénom')
                ->setOptionsFor('Nom')
                ->setOptionsFor('Date de demande')
                ->setOptionsFor('Date de départ')
                ->setOptionsFor('Date de retour')
                ->setOptionsFor('Type');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('user_id_edit');
            
            $filterBuilder->addColumn(
                $columns['user_id'],
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
            
            $main_editor = new TextEdit('prénom_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['Prénom'],
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
            
            $main_editor = new TextEdit('demande_id_edit');
            
            $filterBuilder->addColumn(
                $columns['demande_id'],
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
            
            $main_editor = new DateTimeEdit('date_de_demande_edit', false, 'Y-m-d');
            
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
            
            $main_editor = new DateTimeEdit('date_de_départ_edit', false, 'Y-m-d');
            
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
            
            $main_editor = new DateTimeEdit('date_de_retour_edit', false, 'Y-m-d');
            
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
            
            $main_editor = new TextEdit('Type');
            
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
            
            $main_editor = new TextEdit('cause_edit');
            
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
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for Prénom field
            //
            $column = new TextViewColumn('Prénom', 'Prénom', 'Prénom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
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
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new NumberViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
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
            // View column for Prénom field
            //
            $column = new TextViewColumn('Prénom', 'Prénom', 'Prénom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date de demande field
            //
            $column = new DateTimeViewColumn('Date de demande', 'Date de demande', 'Date De Demande', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date de retour field
            //
            $column = new DateTimeViewColumn('Date de retour', 'Date de retour', 'Date De Retour', $this->dataset);
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
            $column = new TextViewColumn('Cause', 'Cause', 'Cause', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new NumberViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Prénom field
            //
            $editor = new TextEdit('prénom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prénom', 'Prénom', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for demande_id field
            //
            $editor = new TextEdit('demande_id_edit');
            $editColumn = new CustomEditColumn('Demande Id', 'demande_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de demande field
            //
            $editor = new DateTimeEdit('date_de_demande_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Demande', 'Date de demande', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de départ field
            //
            $editor = new DateTimeEdit('date_de_départ_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Départ', 'Date de départ', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de retour field
            //
            $editor = new DateTimeEdit('date_de_retour_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Retour', 'Date de retour', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Type field
            //
            $editor = new TextAreaEdit('type_edit', 50, 8);
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Cause field
            //
            $editor = new TextEdit('cause_edit');
            $editColumn = new CustomEditColumn('Cause', 'Cause', $editor, $this->dataset);
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
            // Edit column for Status field
            //
            $editor = new TextAreaEdit('status_edit', 50, 8);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Solde de Congé field
            //
            $editor = new TextEdit('solde_de_congé_edit');
            $editColumn = new CustomEditColumn('Solde De Congé', 'Solde de Congé', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for user_id field
            //
            $editor = new TextEdit('user_id_edit');
            $editColumn = new CustomEditColumn('User Id', 'user_id', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Prénom field
            //
            $editor = new TextEdit('prénom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prénom', 'Prénom', $editor, $this->dataset);
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
            // Edit column for demande_id field
            //
            $editor = new TextEdit('demande_id_edit');
            $editColumn = new CustomEditColumn('Demande Id', 'demande_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de demande field
            //
            $editor = new DateTimeEdit('date_de_demande_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Demande', 'Date de demande', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de départ field
            //
            $editor = new DateTimeEdit('date_de_départ_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Départ', 'Date de départ', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de retour field
            //
            $editor = new DateTimeEdit('date_de_retour_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Retour', 'Date de retour', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Type field
            //
            $editor = new TextAreaEdit('type_edit', 50, 8);
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Cause field
            //
            $editor = new TextEdit('cause_edit');
            $editColumn = new CustomEditColumn('Cause', 'Cause', $editor, $this->dataset);
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
            // Edit column for Status field
            //
            $editor = new TextAreaEdit('status_edit', 50, 8);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Solde de Congé field
            //
            $editor = new TextEdit('solde_de_congé_edit');
            $editColumn = new CustomEditColumn('Solde De Congé', 'Solde de Congé', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Prénom field
            //
            $editor = new TextEdit('prénom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Prénom', 'Prénom', $editor, $this->dataset);
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
            // Edit column for demande_id field
            //
            $editor = new TextEdit('demande_id_edit');
            $editColumn = new CustomEditColumn('Demande Id', 'demande_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de demande field
            //
            $editor = new DateTimeEdit('date_de_demande_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Demande', 'Date de demande', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de départ field
            //
            $editor = new DateTimeEdit('date_de_départ_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Départ', 'Date de départ', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
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
            $editor = new DateTimeEdit('date_de_retour_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Retour', 'Date de retour', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Type field
            //
            $editor = new TextAreaEdit('type_edit', 50, 8);
            $editColumn = new CustomEditColumn('Type', 'Type', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Cause field
            //
            $editor = new TextEdit('cause_edit');
            $editColumn = new CustomEditColumn('Cause', 'Cause', $editor, $this->dataset);
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
            // Edit column for Status field
            //
            $editor = new TextAreaEdit('status_edit', 50, 8);
            $editColumn = new CustomEditColumn('Status', 'Status', $editor, $this->dataset);
            $editColumn->SetInsertDefaultValue('En cours');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Solde de Congé field
            //
            $editor = new TextEdit('solde_de_congé_edit');
            $editColumn = new CustomEditColumn('Solde De Congé', 'Solde de Congé', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for user_id field
            //
            $column = new NumberViewColumn('user_id', 'user_id', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prénom field
            //
            $column = new TextViewColumn('Prénom', 'Prénom', 'Prénom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for demande_id field
            //
            $column = new NumberViewColumn('demande_id', 'demande_id', 'Demande Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
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
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Cause field
            //
            $column = new TextViewColumn('Cause', 'Cause', 'Cause', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new NumberViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for user_id field
            //
            $column = new NumberViewColumn('user_id', 'user_id', 'User Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Prénom field
            //
            $column = new TextViewColumn('Prénom', 'Prénom', 'Prénom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for demande_id field
            //
            $column = new NumberViewColumn('demande_id', 'demande_id', 'Demande Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
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
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Cause field
            //
            $column = new TextViewColumn('Cause', 'Cause', 'Cause', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddExportColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new NumberViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
            // View column for Prénom field
            //
            $column = new TextViewColumn('Prénom', 'Prénom', 'Prénom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            // View column for Type field
            //
            $column = new TextViewColumn('Type', 'Type', 'Type', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Cause field
            //
            $column = new TextViewColumn('Cause', 'Cause', 'Cause', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Autorisation de sortie du territoire national field
            //
            $column = new CheckboxViewColumn('Autorisation de sortie du territoire national', 'Autorisation de sortie du territoire national', 'Autorisation De Sortie Du Territoire National', $this->dataset);
            $column->SetOrderable(true);
            $column->setDisplayValues('<span class="pg-row-checkbox checked"></span>', '<span class="pg-row-checkbox"></span>');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Status field
            //
            $column = new TextViewColumn('Status', 'Status', 'Status', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Solde de Congé field
            //
            $column = new NumberViewColumn('Solde de Congé', 'Solde de Congé', 'Solde De Congé', $this->dataset);
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
            return 'function transformDateFormat(inputDate) {'. "\n" .
            '  const dateParts = inputDate.split("-");'. "\n" .
            '  const transformedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];'. "\n" .
            '  return transformedDate;'. "\n" .
            '}'. "\n" .
            ''. "\n" .
            'function prepareInlineButtons() {'. "\n" .
            '    $(\'button.inline-button\').click(function() {'. "\n" .
            '        var button = $(this);'. "\n" .
            '        var changetext = button.siblings(\'td[data-column-name="Status"]\');'. "\n" .
            '        var user_id = button.data(\'user_id\');'. "\n" .
            '        var demandeId = button.data(\'demande_id\');'. "\n" .
            '        var user_first_name = button.data(\'user_first_name\');'. "\n" .
            '        var user_last_name = button.data(\'user_last_name\');'. "\n" .
            '        var date_demande = transformDateFormat(button.data(\'date_demande\'));'. "\n" .
            '        var newstatus = \'\';'. "\n" .
            '        '. "\n" .
            '        if (button.hasClass(\'accepter-button\')) {'. "\n" .
            '            newstatus = \'Accéptée\'; '. "\n" .
            '        } else if (button.hasClass(\'rejeter-button\')) {'. "\n" .
            '            newstatus = \'Rejetée\'; '. "\n" .
            '        }'. "\n" .
            '        '. "\n" .
            '        if (newstatus !== \'\') {'. "\n" .
            '            $.getJSON('. "\n" .
            '                location.href,'. "\n" .
            '                {'. "\n" .
            '                    userID: user_id,'. "\n" .
            '                    demandeID: demandeId,'. "\n" .
            '                    status: newstatus'. "\n" .
            '                },'. "\n" .
            '                function (dataFromServer) {'. "\n" .
            '                    if (newstatus === \'Accéptée\') {'. "\n" .
            '                        $(\'#DecisionUserPrenom\').text(user_first_name);'. "\n" .
            '                        $(\'#DecisionUserNom\').text(user_last_name);'. "\n" .
            '                        $(\'#DateDecision\').text(date_demande);'. "\n" .
            '                        $(\'#notification_decision\').modal(\'show\');'. "\n" .
            '                    } else {'. "\n" .
            '                        $(\'#notification_decision\').modal(\'hide\');'. "\n" .
            '                    }   '. "\n" .
            '                }'. "\n" .
            '            );'. "\n" .
            '        }'. "\n" .
            '    });'. "\n" .
            '}'. "\n" .
            ''. "\n" .
            ''. "\n" .
            'prepareInlineButtons();';
        }
        public function GetEnableModalSingleRecordView() { return true; }
    
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
            $chef_id = $this->GetCurrentUserId();
            $user_id = $rowData['user_id'];
            $demande_id = $rowData['demande_id'];
            $sql_1 = sprintf('SELECT Prenom, Nom FROM fonctionnairesv3 WHERE `Numéro` = %d', $chef_id);
            $result_1 = $this->GetConnection()->fetchAll($sql_1);
            $chef_prenom = $result_1[0]['Prenom'];
            $chef_nom = $resulat[0]['Nom'];
            $column_name = $chef_prenom . '-' . $chef_nom . '-' . $chef_id;
            if ($fieldName === 'Status') {
                    $sql_2 = 'SELECT `' . $column_name . '` as fieldData FROM demande_congé_map WHERE user_id = ' . $user_id . 'AND demande_id = ' . $demande_id;
                    $result_2 = $this->GetConnection()->fetchAll($sql_2);
                    $customFieldData = $result_2[0]['fieldData'];
                    switch ($customFieldData) {
                        case 'En cours':
                            $customText = '<span class="status-cell yellow">' . $customFieldData . '</span>';
                            $dataAttributes = sprintf('data-chef_id="%s" data-user_id="%s" data-demande_id="%s" data-autorisation="%s" data-user_first_name="%s" data-user_last_name="%s" data-date_demande="%s"', $chef_id, $rowData['user_id'], $rowData['demande_id'], $fieldData, $rowData['Autorisation de sortie du territoire national'], $rowData['Prénom'],$rowData['Nom'], $rowData['Date de demande']);
                            $customText .= '<button class="btn btn-default inline-button accepter-button" ' .  
                                        $dataAttributes . ' style="margin-left: 15px;" onclick="setAttributes(this)">Accépter</button>';
                            $customText .= '<button class="btn btn-default inline-button rejeter-button" ' . 
                                        $dataAttributes . ' style="margin-left: 15px;">Rejeter</button>';
                            break;
                        case 'Accéptée':
                            $customText = '<span class="status-cell green">' . $customFieldData . '</span>';
                            break;
                        case 'Rejetée':
                            $customText = '<span class="status-cell red">' . $customFieldData . '</span>';
                            break;
                        case 'Annulée':
                            $customText = '<span class="status-cell red">' . $customFieldData . '</span>';
                            break;
                        default:
                            break;
                    }
            
                    $handled = true;
                }
                
            
            if ($fieldName === 'Solde de Congé') {
                $joursConge = $fieldData;
            
                $dataAttributes = sprintf('data-demande_id="%s"', $rowData['demande_id']);
                $customText = '<span class="gradient-cell" ' . $dataAttributes . '>' . $fieldData . '</span>';
            
                $bgColor = 'green'; // Couleur par défaut si la valeur est supérieure ou égale à 22
            
                if ($joursConge <= 22 && $joursConge >= 6) {
                    $bgColor = "green";
                } elseif ($joursConge <= 5 && $joursConge > 0) {
                    $bgColor = 'orange'; 
                } elseif ($joursConge <= 0) {
                    $bgColor = "red";
                }
                $customText .= '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var cellElement = document.querySelector(".gradient-cell[data-demande_id=\'' . $rowData['demande_id'] . '\']");
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
            if ($success) {
                sleep(5);
                $demande_id = $rowData['demande_id'];
                $sql = "DELETE FROM `demande_congé_adm` WHERE `demande_id` = '$demande_id'";
                $page->GetConnection()->ExecSQL($sql);
            }
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
            if ($part == PagePart::Layout) {
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
            if ($chart->getId() == 'demands_status') {
                $options = array(
                    'is3D' => true,
                    'slices' => array(1 => array('offset' => 0.3)),
                    'legend' => array('position' => 'left')
                );
                $chart->setOptions($options);
            }
            
            if ($chart->getId() == 'demands_type') {
                $options = array(
                    'is3D' => true,
                    'slices' => array(1 => array('offset' => 0.3)),
                    'legend' => array('position' => 'left')
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
            $chef_Id = $page->GetCurrentUserId();
            $sql = 'SELECT COUNT(*) as count FROM demande_congé_adm';
            $result = $this->GetConnection()->fetchAll($sql);
            $count = $result[0]['count'];
            
            $isChefDivision = false;
            $isDirecteur = false;
            $isChefService = false;
            
            $inService = false;
            $inDivision = false;
            $inDirection = false;
            
            if ($chef_Id != 1) {
                if ($count != 0) {
                    for ($i = 0; $i < $count; $i++) {
                        $sql = 'SELECT Direction, Division, Service FROM fonctionnairesv3 WHERE `Numéro` = %d';
                        $result_1 = $page->GetConnection()->fetchAll(sprintf($sql, $chef_Id));
            
                        if (!empty($result_1)) {
                            $row = $result_1[0];
                            $direction = $row['Direction'];
                            $division = $row['Division'];
                            $service = $row['Service'];
            
                            if (empty($service)) {
                                if (empty($division)) {
                                    if (!empty($direction)) {
                                        $isDirecteur = true;
                                    }
                                } else {
                                    $isChefDivision = true;
                                }
                            } else {
                                $isChefService = true;
                            }
                        }
                        
                        $sql_id = 'SELECT user_id FROM demande_congé_adm LIMIT 1 OFFSET %d';
                        $result_id = $page->GetConnection()->fetchAll(sprintf($sql_id, $i));
                        $userId = $result_id[0]['user_id'];
                        $result_2 = $page->GetConnection()->fetchAll(sprintf($sql, $userId));
            
                        if (!empty($result_2)) {
                            $row2 = $result_2[0];
                            $direction2 = $row2['Direction'];
                            $division2 = $row2['Division'];
                            $service2 = $row2['Service'];
            
                            if (empty($service2)) {
                                if (empty($division2)) {
                                    if (!empty($direction2)) {
                                        $inDirection = true;
                                    }
                                } else {
                                    $inDivision = true;
                                }
                            } else {
                                $inService = true;
                            }
                        }
            
                        if ($isChefService && $inService) {
                            $usingCondition = sprintf('user_id IN (SELECT `Numéro` FROM fonctionnairesv3 WHERE Service = "%s")', $service);
                        } elseif ($isChefDivision) {
                            $divIDResult = $page->GetConnection()->fetchAll("SELECT ID_Division FROM division WHERE Nom_Div = '$division'");
                            if (!empty($divIDResult)) {
                                $divID = (int)$divIDResult[0]['ID_Division'];
                                if ($inService) {
                                    $usingCondition = "user_id IN (SELECT `Numéro` FROM fonctionnairesv3 WHERE Service IN (SELECT Nom_Serv FROM service WHERE ID_Div = $divID))";
                                } elseif ($inDivision) {
                                    $usingCondition = sprintf('user_id IN (SELECT `Numéro` FROM fonctionnairesv3 WHERE Division = "%s")', $division);
                                }
                            }
                        } elseif ($isDirecteur) {
                            $dirIDResult = $page->GetConnection()->fetchAll("SELECT ID_Dir FROM direction WHERE Libelle = '$direction'");
                            if (!empty($dirIDResult)) {
                                $dirID = (int)$dirIDResult[0]['ID_Dir'];
                                if ($inDivision) {
                                    $usingCondition = "user_id IN (SELECT `Numéro` FROM fonctionnairesv3 WHERE Division IN (SELECT Nom_Div FROM division WHERE ID_Dir = $dirID))";
                                } elseif ($inService) {
                                    $usingCondition = "user_id IN (SELECT `Numéro` FROM fonctionnairesv3 WHERE Service IN (SELECT Nom_Serv FROM service WHERE ID_Dir = $dirID))";
                                } elseif ($inDirection) {
                                    $usingCondition = sprintf('user_id IN (SELECT `Numéro` FROM fonctionnairesv3 WHERE Direction = "%s")', $direction);
                                }
                            }
                        }
                    }
                }
            } else {
                $usingCondition = '1 = 2'; 
            }
            
            $handled = true;
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new demande_congé_admPage("demande_congé_adm", "demande_congé_adm.php", GetCurrentUserPermissionsForPage("demande_congé_adm"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("demande_congé_adm"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
