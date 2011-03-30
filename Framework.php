<?php

require_once('core/Base.php');
require_once('core/Cache.php');
require_once('core/Container.php');
require_once('core/Controller.php');
require_once('core/Router.php');

class Framework extends Base {

    private $container;

    /**
     * Initialize the framework.
     * 
     * @access protected
     * @return void
     */
    function __construct() {
        // Create a new container ovbject
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

    /**
     * Specify a route.
     * 
     * @param string $url 
     * @param string $callback 
     * @param int $lifetime 
     */
    public function route($url, $class, $lifetime = 0) {
        $regexp = array(
            '/:[a-zA-Z_][a-zA-Z0-9_]*/' => '[\w]+',
            '/\*/' => '.+'
        );
    
        $routes = $this->container['routes'];
        
        $route = array(
            'url' => $url,
            'class' => $class,
            'lifetime' => $lifetime,
            'regexp' => str_replace('/', '\/', $url)
        );
        
        foreach ($regexp as $key => $value) {
            $route['regexp'] = preg_replace($key, $value, $route['regexp']);
        }
        
        $routes[] = $route;
        $this->container['routes'] = $routes;
    }

    /**
     * Executes the framework. 
     */
    public function run() {
        $router = $this->container['router']->dispatch();
    }
}
