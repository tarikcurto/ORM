<?php

namespace services\Database\Utils;

use services\Database\Query;

class TablesUtil {
    
    public static function tableListByConnection() {
        
        $data = Query::queryArray('SHOW TABLES');
        return $data;
    }
}
