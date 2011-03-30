<?php

require_once('Container.php');

class Framework extends Base {

    private $container;

    function __construct() {
        $this->conatiner = new Container();

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

    public function route($url, $class) {
        $this->container['routes'][] = array(
            'url' => $url,
            'class' => $class,
            'lifetime' => $lifetime
        );
    }

    public function run() {
        $this->container['router']->dispatch();
    }
}
