<?php
require_once __DIR__ . '/../ParentBaseTypes/Attributes.php'; 

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

?>