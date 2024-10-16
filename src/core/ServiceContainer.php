<?php 

namespace App\core;

class ServiceContainer {

    protected $bindings = []; 

    public function bind($key, $fn){
        $this->bindings[$key] = $fn;
    }

    public function resolve($key){
        if (!array_key_exists($key, $this->bindings)) {
            throw new \Exception("No matching binding found for {$key}");
        }

        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }
}