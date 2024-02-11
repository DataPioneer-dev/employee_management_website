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
    
    
    
    class fonctionnairesv2Page extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Fonctionnairesv2');
            $this->SetMenuLabel('Fonctionnairesv2');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`fonctionnairesv2`');
            $this->dataset->addFields(
                array(
                    new IntegerField('Numéro', true, true, true),
                    new StringField('Civilité'),
                    new StringField('Nom'),
                    new StringField('Prenom'),
                    new StringField('N° CIN'),
                    new DateField('Date de Naissance'),
                    new DateField('Date de rectrutement'),
                    new DateField('Date d\'affectation au CRO'),
                    new StringField('Corps'),
                    new StringField('Grade'),
                    new StringField('Poste de responsabilité'),
                    new StringField('Direction'),
                    new StringField('Division'),
                    new StringField('Service'),
                    new StringField('Situation'),
                    new StringField('N° Tél'),
                    new StringField('Email'),
                    new StringField('Adresse')
                )
            );
            $this->dataset->AddLookupField('Corps', 'corps', new StringField('Libelle'), new StringField('Libelle', false, false, false, false, 'Corps_Libelle', 'Corps_Libelle_corps'), 'Corps_Libelle_corps');
            $this->dataset->AddLookupField('Grade', 'grade', new StringField('Libelle'), new StringField('Libelle', false, false, false, false, 'Grade_Libelle', 'Grade_Libelle_grade'), 'Grade_Libelle_grade');
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
                new FilterColumn($this->dataset, 'Numéro', 'Numéro', 'Numéro'),
                new FilterColumn($this->dataset, 'Civilité', 'Civilité', 'Civilité'),
                new FilterColumn($this->dataset, 'Nom', 'Nom', 'Nom'),
                new FilterColumn($this->dataset, 'Prenom', 'Prenom', 'Prenom'),
                new FilterColumn($this->dataset, 'N° CIN', 'N° CIN', 'N° CIN'),
                new FilterColumn($this->dataset, 'Date de Naissance', 'Date de Naissance', 'Date De Naissance'),
                new FilterColumn($this->dataset, 'Date de rectrutement', 'Date de rectrutement', 'Date De Rectrutement'),
                new FilterColumn($this->dataset, 'Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO'),
                new FilterColumn($this->dataset, 'Corps', 'Corps_Libelle', 'Corps'),
                new FilterColumn($this->dataset, 'Grade', 'Grade_Libelle', 'Grade'),
                new FilterColumn($this->dataset, 'Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité'),
                new FilterColumn($this->dataset, 'Direction', 'Direction', 'Direction'),
                new FilterColumn($this->dataset, 'Division', 'Division', 'Division'),
                new FilterColumn($this->dataset, 'Service', 'Service', 'Service'),
                new FilterColumn($this->dataset, 'Situation', 'Situation', 'Situation'),
                new FilterColumn($this->dataset, 'N° Tél', 'N° Tél', 'N° Tél'),
                new FilterColumn($this->dataset, 'Email', 'Email', 'Email'),
                new FilterColumn($this->dataset, 'Adresse', 'Adresse', 'Adresse')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['Numéro'])
                ->addColumn($columns['Civilité'])
                ->addColumn($columns['Nom'])
                ->addColumn($columns['Prenom'])
                ->addColumn($columns['N° CIN'])
                ->addColumn($columns['Date de Naissance'])
                ->addColumn($columns['Date de rectrutement'])
                ->addColumn($columns['Date d\'affectation au CRO'])
                ->addColumn($columns['Corps'])
                ->addColumn($columns['Grade'])
                ->addColumn($columns['Poste de responsabilité'])
                ->addColumn($columns['Direction'])
                ->addColumn($columns['Division'])
                ->addColumn($columns['Service'])
                ->addColumn($columns['Situation'])
                ->addColumn($columns['N° Tél'])
                ->addColumn($columns['Email'])
                ->addColumn($columns['Adresse']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('Date de Naissance')
                ->setOptionsFor('Date de rectrutement')
                ->setOptionsFor('Date d\'affectation au CRO')
                ->setOptionsFor('Corps')
                ->setOptionsFor('Grade');
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
            
            $main_editor = new TextEdit('civilité_edit');
            $main_editor->SetMaxLength(50);
            
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
            
            $main_editor = new DateTimeEdit('date_de_naissance_edit', false, 'Y-m-d');
            
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
            
            $main_editor = new DateTimeEdit('date_de_rectrutement_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['Date de rectrutement'],
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
            
            $main_editor = new DateTimeEdit('date_d\'affectation_au_cro_edit', false, 'Y-m-d');
            
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
            
            $main_editor = new DynamicCombobox('corps_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv2_Corps_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Corps', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv2_Corps_search');
            
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
            $main_editor->SetHandlerName('filter_builder_fonctionnairesv2_Grade_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('Grade', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_fonctionnairesv2_Grade_search');
            
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
            
            $main_editor = new TextEdit('poste_de_responsabilité_edit');
            $main_editor->SetMaxLength(60);
            
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
            
            $main_editor = new TextEdit('direction_edit');
            $main_editor->SetMaxLength(60);
            
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
            
            $main_editor = new TextEdit('division_edit');
            $main_editor->SetMaxLength(60);
            
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
            
            $main_editor = new TextEdit('service_edit');
            $main_editor->SetMaxLength(60);
            
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
            // View column for Numéro field
            //
            $column = new NumberViewColumn('Numéro', 'Numéro', 'Numéro', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
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
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date de rectrutement field
            //
            $column = new DateTimeViewColumn('Date de rectrutement', 'Date de rectrutement', 'Date De Rectrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Direction field
            //
            $column = new TextViewColumn('Direction', 'Direction', 'Direction', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Division field
            //
            $column = new TextViewColumn('Division', 'Division', 'Division', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Service field
            //
            $column = new TextViewColumn('Service', 'Service', 'Service', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
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
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for Numéro field
            //
            $column = new NumberViewColumn('Numéro', 'Numéro', 'Numéro', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date de rectrutement field
            //
            $column = new DateTimeViewColumn('Date de rectrutement', 'Date de rectrutement', 'Date De Rectrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Direction field
            //
            $column = new TextViewColumn('Direction', 'Direction', 'Direction', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Division field
            //
            $column = new TextViewColumn('Division', 'Division', 'Division', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Service field
            //
            $column = new TextViewColumn('Service', 'Service', 'Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
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
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for Civilité field
            //
            $editor = new TextEdit('civilité_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Civilité', 'Civilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Nom field
            //
            $editor = new TextEdit('nom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom', 'Nom', $editor, $this->dataset);
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
            // Edit column for N° CIN field
            //
            $editor = new TextEdit('n°_cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° CIN', 'N° CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de Naissance field
            //
            $editor = new DateTimeEdit('date_de_naissance_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Naissance', 'Date de Naissance', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date de rectrutement field
            //
            $editor = new DateTimeEdit('date_de_rectrutement_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Rectrutement', 'Date de rectrutement', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Date d'affectation au CRO field
            //
            $editor = new DateTimeEdit('date_d\'affectation_au_cro_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date D\'affectation Au CRO', 'Date d\'affectation au CRO', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'edit_fonctionnairesv2_Corps_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'edit_fonctionnairesv2_Grade_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Poste de responsabilité field
            //
            $editor = new TextEdit('poste_de_responsabilité_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Poste De Responsabilité', 'Poste de responsabilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Direction field
            //
            $editor = new TextEdit('direction_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Direction', 'Direction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Division field
            //
            $editor = new TextEdit('division_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Division', 'Division', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Service field
            //
            $editor = new TextEdit('service_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Service', 'Service', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for Situation field
            //
            $editor = new TextEdit('situation_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Situation', 'Situation', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for N° Tél field
            //
            $editor = new TextEdit('n°_tél_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° Tél', 'N° Tél', $editor, $this->dataset);
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
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for Civilité field
            //
            $editor = new TextEdit('civilité_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Civilité', 'Civilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Nom field
            //
            $editor = new TextEdit('nom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom', 'Nom', $editor, $this->dataset);
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
            // Edit column for N° CIN field
            //
            $editor = new TextEdit('n°_cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° CIN', 'N° CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de Naissance field
            //
            $editor = new DateTimeEdit('date_de_naissance_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Naissance', 'Date de Naissance', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date de rectrutement field
            //
            $editor = new DateTimeEdit('date_de_rectrutement_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Rectrutement', 'Date de rectrutement', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Date d'affectation au CRO field
            //
            $editor = new DateTimeEdit('date_d\'affectation_au_cro_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date D\'affectation Au CRO', 'Date d\'affectation au CRO', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'multi_edit_fonctionnairesv2_Corps_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'multi_edit_fonctionnairesv2_Grade_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Poste de responsabilité field
            //
            $editor = new TextEdit('poste_de_responsabilité_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Poste De Responsabilité', 'Poste de responsabilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Direction field
            //
            $editor = new TextEdit('direction_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Direction', 'Direction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Division field
            //
            $editor = new TextEdit('division_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Division', 'Division', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for Service field
            //
            $editor = new TextEdit('service_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Service', 'Service', $editor, $this->dataset);
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
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for Civilité field
            //
            $editor = new TextEdit('civilité_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Civilité', 'Civilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Nom field
            //
            $editor = new TextEdit('nom_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nom', 'Nom', $editor, $this->dataset);
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
            // Edit column for N° CIN field
            //
            $editor = new TextEdit('n°_cin_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('N° CIN', 'N° CIN', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de Naissance field
            //
            $editor = new DateTimeEdit('date_de_naissance_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Naissance', 'Date de Naissance', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date de rectrutement field
            //
            $editor = new DateTimeEdit('date_de_rectrutement_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date De Rectrutement', 'Date de rectrutement', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Date d'affectation au CRO field
            //
            $editor = new DateTimeEdit('date_d\'affectation_au_cro_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Date D\'affectation Au CRO', 'Date d\'affectation au CRO', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Corps', 'Corps', 'Corps_Libelle', 'insert_fonctionnairesv2_Corps_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
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
            $editColumn = new DynamicLookupEditColumn('Grade', 'Grade', 'Grade_Libelle', 'insert_fonctionnairesv2_Grade_search', $editor, $this->dataset, $lookupDataset, 'Libelle', 'Libelle', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Poste de responsabilité field
            //
            $editor = new TextEdit('poste_de_responsabilité_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Poste De Responsabilité', 'Poste de responsabilité', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Direction field
            //
            $editor = new TextEdit('direction_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Direction', 'Direction', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Division field
            //
            $editor = new TextEdit('division_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Division', 'Division', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for Service field
            //
            $editor = new TextEdit('service_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Service', 'Service', $editor, $this->dataset);
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
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for Numéro field
            //
            $column = new NumberViewColumn('Numéro', 'Numéro', 'Numéro', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date de rectrutement field
            //
            $column = new DateTimeViewColumn('Date de rectrutement', 'Date de rectrutement', 'Date De Rectrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Direction field
            //
            $column = new TextViewColumn('Direction', 'Direction', 'Direction', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Division field
            //
            $column = new TextViewColumn('Division', 'Division', 'Division', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Service field
            //
            $column = new TextViewColumn('Service', 'Service', 'Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
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
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for Numéro field
            //
            $column = new NumberViewColumn('Numéro', 'Numéro', 'Numéro', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for Date de rectrutement field
            //
            $column = new DateTimeViewColumn('Date de rectrutement', 'Date de rectrutement', 'Date De Rectrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Direction field
            //
            $column = new TextViewColumn('Direction', 'Direction', 'Direction', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Division field
            //
            $column = new TextViewColumn('Division', 'Division', 'Division', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Service field
            //
            $column = new TextViewColumn('Service', 'Service', 'Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
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
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for Civilité field
            //
            $column = new TextViewColumn('Civilité', 'Civilité', 'Civilité', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Nom field
            //
            $column = new TextViewColumn('Nom', 'Nom', 'Nom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Prenom field
            //
            $column = new TextViewColumn('Prenom', 'Prenom', 'Prenom', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for N° CIN field
            //
            $column = new TextViewColumn('N° CIN', 'N° CIN', 'N° CIN', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date de Naissance field
            //
            $column = new DateTimeViewColumn('Date de Naissance', 'Date de Naissance', 'Date De Naissance', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date de rectrutement field
            //
            $column = new DateTimeViewColumn('Date de rectrutement', 'Date de rectrutement', 'Date De Rectrutement', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Date d'affectation au CRO field
            //
            $column = new DateTimeViewColumn('Date d\'affectation au CRO', 'Date d\'affectation au CRO', 'Date D\'affectation Au CRO', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Corps', 'Corps_Libelle', 'Corps', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Libelle field
            //
            $column = new TextViewColumn('Grade', 'Grade_Libelle', 'Grade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Poste de responsabilité field
            //
            $column = new TextViewColumn('Poste de responsabilité', 'Poste de responsabilité', 'Poste De Responsabilité', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Direction field
            //
            $column = new TextViewColumn('Direction', 'Direction', 'Direction', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Division field
            //
            $column = new TextViewColumn('Division', 'Division', 'Division', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Service field
            //
            $column = new TextViewColumn('Service', 'Service', 'Service', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for Situation field
            //
            $column = new TextViewColumn('Situation', 'Situation', 'Situation', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for N° Tél field
            //
            $column = new TextViewColumn('N° Tél', 'N° Tél', 'N° Tél', $this->dataset);
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
                '`corps`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('ID_Cor', true, true, true),
                    new StringField('Libelle', true),
                    new StringField('Libelle_Arabe', true)
                )
            );
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv2_Corps_search', 'Libelle', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_fonctionnairesv2_Grade_search', 'Libelle', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv2_Corps_search', 'Libelle', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_fonctionnairesv2_Grade_search', 'Libelle', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv2_Corps_search', 'Libelle', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_fonctionnairesv2_Grade_search', 'Libelle', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv2_Corps_search', 'Libelle', 'Libelle', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_fonctionnairesv2_Grade_search', 'Libelle', 'Libelle', null, 20);
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
        $Page = new fonctionnairesv2Page("fonctionnairesv2", "fonctionnairesv2.php", GetCurrentUserPermissionsForPage("fonctionnairesv2"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("fonctionnairesv2"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
