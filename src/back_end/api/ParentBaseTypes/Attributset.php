<?php
require_once __DIR__ . '/../BaseTypes/NestedType.php'; 
use GraphQL\Type\Definition\Type;
abstract class Attributeset extends NestedType{
    public function __construct(mysqli $connection,array $baseTypes) {
        parent::__construct($connection,'AtrributeSet',$baseTypes); // Only pass the name
    }
    protected function getConf() {
        $attributetype = $this->baseTypes['AttributeType'];
        return [
            'id' => Type::nonNull(Type::id()),
            'name' => Type::nonNull(Type::String()),
            'type' =>  Type::nonNull(Type::String()),
            'productId' =>  Type::nonNull(Type::String()),
            
            'items' =>[
               'type' =>   Type::listOf($attributetype),
               'resolve' =>function ($attributeset) use ($attributetype) {
                return $attributetype->resolveAttributes($attributeset['id']); // Call the resolveCurrency method
               }  
            ]
            
        ];
    }
}

?>