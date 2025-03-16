<?php
$router->add('', 'HomeController', 'index');
$router->add('home', 'HomeController', 'index');
$router->add('register', 'AuthController', 'register');
$router->add('login', 'AuthController', 'login');
$router->add('resetpassword', 'AuthController', 'resetpwd');
$router->add('search/(:any)', 'MovieController', 'handleSearch');
$router->add('submitReview', 'ReviewController', 'submitReview');
$router->add('profile', 'AuthController', 'fetchprofile');
$router->add('updateprofile', 'AuthController', 'updateprofile');
$router->add('logout', 'AuthController', 'logout');
// $router->add('aboutus', 'HomeController', 'aboutus');
?>
