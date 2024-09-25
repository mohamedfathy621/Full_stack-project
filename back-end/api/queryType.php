<?php
// queryType.php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;
require_once 'ooptypes.php'; 
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
class QueryType extends Requests{
    protected $producttype;
    protected $categoryType;
    public function __construct(mysqli $connection) {
        $this->producttype = new ProductType($connection);
        $this->categoryType = new CategoryType($connection);
        parent::__construct($connection,'Query');
    }
    protected function getConf() {
        return [
                
       'products' =>[
        'type' => Type::listOf($this->producttype),
        'resolve' => function ()  {
                return $this->producttype->resolveProduct();
            },
       ],
        
        'categories' => [
            'type' => Type::listOf( $this->categoryType),
           'resolve' =>  function () {
                return $this->categoryType->resolveCategories();
            },
        ],
        ];
    }
}
class MutationType extends Requests{
    protected $Ordertype;
    protected $orderInputType;
    public function __construct(mysqli $connection) {
        $this->Ordertype = new OrderType($connection);
        $this->orderInputType = new OrderInputType();
        parent::__construct($connection,'Mutation');
    }
    protected function getConf() {
        return [
            'RegistOrder' => [
                'type' => Type::listOf($this->Ordertype),
                'args' => [
                    'orders' => Type::nonNull(
                            Type::listOf($this->orderInputType)
                    )
                ],
                 'resolve' => function ($root, $args) {
                    return $this->Ordertype->resolveRegistOrder($args);
                },
            ]
        ];
    }
}
?>