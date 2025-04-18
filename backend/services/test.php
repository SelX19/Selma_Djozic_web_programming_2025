<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/UserController.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/TrainerController.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/ProgramController.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/WorkoutController.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/BlogController.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/AppointmentController.php';

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