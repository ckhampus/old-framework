<?php

/**
 * Base 
 * 
 * @package Framework
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @author Cristian Hampus
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
abstract class Base {
    private $properties = array();

    /**
     * Add property to class. 
     * 
     * @param mixed $name 
     * @param mixed $value 
     */
    protected function addProperty($name, $value = NULL) {
        $this->properties[$name] = $value;
    }

    /**
     * Magic method for setting properties. 
     * 
     * @param mixed $property 
     * @param mixed $value 
     */
    public function __set($property, $value) {
        $methodname = sprintf('_set%s', ucwords($property));

        if (array_key_exists($property, $this->properties)) {
            if (method_exists($this, $methodname)) {
                $this->properties[$property] = $this->$methodname($value);
            } else {
                $this->properties[$property] = $value;
            }
        } else {
            throw new Exception(sprintf('Property "%s" does not exist.', $property));
        }
    }

    /**
     * Magic method for getting properties. 
     * 
     * @param mixed $property 
     * @param mixed $value 
     * @return mixed
     */
    public function __get($property) {
        $methodname = sprintf('_get%s', ucwords($property));

        if (array_key_exists($property, $this->properties)) {
            if (method_exists($this, $methodname)) {
                return $this->$methodname();
            } else {
                return $this->properties[$property];
            }
        } else {
            throw new Exception(sprintf('Property "%s" does not exist.', $property));
        }
    }

}
