<?php
session_start();
mb_internal_encoding("UTF-8");
require './config/funcionsInicials.php';
require './config/baseDeDades.php';
$router = new RouterController();
$router->process(array(treuWEBROOT($_SERVER['REQUEST_URI'])));
// Rendering the view
$router->renderView();
?>