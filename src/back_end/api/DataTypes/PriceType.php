<?php
require_once __DIR__ . '/../ParentBaseTypes/Price.php';
require_once 'CurrencyType.php'; 
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

?>