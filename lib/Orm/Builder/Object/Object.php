<?php

namespace services\Builder\Object;

use League\Plates\Engine;

class Object {

    /**
     *
     * @var string
     */
    protected $nameSpace;

    /**
     *
     * @var array
     */
    protected $importList;

    /**
     *
     * @var string
     */
    protected $object;

    /**
     * 
     * @var string
     */
    protected $extendedClass;

    /**
     *
     * @var array
     */
    protected $attributeList;

    /**
     *
     * @var array
     */
    protected $constructor;

    /**
     *  
     * @var array
     */
    protected $methodList;

    public function __construct() {
        
        $this->importList = [];
        $this->attributeList = [];
        $this->methodList = [];
    }

    /**
     * 
     * @return string
     */
    public function getNameSpace() {
        return $this->nameSpace;
    }

    /**
     * Set full class path:
     * Namespace\Class
     * 
     * @param string $nameSpace
     */
    public function setNameSpace($nameSpace) {
        $this->nameSpace = $nameSpace;
    }

    /**
     * 
     * @return array
     */
    public function getImportList() {

        return $this->importList;
    }

    /**
     * 
     * @param array $importList
     */
    public function setImportList($importList) {

        $this->importList = $importList;
    }

    /**
     * 
     * @param string $object
     */
    public function addImport($object) {

        $this->importList[] = $object;
    }

    /**
     * 
     * @return string
     */
    public function getObject() {

        return $this->object;
    }

    /**
     * 
     * @param string $object
     */
    public function setObject($object) {

        $this->object = $object;
    }

    /**
     * 
     * @return string
     */
    public function getExtendedClass() {

        return $this->extendedClass;
    }

    /**
     * 
     * @param string $extendedClass
     */
    public function setExtendedClass($extendedClass) {

        $this->extendedClass = $extendedClass;
    }

    /**
     * 
     * @return array
     */
    public function getAttributeList() {

        return $this->attributeList;
    }

    /**
     * 
     * @param array $attributeList
     */
    public function setAttributeList($attributeList) {

        $this->attributeList = $attributeList;
    }

    /**
     * 
     * @param string $permission
     * @param string $attribute
     */
    public function addAttribute($permission, $attribute, $content = null) {

        $this->attributeList[] = [$permission, $attribute, $content];
    }

    /**
     * 
     * @return array
     */
    public function getConstructor() {

        return $this->constructor;
    }

    /**
     * 
     * @param array $arguments
     * @param string $content
     */
    public function setConstructor($arguments, $content) {

        $this->constructor = [$arguments, $content];
    }

    /**
     * 
     * @return array
     */
    public function getMethodList() {

        return $this->methodList;
    }

    /**
     * 
     * @param array $methodList
     */
    public function setMethodList($methodList) {

        $this->methodList = $methodList;
    }

    /**
     * 
     * @param string $permission
     * @param string $method
     * @param array $arguments
     * @param string $content
     */
    public function addMethod($permission, $method, $arguments, $content) {

        $this->methodList[] = [$permission, $method, $arguments, $content];
    }

    /**
     * Create object.
     * 
     * @return string
     */
    public function build() {

        return $this->render();
    }

    /**
     * 
     * @return string
     */
    protected function render() {

        $templates = new Engine('./services/builder/templates');
        $data = get_object_vars($this);

        return $templates->render('class_builder', $data);
    }

}
