<?php
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;
class OrderInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderInput',
            'fields' => [
                'tag' => Type::nonNull(Type::string()),
                'order_id' => Type::nonNull(Type::string()),
                'options_set' => Type::nonNull(Type::string()),
                'price' => Type::nonNull(Type::float()),
                'quantatiy' => Type::nonNull(Type::int()),
            ],
        ]);
    }
}
?>