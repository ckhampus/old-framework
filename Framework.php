<?php

require_once('core/Base.php');
require_once('core/Container.php');
require_once('core/Controller.php');
require_once('core/Router.php');

class Framework extends Base {

    private $container;

    function __construct() {
        $this->container = new Container();

        // Settings array
        $this->container['settings'] = array(
            'cache_dir' => './cache',
            'controller_dir' => './controllers',
            'view_dir' => './views'
        );

        // Routes array
        $this->container['routes'] = array();

        // Router object
        $this->container['router'] = function($c) {
            return new Router($c['routes'], $c['settings']);
        };
    }

    public function route($url, $callback, $lifetime = NULL) {
        $regexp = array(
            '/:[a-zA-Z_][a-zA-Z0-9_]*/' => '[\w]+',
            '/\*/' => '.+'
        );
    
        $routes = $this->container['routes'];
        
        $route = array(
            'url' => $url,
            'class' => $callback,
            'lifetime' => $lifetime,
            'regexp' => str_replace('/', '\/', $url)
        );
        
        foreach ($regexp as $key => $value) {
            $route['regexp'] = preg_replace($key, $value, $route['regexp']);
        }
        
        $routes[] = $route;
        $this->container['routes'] = $routes;
    }

    public function run() {
        $router = $this->container['router']->dispatch();
    }
}
