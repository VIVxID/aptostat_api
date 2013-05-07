<?php

namespace aptostatApi\Service;

class LiveService
{
    public function getRealTimeData()
    {
        $cache = new \Memcached();
        $cache->addServer("localhost",11211);

        $realTimeData = $cache->get("live");

        if (empty($realTimeData)) {
            throw new \Exception('Could not fetch cached liveData', 500);
        }

        return $realTimeData;
    }
}
