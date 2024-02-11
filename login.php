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
include_once dirname(__FILE__) . '/components/page/login_page.php';
include_once dirname(__FILE__) . '/authorization.php';
include_once dirname(__FILE__) . '/database_engine/mysql_engine.php';
include_once dirname(__FILE__) . '/components/security/user_identity_storage/user_identity_session_storage.php';

function GetConnectionOptions() {
    $result = GetGlobalConnectionOptions();
    $result['client_encoding'] = 'utf8';
    return $result;
}

function OnAfterLogin($userName, EngConnection $connection, &$canLogin, &$errorMessage) {
    /*$sql = "SELECT failed_login_attempts FROM phpgen_users WHERE user_name='$userName'";
    $failedLoginAttempts = $connection->ExecScalarSQL($sql);
    if ($failedLoginAttempts >= 3) {
     $canLogin = false;
     $errorMessage =
     "Dear $userName, your account is locked due to too many failed login attempts.";
    } else {
     $sql = "UPDATE phpgen_users SET failed_login_attempts = 0 WHERE user_name='$userName'";
     $connection->ExecSQL($sql);
    }*/
}

function OnAfterFailedLoginAttempt($userName, EngConnection $connection, &$errorMessage) {
    /*// Check if user exists
    $sql = "SELECT count(*) FROM phpgen_users WHERE user_name='$userName'";
    $userExists = $connection->ExecScalarSQL($sql);
    if ($userExists == 0) {
     exit;
    }
    // Retrieve a number of previous failed login attempts
    $sql = "SELECT failed_login_attempts FROM phpgen_users WHERE user_name='$userName'";
    $failedLoginAttempts = $connection->ExecScalarSQL($sql);
    // Add a current failed login attempt
    $failedLoginAttempts++;
    // Display message based on a number of failed login attempts
    if ($failedLoginAttempts == 2) {
     $errorMessage = 'You have one attempt left before your account will be locked.';
    } elseif ($failedLoginAttempts == 3) {
     $errorMessage = 'Too many failed login attempts. Your account has been locked.';
    } elseif ($failedLoginAttempts > 3) {
     $errorMessage =
     "Dear $userName, your account is locked due to too many failed login attempts. " .
     'Please contact our support team.';
    }
    // Update a number of failed login attempts in users table
    if ($failedLoginAttempts <= 3) {
     $sql =
     "UPDATE phpgen_users " .
     "SET failed_login_attempts = $failedLoginAttempts " .
     "WHERE user_name='$userName'";
     $connection->ExecSQL($sql);
    }*/
}

function OnBeforeLogout($userName, EngConnection $connection) {
    $sql = "UPDATE `phpgen_users` SET `count_reload_page` = 0 WHERE `user_id` = 1";
    $connection->ExecSQL($sql);
}

SetUpUserAuthorization();

$page = new LoginPage(
    'graphe.php',
    dirname(__FILE__),
    GetApplication()->GetUserAuthentication(),
    MySqlIConnectionFactory::getInstance(),
    Captions::getInstance('UTF-8'),
    GetReCaptcha('login'),
    ''
);


$page->OnAfterLogin->AddListener('OnAfterLogin');
$page->OnAfterFailedLoginAttempt->AddListener('OnAfterFailedLoginAttempt');
$page->OnBeforeLogout->AddListener('OnBeforeLogout');
$page->BeginRender();
$page->EndRender();
