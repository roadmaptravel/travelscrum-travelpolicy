<?php
    
    class Template {
        
        protected static $_instance = null;
        
        public $replacer = '[[%s]]';
        
        private $page, $theme;
        private $pageBlocks = array ();
        private $variables = array ();
        
        private function __construct () { }
        
        public static function start()
        {
            if (self::$_instance === null) {
                $c = __CLASS__;
                self::$_instance = new $c;
            } //if
            
            return self::$_instance;
        }
        
        public function setTheme ($theme) {
            
            if (!is_dir (baseDir . 'backend/template/' . $theme .'/')) {
                
                throw new Exception ("Theme could not be found.");
                
            }
            
            $this->theme = $theme;
            
        }
        
        public function __set ($var, $value) {
            
            $this->variables[$var] = $value;
            
        }
        
        public function setPage ($page) {
            
            if (!file_exists (baseDir . 'backend/template/' . $this->theme .'/' . $page)) {
                
                throw new Exception ("Theme could not be found.");
                
            }
            
            $this->page = $page;
            
        }
        
        public function showError (Exception $e) {
            
            $this->setPage ('errors/base.html');
            
            $this->__set ('errorMsg', $e->getMessage ());
            $this->__set ('errorCode', $e->getCode ());
            
            if ($e->getCode () && file_exists (baseDir . 'backend/template/' . $this->theme .'/errors/' . $e->getCode () . '.html')) {
            
                $this->loadPageBlock ('content', 'errors/' . $e->getCode () . '.html');
                
            } else {
                
                $this->loadPageBlock ('content', 'errors/message.html');
                
            }
            
            ob_end_clean ();
            
            $this->parse ();
            exit;
            
            
        }
        
        public function loadPageBlock ($var, $page) {
            
            
            $this->pageBlocks[$var] = file_get_contents (baseDir . 'backend/template/' . $this->theme . '/'. $page);
            
        }
        
        public function parse ($output = true) {
            
            $html = file_get_contents (baseDir . 'backend/template/'. $this->theme .'/'. $this->page);
            
            foreach ($this->pageBlocks as $var => $block) {
                
                $html = str_replace (sprintf ($this->replacer, $var), $block, $html);
                
            }
            
            foreach ($this->variables as $var => $content) {
                
                $html = str_replace (sprintf ($this->replacer, $var), $content, $html);
                
            }
            
            if ($output === true) {
                
                echo $html;
                
            } else {
                
                return $html;
                
            }
            
        }
        
        public static function field ($type) {
            
            $className = ucfirst (strtolower ($type)) . 'Field';
            
            if (!class_exists ($className)) {
                
                throw new Exception ("Field element '". $className ."' does not exist.");
                
            }
            
            return new $className;
            
        }
        
    }
    
    interface Field {
        
        public function toHTML ();
        
    }
    
    class FieldElement {
        
        public $id;
        public $name;
        public $value = '';
        public $required = false;
        public $classes = array ('form-control');
        
        public $prefix = '<div class="form-group">';
        public $suffix = '</div>';
        
        public $showLabel = true;
        public $labelSize = 2;
        public $fieldSize = 10;
        
        public $placeholder = false;
        public $labelText = '';
        
        public function showLabel () { 
            
            $this->showLabel = true;
            
            return $this;
            
        }
        
        public function hideLabel () { 
            
            $this->showLabel = false;
            
            return $this;
            
        }
        
        public function required ($value) {
            
            $this->required = (bool) $value;
            
            return $this;
            
        }
        
        public function addClass ($className) { 
            
            if (!isset ($this->classes[$className])) {
                
                $this->classes[] = $className;
                
            }
            
            return $this;
            
        }
        
        public function removeClass ($className) {
            
            if (isset ($this->classes[$className])) {
                
                unset ($this->classes[$className]);
                
            }
            
            return $this;
            
        }
        
        public function label () {
            
            if (!$this->showLabel) {
                
                return '<label class="control-label col-md-'. $this->labelSize .' col-sm-'. $this->labelSize .'" for="'. $this->id .'">&nbsp</label>';
                
            }
            
            return '<label class="control-label col-md-'. $this->labelSize .' col-sm-'. $this->labelSize .'" for="'. $this->id .'">'. 
                        $this->labelText .
                    ' ' . ($this->required ? '*' : '') . 
                    ' :</label>';
            
        }
        
        public function start () {
            
            return '<div class="col-md-'. $this->fieldSize .' col-sm-'. $this->fieldSize .'">';
            
        }
        
        public function end () {
            
            return '</div>';
            
        }
        
        public function isRequired () {
            
            return ($this->required ? ' required' : '');
            
        }

        public function __toString () {
            
            $html  = $this->prefix;
            $html .= $this->label ();
            $html .= $this->start ();
            
            $html .= $this->toHTML ();
            
            $html .= $this->end ();
            $html .= $this->suffix;
            
            return $html;
            
        }
        
        public function placeholder () {
            
            if ($this->placeholder) {
                
                return ' placeholder="'. $this->placeholder .'" ';
                
            }
            
        }
        
    }
    
    class TextField extends FieldElement implements Field {
        
        public $rows = 10;
        
        
        public function toHTML () {
            
            $classes = implode (' ', $this->classes);
            
            $html = '<textarea '. $this->isRequired () .' name="'. $this->name .'" id="'. $this->id .'" class="'. $classes .'" rows="'. $this->rows .'">'. $this->value .'</textarea> ';
            
            return $html;
            
        }
        
    }
    
    class HtmlField extends TextField implements Field {
        
        public $rows = 10;
        
        public function __construct () {
            
            $this->classes[] = 'wysiwyg-editor';
            
        }
        
    }
    
    class InputField extends FieldElement implements Field {
        
        public $rows = 10;
        
        public function toHTML () {
            
            $classes = implode (' ', $this->classes);
            
            $html = '<input type="text" '. $this->placeholder () .' '. $this->isRequired () .' name="'. $this->name .'" id="'. $this->id .'" class="'. $classes .'" value="'. $this->value .'" />';
            
            return $html;
            
        }
        
    }
    
    class ImageField extends FieldElement implements Field {
        
        public function toHTML () {
            
            $classes = implode (' ', $this->classes);
            
            $html = '<div class="input-group">';
            
            $moxman = 'moxman.browse({fields: \''. $this->id .'\'});'; 
            
            $html .= '<span class="input-group-addon"><a href="javascript:;" onclick="'. $moxman .'" class="fa fa-image"></a></span>';
            $html .= '<input class="'. $classes .'" type="text" id="'. $this->id .'" name="'. $this->name .'" '. $this->isRequired () .' '. $this->placeholder () .' value="'. $this->value .'" />';
            
            
            $html .= '</div>';
            
            return $html;
            
        }
        
        
    }
    
    class SelectField implements Field {
        
        
        public function toHTML () {
            
            return 'select field';
            
        }
        
    }
    
    class BooleanField extends FieldElement implements Field {
        
        
        public function toHTML () {
            
            $checked1 = $this->value ? ' checked' : '';
            $checked2 = !$this->value ? ' checked' : '';
            
            $html = '<label class="radio-inline">' . 
                        '<input type="radio" name="'. $this->name .'" id="'. $this->id .'" '. $checked1 .' value="1" /> Yes' .
                     '</label>';
            $html .= '<label class="radio-inline">' . 
                        '<input type="radio" name="'. $this->name .'" '. $checked2 .' value="0" /> No' . 
                      '</labe>';
            
            return $html;
            
        }
        
    }
    
    class RadioField implements Field {
        
        public function toHTML () {
            
            return 'radio field';
            
        }
        
        
    }
    
    class ButtonField extends FieldElement implements Field {
        
        public $type = 'button';
        
        public function __construct () {
            
            $this->classes[] = 'btn';
            $this->classes[] = 'btn-lg';
            $this->classes[] = 'btn-success';
            
        }
        
        public function toHTML () {
            
            $classes = implode (' ', $this->classes);
            
            return '<button type="'. $this->type .'" id="'. $this->id .'" class="'. $classes .'">'. $this->value .'</button>';
            
        }
        
    }