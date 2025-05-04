<?php

require_once './ProgramBusinessLogic.php';

class ProgramController
{
    protected $programBusinessLogic;

    public function __construct()
    {
        $this->programBusinessLogic = new ProgramBusinessLogic();
    }

    public function handleRequest()
    {

        switch ($_SERVER['REQUEST_METHOD']) {

            case 'POST': //insertion or adding data to the system - admin accessable method only (for potentially later created admin dashboard)
                $data = $_POST; //reading from the request 
                try {
                    $this->programBusinessLogic->addProgram($data);
                    echo json_encode(['message' => 'Program added to the system successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'GET': //retrieval of data about program
                $id = $_GET['program_id'] ?? null;

                try {
                    if ($id) {
                        $program = $this->programBusinessLogic->getProgramById($id);
                        echo json_encode($program);
                    } else {
                        echo json_encode(['error' => 'Please provide id of specific program to get its description.']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                parse_str(file_get_contents("php://input"), $putData);
                $program_id = $putData['program_id'] ?? null;

                try {
                    if (!$program_id) {
                        throw new Exception("Program ID is required for update.");
                    }
                    $this->programBusinessLogic->updateProgram($program_id, $putData);
                    echo json_encode(['message' => 'Program data updated successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                parse_str(file_get_contents("php://input"), $deleteData);
                $program_id = $deleteData['program_id'] ?? null;

                try {
                    if (!$program_id) {
                        throw new Exception("Program ID is required for deletion.");
                    }

                    $this->programBusinessLogic->deleteProgram($program_id);
                    echo json_encode(['message' => 'Program deleted successfully.']);
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