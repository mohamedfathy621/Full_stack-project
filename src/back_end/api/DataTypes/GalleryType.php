<?php
require_once __DIR__ . '/../ParentBaseTypes/Gallery.php'; 

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

?>