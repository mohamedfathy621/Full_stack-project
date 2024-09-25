<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;

//an abstract class for base types 
abstract class BaseType extends ObjectType{
    //the type and connection is given by the class itself
    protected mysqli $connection;
    public function __construct(mysqli $connection,string $name) {
        $this->connection = $connection;
        $config = [
            'name' =>  $name,
            'fields' => $this->getConf()// each field is initialized in it's own subclass 
        ];
        parent::__construct($config);
    }
    abstract protected function getConf();//each class implements it's own field Initializer
    abstract protected function Resolver($param = null);// each class implements it's own resolver 
}
//an abstract class for types which has nested types in thier fields it differs from the BaseType as it uses an array of basetypes
//each BaseType is resolved in it's own subClass and the main class is resolved also in it's own class
abstract class NestedType extends ObjectType{
    //each subclass provides it's own nested basetype from the array
    protected mysqli $connection;
    protected array $baseTypes;
    public function __construct(mysqli $connection,string $name,array $baseTypes = []) {
        $this->connection = $connection;
        $this->baseTypes = $baseTypes;
        $config = [
            'name' =>  $name,
            'fields' => $this->getConf()
        ];
        parent::__construct($config);
    }
    abstract protected function getConf();
    abstract protected function Resolver($param = null);
}

// an Abstract class for Category as a BaseType 
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

// the main class of CategoryType which handels the resolve logic and the main intilization
class CategoryType extends Category{
    public function __construct(mysqli $connection) {
        parent::__construct($connection); // Pass the connection to the parent
    }
    protected function Resolver($param = null) {
        return $this->resolveCategories(); //implemntaion of the base resolver function for this class
    }

    public function resolveCategories()
    {
        $sql = "SELECT name FROM category"; // the basic sql query
        $result = $this->connection->query($sql);

        if ($result === false) {
            throw new \Exception('Query failed: ' . $this->connection->error);
        }

        $categories = []; // storing the data in an array 
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        $result->free();
        return $categories; // return the data 
    }
}

//the following classes are children of BaseType abstract class which handels the following types 
// Currency , Gallery , Attribute
// they follow the same OOP logic as the category example

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

class CurrencyType extends Currency{
    public function __construct(mysqli $connection) {
        parent::__construct($connection); // Pass the connection to the parent
    }
    protected function Resolver($param = null) {
        return $this->resolveCurrency($param);
    }

    public function resolveCurrency($PriceId)
    {
        $sql = "SELECT * FROM currency where id = '".$PriceId."'";
       
        $result = $this->connection->query($sql);
         
        if ($result === false) {
            throw new \Exception('Query failed: ' . $this->connection->error);
        }

        $currency = [];
        while ($row = $result->fetch_assoc()) {
            $currency[] = $row;
        }
       
        $result->free();
        return $currency[0];
    }
}

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

class GalleryType extends Gallery{
    public function __construct(mysqli $connection) {
        parent::__construct($connection); // Pass the connection to the parent
    }
    protected function Resolver($param = null) {
        return $this->resolveGallery($param);
    }
    public function resolveGallery($ProductId) {
                
        $sql = "SELECT * FROM gallery where productId= '".$ProductId."'";
                        
        $result = $this->connection->query($sql);
        
        if ($result === false) {
            throw new \Exception('Query failed: ' . $connection->error);
        }
        
        $galleries = [];
        while ($row = $result->fetch_assoc()) {
            $galleries[] = $row;
        }
        //echo("\n".json_encode($galleries));
        $result->free();
        return $galleries ;
    }
}

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

class AttributeType extends Attributes{
    public function __construct(mysqli $connection) {
        parent::__construct($connection); // Pass the connection to the parent
    }
    protected function Resolver($param = null) {
        return $this->resolveAttributes($param);
    }
    public function resolveAttributes($attributeSetId) {
        $sql = "select * from attribute where attributeSetId= '".$attributeSetId."'"; 
        $result = $this->connection->query($sql);
        if ($result === false) {
            throw new \Exception('Query failed: ' . $connection->error);
        }
        $attibutes = [];
        while ($row = $result->fetch_assoc()) {
            $attibutes[] = $row;
        }
        $result->free();
        return $attibutes ;
    }
}

// here is the children of the NestedType abstract Class 

// an abstract Class for Price 
abstract class Price extends NestedType{
    public function __construct(mysqli $connection,array $baseTypes) {
        parent::__construct($connection,'Price',$baseTypes); // it is configured using the mysql connection and an array of Types used in it
    }
    //the config of the Price class 
    protected function getConf() {
        $currencyType = $this->baseTypes['currencyType']; // as price has a Nested BaseType of currency it is passed from the main function
        return [
            'amount' => Type::nonNull(Type::float()), 
            'currency' =>[ 
                'type' =>   Type::nonNull($currencyType),
                'resolve' =>function ($price) use ($currencyType) {
                    // here Price class leverage the resolver of currency type 
                    return $currencyType->resolveCurrency($price['id']); // Call the resolveCurrency method
                }
                ] ,
            'currencyId' => Type::nonNull(Type::String())
        ];
    }
}

class PriceType extends Price{
    public function __construct(mysqli $connection) {
        $currencyType = new CurrencyType($connection); //declaring an instance of the currencytype to pass it to the parent class for the resolver logic
        parent::__construct($connection,['currencyType' => $currencyType]); 
    }
    protected function Resolver($param = null) {
        return $this->resolvePrice($param); // each NestedType has it's own resolver to resolve it's logic
    }
    public function resolvePrice($ProductId) {
        $sql = "SELECT * FROM price where productId= '".$ProductId."'"; 
        $result = $this->connection->query($sql);
        if ($result === false) {
            throw new \Exception('Query failed: ' . $connection->error);
        }
        $prices = [];
        while ($row = $result->fetch_assoc()) {
            $prices[] = $row;
        }
        $result->free();
        return $prices ;
    }
}

// this is the implementation of the attributeset class following the same logic as the PriceType
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

class AttributesetType extends Attributeset{
    public function __construct(mysqli $connection) {
        $attributetype = new AttributeType($connection);
        parent::__construct($connection,['AttributeType' => $attributetype]); // Pass the connection to the parent
    }
    protected function Resolver($param = null) {
        return $this->resolveAttributeset($param);
    }
    public function resolveAttributeset($ProductId) {
        
        $sql ="SELECT * FROM attributeset where productId= '".$ProductId."'"; 
        
        $result = $this->connection->query($sql);
        if ($result === false) {
            throw new \Exception('Query failed: ' . $connection->error);
        }
        $attributeset = [];
        while ($row = $result->fetch_assoc()) {
            $attributeset[] = $row;
            
        }
        $result->free();
        return $attributeset ;
    }
}

//the product class is the culmination of the whole classes as it uses both NestedType class and BaseType classes
abstract class Product extends NestedType{
    public function __construct(mysqli $connection,array $baseTypes) {
        parent::__construct($connection,'Product',$baseTypes); // Only pass the name
    }
    protected function getConf() {
        // it uses a NestedType class Price and attributeSet and a BaseType Gallerytype
        $pricetype = $this->baseTypes['PriceType'];
        $gallerytype = $this->baseTypes['GalleryType'];
        $attributeSetType = $this->baseTypes['AttributesetType'];
        return [
            'productId'  => Type::nonNull(Type::id()),
            'name' => Type::nonNull(Type::String()),
            'brand'  =>  Type::nonNull(Type::String()),
            'categoryId' => Type::nonNull(Type::String()),
            'inStock' =>  Type::nonNull(Type::boolean()),
            'description' => Type::nonNull(Type::String()),
            //each NestedType and BaseType is resolved in it's own Class 
            'price' => [
                    'type' => Type::listOf($pricetype),
                    'resolve' =>function ($Product) use ($pricetype) {
                    return $pricetype->resolvePrice($Product['productId']); // Call the resolveCurrency method
                    },
            ],
            'gallery' => [
                'type' => Type::listOf($gallerytype),
                'resolve' =>function ($Product) use ($gallerytype) {
                    return $gallerytype->resolveGallery($Product['productId']); // Call the resolveCurrency method
                 },
           ],
            'attributeset' =>[
                'type' => Type::listOf($attributeSetType),
                'resolve' =>function ($Product) use ($attributeSetType) {
                    return $attributeSetType->resolveAttributeset($Product['productId']);
                }
            ]
            
        ];
    }
}

class ProductType extends Product{
    public function __construct(mysqli $connection) {
        $attributetype = new AttributesetType($connection);
        $pricetype = new PriceType($connection);
        $gallerytype = new GalleryType($connection);
        parent::__construct($connection,['AttributesetType' => $attributetype, 'PriceType' =>  $pricetype, 'GalleryType' => $gallerytype]); // Pass the connection to the parent
    }
    protected function Resolver($param = null) {
        return $this->resolveProduct();
    }
    public function resolveProduct() {
        $sql = "select * from product"; 
        $result = $this->connection->query($sql);
        if ($result === false) {
            throw new \Exception('Query failed: ' . $connection->error);
        }
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $result->free();
        return $products ;
    }
}

// these are the class for the mutation to insert orders
class OrderType extends ObjectType{
    private $connection;
    public function __construct(mysqli $connection){
        $this->connection = $connection;
        $config = [
            'name' => 'Order',
            'fields' => [
                'tag' => Type::nonNull(Type::string()), //the ordername
                'order_id' => Type::nonNull(Type::string()), //each order has it's own unique id given to all it's items
                'options_set' => Type::nonNull(Type::string()), // each product has it's option_set of attributes
                'price' => Type::nonNull(Type::float()), //  the price of each product
                'quantatiy' => Type::nonNull(Type::int()) // the quantatiy of each product
            ]
            ];
        parent::__construct($config);
    }
    // the resolver function of the input
    public function resolveRegistOrder($args)
    {
        $orders = $args['orders'];
        $insertedOrders = [];
        $generatedOrderId = uniqid("ORD_"); // generating the unique order_id
        $this->connection->begin_transaction();

        try {
            $stmt = $this->connection->prepare(
                "INSERT INTO orders (tag, order_id, options_set, price, quantatiy) VALUES (?, ?, ?, ?, ?)"
            );

            foreach ($orders as $order) {
                $stmt->bind_param(
                    "sssdi",  // s for string, d for double/float, i for int
                    $order['tag'],
                    $generatedOrderId,
                    $order['options_set'],
                    $order['price'],
                    $order['quantatiy']
                );
                $stmt->execute();
                $insertedOrders[] = [
                    'tag' => $order['tag'],
                    'order_id' => $generatedOrderId,
                    'options_set' => $order['options_set'],
                    'price' => $order['price'],
                    'quantatiy' => $order['quantatiy']
                ];
            }
            $this->connection->commit();

        } catch (Exception $e) {
            $this->connection->rollback();
            throw new Exception('Error inserting orders: ' . $e->getMessage());
        }
        return $insertedOrders;
    }
}
//this is the orderInputType class implements the order_input Type
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