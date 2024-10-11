<?php
require_once __DIR__ . '/../ParentBaseTypes/Product.php';
require_once 'GalleryType.php'; 
require_once 'AttributesetType.php'; 
require_once 'PriceType.php'; 

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

?>