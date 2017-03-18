<?php

namespace services\Utils;

class TextUtil {
    
    public static function toCamelCase($text, $capitalizeFirst){
        
        $t = str_replace(' ', '', ucwords(str_replace(['-','_'], [' ', ' '], $text)));
        if (!$capitalizeFirst) {
            $t[0] = strtolower($t[0]);
        }

        return $t;
    }
}
