<?php
$startTime = microtime(true);
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpKernel\Debug\ErrorHandler;
ErrorHandler::register(); // Convert errors to exceptions

// Set up default config
$config = array(
    'debug' => true,
    'timer.start' => $startTime,
    'monolog.name' => 'aptostat',
    'monolog.level' => \Monolog\Logger::DEBUG,
    'monolog.logfile' => __DIR__.'/log/dev.log',
    'monolog.logstashfile' => __DIR__ . '/log/logstash.log',
);

// Apply custom config if available
if (file_exists(__DIR__ . '/config.php')) {
    include __DIR__ . '/config.php';
}

// Initialize Application
$app = new Silex\Application($config);

// Set error reporting on
if ($app['debug']) {
    error_reporting(E_ALL);
}

// Initiate propel
Propel::init(__DIR__ . '/../build/conf/aptostat_api-conf.php');
set_include_path(__DIR__ . '/../build/classes' . PATH_SEPARATOR . get_include_path());

// Initiate monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.name' => $app['monolog.name'],
    'monolog.level' => $app['monolog.level'],
    'monolog.logfile' => $app['monolog.logfile'],
));

// Map routes to controllers
include __DIR__ . '/routing.php';

return $app;
