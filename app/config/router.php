<?php

$router = $di->getRouter();

// Define your routes here
$router->add("/test", ["controller" => "test", "action" => "index",]);
$router->addPost('/test/login', 'Test::login');

$router->add("/test/register",["controller" => "test", "action" => "register",]);
$router->addPost('/test/add', 'Test::add');

$router->add("/test/dashboard",["controller" => "test", "action" => "dashboard",])->setName('testDashboard');
$router->addGet("/test/logout",'Test::logout');

$router->add('/users/edit/{id:[0-9]+}', 'Users::edit');
$router->addPost('users/update/{id:[0-9]+}', 'Users::update');
$router->addGet('users/delete/{id:[0-9]+}', 'Users::delete');

$router->handle();
