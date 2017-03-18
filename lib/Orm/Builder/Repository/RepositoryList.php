<?php

namespace services\Builder\Repository;

use services\Builder\Repository\Repository;
use services\Database\Utils\TablesUtil;

class RepositoryList {
    

    /**
     *
     * @var array
     */
    private $repositoryList;
    
    /**
     *
     * @var string
     */
    private $basePath;

    public function __construct() {

        $this->repositoryList = [];
    }
    
    /**
     * 
     * @return string
     */
    private function getBasePath(){
        return $this->basePath;
    }
    
    /**
     * 
     * @param string $basePath
     */
    private function setBasePath($basePath){
        $this->basePath = $basePath;
    }

    /**
     * 
     * @return array
     */
    private function getRepositoryList() {

        return $this->repositoryList;
    }

    /**
     * 
     * @param array $repositoryList
     */
    private function setRepositoryList($repositoryList) {

        $this->repositoryList = $repositoryList;
    }

    /**
     * 
     * @param Repositpry $repository
     */
    private function addRepository($repository) {

        $this->repositoryList[] = $repository;
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
    public function buildFromDatabase() {

        $tables = TablesUtil::tableListByConnection();
        foreach ($tables as $table) {

            $key = array_keys($table)[0];

            $repository = new Repository();
            $repository->setExtendedClass($repository::EXTENDED_CLASS);
            $repository->setTable($table[$key]);
            $repository->setBasePath($this->getBasePath());  
            $repository->build();
                      
            $this->addRepository($repository);
        }
        $dbConnection->close();
        
        return $this;
    }
    
}
