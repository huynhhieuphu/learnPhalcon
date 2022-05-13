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


//categories
$router->add('/categories', ['controller' => 'categories', 'action' => 'index']); // show (view)
$router->add('/categories/create', ['controller' => 'categories', 'action' => 'create']); //create -> form (view create) + store
$router->add('/categories/edit/:int', ['controller' => 'categories', 'action' => 'edit', 'id' => 1]); // edit -> form(view edit) + update
$router->add('/categories/delete/:int', ['controller' => 'categories', 'action' => 'delete', 'id' => 1]); // delete -> delete

//products
$router->add('/products', ['controller' => 'products', 'action' => 'index']);
$router->add('/products/create', ['controller' => 'products', 'action' => 'create']);
$router->add('/products/edit/:int', ['controller' => 'products', 'action' => 'edit', 'id' => 1]);
$router->add('/products/delete/:int', ['controller' => 'products', 'action' => 'delete', 'id' => 1]);

$router->handle();
