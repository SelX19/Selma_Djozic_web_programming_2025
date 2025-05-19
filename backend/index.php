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


Flight::route('/*', function () { //the wildcard route acting as a middleware intercepts and checks all routes (*), apart from the auth/login and auth/register - they remain public, while all other routes are protected
    if (
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0
    ) {
        return TRUE;
    } else {
        try { // all other routes (all apart from login and register) are protected by middleware - the Authorization token is checked, and decoded using JWT, and the user info is set for later use in routes
            $auth_header = Flight::request()->getHeader("Authorization");

            if (!$auth_header || !str_starts_with($auth_header, 'Bearer '))
                Flight::halt(401, "Missing or malformed Authorization header");

            $token = str_replace('Bearer ', '', $auth_header);

            // because many API clients (Postman, frontend apps) use the standard Authorization: Bearer ... format.

            if (Flight::auth_middleware()->verifyToken($token))
                return TRUE;

        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage()); //stop the request and send unauthorized response(401) ifdecoding of JWT fails
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