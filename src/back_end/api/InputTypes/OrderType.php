<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;

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

?>