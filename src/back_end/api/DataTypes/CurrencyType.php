<?php
require_once __DIR__ . '/../ParentBaseTypes/Currency.php'; 
class CurrencyType extends Currency{
    public function __construct(mysqli $connection) {
        parent::__construct($connection); // Pass the connection to the parent
    }
    protected function Resolver($param = null) {
        return $this->resolveCurrency($param);
    }

    public function resolveCurrency($PriceId)
    {
        $sql = "SELECT * FROM Currency where id = '".$PriceId."'";
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
?>