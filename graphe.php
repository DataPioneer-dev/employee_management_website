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
    
    
    
    class graphePage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Dashboard');
            $this->SetMenuLabel('Dashboard');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`graphe`');
            $this->dataset->addFields(
                array(
                    new StringField('Nom', true),
                    new IntegerField('Age', true, true)
                )
            );
        }
    
        protected function DoPrepare() {
            $this->setShowGrid(false);
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
            $sql = 'SELECT `Nom`, `Age` FROM `fonctionnairesv3`';
            $chart = new Chart('Age_distribution', Chart::TYPE_HISTOGRAM, $this->dataset, $sql);
            $chart->setTitle('');
            $chart->setHeight(600);
            $chart->addDataColumn('Nom', 'Nom', 'string');
            $chart->addDataColumn('Age', 'Age', 'number');
            $this->addChart($chart, 0, ChartPosition::BEFORE_GRID, 12);
            
            $sql = 'SELECT `Status`, COUNT(`demande_id`) as total_demands FROM `demande_congé_adm` GROUP BY `Status`';
            $chart = new Chart('demands_status', Chart::TYPE_PIE, $this->dataset, $sql);
            $chart->setTitle('Status des demandes');
            $chart->setHeight(400);
            $chart->setDomainColumn('Status', 'Status', 'string');
            $chart->addDataColumn('total_demands', 'Total des demandes ', 'int');
            $this->addChart($chart, 1, ChartPosition::BEFORE_GRID, 6);
            
            $sql = 'SELECT `Type`, COUNT(demande_id) as total_demands FROM `demande_congé_adm` GROUP BY `Type`';
            $chart = new Chart('demands_type', Chart::TYPE_PIE, $this->dataset, $sql);
            $chart->setTitle('Types des demandes');
            $chart->setHeight(400);
            $chart->setDomainColumn('Type', 'Type', 'string');
            $chart->addDataColumn('total_demands', 'Total des demandes', 'int');
            $this->addChart($chart, 2, ChartPosition::BEFORE_GRID, 6);
            
            $sql = 'SELECT
                d.`Date de demande` AS DateDepart,
                (SELECT SUM(`Nombre de jours demandés`) FROM `demande_congé_adm` WHERE `Type` = \'Annuelle\' AND `Status` = \'Accéptée\' AND `Date de demande` <= DateDepart) AS Total_Annuelle,
                (SELECT SUM(`Nombre de jours demandés`) FROM `demande_congé_adm` WHERE `Type` = \'Exceptionnelle\' AND `Status` = \'Accéptée\' AND `Date de demande` <= DateDepart) AS Total_Excep
            FROM
                `demande_congé_adm` d
            GROUP BY
                `Date de demande`';
            $chart = new Chart('Conge_consomme', Chart::TYPE_LINE, $this->dataset, $sql);
            $chart->setTitle('Le nombre de jours de congé consommés');
            $chart->setHeight(300);
            $chart->setDomainColumn('DateDepart', 'DateDepart', 'date');
            $chart->addDataColumn('Total_Annuelle', 'Congé Annuel', 'int');
            $chart->addDataColumn('Total_Excep', 'Congé Exceptionnel', 'int');
            $this->addChart($chart, 3, ChartPosition::BEFORE_GRID, 12);
            
            $sql = 'SELECT
                a.`Libelle`,
                SUM(CASE WHEN b.`Civilité` = \'M\' THEN 1 ELSE 0 END) AS Nombre_M,
                SUM(CASE WHEN b.`Civilité` = \'Mme\' THEN 1 ELSE 0 END) AS Nombre_Mme
            FROM
                `corps` a
            INNER JOIN
                `fonctionnairesv3` b ON a.`Libelle` = b.`Corps`
            GROUP BY
                a.`Libelle`';
            $chart = new Chart('Corps_M_Mme', Chart::TYPE_BAR, $this->dataset, $sql);
            $chart->setTitle('Nombre des femmes et des hommes dans chaque corps');
            $chart->setHeight(500);
            $chart->setDomainColumn('Libelle', 'Libelle', 'string');
            $chart->addDataColumn('Nombre_M', 'Homme', 'int');
            $chart->addDataColumn('Nombre_Mme', 'Femme', 'int');
            $this->addChart($chart, 4, ChartPosition::BEFORE_GRID, 12);
            
            $sql = 'SELECT
                a.`Libelle`,
                SUM(CASE WHEN b.`Civilité` = \'M\' THEN 1 ELSE 0 END) AS Nombre_M,
                SUM(CASE WHEN b.`Civilité` = \'Mme\' THEN 1 ELSE 0 END) AS Nombre_Mme
            FROM
                `grade` a
            INNER JOIN
                `fonctionnairesv3` b ON a.`Libelle` = b.`Grade`
            GROUP BY
                a.`Libelle`';
            $chart = new Chart('Grade_M_Mme', Chart::TYPE_COLUMN, $this->dataset, $sql);
            $chart->setTitle('Nombre des femmes et des hommes dans chaque grade');
            $chart->setHeight(500);
            $chart->setDomainColumn('Libelle', 'Libelle', 'string');
            $chart->addDataColumn('Nombre_M', 'Homme', 'int');
            $chart->addDataColumn('Nombre_Mme', 'Femme', 'int');
            $this->addChart($chart, 5, ChartPosition::BEFORE_GRID, 12);
            
            $sql = 'SELECT
                a.`Libelle`,
                SUM(CASE WHEN b.`Civilité` = \'M\' THEN 1 ELSE 0 END) AS Nombre_M,
                SUM(CASE WHEN b.`Civilité` = \'Mme\' THEN 1 ELSE 0 END) AS Nombre_Mme
            FROM
                `direction` a
            INNER JOIN
                `fonctionnairesv3` b ON a.`Libelle` = b.`Direction`
            GROUP BY
                a.`Libelle`';
            $chart = new Chart('Direction_M_Mme', Chart::TYPE_BAR, $this->dataset, $sql);
            $chart->setTitle('Nombre des femmes et des hommes dans chaque direction');
            $chart->setHeight(500);
            $chart->setDomainColumn('Libelle', 'Libelle', 'string');
            $chart->addDataColumn('Nombre_M', 'Homme', 'int');
            $chart->addDataColumn('Nombre_Mme', 'Femme', 'int');
            $this->addChart($chart, 6, ChartPosition::BEFORE_GRID, 12);
            
            $sql = 'SELECT
                a.`Nom_Div`,
                SUM(CASE WHEN b.`Civilité` = \'M\' THEN 1 ELSE 0 END) AS Nombre_M,
                SUM(CASE WHEN b.`Civilité` = \'Mme\' THEN 1 ELSE 0 END) AS Nombre_Mme
            FROM
                `division` a
            INNER JOIN
                `fonctionnairesv3` b ON a.`Nom_Div` = b.`Division`
            GROUP BY
                a.`Nom_Div`';
            $chart = new Chart('Division_M_Mme', Chart::TYPE_BAR, $this->dataset, $sql);
            $chart->setTitle('Nombre des femmes et des hommes dans chaque division');
            $chart->setHeight(500);
            $chart->setDomainColumn('Nom_Div', 'Nom_Div', 'string');
            $chart->addDataColumn('Nombre_M', 'Homme', 'int');
            $chart->addDataColumn('Nombre_Mme', 'Femme', 'int');
            $this->addChart($chart, 7, ChartPosition::BEFORE_GRID, 12);
            
            $sql = 'SELECT
                a.`Nom_Serv`,
                SUM(CASE WHEN b.`Civilité` = \'M\' THEN 1 ELSE 0 END) AS Nombre_M,
                SUM(CASE WHEN b.`Civilité` = \'Mme\' THEN 1 ELSE 0 END) AS Nombre_Mme
            FROM
                `service` a
            INNER JOIN
                `fonctionnairesv3` b ON a.`Nom_Serv` = b.`Service`
            GROUP BY
                a.`Nom_Serv`';
            $chart = new Chart('Service_M_Mme', Chart::TYPE_COLUMN, $this->dataset, $sql);
            $chart->setTitle('Nombre des femmes et des hommes dans chaque service');
            $chart->setHeight(600);
            $chart->setDomainColumn('Nom_Serv', 'Nom_Serv', 'string');
            $chart->addDataColumn('Nombre_M', 'Homme', 'int');
            $chart->addDataColumn('Nombre_Mme', 'Femme', 'int');
            $this->addChart($chart, 8, ChartPosition::BEFORE_GRID, 12);
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'Nom', 'Nom', 'Nom'),
                new FilterColumn($this->dataset, 'Age', 'Age', 'Age')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
    
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
    
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
    
        }
    
        protected function AddEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
    
            $grid->SetShowAddButton(false && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
    
        }
    
        protected function AddExportColumns(Grid $grid)
        {
    
        }
    
        private function AddCompareColumns(Grid $grid)
        {
    
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
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && false);
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
    
        }
    
        protected function doRegisterHandlers() {
            
            
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
            if ($chart->getId() == 'Age_distribution') {
                $chart->setOptions(array(
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
                ));
            } 
            
            if ($chart->getId() == 'demands_status' || $chart->getId() == 'demands_type') {
                $chart->setOptions(array(
                    'is3D' => true,
                    'slices' => array(1 => array('offset' => 0.3)),
                    'legend' => array('position' => 'left')
                ));
            }
            
            if ($chart->getId() === 'Corps_M_Mme' || $chart->getId() === 'Direction_M_Mme' || $chart->getId() === 'Division_M_Mme') {
                $chart->setOptions(array(
                    'legend' => array('position' => 'bottom'),
                    'hAxis' => array('format' => '0'),
                    'vAxis' => array('textStyle' => array('fontSize' => '15')),
                ));
            } 
            
            if ($chart->getId() === 'Grade_M_Mme' || $chart->getId() === 'Service_M_Mme') {
                $chart->setOptions(array(
                    'chartArea' => array(
                        'width' => '80%',
                        'height' => '75%'
                    ),
                    'vAxis' => array(
                        'format' => '0'
                    ),
                ));
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
        $Page = new graphePage("graphe", "graphe.php", GetCurrentUserPermissionsForPage("graphe"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("graphe"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
