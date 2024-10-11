<?php
require_once __DIR__ . '/../BaseTypes/BaseType.php'; 
use GraphQL\Type\Definition\Type;
abstract class Gallery extends BaseType{
    public function __construct(mysqli $connection) {
        parent::__construct($connection,'Gallery'); // Only pass the name
    }
    protected function getConf() {
        return [
            'url' => Type::nonNull(Type::string()),
            'productId' =>Type::nonNull(Type::String())
        ];
    }
}

?>