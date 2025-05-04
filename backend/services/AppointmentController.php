<?php

require_once './AppointmentBusinessLogic.php';

class AppointmentController
{
    protected $appointmentBusinessLogic;

    public function __construct()
    {
        $this->appointmentBusinessLogic = new AppointmentBusinessLogic();
    }

    public function handleRequest()
    {

        switch ($_SERVER['REQUEST_METHOD']) {

            case 'POST': // adding appointment to the system - by user/trainer
                $data = $_POST; //reading from the request - P.S.: form shall be for filling in with data for appointment or from calendar reading directly..
                try {
                    $this->appointmentBusinessLogic->addAppointment($data);
                    echo json_encode(['message' => 'Appointment added to the system successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'GET': //retrieval of data about program
                $id = $_GET['appointment_id'] ?? null;
                $date = $_GET['appointment_date'] ?? null;
                $time = $_GET['appointment_time'] ?? null;

                try {
                    if ($id) {
                        $appointment = $this->appointmentBusinessLogic->getAppointmentById($id);
                        echo json_encode($appointment);
                    } else if ($date) {
                        $appointment = $this->appointmentBusinessLogic->getByAppointmentDate($date);
                        echo json_encode($appointment);
                    } else if ($time) {
                        $appointment = $this->appointmentBusinessLogic->getByAppointmentTime($time);
                        echo json_encode($appointment);
                    } else {
                        echo json_encode(['error' => 'Please provide specific data about the appointment in order to retrieve the target one.']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                parse_str(file_get_contents("php://input"), $putData);
                $appointment_id = $putData['appointment_id'] ?? null;

                try {
                    if (!$appointment_id) {
                        throw new Exception("Appointment ID is required for update.");
                    }
                    $this->appointmentBusinessLogic->updateAppointment($appointment_id, $putData);
                    echo json_encode(['message' => 'Appointment data updated successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                parse_str(file_get_contents("php://input"), $deleteData);
                $appointment_id = $deleteData['appointment_id'] ?? null;

                try {
                    if (!$appointment_id) {
                        throw new Exception("Appointment ID is required for deletion.");
                    }

                    $this->appointmentBusinessLogic->deleteAppointment($appointment_id);
                    echo json_encode(['message' => 'Appointment deleted successfully.']);
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