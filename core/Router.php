<?php

/**
 * Router 
 *
 * The router class is responsible for routing
 * requests to the right classes and function.
 * 
 * @package Framework
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Router extends Base {    
    private $routes = array();
    private $settings = array();

    /**
     * Creates a new router. 
     * 
     * @param Array $routes 
     * @param Array $settings 
     * @access protected
     */
    function __construct(Array $routes, Array $settings) {
        $this->routes = $routes;
        $this->settings = $settings;
    }

    /**
     * Dispatches the request to the right class.
     * 
     * @return bool
     */
    public function dispatch() {
        $request = parse_url(self::getCurrentUrl());
        $base = parse_url(self::getBaseUrl());

        $requested_path = str_replace('//', '/', str_replace(self::getScriptName(), '', $request['path']));

        $path = substr($requested_path, strlen($base['path']));

        foreach ($this->routes as $route) {
            $arguments = array_diff(explode('/', $path), explode('/', $route['url']));
            //$class = str_replace(' ', '', ucwords(str_replace('-', ' ', $route['class'])));
            $filename = realpath(sprintf('%s/%s.php', $this->settings['controller_dir'], $route['class']));
      
            if (preg_match(sprintf('/^%s$/', $route['regexp']), $path)) {
                if (file_exists($filename)) {
                    
                    $cache = new Cache($this->settings, $route['lifetime']);
                    
                    if (!$cache->start('cache_' . md5($path))) {
                    
                        include_once($filename);

                        $object = new $route['class']($this->settings);
                    
                        call_user_func_array(array($object, $_SERVER['REQUEST_METHOD']), $arguments);
                        
                        $cache->end();
                    }
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    /**
     * Returns the script name of the
     * file that includes the framework. 
     * 
     * @static
     * @return string
     */
    public static function getScriptName() {
        $script_name = $_SERVER['SCRIPT_NAME'];

        return substr($script_name, strripos($script_name, '/') + 1);
    }

    /**
     * Returns the current url.  
     * 
     * @static
     * @return string
     */
    public static function getCurrentUrl() {
        $url = self::getBaseUrl();
        $url .= substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));

        return $url;
    }

    /**
     * Return the url of the script
     * file that includes the framework.
     * 
     * @static
     * @return string
     */
    public static function getScriptUrl() {
        $url = self::getBaseUrl();
        $url .= '/'.self::getScriptName();

        return $url;
    }

    /**
     * Returns the base url of the script. 
     * 
     * @static
     * @return string
     */
    public static function getBaseUrl() {
        $url = 'http';

        if (isset($_SERVER['HTTPS'])) {
            $url .= 's';
        }

        $url .= sprintf('://%s', $_SERVER['SERVER_NAME']);
        $url .= $_SERVER['SCRIPT_NAME'];

        return str_replace(sprintf('/%s', self::getScriptName()), '', $url);
    }
}
