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
    
    
    
    class cadre_fonctionnairesPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Fonctionnaires');
            $this->SetMenuLabel('Fonctionnaires');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnaires`');
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
            $this->dataset->AddLookupField('Superviseur_Serv', 'fonctionnaires', new IntegerField('ID_Utilis'), new StringField('Nom_Utilis', false, false, false, false, 'Superviseur_Serv_Nom_Utilis', 'Superviseur_Serv_Nom_Utilis_fonctionnaires'), 'Superviseur_Serv_Nom_Utilis_fonctionnaires');
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
            
            $main_editor = new TextEdit('Email');
            
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
            
            $main_editor = new DateTimeEdit('date_naiss_edit', false, 'd-m-Y');
            
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
            $main_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_ID_Div_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Div', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_ID_Div_search');
            
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
            $main_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_ID_Serv_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('ID_Serv', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_ID_Serv_search');
            
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
            $main_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_Cadre_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Cadre', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_Cadre_search');
            
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
            $main_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_Grade_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Grade', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_Grade_search');
            
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
            
            $main_editor = new TextEdit('Aujour');
            
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
            $main_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_Corps_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Corps', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_Corps_search');
            
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
            $main_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_Superviseur_Serv_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Superviseur_Serv', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_cadre_fonctionnaires_Superviseur_Serv_search');
            
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
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
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
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $editor = new TextAreaEdit('email_edit', 50, 8);
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
            $editor = new DateTimeEdit('date_naiss_edit', false, 'd-m-Y');
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
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'edit_cadre_fonctionnaires_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
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
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'edit_cadre_fonctionnaires_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
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
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'edit_cadre_fonctionnaires_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'edit_cadre_fonctionnaires_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextAreaEdit('aujour_edit', 50, 8);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'edit_cadre_fonctionnaires_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'edit_cadre_fonctionnaires_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
            $editor = new TextAreaEdit('email_edit', 50, 8);
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
            $editor = new DateTimeEdit('date_naiss_edit', false, 'd-m-Y');
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
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'multi_edit_cadre_fonctionnaires_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
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
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'multi_edit_cadre_fonctionnaires_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
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
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'multi_edit_cadre_fonctionnaires_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'multi_edit_cadre_fonctionnaires_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextAreaEdit('aujour_edit', 50, 8);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'multi_edit_cadre_fonctionnaires_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'multi_edit_cadre_fonctionnaires_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
            $editor = new TextAreaEdit('email_edit', 50, 8);
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
            $editor = new DateTimeEdit('date_naiss_edit', false, 'd-m-Y');
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
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Div', 'ID_Div', 'ID_Div_Nom_Div', 'insert_cadre_fonctionnaires_ID_Div_search', $editor, $this->dataset, $lookupDataset, 'ID_Division', 'Nom_Div', '');
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
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Div'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Serv', 'ASC');
            $editColumn = new DynamicLookupEditColumn('ID Serv', 'ID_Serv', 'ID_Serv_Nom_Serv', 'insert_cadre_fonctionnaires_ID_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Serv', 'Nom_Serv', '');
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
            $editColumn = new DynamicLookupEditColumn('Cadre', 'Cadre', 'Cadre_Libelle', 'insert_cadre_fonctionnaires_Cadre_search', $editor, $this->dataset, $lookupDataset, 'ID_Cadr', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'insert_cadre_fonctionnaires_Grade_search', $editor, $this->dataset, $lookupDataset, 'ID_Grad', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Aujour field
            //
            $editor = new TextAreaEdit('aujour_edit', 50, 8);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'insert_cadre_fonctionnaires_Corps_search', $editor, $this->dataset, $lookupDataset, 'ID_Cor', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Superviseur Serv', 'Superviseur_Serv', 'Superviseur_Serv_Nom_Utilis', 'insert_cadre_fonctionnaires_Superviseur_Serv_search', $editor, $this->dataset, $lookupDataset, 'ID_Utilis', 'Nom_Utilis', '');
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
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Nom_Utilis field
            //
            $column = new TextViewColumn('Nom_Utilis', 'Nom_Utilis', 'Nom Utilis', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Adresse field
            //
            $column = new TextViewColumn('Adresse', 'Adresse', 'Adresse', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Fonction field
            //
            $column = new TextViewColumn('Fonction', 'Fonction', 'Fonction', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date_Naiss field
            //
            $column = new DateTimeViewColumn('Date_Naiss', 'Date_Naiss', 'Date Naiss', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
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
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Serv field
            //
            $column = new TextViewColumn('ID_Serv', 'ID_Serv_Nom_Serv', 'ID Serv', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Cadre', 'Cadre_Libelle', 'Cadre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Aujour field
            //
            $column = new TextViewColumn('Aujour', 'Aujour', 'Aujour', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom_Arabe field
            //
            $column = new TextViewColumn('Nom_Arabe', 'Nom_Arabe', 'Nom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom_Arabe field
            //
            $column = new TextViewColumn('Prenom_Arabe', 'Prenom_Arabe', 'Prenom Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
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
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Sexe field
            //
            $column = new TextViewColumn('Sexe', 'Sexe', 'Sexe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Admin field
            //
            $column = new TextViewColumn('Admin', 'Admin', 'Admin', $this->dataset);
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
                    new StringField('Nom_Arabe'),
                    new IntegerField('ID_Dir')
                )
            );
            $lookupDataset->setOrderByField('Nom_Div', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_cadre_fonctionnaires_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_cadre_fonctionnaires_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_cadre_fonctionnaires_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_cadre_fonctionnaires_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_cadre_fonctionnaires_Corps_search', 'ID_Cor', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_cadre_fonctionnaires_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_cadre_fonctionnaires_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_cadre_fonctionnaires_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_cadre_fonctionnaires_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_cadre_fonctionnaires_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_cadre_fonctionnaires_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_cadre_fonctionnaires_Corps_search', 'ID_Cor', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_cadre_fonctionnaires_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_cadre_fonctionnaires_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_cadre_fonctionnaires_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_cadre_fonctionnaires_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_cadre_fonctionnaires_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_cadre_fonctionnaires_Corps_search', 'ID_Cor', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_cadre_fonctionnaires_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_cadre_fonctionnaires_ID_Div_search', 'ID_Division', 'Nom_Div', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_cadre_fonctionnaires_ID_Serv_search', 'ID_Serv', 'Nom_Serv', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_cadre_fonctionnaires_Cadre_search', 'ID_Cadr', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_cadre_fonctionnaires_Grade_search', 'ID_Grad', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_cadre_fonctionnaires_Corps_search', 'ID_Cor', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_cadre_fonctionnaires_Superviseur_Serv_search', 'ID_Utilis', 'Nom_Utilis', null, 20);
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
    
    
    
    class cadrePage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Cadre');
            $this->SetMenuLabel('Cadre');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cadre`');
            $this->dataset->addFields(
                array(
                    new IntegerField('ID_Cadr', true, true, true),
                    new StringField('Libelle'),
                    new StringField('Libelle_Arabe')
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
                new FilterColumn($this->dataset, 'ID_Cadr', 'ID_Cadr', 'ID Cadr'),
                new FilterColumn($this->dataset, 'Libelle', 'Libelle', 'Libelle'),
                new FilterColumn($this->dataset, 'Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['ID_Cadr'])
                ->addColumn($columns['Libelle'])
                ->addColumn($columns['Libelle_Arabe']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_cadr_edit');
            
            $filterBuilder->addColumn(
                $columns['ID_Cadr'],
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
            
            $main_editor = new TextEdit('Libelle');
            
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
            
            $main_editor = new TextEdit('Libelle_Arabe');
            
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
            if (GetCurrentUserPermissionsForPage('cadre.fonctionnaires')->HasViewGrant() && $withDetails)
            {
            //
            // View column for cadre_fonctionnaires detail
            //
            $column = new DetailColumn(array('ID_Cadr'), 'cadre.fonctionnaires', 'cadre_fonctionnaires_handler', $this->dataset, 'Fonctionnaires');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for ID_Cadr field
            //
            $column = new NumberViewColumn('ID_Cadr', 'ID_Cadr', 'ID Cadr', $this->dataset);
            $column->SetOrderable(true);
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
            $column->SetMaxLength(20);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
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
            // View column for ID_Cadr field
            //
            $column = new NumberViewColumn('ID_Cadr', 'ID_Cadr', 'ID Cadr', $this->dataset);
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
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Libelle field
            //
            $editor = new TextAreaEdit('libelle_edit', 50, 8);
            $editColumn = new CustomEditColumn('Libelle', 'Libelle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Libelle_Arabe field
            //
            $editor = new TextAreaEdit('libelle_arabe_edit', 50, 8);
            $editColumn = new CustomEditColumn('Libelle Arabe', 'Libelle_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Libelle field
            //
            $editor = new TextAreaEdit('libelle_edit', 50, 8);
            $editColumn = new CustomEditColumn('Libelle', 'Libelle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Libelle_Arabe field
            //
            $editor = new TextAreaEdit('libelle_arabe_edit', 50, 8);
            $editColumn = new CustomEditColumn('Libelle Arabe', 'Libelle_Arabe', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Libelle field
            //
            $editor = new TextAreaEdit('libelle_edit', 50, 8);
            $editColumn = new CustomEditColumn('Libelle', 'Libelle', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Libelle_Arabe field
            //
            $editor = new TextAreaEdit('libelle_arabe_edit', 50, 8);
            $editColumn = new CustomEditColumn('Libelle Arabe', 'Libelle_Arabe', $editor, $this->dataset);
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
            // View column for ID_Cadr field
            //
            $column = new NumberViewColumn('ID_Cadr', 'ID_Cadr', 'ID Cadr', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for ID_Cadr field
            //
            $column = new NumberViewColumn('ID_Cadr', 'ID_Cadr', 'ID Cadr', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Libelle', 'Libelle', 'Libelle', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(20);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle_Arabe field
            //
            $column = new TextViewColumn('Libelle_Arabe', 'Libelle_Arabe', 'Libelle Arabe', $this->dataset);
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
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new cadre_fonctionnairesPage('cadre_fonctionnaires', $this, array('Cadre'), array('ID_Cadr'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('cadre.fonctionnaires'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('cadre.fonctionnaires'));
            $detailPage->SetHttpHandlerName('cadre_fonctionnaires_handler');
            $handler = new PageHTTPHandler('cadre_fonctionnaires_handler', $detailPage);
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
        $Page = new cadrePage("cadre", "cadre.php", GetCurrentUserPermissionsForPage("cadre"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("cadre"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
