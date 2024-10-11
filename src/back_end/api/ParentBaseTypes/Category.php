<?php
require_once __DIR__ . '/../BaseTypes/BaseType.php'; 
use GraphQL\Type\Definition\Type;
abstract class Category extends BaseType {
    public function __construct(mysqli $connection) {
        parent::__construct($connection,'Category'); // the name and the mysql connection is passed 
    }
    protected function getConf() {
        return [
            'name' => Type::nonNull(Type::string()) // the data field configiration for categories
        ];
    }
}

?>