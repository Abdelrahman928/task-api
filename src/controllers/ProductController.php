<?php

namespace App\controllers;

use App\core\Validator;
use App\core\ProductManager;

class ProductController{

    public function create($request){
        $validationErrors = Validator::validate($request);

        if(!empty($validationErrors)){
            http_response_code(422);
            echo json_encode([
                'status' => 422,
                'message' => $validationErrors
            ]);
            return;
        }
        $product = ProductManager::create($request);
        $product->save();

        http_response_code(201);
        echo json_encode([
            'status' => 201,
            'message' => 'Product created successfully.'
        ]);
    }

    public function index(){
        $products = ProductManager::getAll();

        if(Empty($products)){
            http_response_code(404);
            echo json_encode([
                'status' => 404,
                'message' => 'no products found.'
            ]);
            return;
        }
        http_response_code(200);
        echo json_encode([
            'status' => 200,
            'products' => $products
        ]);
    }

    public function destroy($request){
        if (!isset($request['ids']) || !is_array($request['ids'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input. Please provide an array of ids to delete.']);
            return;
        }

        if (ProductManager::destroy($request['ids'])) {
            http_response_code(200);
            echo json_encode([
                'status' => 200,
                'message' => 'Product deleted successfully.'
            ]);
            return;
        }
    
        http_response_code(404);
        echo json_encode([
            'status' => 404,
            'error' => 'Product not found.'
        ]);
    }
}

