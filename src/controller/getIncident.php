<?php

$out = array('message' => 'The user was not found.');
$code = 200;



if (isset($incidentId)) {
	$out['incidentId'] = $incidentId;
}
