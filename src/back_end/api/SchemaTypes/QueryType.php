<?php
require_once __DIR__ . '/../BaseTypes/Requests.php';
require_once __DIR__ . '/../DataTypes/ProductType.php'; 
require_once __DIR__ . '/../DataTypes/CategoryType.php'; 
use GraphQL\Type\Definition\Type;
class QueryType extends Requests{
    protected $producttype;
    protected $categoryType;
    protected $connection;
    public function __construct() {
        $this->connection = new mysqli('localhost', 'root', 'KERdasa621998', 'project');
        $this->producttype = new ProductType($this->connection);
        $this->categoryType = new CategoryType($this->connection);
        parent::__construct($this->connection,'Query');
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

?>