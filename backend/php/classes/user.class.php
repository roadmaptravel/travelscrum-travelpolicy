<?php

class User {

    protected $data;
    protected $userId;

    public function __construct ($userId = false) {
        
        // Fetch everything from this user!
        if (!$userId) {
        
            return false;
            
        }
        
        try {
            
            $dbh = DB::getConnection ();
            
            $stmt = $dbh->prepare ("SELECT * FROM user WHERE id = :id AND active AND deleted IS NULL LIMIT 1");
            
            $stmt->bindParam (':id', $userId, PDO::PARAM_STR);
            
            $success = $stmt->execute ();
            
            if ($success) {
                
                $this->userId = $userId;
                
                $data = $stmt->fetch ();
                
                if ($data['firstName']) {
                    
                    foreach ($data as $key => $value) {
                        
                        $this->data[$key] = $value;
                        
                    }
                    
                }
            }
            
            # Free resources
            $stmt = null;
            $dbh  = null;
            
            return true;
            
        } catch (Exception $e) {
            
            return false;
            
        }
    }
    
    public function __get ($var) {
        
        if (isset ($this->data[$var])) {
            
            return $this->data[$var];
            
        }
        
        return false;
        
    }
    
    public static function checkCredentials ($username, $password, $checkDigestOnly = false) {
        
        $userId = false;
        $digest = false;
        
        try {
            
            $dbh = DB::getConnection ();
            
            $stmt = $dbh->prepare ("SELECT id, password FROM user WHERE username = :username AND active AND deleted IS NULL LIMIT 1");
            
            $stmt->bindParam (':username', $username, PDO::PARAM_STR);
            
            $success = $stmt->execute ();
            
            if ($success) {
                
                $data = $stmt->fetch ();
                
                if ($checkDigestOnly === true) {
                
                    if ($password === $data['password']) {
                        
                        $userId = $data['id'];
                        $digest = $data['password'];
                    }
                
                } else {
                
                    if (crypt ($password, $data['password']) == $data['password']) {
                        
                        $userId = $data['id'];
                        $digest = $data['password'];
                        
                    }
                }
            }
            
            # Free resources
            $stmt = null;
            $dbh  = null;
            
        } catch (Exception $e) {
            
            $userId = false;
            $digest = false;
            
        }
        
        return array ($userId, $digest, $username);
        
    }
    
    public function toggleActive () {
        
        try {
            
            $stmt = DB::getConnection ()->prepare ("UPDATE user SET active = active XOR 1 WHERE id = :id LIMIT 1");
            $stmt->bindParam (':id', $this->userId);
            
            $success = $stmt->execute ();

            # Free resources
            $stmt = null;
            $dbh  = null;
            
            if ($success) {
                
                return true;
                
            }
            
        } catch (Exception $e) {
            
            return false;
            
        }
        
        return false;
        
    }
    
    public function delete () {
        
        try {
            
            $stmt = DB::getConnection ()->prepare ("UPDATE user SET deleted = NOW() WHERE id = :id LIMIT 1");
            $stmt->bindParam (':id', $this->userId);
            
            $success = $stmt->execute ();

            # Free resources
            $stmt = null;
            $dbh  = null;
            
            if ($success) {
                
                return true;
                
            }
            
        } catch (Exception $e) {
            
            return false;
            
        }
        
        return false;
        
    }
    
    public function all () {
        
        try {
            
            $dbh = DB::getConnection ();
            
            $stmt = $dbh->prepare ("
            SELECT 
                *
            FROM 
                user
            WHERE 
                deleted IS NULL
            ORDER BY id DESC
            "); 
                           
            $stmt->bindParam (':id', $id, PDO::PARAM_STR);
            
            $success = $stmt->execute ();
            
            if ($success) {
                
                return $stmt->fetchAll (PDO::FETCH_NAMED);
                
            }
            
            # Free resources
            $stmt = null;
            $dbh  = null;
            
            return true;
            
        } catch (Exception $e) {
            
            return false;
        }
        
    }
    
    public function updateLastLogin ($userId) {
	    
	    try {
            
            $stmt = DB::getConnection ()->prepare ("UPDATE user SET lastLogin = NOW() WHERE id = :id LIMIT 1");
            $stmt->bindParam (':id', $userId);
            
            $success = $stmt->execute ();

            # Free resources
            $stmt = null;
            $dbh  = null;
            
            if ($success) {
                
                return true;
                
            }
            
        } catch (Exception $e) {
            
            return false;
            
        }
        
        return false;
        
	    
    }
    
    public function search ($string) {
        
        try {
            
            $dbh = DB::getConnection ();
            
            $stmt = $dbh->prepare ("
            SELECT 
                *
            FROM 
                user
            WHERE
                deleted IS NULL
            AND (
                firstName LIKE :search
                OR
                lastName LIKE :search1
                OR
                email LIKE :search2
                OR
                CONCAT(firstName, ' ', lastName) LIKE :search3
            )
            ORDER BY id DESC
            "); 
                           
            $string  = '%' . $string . '%';
                           
            $stmt->bindParam (':search', $string, PDO::PARAM_STR);
            $stmt->bindParam (':search1', $string, PDO::PARAM_STR);
            $stmt->bindParam (':search2', $string, PDO::PARAM_STR);
            $stmt->bindParam (':search3', $string, PDO::PARAM_STR);

            $success = $stmt->execute ();

            if ($success) {
                
                return $stmt->fetchAll (PDO::FETCH_NAMED);
                
            }
            
            # Free resources
            $stmt = null;
            $dbh  = null;
            
            return true;
            
        } catch (Exception $e) {
            
            echo $e->getMessage ();
            
            return false;
        }
        
    }
}