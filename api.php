<?php

$router->get('/', 'App\controllers\ProductController@index');
$router->post('/add-product', 'App\controllers\ProductController@create');
$router->delete('/products', 'App\controllers\ProductController@destroy');

