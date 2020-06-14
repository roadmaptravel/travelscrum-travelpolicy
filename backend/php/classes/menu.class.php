<?php
    
class Menu implements Iterator {

    private $table = 'pages';    
    private $_items = array ();
    
    public function __construct ($type = '') {
        
        $config = Config::getInstance ();
        
        if (!isset ($config['menus'][$type]) || !$config['menus'][$type]) {
            
            throw new Exception ('Menu could not be found in settings.');
            
        }
        
        $this->_load ($config['menus'][$type]);
        
    }
    
    private function _load ($selector) {
        
        $fpdo = DB::getBuilder ();
        
        $query = $fpdo->from ($this->table)
                        ->select (null)
                        ->select ('id')
                        ->where ('deleted', null)
                        ->where ('active', 1)
                        ->where ($selector, 1)
                        ->orderBy ('menuOrder ASC');

        $success = $query->execute ();
        
        
        
        if ($success) {
            
            foreach ($query as $page) {
                
                $this->_items[] = new Page ($page['id']);
                
            }
            
        }     
        
        return false;          
        
    }
    
    
    public function rewind() {
        
        reset($this->_items);
        
    }
    
    public function current() {
        
        $var = current($this->_items);

        return $var;
        
    }

    public function key()  {
        
        $var = key($this->_items);

        return $var;
        
    }
    
    public function next()  {
    
        $var = next($this->_items);

        return $var;
        
    }
    
    public function valid() {
        
        $key = key($this->_items);
        $var = ($key !== NULL && $key !== FALSE);

                
        if ($var && !$this->_items[$key] instanceof Page) 
            $var = false;

        return $var;
        
    }
    
}