<?php
    
    class Setting implements Iterator {
        
        private $_items = array ();
        protected $table  = 'settings';
        
        public function __construct () {
            
            $fpdo = DB::getBuilder ();
            
            $query = $fpdo->from ($this->table)->execute ();
            
            foreach ($query as $row) {
                
                
                $className = 'SettingItem' . ucfirst (strtolower ($row['type']));
                
                if (!class_exists ($className)) {
                    
                    throw new Exception ('Setting with type '. $row['type'] .' does not exist');
                    
                }
                
                $this->_items[] = new $className($row);
                
            }
            
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
    
                    
            if ($var && !$this->_items[$key] instanceof SettingItem) 
                $var = false;
    
            return $var;
            
        }
        
    }
    
    class SettingItem extends Setting {
        
        private $properties;
        private $updatedProperties;
        
        public function __construct ($properties) {
            
            $this->properties = $properties;
            
        }
        
        public function __get ($var) {
            
            if (isset ($this->updatedProperties[$var])) {
                
                return $this->updatedProperties[$var];
                
            }
            
            return isset ($this->properties[$var]) ? $this->properties[$var] : '';
            
        }
        
        public function value ($val) {
            
            $this->updatedProperties['value'] = $val;
            
        }
        
        public function __set ($var, $value) {
            
            throw new Exception ('It is not possible to set a property like this.');
            
        }
        
        public function save () {
            
            $fpdo = DB::getBuilder ();
            
            $data = $this->updatedProperties;
            $data['lastModified'] = new FluentLiteral ('NOW()');
            $data['lastModifiedBy'] = USER_NAME;
            
            $success = $fpdo->update ($this->table)->set ($data)->where ('id', $this->properties['id'])->execute ();
                
            return (bool) $success;
            
            
        }
        
    }
    
    
    class SettingItemHtml extends SettingItem {
        
        
        
    }
    
    class SettingItemInput extends SettingItem {
        
        
        
    }
    
    class SettingItemBoolean extends SettingItem {
        
        
        
    }
    
    class SettingItemText extends SettingItem {
        
        
        
    }
    
    class SettingItemImage extends SettingItem {
        
        
        
    }