<?php 

namespace App\core;

use App\core\ProductManager;

class Validator extends ProductManager{

    public static function validate($data){
        $errors = [];

        if (!isset($data['type'])) {
            $errors['type'] = 'type is required.';
        }

        if (!array_key_exists($data['type'], ProductManager::$productTypes)) {
            $errors['type'] = 'please enter a valid product type.';
        }

        if (!self::validateUniqueSku($data['sku'])) {
            $errors['sku'] = 'the SKU you provided belongs to an existing item.';
        }

        if (empty($data['sku'])) {
            $errors['sku'] = 'SKU is required';
        }

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }

        if (empty($data['price']) || !is_numeric($data['price'])) {
            $errors['price'] = 'Valid price is required';
        }
  
        if ($data['type'] === 'dvd') {
            if((empty($data['size']))){
                $errors['specificAttributes'] = 'size is required for for DVDs';
            }elseif(!is_numeric($data['size'])){
                $errors['specificAttributes'] = 'size must be a number.';
            }
        }

        if ($data['type'] === 'furniture') {
            if ((empty($data['height']) || empty($data['width']) || empty($data['length']))){
                $errors['specificAttributes'] = 'Height, width, and length are required for furniture';
            }elseif(!is_numeric($data['height']) || !is_numeric($data['width']) || !is_numeric($data['length'])){
                $errors['specificAttributes'] = 'height, width, and length fields must be a number.';
            }
        }

        if ($data['type'] === 'book') {
            if((empty($data['weight']))){
                $errors['specificAttributes'] = 'weight is required for for books';
            }elseif(!is_numeric($data['weight'])){
                $errors['specificAttributes'] = 'weight must be a number.';
            }
        }

        return $errors;
    }
}