<?php
    
    $settings = array ();
    

    $settings['menus'] = array (

        'header' => 'showInHeader'
        
    );
    
    $settings['images']['upload_dir']   = '/assets/userdata/images/';
    
    $fpdo = DB::getBuilder ();
    
    $query = $fpdo->from ('settings');
    
    foreach ($query as $row) {
        
        $settings[$row['section']][$row['var']] = $row['value'];
        
    }
    
    return $settings;