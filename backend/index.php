<?php
require 'vendor/autoload.php'; // Composer autoloader

// to add middleware protection to routes - it will validate JWT (used for authorization)

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Including required services
require_once 'services/AuthServices.php';
require_once 'services/UserService.php';
require_once 'services/TrainerService.php';
require_once 'services/ProgramService.php';
require_once 'services/BlogService.php';
require_once 'services/AppointmentService.php';
require_once 'services/WorkoutService.php';
require "middleware/AuthMiddleware.php";

// registering services as singletons to be used later 
Flight::register('UserService', 'UserService');
Flight::register('TrainerService', 'TrainerService');
Flight::register('ProgramService', 'ProgramService');
Flight::register('BlogService', 'BlogService');
Flight::register('AppointmentService', 'AppointmentService');
Flight::register('WorkoutService', 'WorkoutService');
Flight::register('auth_service', "AuthService");
Flight::register('auth_middleware', "AuthMiddleware");

//test
Flight::route("GET /api/", function () {
    Flight::json([
        "status" => "OK",
        "message" => "Welcome to the Fitness API!",
        "version" => "1.0.0",
        "timestamp" => date('c')
    ]);
});

Flight::route('/*', function () {
    if (
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0
    ) {
        return TRUE;
    } else {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if (Flight::auth_middleware()->verifyToken($token))
                return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});


// Routes are loaded afterward, so protected routes will obey middleware
require_once __DIR__ . '/routes/AuthRoutes.php';
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/TrainerRoutes.php';
require_once __DIR__ . '/routes/ProgramRoutes.php';
require_once __DIR__ . '/routes/BlogRoutes.php';
require_once __DIR__ . '/routes/AppointmentRoutes.php';
require_once __DIR__ . '/routes/WorkoutRoutes.php';

Flight::start();  // Launch FlightPHP
?>