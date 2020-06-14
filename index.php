<?php
error_reporting (E_ALL);
ini_set ('display_errors', 1);
require_once './backend/php/include/header.php';

if ($auth->loggedin !== Auth::LOGGEDIN) {

    require_once './backend/html/login.php';
 
    exit;   
}

require_once './backend/html/head.php';

try {
    
    if (isset ($_GET['route'])) 
    {
        
        if (isset ($Modules[$_GET['route']]))
        {
            
            $Module = $Modules[$_GET['route']];
            
            if ($Module['custom']) 
            {
                $page = 'custom/' . $Module['moduleFile'];
            }
            else
            {
                $page = $Module['moduleFile'];
            }
            
        }
        else
        {
            $page = 'index.php';
        }
    
    }
    else
    {
        
        $page = 'index.php';
        
    }
    
    
    if (file_exists ('./backend/php/pages/'. $page))
    {
    
        require_once './backend/php/pages/' . $page;
        
    }
    else
    {
    
        require_once './backend/php/pages/index.php';
    
    }

} catch (Exception $e) {
    
    if ($template instanceof Template) {
        $template->showError ($e);
    } else {
        
        echo $e->getMessage ();
        exit;
        
    }
    
}
    
require_once './backend/html/foot.php';