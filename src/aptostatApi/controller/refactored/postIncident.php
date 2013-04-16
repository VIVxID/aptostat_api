<?php

// Init propel
require_once '/var/www/vendor/propel/propel1/runtime/lib/Propel.php';
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());

// Fetch parameters
$author = $request->request->get('author');
$text = $request->request->get('message');
$flag = $request->request->get('flag');
$reports = $request->request->get('reports');
$visible = $request->request->get('visible');

// Validate parameters
if (is_null($author) or strlen($author) > 20 ) {
    $out = array('error' => 'An incident must have an author, which cannot exceed 20 characters.');
    $code = 418;
} elseif (is_null($text) or strlen($text) > 255) {
    $out = array('error' => 'An incident must have a message, which cannot exceed 255 characters.');
    $code = 418;
} elseif (is_null($flag) or !preg_match('/^[1-6]{1}$/', $flag)) {
    $out = array('error' => 'Flag is missing or not a number.');
    $code = 418;
} elseif (is_null($visible) or !preg_match('/^[1-6]{1}$/', $flag)) {
    $out = array('error' => 'Visibility is missing or not a number.');
    $code = 418;
} elseif (is_null($reports)) {
    $out = array('error' => 'An incident must contain one or more valid reports.');
    $code = 418;
} else {

    $incident = new Incident();
    $incident->setTimestamp(time());
    $incident->save();

    $message = new Message();
    $message->setTimestamp(time());
    $message->setIdFlag($flag);
    $message->setAuthor($author);
    $message->setText($text);
    $message->setVisible($visible);
    $message->setIdIncident($incident->getIdIncident());
    $message->save();

    if (is_array($reports)) {

        foreach ($reports as $report) {

            $link = new IncidentReport();
            $link->setIdIncident($incident->getIdIncident());
            $link->setIdReport($report);
            $link->save();

            $out['incident '.$incident->getIdIncident()]['reports'][] = $report;


        }

    } else {

        $link = new IncidentReport();
        $link->setIdIncident($incident->getIdIncident());
        $link->setIdReport($reports);
        $link->save();

        $out['incident '.$incident->getIdIncident()]['report'][] = $reports;

    }

    $out['incident '.$incident->getIdIncident()]['message'] = array(
        'author' => $author,
        'text' => $text,
        'timestamp' => $incident->getTimestamp(),
        'visible' => $visible,
        'flag' => $flag
    );

    $code = 200;
}
