<?php
	
if (!session_id ())
    session_start ();
    
ob_start ();


$baseDir = realpath (dirname (__DIR__) . '/../../') . '/';
define ('baseDir',  $baseDir);

require_once baseDir . 'backend/php/classes/FluentPDO/FluentPDO.php';
require_once baseDir . 'backend/php/classes/app.class.php';

require_once baseDir . 'backend/php/classes/user.class.php';
require_once baseDir . 'backend/php/classes/security.class.php';
require_once baseDir . 'backend/php/classes/db.class.php';
require_once baseDir . 'backend/php/classes/config.class.php';
require_once baseDir . 'backend/php/classes/api.class.php';
require_once baseDir . 'backend/php/classes/menu.class.php';
require_once baseDir . 'backend/php/classes/atpco.class.php';
require_once baseDir . 'backend/php/classes/covidcontrols.class.php';
require_once baseDir . 'backend/php/classes/settings.class.php';

require_once baseDir . 'backend/php/classes/template/template.class.php';

require_once baseDir . 'backend/config/config.php';

$rootDir = realpath (dirname (__DIR__) . '/../../../') . '/'. pathToWebsite .'/';
define ('rootDir',  $rootDir);




$template = Template::start ();
$template->setTheme (THEME_DIR);

$template->pagetitle = CMS_NAME .' - '. SITE_NAME .' - '. SITE_URL;

try {
    
    DB::getConnection ();
    
    Config::setFile (baseDir . 'backend/php/include/settings.php');
    
    $auth = new Auth;
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset ($_POST['action']) && $_POST['action'] == 'login') {
        
        if ($auth->login ($_POST['username'], $_POST['password']) === Auth::LOGGEDIN) {
            
            header ('HTTP/1.1 301 Moved Permanently');
            header ('Location: index.html');
            exit;
            
        } else {
            
            $loginError = true;
            
            $errorMessage = 'loginfailed';
            
        }
        
    }
    
    if (isset ($_GET['logout'])) {
        
        $auth->logout ();
        
        header ('HTTP/1.1 301 Moved Permanently');
        header ('Location: index.html?loggedout=true');
        exit;
        
    }
    
    if ($auth->status ()) {
        
        $user = new User ($_SESSION['user_id']);
        
        define ('USER_NAME', $user->firstName .' '. $user->lastName);
        
    }
    
} catch (Exception $e) {
    
    $template->showError ($e);
    
}