<?php

require_once('Base.php');

abstract class Controller extends Base  {

    /**
     * Method that handle HTTP GET method 
     * 
     * @return void
     */
    public function get() {
        throw new BadMethodCallException('Method not implemented.');
    }

    /**
     * Method that handle HTTP POST method 
     * 
     * @return void
     */
    public function post() {
        throw new BadMethodCallException('Method not implemented.');
    }


    /**
     * Method that handle HTTP PUT method 
     * 
     * @return void
     */
    public function put() {
        throw new BadMethodCallException('Method not implemented.');
    }

    /**
     * Method that handle HTTP DELETE method 
     * 
     * @return void
     */
    public function delete() {
        throw new BadMethodCallException('Method not implemented.');
    }
}
