<?php

namespace aptostatApi\model;

class Uptime
{
    private $feed = array();
    private $hosts = array(
            "Atika Backoffice" => 615766,
            "DrVideo Encoding" => 615772,
            "DrFront Backoffice" => 615760,
            "DrVideo Backoffice" => 615764,
            "DrVideo CDN" => 615768,
            "DrVideo API" => 615770,
            "DrPublish Backoffice" => 615767,
            "DrPublish API" => 615771);
    
    public function __construct()
    {
        return $this->query();
    }

    public function query()
    {
        $login = file('/var/apto/ping', FILE_IGNORE_NEW_LINES);
        $curl = curl_init();
        $out = array();
        $m = new Memcached();
        $m->addServer("localhost",11211);
    
        if (!$m->get("uptime")) {
        
            foreach ($this->hosts as $hostName => $hostID) {
        
                $options = array(
                    CURLOPT_URL => "https://api.pingdom.com/api/2.0/summary.outage/$hostID",
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_USERPWD => $login[0].":".$login[1],
                    CURLOPT_HTTPHEADER => array("App-Key: ".$login[2]),
                    CURLOPT_RETURNTRANSFER => true
                    );
            
                // Execute 
                curl_setopt_array($curl,$options);
                $response = json_decode(curl_exec($curl),true);
                $checkList = $response["summary"]["states"];
                
                foreach ($checkList as $check) {
                
                    if ($check["status"] != "up") {
             
                        $out[$hostName][$check["timefrom"] = $check["status"];
                    
                    }
                }
            }
            
            $m->set("uptime", $out, 60);
            
        } else {
        
            $out = $m->get("live");
        
        }
        
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
