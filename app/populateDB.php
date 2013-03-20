<?php

$app = include 'app.php';

$generator = \Faker\Factory::create();
$populator = new Faker\ORM\Propel\Populator($generator);
$populator->addEntity('Service', 5);
$populator->addEntity('Source', 5);
$populator->addEntity('Flag', 5);
$populator->addEntity('Incident', 5);
$populator->addEntity('Report', 5);
$populator->addEntity('ReportStatus', 1, array(
        'Timestamp' => $generator->dateTime
    ));
$populator->addEntity('IncidentReport', 1);
$populator->addEntity('Message', 5);
$insertedPKs = $populator->execute();

foreach ($insertedPKs as $model => $items) {
    echo sprintf(
        'Created %s %s%s' .PHP_EOL,
        count($items),
        $model,
        count($items) !== 1 ? 's' : ''
    );
}
