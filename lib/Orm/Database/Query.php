<?php

namespace services\Database;

use services\Database\Connection;

class Query {

    public static function query($query){
        
        $socket = new Connection();
        $data = $socket->query($query);
        
        $socket->close();
        
        return $data;
    }
    
    public static function queryArray($query){
        
        $data = self::query($query);
        
        if (!($data->num_rows > 0)){
            return [];
        }
        
        $dataArray = [];
        while ($row = $data->fetch_assoc()) {
            
            $dataArray[] = $row;
        }
        
        return $dataArray;
    }
    
    public static function queryJson($query){
        
        $data = self::queryArray($query);
        return json_encode($data);
    }
}
