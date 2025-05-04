<?php

require_once './UserService.php';
require_once './BaseBusinessLogic.php';

class UserBusinessLogic extends BaseBusinessLogic
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
        parent::__construct();
    }

    // some retrieval functions' validation

    public function getByEmail($email)
    {
        // Check if the email exists
        if ($this->userService->emailExists($email)) {
            return $this->userService->getByEmail($email);
        } else {
            throw new Exception("Email does not exist.");
        }
    }

    public function getActiveUsersByRole($role)
    {
        // Fetch users from DAO, but only include active users
        return $this->userService->getByRole($role);

    }

    public function getByFirstName($name)
    {
        return $this->userService->getByFirstName($name);
    }

    public function getByLastName($surname)
    {
        return $this->userService->getByLastName($surname);
    }

    public function getById($id)
    {
        return $this->userService->getById($id);
    }


    //conditional delete logic:

    public function deleteUserWithCleanup($user_id)
    {
        // Validation: Check if the user has appointments or history - if so, disable deletion
        if ($this->userService->hasRelatedData($user_id)) {
            throw new Exception("User has related data and cannot be deleted.");
        }

        // Otherwise delete a user
        $this->userService->deleteUser($user_id);

        return true; // indicating that user has been deleted
    }


    // conditional update logic:

    public function updateUserData($user_id, $updatedData)
    {
        // Check if user exists
        $user = $this->userService->getById($user_id);
        if (!$user) {
            throw new Exception("User not found.");
        }

        // Check if the email is changing and already exists for another user
        if (isset($updatedData['email']) && $updatedData['email'] !== $user['email']) {
            if ($this->userService->emailExists($updatedData['email'])) {
                throw new Exception("Email already in use by another user.");
            }
        }

        // Validate first and last name
        if (empty($updatedData['first_name']) || empty($updatedData['last_name'])) {
            throw new Exception("First name and last name cannot be empty.");
        }

        // Optional phone validation
        if (!empty($updatedData['phone']) && !preg_match('/^\+?[0-9]{7,15}$/', $updatedData['phone'])) {
            throw new Exception("Invalid phone number format.");
        }

        // Role validation
        $validRoles = ['user', 'trainer', 'admin'];
        if (!in_array($updatedData['role'], $validRoles)) {
            throw new Exception("Invalid role provided.");
        }

        // Update user using existing UserService method
        return $this->userService->updateUser($user_id, $updatedData);
    }












}

?>