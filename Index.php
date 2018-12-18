<?php



// aktivera output buffering
// http://php.net/manual/en/ref.outcontrol.php
// http://php.net/manual/en/function.ob-start.php
ob_start();
// Laddar  klasser
require_once('includes/autoloadclasses.inc.php');
spl_autoload_register("autoClasses");

session_start();

if (!$_SESSION['user'] instanceof User) {
    $_SESSION['user'] = new User();
}

// laddar settings
require_once("includes/settings.inc.php");

// Ansluter till db
require_once("includes/db.inc.php");


// Inkludera fil med hjälpfunktioner
require_once("includes/functions.inc.php");


// Ladda rätt controller
require_once("includes/routes.inc.php");


// Om det finns någon getparameter controller:
$controller = $_GET['controller'] ?? "default";


// Om angiven controller inte finns i vår routesarray, sätt till "default"
if (!array_key_exists($controller, $routes)) {
    $controller = "default";
}

require_once("controllers/".$routes[$controller]);






