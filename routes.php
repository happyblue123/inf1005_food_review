<?php
$router->add('', 'HomeController', 'index');
$router->add('home', 'HomeController', 'index');
$router->add('trendingmovies', 'MovieController', 'fetchTrendingMovies');
$router->add('register', 'AuthController', 'register');
$router->add('login', 'AuthController', 'login');
$router->add('resetpassword', 'AuthController', 'resetpwd');
$router->add('search/(:any)', 'MovieController', 'handleSearch');

// $router->add('myreviews', 'ReviewController', 'fetchmyreviews');
$router->add('logout', 'AuthController', 'logout');
// $router->add('aboutus', 'HomeController', 'aboutus');
?>
