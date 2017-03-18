<?php

namespace services\Utils;

class ExplorerUtil {

    /**
     * Create directory by full path.
     * 
     * @param string $fullPath
     */
    public static function createDir($fullPath) {

        $fullPathArr = explode('/', $fullPath);
        $pathTest = '';

        for($i = 0; $i < count($fullPathArr); $i++) {
            
            if($i>0){
                $pathTest .= '/'.$fullPathArr[$i];
            }else{
                $pathTest .= $fullPathArr[$i];
            }
            
            if (strlen($pathTest)>0 && !is_dir($pathTest)) {
                
                mkdir($pathTest);
            }
        }
    }

    /**
     * Create file by full path.
     * 
     * @param string $fullPath
     */
    public static function createFile($fullPath, $content) {

        //Windows to linux && explode
        $fullPathArr = explode('/', str_replace('\\', '/', $fullPath));

        //Get File and path
        $file = array_pop($fullPathArr);
        $path = implode('/', $fullPathArr);

        //Create all folders of path
        self::createDir($path);

        //Create file and write
        $f = fopen($path . '/' . $file, "w") or die("Unable to open file!");
        fwrite($f, $content);
        fclose($f);
    }

}
