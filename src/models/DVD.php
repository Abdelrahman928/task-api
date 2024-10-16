<?php 

namespace App\models;

class DVD extends Product {
    private $size;

    public function __construct($connection) {
        parent::__construct($connection);
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getSize() {
        return $this->size;
    }

    public function save() {
        $sql = "INSERT INTO products (sku, name, price, type, size) VALUES (?, ?, ?, 'dvd', ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$this->sku, $this->name, $this->price, $this->size]);
    }

    public function setSpecificAttributes($data) {
        $this->setSize($data['size']);
    }
   
    public function getSpecificAttributes() {
        return [
            'size' => $this->getSize()
        ];
    }
}