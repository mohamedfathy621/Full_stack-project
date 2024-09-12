<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;
class OrderType extends ObjectType{
    public function __construct(){
        $config = [
            'name' => 'Order',
            'fields' => [
                'tag' => Type::nonNull(Type::string()),
                'order_id' => Type::nonNull(Type::string()),
                'options_set' => Type::nonNull(Type::string()),
                'price' => Type::nonNull(Type::float()),
                'quantatiy' => Type::nonNull(Type::int())
            ]
            ];
        parent::__construct($config);
    }
}
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
class ProductCategoryResolver
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function resolveProducts($args)
    {
        $extra_sql=$args['category'];
        $sql = "SELECT * FROM product" . $extra_sql;
        $result = $this->connection->query($sql);

        if ($result === false) {
            throw new \Exception('Query failed: ' . $this->connection->error);
        }

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $row['description'] = htmlspecialchars($row['description']);
            $products[] = $row;
        }

        $result->free();
        return $products;
    }
    public function resolveRegistOrder($args)
    {
        $orders = $args['orders'];
        $insertedOrders = [];
        $generatedOrderId = uniqid("ORD_");
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

    public function resolveCategories()
    {
        $sql = "SELECT name FROM category";
        $result = $this->connection->query($sql);

        if ($result === false) {
            throw new \Exception('Query failed: ' . $this->connection->error);
        }

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        $result->free();
        return $categories;
    }
}
class CategoryType extends ObjectType{
    public function __construct(){
        $config = [
            'name' => 'Category',
            'fields' => [
                'name' => Type::nonNull(Type::string())
            ]
            ];
        parent::__construct($config);
    }
    
}
class GalleryType extends ObjectType{
    public function __construct(){
        $config = [
            'name' => 'Gallery',
            'fields' => [
                'url' => Type::nonNull(Type::string()),
                'productId' =>Type::nonNull(Type::String())
            ]
            ];
        parent::__construct($config);
    }
    public static function resolveGallery($product, $connection) {
                
        $sql = "SELECT * FROM gallery where productId= '".$product['productId']."'";
                        
        $result = $connection->query($sql);
        
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
class CurrencyType extends ObjectType {
    public function __construct(){
        $config = [
            'name' => 'Currency',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'label' => Type::nonNull(Type::String()),
                'symbol' => Type::nonNull(Type::String()),
            ]
            ];
        parent::__construct($config);
    }
}
class AttributeType extends ObjectType {
    public function __construct(){
        $config = [
            'name' => 'Attribute',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'displayValue' => Type::nonNull(Type::String()),
                'value' => Type::nonNull(Type::String()),
                'attributeSetId' => Type::nonNull(Type::String()),
            ]
            ];
        parent::__construct($config);
    }
}

class PriceType extends ObjectType {
    public function __construct($currencytype){
        $config = [
            'name' => 'Price',
            'fields' => [
                'amount' => Type::nonNull(Type::float()),
                'currency' => Type::nonNull($currencytype),
                'currencyId' => Type::nonNull(Type::String())
            ]
            ];
        parent::__construct($config);
    }
    public static function resolvePrice($product, $connection) {
        $sql = "SELECT p.amount AS amount, c.label, c.symbol FROM price p JOIN currency c ON p.currencyId = c.id WHERE p.productId = '".$product['productId']."'";
        $result = $connection->query($sql);
        if ($result === false) {
            throw new \Exception('Query failed: ' . $connection->error);
        }
        $prices = [];
        while ($row = $result->fetch_assoc()) {
            $prices[] = [
                'amount' => (float) $row['amount'],
                'currency' => [
                    'label' => $row['label'],
                    'symbol' => $row['symbol'],
                ],
            ];
        }
        $result->free();
        return $prices;
    }
}
class AtrributeSet extends ObjectType {
    public function __construct($attributetype){
        $config = [
            'name' => 'AtrributeSet',
            'fields' => [
                'id' => Type::nonNull(Type::id()),
                'name' => Type::nonNull(Type::String()),
                'type' =>  Type::nonNull(Type::String()),
                'productId' =>  Type::nonNull(Type::String()),
                'items' => Type::listOf($attributetype),
            ]
            ];
        parent::__construct($config);
    }
    public static function resolveattribute ($product, $connection) {        
        $sql = "SELECT a.name  AS name, a.productId, a.id,b.displayValue,b.value,a.type FROM attributeset a JOIN attribute b ON a.id = b.attributeSetId  where a.productId= '".$product['productId']."'";
                        
        $result = $connection->query($sql);
        if ($result === false) {
            throw new \Exception('Query failed: ' . $connection->error);
        }
        
        $inventory = [];
        $zobry = [];
        while ($row = $result->fetch_assoc()) {
            if (!isset($zobry[$row['id']])) {
                 $inventory[]=[
                     'id' => $row['id'],
                    'name'=> $row['name'],
                    'type' => $row['type']
                ];
                $zobry[$row['id']]=[
                    ['displayValue' => $row['displayValue'],
                    'value' => $row['value']]
                ];
               
             
             }
            else{
                array_push($zobry[$row['id']], ['displayValue' => $row['displayValue'], 'value' => $row['value']]);
            }
        }
        $result->free();
        foreach ($inventory as $key => $value) {
            $inventory[$key]['items'] = $zobry[$value['id']];
           
        }
        return $inventory;
    }
}
class ProductType extends ObjectType {
    public function __construct($attributeSetType,$gallerytype,$pricetype,$connection){
        $config = [
            'name' => 'Product',
            'fields' => [
                'productId'  => Type::nonNull(Type::id()),
                'name' => Type::nonNull(Type::String()),
                'brand'  =>  Type::nonNull(Type::String()),
                'categoryId' => Type::nonNull(Type::String()),
                'inStock' =>  Type::nonNull(Type::boolean()),
                'description' => Type::nonNull(Type::String()),
                'price' => [
                    'type' => Type::listOf($pricetype),
                    'resolve' => function ($product) use ($connection) {
                        return PriceType::resolvePrice($product, $connection);
                    },
                ],
                'gallery' => [
                    'type' => Type::listOf($gallerytype),
                    'resolve' => function ($product) use($connection){
                        return GalleryType::resolveGallery($product, $connection);
                    }
                ],
                'attributeset' =>[
                    'type' => Type::listOf($attributeSetType),
                    'resolve' => function ($product) use($connection){
                        return AtrributeSet::resolveattribute($product, $connection);
                    }
                ],
                
            ]
        ];
        parent::__construct($config);
    }
}

?>