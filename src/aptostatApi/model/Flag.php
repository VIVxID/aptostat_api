<?php



namespace aptostatApi\model;


class Flag
{
    public static function getFlags()
    {
        return array(
            'WARNING',
            'CRITICAL',
            'INTERNAL',
            'IGNORED',
            'RESPONDING',
            'RESOLVED',
        );
    }
}
