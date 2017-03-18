<?php

namespace services\Builder\Repository;
    
use services\Builder\Object\Object;
use services\Builder\Repository\QueriesRepositoryBuilder;
use services\Utils\ExplorerUtil;
use services\Utils\TextUtil;

use services\Database\Utils\ColumnsUtil;

class Repository extends Object{
    
    //TODO: Move to preferences
    const EXTENDED_CLASS = '\\models\\Repository';
    const NAMESPACE_BASE = 'models\\repositories';

    private $table;
    
    private $basePath;
    
    private $queryBuilder;
    
    /**
     * Repository constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->queryBuilder = new QueriesRepositoryBuilder($this);
    }

    /**
     * @return string
     */
    public function getTable() {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable($table) {
        $this->table = $table;
    }
    
    /**
     * @return string
     */
    public function getBasePath() {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }

    /**
     * @override
     * @param string $namespace Set null.
     */
    public function setNameSpace($namespace) {

        $table = $this->table;
        $tableArray = explode('_', $table);

        array_pop($tableArray);
        $clientSpace = implode('\\', $tableArray);

        if (strlen($clientSpace) > 0) {
            $this->nameSpace = self::NAMESPACE_BASE . '\\' . $clientSpace;
        } else {
            $this->nameSpace = self::NAMESPACE_BASE;
        }
    }

    public function setObject($obj) {

        $table = $this->table;
        $tableToArray = explode('_', $table);

        $obj = ucfirst($tableToArray[count($tableToArray) - 1]);

        $this->object = TextUtil::toCamelCase($obj, true) . 'Repository';
    }
    
    public function getEntityNameSpace(){

        $regex = "/^([\w\\\]{0,}\\\)(repositories)([\w\\\]{0,})$/";
        $regexReplace = "$1entities$3";
        
        return preg_replace($regex, $regexReplace, $this->getNameSpace());
    }
    
    public function getEntityName(){
        
        $regex = '/^([\w]{1,})(Repository)$/';
        $regexReplace = "$1Entity";
        
        return preg_replace($regex, $regexReplace, $this->getObject());
    }

    private function addImportEntity(){
        
        $this->addImport($this->getEntityNameSpace().'\\'.$this->getEntityName());
    }
    
    /**
     * Build repository from table.
     * @return $this
     */
    public function build() {

        //Build file
        $this->setNameSpace(null);
        $this->setObject(null);
        $this->addImportEntity();
        $this->setConstructor([], "\t\tparent::__construct();");
        $this->buildQueries();
        
        //Write file
        $fullPath = $this->getBasePath() . '/' . $this->getNameSpace() . '/' . $this->getObject() . '.php';
        ExplorerUtil::createFile($fullPath, $this->build());

        return $this;
    }
    
    /**
     * Build methods and properties for queries.
     */
    private function buildQueries(){
        
        $columnList = ColumnsUtil::columnListByTable($this->table);
        $columnStringList = array_column($columnList, ColumnsUtil::COLUMN_NAME);
        
        $this->queryBuilder->buildTableAttributes($columnStringList);
        $this->queryBuilder->buildTableMethods();
        
        foreach ($columnList as $column){
            
            $this->queryBuilder->buildColumnMethods($column, $this->table);
        }
    }
    
}
