<?php
require_once __DIR__ . '/../BaseTypes/Requests.php';
require_once __DIR__ . '/../BaseTypes/OrderInputType.php';
require_once __DIR__ . '/../InputTypes/OrderType.php'; 
use GraphQL\Type\Definition\Type;
class MutationType extends Requests{
    protected $Ordertype;
    protected $orderInputType;
    protected $connection;
    public function __construct() {
        $this->connection = new mysqli('localhost', 'root', 'KERdasa621998', 'project');
        $this->Ordertype = new OrderType($this->connection);
        $this->orderInputType = new OrderInputType();
        parent::__construct($this->connection,'Mutation');
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