<?php 

namespace App\models;

class Book extends Product {
    protected $weight;

    public function __construct($connection) {
        parent::__construct($connection);
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function save() {
        $sql = "INSERT INTO products (sku, name, price, type, weight) VALUES (?, ?, ?, 'book', ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$this->sku, $this->name, $this->price, $this->weight]);
    }

    public function setSpecificAttributes($data) {
        $this->setWeight($data['weight']);
    }
    
    public function getSpecificAttributes() {
        return [
            'weight' => $this->getWeight()
        ];
    }
}