<?php
require 'vendor/autoload.php'; //run autoloader

require_once __DIR__ . '/backend/services/UserService.php';
Flight::register('UserService', 'UserService');
require_once __DIR__ . '/backend/routes/UserRoutes.php';

require_once __DIR__ . '/backend/services/TrainerService.php';
Flight::register('TrainerService', 'TrainerService');
require_once __DIR__ . '/backend/routes/TrainerRoutes.php';

require_once __DIR__ . '/backend/services/ProgramService.php';
Flight::register('ProgramService', 'ProgramService');
require_once __DIR__ . '/backend/routes/ProgramRoutes.php';

require_once __DIR__ . '/backend/services/BlogService.php';
Flight::register('BlogService', 'BlogService');
require_once __DIR__ . '/backend/routes/BlogRoutes.php';

require_once __DIR__ . '/backend/services/AppointmentService.php';
Flight::register('AppointmentService', 'AppointmentService');
require_once __DIR__ . '/backend/routes/AppointmentRoutes.php';

require_once __DIR__ . '/backend/services/WorkoutService.php';
Flight::register('WorkoutService', 'WorkoutService');
require_once __DIR__ . '/backend/routes/WorkoutRoutes.php';

Flight::start();  //start FlightPHP
?>