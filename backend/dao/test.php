<?php

// displaying error messages directly in browser, since logging is not working on my Mac for some reason for port 3306

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// some examples testing each CRUD functionality (retrieval, insertion, deletion, and update) on some entities

require_once './UserDao.php';
require_once './TrainerDao.php';
require_once './ProgramDao.php';


$userDao = new UserDao();
$trainerDao = new TrainerDao();
$programDao = new ProgramDao();


// Insert a new user (Client)
$userDao->addUser([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'tin@example.com',
    'password' => password_hash('password123', PASSWORD_DEFAULT),
    'phone' => '061 361 177',
    'role' => 'client'
]);


// Insert a new user (Trainer)
$trainerDao->addTrainer([
    'specialization' => 'yoga instructor',
    'experience' => 2,
    'bio' => 'yoga instructor living passionately',
    'rating' => 5,
]);


// Fetch all users
$users = $userDao->getAll();
print_r($users);


// Fetch all trainers
$trainers = $trainerDao->getAll();
print_r($trainers);

// Update trainer data for trainer with id=2
$trainerUpdate = [
    'specialization' => 'Updated Specialization',
    'experience' => 10,
    'bio' => 'Updated bio information.',
    'rating' => 4.8,
    'user_id' => 2
];

$trainerDao->updateTrainer(3, $trainerUpdate);

// verify update

$updatedTrainer = $trainerDao->getTrainerById(2);
print_r($updatedTrainer);

// delete a program

$programDao->deleteProgram(2);


?>