<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('Europe/Dublin');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => '127.0.0.1',
          'port' => '3306',
          'username' => 'root',
          'database' => 'gestion_fonct',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return true;
}

function HasHomePage()
{
    return true;
}

function GetHomeURL()
{
    return 'index.php';
}

function GetHomePageBanner()
{
    return '';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => 'menu', 'description' => '');
    $result[] = array('caption' => 'Paramétrage', 'description' => '');
    $result[] = array('caption' => 'Services', 'description' => '');
    $result[] = array('caption' => 'Demandes de congé', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Gestion des fonctionnaires', 'short_caption' => 'Gestion des fonctionnaires', 'filename' => 'fonctionnairesv3.php', 'name' => 'fonctionnairesv3', 'group_name' => 'menu', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Gestion des demandes de congé', 'short_caption' => 'Gestion des demandes de congé', 'filename' => 'demande_congé_adm.php', 'name' => 'demande_congé_adm', 'group_name' => 'Demandes de congé', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Demandes de congé', 'short_caption' => 'Demandes de congé', 'filename' => 'demande_congé.php', 'name' => 'demande_congé', 'group_name' => 'Services', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Corps', 'short_caption' => 'Corps', 'filename' => 'corps.php', 'name' => 'corps', 'group_name' => 'Paramétrage', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Grade', 'short_caption' => 'Grade', 'filename' => 'grade.php', 'name' => 'grade', 'group_name' => 'Paramétrage', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Direction', 'short_caption' => 'Direction', 'filename' => 'direction.php', 'name' => 'direction', 'group_name' => 'Paramétrage', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Division', 'short_caption' => 'Division', 'filename' => 'division.php', 'name' => 'division', 'group_name' => 'Paramétrage', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Service', 'short_caption' => 'Service', 'filename' => 'service.php', 'name' => 'service', 'group_name' => 'Paramétrage', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Jours Fériés', 'short_caption' => 'Jours Fériés', 'filename' => 'jours_fériés.php', 'name' => 'jours_fériés', 'group_name' => 'Paramétrage', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Demandes de congé rejetées', 'short_caption' => 'Demandes de congé rejetées', 'filename' => 'demande_congé_rejetée.php', 'name' => 'demande_congé_rejetée', 'group_name' => 'Demandes de congé', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Demandes de congé acceptées', 'short_caption' => 'Demandes de congé acceptées', 'filename' => 'demande_congé_acceptée.php', 'name' => 'demande_congé_acceptée', 'group_name' => 'Demandes de congé', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Demande d\'attestation de travail', 'short_caption' => 'Demande d\'attestation de travail', 'filename' => 'attestation_travail_user.php', 'name' => 'attestation_travail_user', 'group_name' => 'Services', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Gestion des demandes d\'attestation de travail', 'short_caption' => 'Gestion des demandes d\'attestation de travail', 'filename' => 'attestation_travail_adm.php', 'name' => 'attestation_travail_adm', 'group_name' => 'menu', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '<span class="navbar-brand">
 <span>
 <img src="logo.png" style="height: 44px; margin-top: -14px;">
 </span>
</span>
<span class="navbar-brand">
 <span class="hidden-xs"><strong>Conseil régional de l\'Oriental</strong></span>
</span>';
}

function GetPagesFooter()
{
    return
        '<div style="text-align: center; font-size: 14px;">
  <p>
    &copy; <span class="copyright">2023-
    <script type="text/javascript">
      document.write(new Date().getFullYear().toString())
    </script></span>
    <a href="https://conseilregionoriental.ma/fr" target="_blank">Conseil régional de l\'Oriental</a>.
    Follow us:
    <a style="font-size: 25px;" class="link-icon" href="https://www.facebook.com/ConseilRegionOriental" target="_blank"><i class="icon-facebook-square"></i></a>
    <a style="font-size: 25px;" class="link-icon" href="https://twitter.com/RegionalConseil?s=08" target="_blank"><i class="icon-twitter"></i></a>
    <a style="font-size: 25px;" class="link-icon" href="https://www.youtube.com/channel/UCfc8IyBsgkunGIQcrKEx0aw" target="_blank"><i class="icon-youtube"></i></a>
  </p>
</div>';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(true);
    $page->setShowNavigation(true);
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1252'; }

function Global_AddEnvironmentVariablesHandler(&$variables)
{

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{

}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{

}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 1;
}

function GetPageListType()
{
    return PageList::TYPE_MENU;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 0;
}

function GetMailer()
{
    $mailerOptions = new MailerOptions(MailerType::Sendmail, '', '');
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MySqlIConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}

/**
 * @param string $pageName
 * @param int|null $userId
 * @param string $userName
 * @param EngConnection $connection
 * @param PermissionSet $permissions
 */
function CustomizePagePermissions($pageName, $userId, $userName, $connection, &$permissions)
{
    if ($pageName == 'attestation_travail_user') {
        if ($userId == 1) {
            $permissions->setGrants(false, false, false, false);
        }
    }
    
    if ($pageName == 'demande_congé') {
        $currentDate = new DateTime();
        $sql = 
         "SELECT `Date de retour` " .
         "FROM `demande_congé` " .
         "WHERE `user_id` = '$userId' AND `Status` = 'Accéptée'";
        $queryResult = $connection->fetchAll($sql);
        
        if (!empty($queryResult)) {
            foreach ($queryResult as $row) {
                $dateRetour = DateTime::createFromFormat('Y-m-d', $row['Date de retour']);
                if ($currentDate < $dateRetour) {
                    $permissions->setAddGrant(false);
                    break;
                }
            }
        }
        
        $sqlSoldeNull = "SELECT `Solde de Congé` " .
                       "FROM `fonctionnairesv3` " .
                       "WHERE `Numéro` = '$userId'";
        
        $queryResult = $connection->fetchAll($sqlSoldeNull);
        
        if (!empty($queryResult)) {
            foreach ($queryResult as $row) {
                if ($row['Solde de Congé'] === NULL || is_null($row['Solde de Congé'])) {
                    $permissions->setAddGrant(false);
                    break; 
                }
            }
        }
        
        
        
        if  (GetApplication()->IsLoggedInAsAdmin())  {
            $permissions->setGrants(false, false, false, false);
        }
    }
    
    if ($pageName == 'jours_fériés') {
        if ($userId === 1) {
           $permissions->setGrants(true, true, true, true);
        }
    }
}

/**
 * @param string $pageName
 * @return IPermissionSet
 */
function GetCurrentUserPermissionsForPage($pageName) 
{
    $originalPermissions = GetApplication()->GetCurrentUserPermissionSet($pageName);
    $customPermissions = new PermissionSet(
        $originalPermissions->HasViewGrant(), 
        $originalPermissions->HasEditGrant(),
        $originalPermissions->HasAddGrant(),
        $originalPermissions->HasDeleteGrant(),
        $originalPermissions->HasAdminGrant()
    );
    $connection = createConnection();
    $connection->Connect();
    $userId = GetApplication()->GetCurrentUserId();
    $userName = GetApplication()->GetCurrentUser();
    CustomizePagePermissions($pageName, $userId, $userName, $connection, $customPermissions);
    return $customPermissions;
}
