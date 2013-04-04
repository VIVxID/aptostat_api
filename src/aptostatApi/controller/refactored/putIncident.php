<?php

// Init propel
Propel::init("/var/www/build/conf/aptostat-conf.php");
set_include_path("/var/www/build/classes" . PATH_SEPARATOR . get_include_path());

$out = array();

//Check for added reports.
if (!is_null($request->request->get('reports'))) {

    $reports = $request->request->get('reports');

    //The API accepts any number of reports at a time. Either as an array or a single variable.
    if (is_array($reports)) {

        foreach ($reports as $report) {

            //Set parameters.
            $addReport = new IncidentReport();
            $addReport->setIdReport($report);
            $addReport->setIdIncident($incidentId);

            //Save to database.
            $addReport->save();

            //Return the added reports.
            $out["reports"][] = $report;

        }
    } else {

        //Set parameters.
        $addReport = new IncidentReport();
        $addReport->setIdReport($reports);
        $addReport->setIdIncident($incidentId);

        //Save to database.
        $addReport->save();

        //Return the added report.
        $out["reports"] = $reports;

    }
}

//Check for added message.
if (!is_null($request->request->get('message'))) {

    $message = $request->request->get('message');

    $text = $message["text"];
    $author = $message["author"];
    $visible = $message["visible"];
    $flag = $message["flag"];

    //Set parameters.
    $addMessage = new Message();
    $addMessage->setIdIncident($incidentId);
    $addMessage->setText($text);
    $addMessage->setAuthor($author);
    $addMessage->setVisible($visible);
    $addMessage->setTimestamp(time());
    $addMessage->setIdFlag($flag);

    //Save to database.
    $addMessage->save();

    //Return the added message.
    $out["message"] = array(
                        "message" => $text,
                        "author" => $author,
                        "visible" => $visible,
                        "flag" => $flag
                        );

}

//Check the return array and set HTML-codes.
if (empty($out)) {

    $code = 400;
    $out = array(
            'error' => array(
                'errorCode' => 400,
                'errorMessage' => 'No data was added.',
            ),
        );


} else {

    $code = 200;

}
