<?php
require_once __DIR__ . '/../ParentBaseTypes/Category.php'; 

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
?>