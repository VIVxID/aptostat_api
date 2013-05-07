<?php


namespace aptostatApi\Service;

class KillswitchService
{
    private $gatherKillPath;

    public function __construct()
    {
        $this->gatherKillPath = __DIR__ . '/../../../app/lock/gatherKill.lock';
    }

    public function getSwitchStatus()
    {
        if (file_exists($this->gatherKillPath)) {
            return array('killswitchStatus' => 'on');
        } else {
            return array('killswitchStatus' => 'off');
        }
    }

    public function killSystem()
    {
        if (file_exists($this->gatherKillPath)) {
            return array(
                'killswitchStatus' => 'on',
                'message' => 'The system has already been stopped from fetching new reports'
            );
        } else {
            touch($this->gatherKillPath);

            if (!file_exists($this->gatherKillPath)) {
                throw new \Exception('Could not shut down the system. Contact admin.', 500);
            }

            return array(
                'killswitchStatus' => 'on',
                'message' => 'The system has stopped fetching new reports'
            );
        }
    }

    public function reviveSystem()
    {
        if (!file_exists($this->gatherKillPath)) {
            return array(
                'killswitchStatus' => 'off',
                'message' => 'The system is already running'
            );
        } else {
            unlink($this->gatherKillPath);

            if (file_exists($this->gatherKillPath)) {
                throw new \Exception('Could not turn on the system. Contact admin.', 500);
            }

            return array(
                'killswitchStatus' => 'off',
                'message' => 'The system has started fetching new reports'
            );
        }
    }
}
