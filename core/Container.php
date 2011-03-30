<?php
/**
 * Container 
 * 
 * @uses ArrayAccess
 * @package Framework
 * @version //autogen//
 * @copyright Copyright (c) 2010 All rights reserved.
 * @author Cristian Hampus
 * @license PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class Container implements ArrayAccess {
    /**
     *  Array containing all the objects.
     */
    private static $values = array();
    
    private function get($id) {
        if (!isset(self::$values[$id])) {
            throw new InvalidArgumentException(sprintf('Identifier "%s" is not defined', $id));
        }
        
        return is_callable(self::$values[$id]) ? call_user_func(self::$values[$id], $this) : self::$values[$id];
    }
    
    
    /**
     * Add an array of values to the container.
     * 
     * @param Array $values 
     * @access public
     * @return void
     */
    public function addValues(Array $values) {
        self::$values = array_merge(self::$values, $values);
    }

    /**
     * Assigns a value to the specified offset. 
     * 
     * @param mixed $id 
     * @param mixed $value
     * @access public 
     * @return void
     */
    public function offsetSet($id, $value) {
        self::$values[$id] = $value;
    }

    /**
     * Returns the value at the specified offset.
     * 
     * @param mixed $id
     * @access public
     * @return void
     */
    public function offsetGet($id) {
        if (!isset(self::$values[$id])) {
            throw new InvalidArgumentException(sprintf('Identifier "%s" is not defined', $id));
        }
        
        return is_callable(self::$values[$id]) ? call_user_func(self::$values[$id], $this) : self::$values[$id];
    }

    /**
     * Checks whether or not an offset exists.
     * 
     * @param mixed $id
     * @access public 
     * @return void
     */
    public function offsetExists($id) {
        return isset(self::$values[$id]);
    }

    /**
     * Unsets an offset.
     * 
     * @param mixed $id
     * @access public 
     * @return void
     */
    public function offsetUnset($id) {
        unset(self::$values[$id]);
    } 
}
