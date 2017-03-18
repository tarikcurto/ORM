<?php

namespace services\Builder\Entity;

use services\Builder\Entity\Entity;

class EntityList {

    /**
     *
     * @var array
     */
    private $entityList;
    
    /**
     *
     * @var string
     */
    private $baseDir;

    public function __construct() {

        $this->entityList = [];
    }
    
    /**
     * 
     * @return string
     */
    public function getBasePath(){
        return $this->baseDir;
    }
    
    /**
     * 
     * @param string $basePath
     */
    public function setBasePath($basePath){
        $this->baseDir = $basePath;
    }

    /**
     * 
     * @return array
     */
    public function getEntityList() {

        return $this->entityList;
    }

    /**
     * 
     * @param array $entityList
     */
    public function setEntityList($entityList) {

        $this->entityList = $entityList;
    }

    /**
     * 
     * @param Entity $entity
     */
    public function addEntity($entity) {

        $this->entityList[] = $entity;
    }

    /**
     * 
     * @param string $user
     * @param string $pass
     * @param string $database
     * @param string $host
     * @return $this
     * @throws \Exception
     */
    public function fromDatabase($user, $pass, $database, $host) {

        $dbConnection = new \mysqli($host, $user, $pass, $database);

        if ($dbConnection->connect_error) {
            throw new \Exception("MYSQLI err: " . $dbConnection->connect_error);
        }

        $result = $dbConnection->query('SHOW TABLES;');
        if (!($result->num_rows > 0))
            return $this;

        //Get all tables from database
        while ($row = $result->fetch_assoc()) {

            $key = array_keys($row)[0];

            $entityBuilder = new Entity();
            $entityBuilder->setTable($row[$key]);
            $entityBuilder->setBasePath($this->getBasePath());  
            $entityBuilder->fromTable($dbConnection);
                      
            $this->addEntity($entityBuilder);
        }
        $dbConnection->close();

        return $this;
    }

}
