<?php

class Auth {

    const LOGGEDIN = true;
    const NOTLOGGEDIN = false;

    protected $_data = array (
        'loggedin' => false
    );
    
    protected $data = array ();
    
    public function __construct () {
        
        // When started, check if login is correct
        $this->checkStatus ();
        
        return $this;
        
    }
    
    public function __get ($name) {
        
        if (isset ($this->_data[$name])) {
            
            return $this->_data[$name];
            
        } else {
            
            return $this->data[$name];
            
        }
        
    }
    
    public function __set ($name, $value) {
        
        if (isset ($this->_data[$name])) {
            
            throw new Exception ("Not allowed to set variable ". $name);
            
        } else {
            
            $this->data[$name] = $value;
            
        }
        
    }
    
    public function login ($username, $password) {
        
        $data = User::checkCredentials ($username, $password);
        
        if ($data[0] && $data[1]) {
            
            $_SESSION['user_id'] = $data[0];
            $_SESSION['username'] = $data[2];
            $_SESSION['digest'] = $data[1];
            $_SESSION['secondDigest'] = DB::crypt ($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
            
            if ($this->checkStatus ()) {
	            
	            User::updateLastLogin ($data[0]);
	            return true;
	            
            } else {
	            
	            return false;
	            
            }
            
        } else {
            
            return false;
            
        }
        
    } 
    
    public function logout () {
        
        $_SESSION['user_id'] = false;
        $_SESSION['username'] = false;
        $_SESSION['digest'] = false;
        $_SESSION['secondDigest'] = false;
        
        unset ($_SESSION);
        
    }
    
    
    public function checkStatus () {
    
        
        if (!isset ($_SESSION['user_id'])) {
            
            return false;
            
        }
        
        if (!isset ($_SESSION['secondDigest'])) {
            
            return false;
            
        }
        
        if (!isset ($_SESSION['username'])) {
            
            return false;
            
        }
        
        if (!isset ($_SESSION['digest'])) {
            
            return false;
            
        }
        
        if ($_SESSION['secondDigest'] != crypt ($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'], $_SESSION['secondDigest'])) {
            
            return false;
            
        }
        $data = User::checkCredentials ($_SESSION['username'], $_SESSION['digest'], true);
        
        $this->_data['loggedin'] = $data[0] ? Auth::LOGGEDIN : Auth::NOTLOGGEDIN;
        
        return (bool) $this->_data['loggedin'] == Auth::LOGGEDIN;
        
    }
    
    public function status () {
        
        return (bool) $this->_data['loggedin'] == Auth::LOGGEDIN;
        
    }
    
}