<?php

/**
 * Controller 
 * 
 * @package Framework
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author  
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class Controller extends Base  {

    /**
     * Method that handle HTTP GET method 
     */
    public function get() {
        throw new BadMethodCallException('Method not implemented.');
    }

    /**
     * Method that handle HTTP POST method 
     */
    public function post() {
        throw new BadMethodCallException('Method not implemented.');
    }


    /**
     * Method that handle HTTP PUT method 
     */
    public function put() {
        throw new BadMethodCallException('Method not implemented.');
    }

    /**
     * Method that handle HTTP DELETE method 
     */
    public function delete() {
        throw new BadMethodCallException('Method not implemented.');
    }
}
