<?php

require_once '/var/www/vendor/propel/propel1/runtime/lib/Propel.php';
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());


$match = ReportQuery::create()
            ->filterByTimestamp('2013-02-26 13:55:30')
            ->useServiceQuery()
                ->filterByName('Test Service')
            ->endUse()
            ->useGroupsQuery()
                ->filterByProposedFlag('1')
            ->endUse()
            ->filterByCheckType('Test')
            ->find();


