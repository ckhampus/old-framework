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

        $this->container['routes'] = array();

        
        $this->container['router'] = function($c) {
            return new Router($c['routes'], $c['settings']);
        };
    }

    public function route($url, $class, $lifetime = NULL) {
        $regexp = array(
            '/:[a-zA-Z_][a-zA-Z0-9_]*/' => '[\w]+',
            '/\*/' => '.+'
        );
    
        // PHP <5.3.4 can't pass by reference via offsetGet.
        $c = $this->container['routes'];
        
        $temp = array(
            'url' => $url,
            'class' => $class,
            'lifetime' => $lifetime,
            'regexp' => str_replace('/', '\/', $url)
        );
        
        foreach ($regexp as $key => $value) {
            $temp['regexp'] = preg_replace($key, $value, $temp['regexp']);
        }
        
        $c[] = $temp;
        
        $this->container['routes'] = $c;
    }

    public function run() {
        $router = $this->container['router']->dispatch();
    }
}
