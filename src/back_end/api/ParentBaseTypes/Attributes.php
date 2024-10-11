<?php
require_once __DIR__ . '/../BaseTypes/BaseType.php'; 
use GraphQL\Type\Definition\Type;
abstract class Attributes extends BaseType{
    public function __construct(mysqli $connection) {
        parent::__construct($connection,'Attribute'); // Only pass the name
    }
    protected function getConf() {
        return [
            'id' => Type::nonNull(Type::id()),
            'displayValue' => Type::nonNull(Type::String()),
            'value' => Type::nonNull(Type::String()),
            'attributeSetId' => Type::nonNull(Type::String()),
        ];
    }
}

?>