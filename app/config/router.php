<?php

$router = $di->getRouter();

// Define your routes here

$router->add(
    "/test",
    [
        "controller" => "test",
        "action"     => "index",
    ]
);

$router->addPost(
    '/test/login',
    'Test::login'
);

$router->add(
    "/test/register",
    [
        "controller" => "test",
        "action"     => "register",
    ]
);

$router->addPost(
    '/test/add',
    'Test::add'
);

$router->handle();
