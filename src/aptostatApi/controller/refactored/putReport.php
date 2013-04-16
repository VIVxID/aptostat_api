<?php
// Init propel
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());

$out = array();

//Check the input.
if (!is_null($reportId)) {

    //Set parameters.
    $resolveReport = new ReportStatus();
    $resolveReport->setIdReport($reportId);
    $resolveReport->setTimestamp(time());
    $resolveReport->setIdFlag('6');

    //Save to database.
    $resolveReport->save();

    //Return the added report.
    $out["resolved"] = $reportId;

}

//Check the return array and set HTML-codes.
if (empty($out)) {

    $code = 400;
    $out = array(
            'error' => array(
                'errorCode' => 400,
                'errorMessage' => 'Nothing was changed.',
            ),
        );


} else {

    $code = 200;

}
