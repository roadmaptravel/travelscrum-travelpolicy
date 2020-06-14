<?php

class DB {
    
    private static $inst;
    private static $builderInst;
    
    public static function crypt ($password, $length = 10) {
        
        $chars = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $salt = sprintf ('$2a$%02d$', $length);
        
        for ($i=0; $i < 22; $i++) {
        
            $salt .= $chars[rand (0,63)];
            
        }
        
        return crypt ($password, $salt);
        
    }
    
    public static function getConnection()
    {
        static $inst = null;
        
        if ($inst === null) {
            
            try {
            
            $dbh = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
            
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            
            } catch (Exception $e) {
                
                throw new Exception ($e->getMessage (), 4001);
                
            }
            
            $inst = $dbh;
        }
        
        return $inst;
    }
    
    public static function getBuilder() 
    {
        
        static $builderInst = null;
        
        if ($builderInst === null) {
            
            if (self::$inst === null) {
                
                $inst = DB::getConnection ();
                
            }
            
            
            $fPDO = new FluentPDO ($inst);
            /*
$fPDO->debug = function($BaseQuery) {
            	echo "query: " . $BaseQuery->getQuery(false) . "\n";
            	echo "parameters: " . implode(', ', $BaseQuery->getParameters()) . "\n";
            	echo "rowCount: " . $BaseQuery->getResult()->rowCount() . "\n";
            	// time is impossible to test (each time is other)
            	// echo $FluentQuery->getTime() . "\n";
            };
*/
            
            $builderInst = $fPDO;
        }
        
        return $builderInst;
        
    }
    
}

function show ($query) {
    
    echo $query;
    
}