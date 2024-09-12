<?php
// queryType.php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;
require_once 'Types.php';
$host = 'localhost';     // Database host
$username = 'root';      // Database username
$password = 'KERdasa621998'; // Database password
$database = 'project'; // Database name
$connection = new mysqli($host, $username, $password, $database);
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}
$categoryType = new CategoryType();
$galleryType = new GalleryType();
$currencyType = new CurrencyType();
$attributeType = new AttributeType();
$orderInputType = new OrderInputType();
$priceType = new PriceType($currencyType);
$attributesetType = new AtrributeSet($attributeType);
$producttype = new ProductType($attributesetType,$galleryType,$priceType,$connection);
$Ordertype= new OrderType();
$resolver = new ProductCategoryResolver($connection);
$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
       'products' =>[
        'type' => Type::listOf($producttype),
        'args' => [
            'category' => Type::nonNull(Type::String())
        ],
      'resolve' => function ($root, $args) use ($resolver) {
                return $resolver->resolveProducts($args);
            },
       ],
        'categories' => [
            'type' => Type::listOf($categoryType),
           'resolve' => function () use ($resolver) {
                return $resolver->resolveCategories();
            },
        ],
    ]
]);
$mutationType = new ObjectType([
    'name' => 'Mutation',
    'fields' => [
        'RegistOrder' => [
            'type' => Type::listOf($Ordertype),
            'args' => [
                'orders' => Type::nonNull(
                        Type::listOf($orderInputType)
                )
            ],
             'resolve' => function ($root, $args) use ($resolver) {
                return $resolver->resolveRegistOrder($args);
            },
        ]
    ]
    
    
]);

?>