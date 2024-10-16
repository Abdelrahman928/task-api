<?php

$router->get('/', 'App\Controllers\ProductController@index');
$router->post('/add-product', 'App\Controllers\ProductController@create');
$router->delete('/products', 'App\Controllers\ProductController@destroy');

