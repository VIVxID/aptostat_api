<?php

namespace aptostatApi\model;

class Uptime
{
    private $feed = array();
    
    public function __construct()
    {
        return $this->query();
    }

    public function query()
    {

        $m = new \Memcached();
        $m->addServer("localhost",11211);

        $out = $m->get("uptime");
        
        if (empty($out)) {
            return 500; // Internal Error
        }
        
        // Store the info
        $this->feed = $out;
        
        return 200; // Ok
    }
    
    public function get()
    {
        return $this->feed;
    }
}
