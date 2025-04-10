<?php
$router->add('', 'HomeController', 'index');
$router->add('home', 'HomeController', 'index');
$router->add('register', 'AuthController', 'register');
$router->add('login', 'AuthController', 'login');
$router->add('resetpassword', 'AuthController', 'resetpwd');
$router->add('forgotPwd', 'AuthController', 'forgotPwd');
$router->add('profile', 'AuthController', 'fetchprofile');
$router->add('updateprofile', 'AuthController', 'updateprofile');
$router->add('logout', 'AuthController', 'logout');
$router->add('movie/(:any)', 'MovieController', 'handleSearch');
$router->add('search/query/(:any)', 'MovieController', 'handleSearch');
$router->add('search/genre/(:any)', 'MovieController', 'handleSearch');
$router->add('submitReview', 'ReviewController', 'submitReview');
$router->add('deleteReview/(:any)', 'ReviewController', 'deleteReview');
$router->add('about', 'AboutController', 'about');
$router->add('add-to-watchlist/(:any)', 'WatchlistController', 'saveMovieToWatchlist');
$router->add('remove-from-watchlist/(:any)', 'WatchlistController', 'removeMovieFromWatchlist');
$router->add('chatroom', 'ChatController', 'displayChatrooms');
$router->add('createChatroom', 'ChatController', 'createChatroom');
$router->add('privacy', 'PrivacyController', 'showPrivacyPage');
$router->add('faq', 'FAQController', 'displayFAQ');
$router->add('deleteaccount', 'UserController', 'deleteAccount');
$router->add('goodbye', 'HomeController', 'goodbye');
$router->add('add-to-watchhistory/(:any)', 'WatchhistoryController', 'saveMovieToHistory');
$router->add('remove-from-watchhistory/(:any)', 'WatchhistoryController', 'removeMovieFromHistory');
$router->add('error', 'HomeController', 'noroutefound');
?>
