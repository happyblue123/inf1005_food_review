<?php
$router->add('', 'HomeController', 'index');
$router->add('home', 'HomeController', 'index');
$router->add('register', 'AuthController', 'register');
$router->add('login', 'AuthController', 'login');
$router->add('resetpassword', 'AuthController', 'resetpwd');
$router->add('myreviews', 'ReviewController', 'fetchmyreviews');
$router->add('logout', 'AuthController', 'logout');
// $router->add('aboutus', 'HomeController', 'aboutus');
?>
