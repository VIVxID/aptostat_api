<?php

namespace aptostatApi\Service;

class UptimeService
{
    public function getUptimeData()
    {
        $cache = new \Memcached();
        $cache->addServer("localhost",11211);

        $uptimeData = $cache->get("uptime");

        if (empty($uptimeData)) {
            throw new \Exception('Could not fetch cached uptimeData', 500);
        }

        return $uptimeData;
    }
}
