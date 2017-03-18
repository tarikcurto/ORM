<?php

namespace services\Database\Utils;

use services\Database\Query;

class ColumnsUtil {

    const COLUMN_NAME = 'Field';
    
    const COLUMN_TYPE = 'Type';
    
    const COLUMN_KEY = 'Key';
    
    const COLUMN_DEFAULT = 'Default';
    
    public static function columnListByTable($tableName) {
        
        $data = Query::queryArray("SHOW COLUMNS FROM `$tableName`");
        return $data;
    }
}
