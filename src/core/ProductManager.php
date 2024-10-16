<?php 

namespace App\core;

use App\models\DVD;
use App\models\Book;
use App\models\Furniture;
use App\core\App;
use PDO;

class ProductManager {
    protected $connection;
    protected static $productTypes = [
        'dvd' => DVD::class,
        'book' => Book::class,
        'furniture' => Furniture::class,
    ];

    public static function create($data) {
        if (App::container() === null) {
            throw new \Exception('Service container is not set.');
        }

        $connection = App::container()->resolve('App\core\Database');

        $productClass = self::$productTypes[$data['type']];
        $product = new $productClass($connection); 

        $product->setType($data['type']);
        $product->setSku($data['sku']);
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setSpecificAttributes($data);

        return $product;
    }

    public static function getAll(){
        $connection = App::container()->resolve('App\core\Database');
        $sql = "SELECT * FROM products";
        $stmt = $connection->prepare($sql);
        $stmt->execute();

        $productdata = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        
        foreach($productdata as $data){
            $type = $data['type'];
            $productClass = self::$productTypes[$type];
            $product = new $productClass($connection);

            $product->setId($data['id']);
            $product->setType($data['type']);
            $product->setSku($data['SKU']);
            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setSpecificAttributes($data);

            $products[] = [
                'id' => $product->getId(),
                'type' => $product->getType(),
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'specificAttributes' => $product->getSpecificAttributes(),
            ];
        }
        return $products;

        // $filteredProducts = array_map(function($product) {
        //     return array_filter($product, function($value) {
        //         return !is_null($value);
        //     });
        // }, $products);

        // return $filteredProducts;
    }

    public static function destroy(Array $ids){
        $connection = App::container()->resolve('App\core\Database');
        $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
        $sql = "DELETE FROM products where id IN ($placeholders)";
        $stmt = $connection->prepare($sql);
        $stmt->execute($ids);
        return $stmt->rowCount() > 0;
    }

    public static function validateUniqueSku($sku) {
        $connection = App::container()->resolve('App\core\Database');
        $sql = "SELECT COUNT(*) FROM products WHERE SKU = ?";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$sku]);
    
        return $stmt->fetchColumn() == 0;
    }
}