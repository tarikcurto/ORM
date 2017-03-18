<?php

namespace services\Database;

use mysqli as DB;

class Connection {
    
    private $socket;
    
    public function __construct() {
        
        $this->connnect();
    }
    
    /**
     * Connect by user config data.
     * 
     */
    protected function connnect(){
        
        $db = [];
        
        //TODO: Good?
        require_once 'preferences.php';
        
        $this->socket = new DB($db['host'], $db['user'], $db['pass'], $db['database']);
        
        return $this->socket;
    }
    
    public function query($q){
        
        return $this->socket->query($q);
    }
    
    /**
     * Close current database session.
     * 
     */
    public function close(){
        
        return $this->socket->close();
    }
}
