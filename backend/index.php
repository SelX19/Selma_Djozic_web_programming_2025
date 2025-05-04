<?php
require 'vendor/autoload.php'; //run autoloader

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'services/UserService.php';
Flight::register('UserService', 'UserService');
require_once 'routes/UserRoutes.php';


require_once 'services/TrainerService.php';
Flight::register('TrainerService', 'TrainerService');
require_once 'routes/TrainerRoutes.php';

require_once 'services/ProgramService.php';
Flight::register('ProgramService', 'ProgramService');
require_once 'routes/ProgramRoutes.php';

require_once 'services/BlogService.php';
Flight::register('BlogService', 'BlogService');
require_once 'routes/BlogRoutes.php';

require_once 'services/AppointmentService.php';
Flight::register('AppointmentService', 'AppointmentService');
require_once 'routes/AppointmentRoutes.php';

require_once 'services/WorkoutService.php';
Flight::register('WorkoutService', 'WorkoutService');
require_once 'routes/WorkoutRoutes.php';

Flight::start();  //start FlightPHP
?>