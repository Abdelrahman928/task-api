<?php 

use App\core\App;
use App\core\Database;
use App\core\ServiceContainer;

$container = new ServiceContainer();

try {
    $container->bind('App\core\Database', function () {
        $config = require 'config.php';
        $database = new Database($config);

        return $database->connect();
    });
} catch (\Exception $e) {
    echo 'Error binding database: ' . $e->getMessage();
    exit;
}

App::setContainer($container);