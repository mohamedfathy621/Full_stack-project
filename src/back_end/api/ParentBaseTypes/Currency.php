<?php
require_once __DIR__ . '/../BaseTypes/BaseType.php'; 
use GraphQL\Type\Definition\Type;
abstract class Currency extends BaseType{
    public function __construct(mysqli $connection) {
        parent::__construct($connection,'Currency'); // Only pass the name
    }
    protected function getConf() {
        return [
            'id' => Type::nonNull(Type::id()),
            'label' => Type::nonNull(Type::String() ),
            'symbol' => Type::nonNull(Type::String()),
        ];
    }
}
?>