<?php

require_once '/var/www/vendor/propel/propel1/runtime/lib/Propel.php';
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());

$source = new Source();
$source->setName('Test Source');

$group = new Groups();
$group->setProposedFlag('1');

$service = new Service();
$service->setName('Test Service');

$report = new Report();
$report->setErrorMessage('Test Message');
$report->setTimestamp('2013-02-26 13:55:30');
$report->setCheckType('Test');

$source->addReport($report);
$service->addReport($report);
$group->addReport($report);
$report->save();
