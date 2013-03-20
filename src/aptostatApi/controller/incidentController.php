<?php

// Initiate propel
//require_once '/var/www/vendor/propel/propel1/runtime/lib/Propel.php';
Propel::init(__DIR__ . '/../../../build/conf/aptostat_api-conf.php');
set_include_path(__DIR__ . '/../../../build/classes' . PATH_SEPARATOR . get_include_path());

// Load classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

// GET: api/incident - Return a list of incidents
// Nothing working yet

// GET: api/incident/{incidentId} - Return a spesific incident
$app->get('/api/incident/{incidentId}', function($incidentId) use ($app) {
    $incident = new aptostatApi\model\Incident;
    $status = $incident->query($incidentId);

    switch ($status) {
        case 200:
            return $app->json($incident->get(), 200);
            break;
        case 400:
            return $app->json(array(
                'errorCode' => 400,
                'errorDesc' => 'Id requested is not a number'
                ), 400);
            break;
        case 404:
            return $app->json(array(
                'errorCode' => 404,
                'errorDesc' => 'Incident with that ID not found'
                ), 404);
            break;
        default:
            return $app->json(array(
                'errorCode' => 500,
                'errorDesc' => 'Internal server error'
                ), 500);
            break;
    }
});

// POST: api/incident - Create a new incident
$app->post('/api/incident', function(Request $request) use ($app) {
        $incident = new aptostatApi\model\Incident;

        $author = $request->request->get('author');
        $message = $request->request->get('message');
        $flag = $request->request->get('flag');
        $reports = $request->request->get('reports');
        $visibility = $request->request->get('visibility');

        $out = $incident->create($author, $message, $flag, $reports, $visibility);

        if (!is_array($out)) {
            switch ($out) {
                case 400:
                    return $app->json(array(
                        'errorCode' => 400,
                        'errorDesc' => 'Your request is not complete, or something is wrong'
                        ), 400);
                    break;
                default:
                    return $app->json(array(
                        'errorCode' => 500,
                        'errorDesc' => 'Internal server error'
                        ), 500);
                    break;
            }
        }
        return $app->json($out, 200);
});

// PUT: api/incident/{incidentId} - Modify incident
$app->put('/api/incident/{incidentId}', function(Request $request, $incidentId) use ($app) {
    $incident = new aptostatApi\model\Incident;
    $out = null;

    // Add or remove reports
    if ($request->request->get('reports')) {
        $reports = $request->request->get('reports');
        $mode = $request->request->get('mode');

        if ($mode == 'add') {
            $rOut = $incident->addReport($incidentId, $reports);

            switch ($rOut) {
                case 400:
                    return $app->json(array(
                        'errorCode' => 400,
                        'errorDesc' => 'Your request is not complete, or something is wrong'
                        ), 400);
                    break;
                case 404:
                    return $app->json(array(
                        'errorCode' => 404,
                        'errorDesc' => 'Incident with that ID not found '
                                       . 'or the reports you are trying to add do not exist'
                        ), 404);
                    break;
                case 409:
                    return $app->json(array(
                        'errorCode' => 409,
                        'errorDesc' => 'You tried to add a report that is already connected '
                        ), 409);
                    break;
            }
        } elseif ($mode == 'remove' or $mode == 'delete') {
            $rOut = $incident->removeReport($incidentId, $reports);

            switch ($rOut) {
                case 400:
                    return $app->json(array(
                        'errorCode' => 400,
                        'errorDesc' => 'Your request is not complete, or something is wrong'
                        ), 400);
                    break;
                case 404:
                    return $app->json(array(
                        'errorCode' => 404,
                        'errorDesc' => 'Some or all of your requested deletes does not exist'
                        ), 404);
                    break;
            }
        }


    }

    // Add a new message and status to the incident
    if ($request->request->get('message')) {
        $message = $request->request->get('message');
        $author = $request->request->get('author');
        $flag = $request->request->get('flag');
        $visibility = $request->request->get('visibility');

        $mOut = $incident->addMessage($incidentId, $author, $message, $flag, $visibility);

        if (!is_array($mOut)) {
            switch ($mOut) {
                case 400:
                    return $app->json(array(
                        'errorCode' => 400,
                        'errorDesc' => 'Check your request, something is wrong'
                        ), 400);
                    break;
                case 404:
                    return $app->json(array(
                        'errorCode' => 404,
                        'errorDesc' => 'Incident with that ID not found'
                        ), 404);
                    break;
                default:
                    return $app->json(array(
                       'errorCode' => 500,
                       'errorDesc' => 'Internal server error'
                       ), 500);
                    break;
            }
        }
    }

    // Build reponse message
    if (isset($rOut)) {
        $out['reports'] = $rOut;
    }
    if (isset($mOut)) {
        $out['messages'] = $mOut;
    }

    // Return out if some of these operations succeeded, else return 400
    if (is_null($out)) {
        return $app->json(array(
            'errorCode' => 400,
            'errorDesc' => 'Something went wrong. Please check your request'
            ), 400);
    }

    return $app->json($out, 200);
});
