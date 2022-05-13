<?php
$loader = new \Phalcon\Loader();

/**
 * Get config service for use in inline setup below
 */
$config = $di->getConfig();

$loader->registerNamespaces(
    [
        'App\Controllers'    => $config->application->controllersDir,
        'App\Models'         => $config->application->modelsDir,
        'App\Validations'    => APP_PATH . '/validations',
    ]
);

$loader->register();
