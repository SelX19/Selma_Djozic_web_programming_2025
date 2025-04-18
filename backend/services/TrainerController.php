<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/TrainerBusinessLogic.php';

class TrainerController
{
    protected $trainerBusinessLogic;

    public function __construct()
    {
        $this->trainerBusinessLogic = new TrainerBusinessLogic();
    }

    public function handleRequest()
    {

        switch ($_SERVER['REQUEST_METHOD']) {

            case 'POST': //insertion or adding data to the system
                $data = $_POST; //reading from the request (e.g. data submitted in the registration or sign-up form)
                try {
                    $this->trainerBusinessLogic->registerUser($data); // TrainerBusinessLogic extends BaseBusinessLogic, so it has an access to the method registerUser()
                    echo json_encode(['message' => 'User added to the system successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'GET': //retrieval of data
                $specialization = $_GET['specialization'] ?? null;
                $experience = $_GET['experience'] ?? null;
                $rating = $_GET['rating'] ?? null;
                $id = $_GET['trainer_id'] ?? null;

                try {
                    if ($specialization) {
                        $trainer = $this->trainerBusinessLogic->getTrainersBySpecialization($specialization);
                        echo json_encode($trainer);
                    } elseif ($experience) {
                        $trainer = $this->trainerBusinessLogic->getTrainersByExperience($experience);
                        echo json_encode($trainer);
                    } elseif ($rating) {
                        $trainer = $this->trainerBusinessLogic->getTrainersByRating($rating);
                        echo json_encode($trainer);
                    } elseif ($id) {
                        $trainer = $this->trainerBusinessLogic->getTrainerById($id);
                        echo json_encode($trainer);
                    } else {
                        echo json_encode(['error' => 'Please provide data(specialization, experience, rating, or id) by which you want to filter trainers and retrieve data for target one.']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                parse_str(file_get_contents("php://input"), $putData);
                $trainer_id = $putData['trainer_id'] ?? null;

                try {
                    if (!$trainer_id) {
                        throw new Exception("User ID is required for update.");
                    }
                    $this->trainerBusinessLogic->updateTrainer($trainer_id, $putData);
                    echo json_encode(['message' => 'Trainer updated successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                parse_str(file_get_contents("php://input"), $deleteData);
                $trainer_id = $deleteData['trainer_id'] ?? null;

                try {
                    if (!$trainer_id) {
                        throw new Exception("Trainer ID is required for deletion.");
                    }

                    $this->trainerBusinessLogic->deleteTrainer($trainer_id);
                    echo json_encode(['message' => 'Trainer deleted successfully.']);
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