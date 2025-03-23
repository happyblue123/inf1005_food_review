<?php
$router->add('', 'HomeController', 'index');
$router->add('home', 'HomeController', 'index');
$router->add('register', 'AuthController', 'register');
$router->add('login', 'AuthController', 'login');
$router->add('resetpassword', 'AuthController', 'resetpwd');
$router->add('profile', 'AuthController', 'fetchprofile');
$router->add('updateprofile', 'AuthController', 'updateprofile');
$router->add('logout', 'AuthController', 'logout');
$router->add('movie/(:any)', 'MovieController', 'handleSearch');
$router->add('search/query/(:any)', 'MovieController', 'handleSearch');
$router->add('search/genre/(:any)', 'MovieController', 'handleSearch');
$router->add('submitReview', 'ReviewController', 'submitReview');
$router->add('deleteReview/(:any)', 'ReviewController', 'deleteReview');
$router->add('about', 'AboutController', 'about');
$router->add('chatroom', 'ChatController', 'createChatroom');
?>
