<?php

namespace aptostatApi\model;

class Live
{
    private $feed = array();
    
    public function __construct()
    {
        return $this->query();
    }
    
    public function query()
    {   
        $out = null;
        $m = new Memcached();
        $m->connect("localhost",11211);
    
        if ($m->get("live") === false) {
        
            $login = file('/var/apto/ping', FILE_IGNORE_NEW_LINES);
            $curl = curl_init();
        
            $options = array(
                CURLOPT_URL => "https://api.pingdom.com/api/2.0/checks",
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_USERPWD => $login[0].":".$login[1],
                CURLOPT_HTTPHEADER => array("App-Key: ".$login[2]),
                CURLOPT_RETURNTRANSFER => true
                );
            
            // Execute 
            curl_setopt_array($curl,$options);
            $response = json_decode(curl_exec($curl),true);
            $checkList = $response["checks"];
            $m->set("live", $response["checks"], 60);
            
        
        } else {
        
            $checkList = $m->get("live");
        
        }
        
        // Format the information
        foreach ($checkList as $check) {
            switch ($check["name"]) {
                case "DrVideo Encoding":
                    $out["DrVideo Encoding"] = $check["status"];
                    break;
                case "DrVideo Backoffice":
                    $out["DrVideo Backoffice"] = $check["status"];
                    break;
                case "DrVideo CDN":
                    $out["DrVideo CDN"] = $check["status"];
                    break;
                case "DrVideo API":
                    $out["DrVideo API"] = $check["status"];
                    break;
                case "DrFront Backoffice":
                    $out["DrFront Backoffice"] = $check["status"];
                    break;
                case "DrPublish Backoffice":
                    $out["DrPublish Backoffice"] = $check["status"];
                    break;
                case "DrPublish API":
                    $out["DrPublish API"] = $check["status"];
                    break;
                case "Atika Backoffice":
                    $out["Atika Backoffice"] = $check["status"];
                    break;
            }
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
