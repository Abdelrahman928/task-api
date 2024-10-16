<?php 

namespace App\models;

class Furniture extends Product {
    protected $height;
    protected $width;
    protected $length;

    public function __construct($connection) {
        parent::__construct($connection);
    }

    public function setheight($height) {
        $this->height = $height;
    }

    public function setwidth($width) {
        $this->width = $width;
    }

    public function setlength($length) {
        $this->length = $length;
    }

    public function getheight() {
        return $this->height;
    }

    public function getwidth() {
        return $this->width;
    }

    public function getlength() {
        return $this->length;
    }

    public function save() {
        $sql = "INSERT INTO products (sku, name, price, type, height, width, length) VALUES (?, ?, ?, 'furniture', ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$this->sku, $this->name, $this->price, $this->height, $this->width, $this->length]);
    }

    public function setSpecificAttributes($data) {
        $this->setheight($data['height']);
        $this->setwidth($data['width']);
        $this->setlength($data['length']);
    }

    public function getSpecificAttributes() {
        return [
            'height' => $this->getheight(),
            'width' => $this->getwidth(),
            'length' => $this->getlength()
        ];
    }
}