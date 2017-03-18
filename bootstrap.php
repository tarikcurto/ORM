<?php

/**
 * Task list:
 * 
 * services folder to src
 * services namespace to tarikcurto
 * 
 */

require_once __DIR__.'/vendor/autoload.php';

spl_autoload_register('autoload');

function autoload($use) {
    
    preg_match("/^([a-zA-Z]{1,})\\\([\w\\\]{1,})$/", $use, $data);
    
    if (count($data) !== 3){
        throw new Exception("$use can not be loaded.");
    }

    switch ($data[1]) {

        case 'services':
            require_once __DIR__.'/services/'.$data[2].'.php';
            break;
    }   
}

use services\Builder\Repository\RepositoryList;
$r = new RepositoryList();$r->buildFromDatabase();