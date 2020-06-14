<?php
    
final class API {
    
    private $_data = array (
        'file' => 'json',
    	'f'	=> 'get_data',
    	't' => '',
    	't_id' => '',
    	'p'	=> 0,
    	'full' => 1
    );
    
    public static function Instance() {
        
        static $inst = null;
        if ($inst === null) {
            
            $config = Config::getInstance();
            
            $inst = new API ($config['knkvapi']['url'], $config['knkvapi']['key']);
            
        }
        
        return $inst;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct($url, $key) {

        $this->url = rtrim ($url, '/') . '/' . $key .'/json/';

    }
    
    public function getStandings () {
        
        $this->_data['t'] = 'standing';
        
        return $this->call ();
        
    }
    
    public function getProgram () {
        
        $this->_data['t'] = 'program';
        
        return $this->call ();
        
    }
    
    public function get ($type) {
        
        $dbh = DB::getConnection ();
        
        $stmt = $dbh->prepare ("SELECT * FROM api_data WHERE id = :id LIMIT 1");
        
        $stmt->bindParam (':id', $type, PDO::PARAM_STR);
        
        $stmt->execute ();
        $data = $stmt->fetch (PDO::FETCH_NAMED);
        
        return $data;
        
    }
    
    public function update ($type, $result = false) {
        
        $dbh = DB::getConnection ();
        
        $stmt = $dbh->prepare ("INSERT INTO api_data SET id = :id, data = :data2, last_update = NOW() ON DUPLICATE KEY UPDATE data = :data, last_update = NOW()");
        
        $result = $result === false ? $this->response : $result;
        
        $stmt->bindParam (':id', $type, PDO::PARAM_STR);
        $stmt->bindParam (':data', $result, PDO::PARAM_STR);
        $stmt->bindParam (':data2', $result, PDO::PARAM_STR);
    
        return $stmt->execute ();
        
    }
    
    private function call () {
        
        //open connection
        $ch = curl_init();
        
        //loop through post fields
        $field_string = '';
        
        foreach ($this->_data as $key => $value) { 
            $fields_string .= $key.'='.$value.'&'; 
        }
        
        rtrim ($fields_string, '&');
        
        //set the url, number of POST vars, POST data
        curl_setopt ($ch, CURLOPT_URL, $this->url);
        curl_setopt ($ch, CURLOPT_POST, count($this->_data));
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        
        $result = curl_exec($ch);
        
        return $this->parse ($result);
        
    }
    
    private function parse ($result) {
        
        if (strpos($result, 'clubplugin') === false) {
            
            $this->response = $result;
            
            return true;
            
        } else {
            
            $this->setError ($result);
            
            return false;
            
        }
        
    }
    
    private function setError ($error) {
        
        $error  = str_replace ('alert(', '', $error);
        $exp    = explode ('"', $error);
        
        $error = $exp[1];
        
        $this->error = true;
        $this->errorMsg = $error;
        
    }
    
    
}