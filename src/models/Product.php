<?php

namespace App\models;

abstract class Product{
    protected $connection;
    protected $id;
    protected $sku;
    protected $name;
    protected $price;
    protected $type;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setType($type){
        $this->type = $type;
    }

    public function setSku($sku) {
        $this->sku = $sku;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getId() {
        return $this->id;
    }

    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getType(){
        return $this->type;
    }

    abstract public function save();
    abstract public function setSpecificAttributes($data);
}