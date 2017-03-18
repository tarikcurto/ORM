<?php

namespace services\Builder\Entity;

use services\Builder\Object\Object;
use services\Utils\ExplorerUtil;
use services\Utils\TextUtil;

class Entity extends Object {

    const NAMESPACE_BASE = 'models\\entities';

    /**
     *
     * @var string
     */
    private $table;

    /**
     *
     * @var string
     */
    private $basePath;

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * @return string
     */
    public function getTable() {
        return $this->table;
    }

    /**
     * 
     * @param string $table
     */
    public function setTable($table) {
        $this->table = $table;
    }

    /**
     * 
     * @return string
     */
    public function getBasePath() {
        return $this->basePath;
    }

    /**
     * 
     * @param string $basePath
     */
    public function setBasePath($basePath) {
        $this->basePath = $basePath;
    }

    /**
     * @override
     * @param string $nameSpace Set null.
     */
    public function setNameSpace($nameSpace) {

        $table = $this->table;
        $tableArray = explode('_', $table);

        array_pop($tableArray);
        $clientSpace = implode("\\", $tableArray);

        if (strlen($clientSpace) > 0) {
            $this->nameSpace = self::NAMESPACE_BASE . '\\' . $clientSpace;
        } else {
            $this->nameSpace = self::NAMESPACE_BASE;
        }
    }

    public function setObject($obj) {

        $table = $this->table;
        $tableToArray = explode('_', $table);

        $obj = ucfirst(
                $tableToArray[count($tableToArray) - 1]);

        $this->object = $obj . 'Entity';
    }

    /**
     * Add attribute, getter and setter by attribute name.
     * 
     * @param string $attribute
     */
    public function addDataTransfer($attribute) {

        $attribute = TextUtil::toCamelCase($attribute, false);

        $this->addAttribute('private', '$' . $attribute);

        $getContent = "\t\treturn \$this->" . $attribute . ';';
        $this->addMethod('public', 'get' . ucfirst($attribute), [], $getContent);

        $setContent = "\t\t\$this->" . $attribute . ' = $' . $attribute . ';';
        $this->addMethod('public', 'set' . ucfirst($attribute), ['$' . $attribute], $setContent);
    }

    /**
     * Build entity from table.
     * 
     * @param \mysqli $dbConnection
     * @return $this
     */
    public function fromTable($dbConnection) {

        $this->setNameSpace(null);
        $this->setObject(null);

        $table = $this->table;

        $result = $dbConnection->query('SHOW COLUMNS FROM ' . $table . ';');

        if (!($result->num_rows > 0))
            return $this;

        //Get all columns from table
        while ($columnTable = $result->fetch_assoc()) {

            $this->addDataTransferByColumn($columnTable);
        }

        $fullPath = $this->getBasePath() . '/' . $this->getNameSpace() . '/' . $this->getObject() . '.php';
        ExplorerUtil::createFile($fullPath, $this->build());

        return $this;
    }

    /**
     * Add attribute, getter and setter by table column.
     * 
     * @param array $column
     */
    private function addDataTransferByColumn($column) {

        $this->addDataTransfer($column['Field']);
    }

}
