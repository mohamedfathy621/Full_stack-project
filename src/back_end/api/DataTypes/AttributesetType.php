<?php
require_once __DIR__ . '/../ParentBaseTypes/Attributset.php';
require_once 'AttributeType.php'; 

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

?>