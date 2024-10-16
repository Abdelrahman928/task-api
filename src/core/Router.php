<?php

namespace App\core;

class Router
{
    protected $routes = [];

    public function get($uri, $controllerAction)
    {
        $this->routes['GET'][$uri] = $controllerAction;
    }

    public function post($uri, $controllerAction)
    {
        $this->routes['POST'][$uri] = $controllerAction;
    }

    public function delete($uri, $controllerAction)
    {
        $this->routes['DELETE'][$uri] = $controllerAction;
    }

    public function route($requestMethod, $requestUri) {
        if (!isset($this->routes[$requestMethod])) {
            http_response_code(404);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        foreach ($this->routes[$requestMethod] as $uri => $action) {
            if ($uri === $requestUri) {
                list($controller, $method) = explode('@', $action);
                $controllerInstance = new $controller();

                if ($requestMethod === 'POST') {
                    if (method_exists($controllerInstance, $method)) {
                        $requestData = json_decode(file_get_contents('php://input'), true);
                        $requestData = $requestData === null ? [] : $requestData;

                        $controllerInstance->$method($requestData);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Method not found']);
                        return;
                    }
                } elseif ($requestMethod === 'GET') {
                    if (method_exists($controllerInstance, $method)) {
                        $controllerInstance->$method();
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Method not found']);
                        return;
                    }
                } elseif ($requestMethod === 'DELETE'){
                    if (method_exists($controllerInstance, $method)) {
                        $requestData = json_decode(file_get_contents('php://input'), true);
                        $requestData = $requestData === null ? [] : $requestData;
                        $controllerInstance->$method($requestData);
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Method not found']);
                        return;
                    }
                }
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
}