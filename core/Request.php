<?php

require_once('Base.php');
require_once('Mime.php');

/**
 * Request 
 * 
 * @package Framework
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class Request extends Base {
    private $headers = array();
    private $body = NULL;
    
    function __construct() {
        $this->addProperty('isXMLHttpRequest');

        foreach ($_SERVER as $key => $val) {
            if (strpos($key, 'HTTP_') === 0) {
                $name = str_replace(array('HTTP_', '_'), array('', '-'), $key);
                $this->headers[$name] = $value;
            }
        }

        $this->isXMLHttpRequest = isset($this->header('X-Requested-With'));

        $this->body = file_get_contents('php://input');
    }

    /**
     * Get the request header key.
     * 
     * @param mixed $key 
     * @return string
     */
    public function header($key) {
        if (!isset($this->headers[$key])) {
            //throw new InvalidArgumentException('Invalid request header key.');
        }
        
        if ($key === 'Referer') {
            $key = 'Referrer';
        }

        return $this->headers[$key];
    }

    /**
     * Check if the Accept header is present, and includes the given type. 
     * 
     * @param string $type 
     * @return bool
     */
    public function accept($type) {
        $type = (strpos($type, '/') === FALSE) ? Mime::lookupSubtype($type) : $type;
        
        try {
            return (strpos($this->header('Accept'), $type));
        } catch (Exception $e) {
            return FALSE;
        }
    }

    /**
     * Check if the incoming request contains the Content-Type 
     * header field, and it contains the give mime type.
     * 
     * @param string $type 
     * @return bool
     */
    public function is($type) {
        $type = (strpos($type, '/') === FALSE) ? Mime::lookupSubtype($type) : $type);

        try {
            return (strpos($this->header('Content-Type'), $type));
        } catch (Exception $e) {
            return FALSE;
        }
    }
}
