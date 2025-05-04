<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './UserController.php';
require_once './TrainerController.php';
require_once './ProgramController.php';
require_once './WorkoutController.php';
require_once './BlogController.php';
require_once './AppointmentController.php';

$controller = new UserController();
$controller->handleRequest(); // This shall handle POST, GET, PUT, and DELETE requests.

$controller2 = new TrainerController();
$controller2->handleRequest(); // This shall handle POST, GET, PUT, and DELETE requests.

$controller3 = new ProgramController();
$controller3->handleRequest(); // This shall handle POST, GET, PUT, and DELETE requests.

$controller4 = new WorkoutController();
$controller4->handleRequest(); // This shall handle POST, GET, PUT, and DELETE requests.

$controller5 = new BlogController();
$controller5->handleRequest(); // This shall handle POST, GET, PUT, and DELETE requests.

$controller6 = new AppointmentController();
$controller6->handleRequest(); // This shall handle POST, GET, PUT, and DELETE requests.



?>