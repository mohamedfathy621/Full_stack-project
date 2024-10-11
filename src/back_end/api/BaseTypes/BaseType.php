<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

abstract class BaseType extends ObjectType{
    //the type and connection is given by the class itself
    protected mysqli $connection;
    public function __construct(mysqli $connection,string $name) {
        $this->connection = $connection;
        $config = [
            'name' =>  $name,
            'fields' => $this->getConf()// each field is initialized in it's own subclass 
        ];
        parent::__construct($config);
    }
    abstract protected function getConf();//each class implements it's own field Initializer
    abstract protected function Resolver($param = null);// each class implements it's own resolver 
}

?>