<?php

namespace services\Builder\Repository;
    
use services\Builder\Repository\Repository as Repository;
use services\Utils\TextUtil;
use League\Plates\Engine;

class QueriesRepositoryBuilder{

    /**
     *
     * @var Repository
     */
    private $repository;
    
    private $templateQueries;   
    
    public function __construct(Repository $repository) {
        
        $this->repository = $repository;
    }
    
    /** 
     * @return Engine
     */
    private function getTemplateQueries(){
        
        if(!isset($this->templateQueries)){
            $this->templateQueries = new Engine('./services/builder/templates/repository/queries');
        }
        
        return $this->templateQueries;
    }
    
    /**
     * 
     */
    public function buildTableMethods(){
        
        $this->queryRowToEntity();
        $this->queriedInfo();
        $this->queryPersist();
        $this->queryFindAll();
    }
    
    /**
     * 
     * @param array $columnTable
     */
    public function buildColumnMethods($columnTable){
        
       $this->queryFindOneByColumn($columnTable);
       $this->queryFindByColumn($columnTable);
       $this->queryUpdateByColumn($columnTable);
    }
    
    /**
     * 
     * @param array $columnList
     */
    public function buildTableAttributes($columnList){
        
        $this->repository->addAttribute('protected', '$table', "\"{$this->repository->getTable()}\"");
        $this->repository->addAttribute('protected', '$columnList', json_encode($columnList));
    }
    
    /**
     * 
     */
    private function queriedInfo(){
        
        $this->repository->setConstructor(['$id = false'], "\t\tparent::__construct();"
                . "\n\t\tif(\$id!==false)return \$this->findById(\$id);");
    }
    
    private function queryRowToEntity(){
        
        $methodName = 'buildEntity';
        $args = ['$data'];
        
        $template = $this->getTemplateQueries();        
        $content = $template->render('build_entity', [
            'entity_name' => preg_replace("/^([\w]{1,})(Repository)$/", "$1Entity", $this->repository->getObject())
        ]);
        
        $this->repository->addMethod('public', $methodName, $args, $content);
    }
    
    /**
     * 
     * @param string $column
     */
    private function queryPersist() {
        
        $methodName = 'persist';
        $args = [
            '$'.TextUtil::toCamelCase($this->repository->getTable(), false).'Entity'
         ];
        
        $template = $this->getTemplateQueries();        
        $content = $template->render('persist', [
            'table' => '$this->table',
            'data' => $args[0],
        ]);
        
        $this->repository->addMethod('public', $methodName, $args, $content);
    }
    
    /**
     * 
     * @param string $column
     */
    private function queryFindAll() {
        
        $methodName = 'findAll';
        $args = [];
        
        $template = $this->getTemplateQueries();        
        $content = $template->render('find', [
            'table' => '$this->table',
            'where' => [],
            'join' => [],
            'order' => ['id', 'desc'],
            'single' => false,
        ]);
        
        $this->repository->addMethod('public', $methodName, $args, $content);
    }
    
    /**
     * 
     * @param string $column
     */
    private function queryFindOneByColumn($column) {
        
        $methodName = 'findOneBy'.TextUtil::toCamelCase($column['Field'], true);
        $args = ['$'.TextUtil::toCamelCase($column['Field'], false)];
        
        $template = $this->getTemplateQueries();        
        $content = $template->render('find', [
            'table' => '$this->table',
            'where' => [ [$column['Field'], $args[0]], ],
            'join' => [],
            'order' => ['id', 'desc'],
            'single' => true,
        ]);
        
        $this->repository->addMethod('public', $methodName, $args, $content);
    }
    
    /**
     * 
     * @param string $column
     */
    private function queryFindByColumn($column) {
        
        $methodName = 'findBy'.TextUtil::toCamelCase($column['Field'], true);
        $args = ['$'.TextUtil::toCamelCase($column['Field'], false)];
        
        $template = $this->getTemplateQueries();        
        $content = $template->render('find', [
            'table' => '$this->table',
            'where' => [ [$column['Field'], $args[0]], ],
            'join' => [],
            'order' => ['id', 'desc'],
            'single' => false,
        ]);
        
        $this->repository->addMethod('public', $methodName, $args, $content);
    }
    
    /**
     * 
     * @param string $column
     */
    private function queryUpdateByColumn($column) {
        
        $methodName = 'updateBy'.TextUtil::toCamelCase($column['Field'], true);
        $args = ['$'.TextUtil::toCamelCase($column['Field'], false), '$data'];
        
        $template = $this->getTemplateQueries();        
        $content = $template->render('update', [
            'table' => '$this->table',
            'where' => [ [$column['Field'], $args[0]], ],
            'data' => '$data',
        ]);
        
        $this->repository->addMethod('public', $methodName, $args, $content);
    }
    
}
