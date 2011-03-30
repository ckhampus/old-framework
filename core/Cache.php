<?php

class Cache extends Base {
    private $settings;
    private $id;
    private $lifetime;
    private $filename;

    function __construct(Array $settings, $lifetime) {
        $this->settings = $settings;
        $this->lifetime = $lifetime;
    }

    public function start($id) {
        if ($this->lifetime === 0) {
            return FALSE;
        }
    
        $this->id = $id;
        $this->filename = sprintf('%s/%s.tmp', realpath($this->settings['cache_dir']), $this->id);
        
        if (file_exists($this->filename)) {  
            $now = new DateTime();
            
            $cache = explode('|', file_get_contents($this->filename), 2);
            $timestamp = DateTime::createFromFormat(DateTime::W3C, $cache[0]);
            
            if ($now < $timestamp) {
                echo $cache[1];
                
                return TRUE;
            }
        }
        
        ob_start();
        
        return FALSE;
    }
    
    public function end() {
        if ($this->lifetime === 0) {
            return;
        }
    
        $cache = ob_get_flush();
        
        $time = new DateTime();
        $time->modify(sprintf('%s seconds', $this->lifetime));
        
        file_put_contents($this->filename, sprintf('%s|%s', $time->format(DateTime::W3C), $cache));
    }
}