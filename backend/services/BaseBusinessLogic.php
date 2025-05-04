<?php

require_once './UserService.php';
require_once './TrainerService.php';

class BaseBusinessLogic //containing common methods (login, and signup/regster pages) for regular user, and a trainer (and potentially an admin - if I manage to find time to implement it later on)
{
    protected $userService;
    protected $trainerService;

    // Constructor to initialize services
    public function __construct()
    {
        $this->userService = new UserService();
        $this->trainerService = new TrainerService();
    }

    // Register User or Trainer (conditional insertion - validating email, password, and other fields when registering a user - used for sign up form)
    public function registerUser($user)
    {
        // Validate email format (filter_var - a built-in php function to allow us use of specific filters, such as: FILTER_VALIDATE_EMAIL - checking if email contains: '@', domain, no illegal characters, etc.)
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        // Check if email already exists
        if ($this->userService->emailExists($user['email'])) {
            throw new Exception("Email already exists.");
        }

        // Validate password strength
        $password = $user['password'];
        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||  // at least one uppercase letter
            !preg_match('/[0-9]/', $password) ||  // at least one digit
            !preg_match('/[\W]/', $password)      // at least one special character
        ) {
            throw new Exception("Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.");
        }

        // Check if role is selected
        if (!isset($user['role']) || empty($user['role'])) {
            throw new Exception("User role must be selected.");
        }

        // Call user or trainer service to add the user/trainer
        if ($this->trainerService) {
            $this->trainerService->addTrainer($user);
        } else {
            $this->userService->addUser($user);
        }

        return true;
    }

    // Login User or Trainer
    public function loginUser($credentials)
    {
        // Validate email exists
        if (!$this->userService->emailExists($credentials['email'])) {
            throw new Exception("User with that email address does not exist.");
        }

        // Get user by email
        $user = $this->userService->getByEmail($credentials['email']);

        // Validate password
        if (!password_verify($credentials['password'], $user['password'])) {
            throw new Exception("Incorrect password.");
        }

        return true;  // Successfully logged in
    }
}

?>