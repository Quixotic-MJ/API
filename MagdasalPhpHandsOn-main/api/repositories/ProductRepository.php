<?php
require_once "config/Database.php";
require_once "repositories\interface\IProductRepository.php";

class ProductRepository implements IProductRepository {
    private $databaseConnection;
    private Database $database;
    
    public function __construct() {
        $this->database =  Database::getInstance();
        $this->databaseConnection = $this->database->getConnection();
    }

    public function GetAllProduct() 
    {
        $query = "SELECT Product.ProductId, Product.ProductName, ProductDetails.ProductPrice, ProductDetails.ProductDate
                  FROM Product 
                  LEFT JOIN ProductDetails ON Product.ProductId = ProductDetails.ProductId";
        return $this->ExecuteSqlQuery($query, []);
    }

    public function GetLatestPriceOfTheProduct() 
    {
        $query = "SELECT p.ProductId, p.ProductName, pd.ProductPrice, pd.ProductDate
                  FROM Product p
                  INNER JOIN ProductDetails pd ON p.ProductId = pd.ProductId
                  WHERE pd.ProductDate = (
                      SELECT MAX(ProductDate) 
                      FROM ProductDetails 
                      WHERE ProductId = p.ProductId
                  )";
        return $this->ExecuteSqlQuery($query, []);
    }

    public function GetProductById($productId) 
    {
        $query = "SELECT 
                    Product.ProductId,
                    Product.ProductName,
                    ProductDetails.ProductPrice,
                    ProductDetails.ProductDate
                   FROM Product 
                   INNER JOIN ProductDetails ON ProductDetails.ProductId = Product.ProductId
                   WHERE Product.ProductId = :productId";

        $params = [
            ':productId' => $productId
        ];

        return $this->ExecuteSqlQuery($query, $params);
    }

    private function ExecuteSqlQuery(string $query, array $params) {
        $statementObject = $this->databaseConnection->prepare($query);
        $statementObject->execute($params);

        if (stripos($query, "SELECT") === 0) {
            return $statementObject->fetchAll(PDO::FETCH_ASSOC);
        }

        return null;
    }
}