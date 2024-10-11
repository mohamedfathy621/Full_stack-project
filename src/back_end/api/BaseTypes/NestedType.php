<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

abstract class NestedType extends ObjectType{
    //each subclass provides it's own nested basetype from the array
    protected mysqli $connection;
    protected array $baseTypes;
    public function __construct(mysqli $connection,string $name,array $baseTypes = []) {
        $this->connection = $connection;
        $this->baseTypes = $baseTypes;
        $config = [
            'name' =>  $name,
            'fields' => $this->getConf()
        ];
        parent::__construct($config);
    }
    abstract protected function getConf();
    abstract protected function Resolver($param = null);
}

?>