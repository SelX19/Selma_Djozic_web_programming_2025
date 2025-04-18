<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/UserBusinessLogic.php';

class UserController
{
    protected $userBusinessLogic;

    public function __construct()
    {
        $this->userBusinessLogic = new UserBusinessLogic();
    }

    public function handleRequest()
    {

        switch ($_SERVER['REQUEST_METHOD']) {

            case 'POST': //insertion or adding data to the system
                $data = $_POST; //reading from the request (e.g. data submitted in the registration or sign-up form)
                try {
                    $this->userBusinessLogic->registerUser($data); //UserBusinessLogic extends BaseBusinessLogic, so it has an access to the method registerUser()
                    echo json_encode(['message' => 'User added to the system successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'GET': //retrieval of data
                $email = $_GET['email'] ?? null;
                $role = $_GET['role'] ?? null;
                $first_name = $_GET['first_name'] ?? null;
                $last_name = $_GET['last_name'] ?? null;
                $id = $_GET['user_id'] ?? null;

                try {
                    if ($email) {
                        $user = $this->userBusinessLogic->getByEmail($email);
                        echo json_encode($user);
                    } elseif ($role) {
                        $users = $this->userBusinessLogic->getActiveUsersByRole($role);
                        echo json_encode($users);
                    } elseif ($first_name) {
                        $users = $this->userBusinessLogic->getByFirstName($first_name);
                        echo json_encode($users);
                    } elseif ($last_name) {
                        $users = $this->userBusinessLogic->getByLastName($last_name);
                        echo json_encode($users);
                    } elseif ($id) {
                        $users = $this->userBusinessLogic->getById($id);
                        echo json_encode($users);
                    } else {
                        echo json_encode(['error' => 'Please provide data(email, role, first name, last name, or user id) by which you want to filter users and retrieve data for target one.']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                parse_str(file_get_contents("php://input"), $putData);
                $user_id = $putData['user_id'] ?? null;

                try {
                    if (!$user_id) {
                        throw new Exception("User ID is required for update.");
                    }
                    $this->userBusinessLogic->updateUserData($user_id, $putData);
                    echo json_encode(['message' => 'User updated successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                parse_str(file_get_contents("php://input"), $deleteData);
                $user_id = $deleteData['user_id'] ?? null;

                try {
                    if (!$user_id) {
                        throw new Exception("User ID is required for deletion.");
                    }

                    $this->userBusinessLogic->deleteUserWithCleanup($user_id);
                    echo json_encode(['message' => 'User deleted successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed.']);
                break;
        }
    }

}



?>