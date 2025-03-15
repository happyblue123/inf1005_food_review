<?php
$router->add('', 'HomeController', 'index');
$router->add('home', 'HomeController', 'index');
$router->add('register', 'AuthController', 'register');
$router->add('login', 'AuthController', 'login');
$router->add('logout', 'AuthController', 'logout');
// $router->add('aboutus', 'HomeController', 'aboutus');
?>
