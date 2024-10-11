<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;

abstract class Requests extends ObjectType{
    public function __construct(mysqli $connection,string $name) {
        mysqli_set_charset($connection, 'utf8mb4');
        if ($connection->connect_error) {
            die('Connection failed: ' . $connection->connect_error);
        }
        $config = [
            'name' =>  $name,
            'fields' => $this->getConf()
        ];
        parent::__construct($config);
    }
    abstract protected function getConf();
}

?>