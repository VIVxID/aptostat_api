<?php


namespace aptostatApi\Service;

class KillswitchService
{
    public function getSwitchStatus()
    {
        if (file_exists('../../../app/lock/gatherKill.lock')) {
            return array('killswitchStatus' => 'on');
        } else {
            return array('killswitchStatus' => 'off');
        }
    }

    public function killSystem()
    {
        if (file_exists('../../../app/lock/gatherKill.lock')) {
            return array(
                'killswitchStatus' => 'on',
                'message' => 'The system has already been stopped from fetching new reports'
            );
        } else {
            touch("../../../app/lock/gatherKill.lock");

            if (!file_exists('../../../app/lock/gatherKill.lock')) {
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
        if (!file_exists('../../../app/lock/gatherKill.lock')) {
            return array(
                'killswitchStatus' => 'off',
                'message' => 'The system is already running'
            );
        } else {
            delete("../../../app/lock/gatherKill.lock");

            if (file_exists('gatherKill.lock')) {
                throw new \Exception('Could not turn on the system. Contact admin.', 500);
            }

            return array(
                'killswitchStatus' => 'off',
                'message' => 'The system has started fetching new reports'
            );
        }
    }
}