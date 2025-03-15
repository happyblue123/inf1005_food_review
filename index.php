<?php
require_once __DIR__ . '/config.ini';
require_once __DIR__ . '/app/core/Router.php';

$router = new Router();  // Initialize the router first

require_once __DIR__ . '/routes.php'; // Now include routes.php

$router->run();
?>