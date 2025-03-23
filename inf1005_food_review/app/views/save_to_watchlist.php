<?php
require_once __DIR__ . '/../controllers/SearchController.php';

$controller = new SearchController();
$controller->saveMovieToWatchlist($_POST['movie_id']);

header('Location: profile.php');
?>
