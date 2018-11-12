<?php

if ((isset(ROUTER[1])) and (ROUTER[1] == 'environment')) {
    $database = \ArchFW\Model\DatabaseFactory::getInstance();
    $databaseDetails = $database->info();

    $devmode = (CONFIG['app']['production']) ? 'turned off' : 'turned on';
    return [
        'window'   => 'advanced',
        'database' => $databaseDetails,
        'software' => $_SERVER['SERVER_SOFTWARE'],
        'ip'       => $_SERVER['SERVER_ADDR'],
        'port'     => $_SERVER['SERVER_PORT'],
        'devmode'  => $devmode,
        'protocol' => $_SERVER['SERVER_PROTOCOL'],

    ];
}

return ['window' => 'basic'];