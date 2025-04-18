<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/WorkoutBusinessLogic.php';

class WorkoutController
{
    private $workoutBusinessLogic;

    public function __construct()
    {
        $this->workoutBusinessLogic = new WorkoutBusinessLogic();
    }

    public function handleRequest()
    {

        switch ($_SERVER['REQUEST_METHOD']) {

            case 'POST': // adding a workout to the system - by admin (in future admin dashboard - to be implemented)
                $data = $_POST; //reading from the request 
                try {
                    $this->workoutBusinessLogic->addWorkout($data);
                    echo json_encode(['message' => 'Workout added to the system successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'GET': //retrieval of data about workout
                $duration = $_GET['duration'] ?? null;
                $difficulty = $_GET['difficulty'] ?? null;
                $id = $_GET['workout_id'] ?? null;

                try {
                    if ($duration) {
                        $workout = $this->workoutBusinessLogic->getByDuration($duration);
                        echo json_encode($workout);
                    } else if ($difficulty) {
                        $workout = $this->workoutBusinessLogic->getByDifficulty($difficulty);
                        echo json_encode($workout);
                    } else if ($id) {
                        $workout = $this->workoutBusinessLogic->getWorkoutById($id);
                        echo json_encode($workout);
                    } else {
                        echo json_encode(['error' => 'Please provide specific data about the workout (id/duration/difficulty) in order to retrieve the target workout.']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                parse_str(file_get_contents("php://input"), $putData);
                $workout_id = $putData['workout_id'] ?? null;

                try {
                    if (!$workout_id) {
                        throw new Exception("Workout ID is required for update.");
                    }
                    $this->workoutBusinessLogic->updateWorkout($workout_id, $putData);
                    echo json_encode(['message' => 'Workout data updated successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                parse_str(file_get_contents("php://input"), $deleteData);
                $workout_id = $deleteData['workout_id'] ?? null;

                try {
                    if (!$workout_id) {
                        throw new Exception("Workout ID is required for deletion.");
                    }

                    $this->workoutBusinessLogic->deleteWorkout($workout_id);
                    echo json_encode(['message' => 'Workout deleted successfully.']);
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