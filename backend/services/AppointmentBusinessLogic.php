<?php

require_once './AppointmentService.php';

class AppointmentBusinessLogic
{

    protected $appointmentService;

    public function __construct()
    {
        $this->appointmentService = new AppointmentService();

    }

    // retrieval functions' validation

    public function getAppointmentById($id)
    {

        // Validate if ID is provided and is a numeric value
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid appointment ID.');
        }

        return $this->appointmentService->getAppointmentById($id);
    }

    public function getAppointmentDate($id)
    {
        // Validate if ID is provided and is numeric
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid user ID.');
        }

        return $this->appointmentService->getAppointmentDate($id);
    }

    public function getByAppointmentDate($appointment_date)
    {
        // Validate if appointment_date is provided and is a valid date format
        if (empty($appointment_date) || !strtotime($appointment_date)) {
            throw new Exception('Invalid appointment date.');
        }

        return $this->appointmentService->getByAppointmentDate($appointment_date);
    }

    public function getAppointmentTime($id)
    {
        // Validate if ID is provided and is numeric
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid user ID.');
        }

        return $this->appointmentService->getAppointmentTime($id);
    }

    public function getByAppointmentTime($appointment_time)
    {
        // Validate if appointment_time is provided and is a valid time format
        if (empty($appointment_time) || !strtotime($appointment_time)) {
            throw new Exception('Invalid appointment time.');
        }

        return $this->appointmentService->getByAppointmentTime($appointment_time);
    }

    public function getByStatus($status)
    {
        // Validate if status is provided and is a valid string
        if (empty($status) || !is_string($status)) {
            throw new Exception('Invalid status.');
        }

        return $this->appointmentService->getByStatus($status);
    }

    // insertion with prior fields' validation

    public function addAppointment($appointment)
    {
        // Validate appointment_date is provided and is a valid date
        if (empty($appointment['appointment_date']) || !strtotime($appointment['appointment_date'])) {
            throw new Exception('Invalid appointment date.');
        }

        // Validate appointment_time is provided and is a valid time
        if (empty($appointment['appointment_time']) || !strtotime($appointment['appointment_time'])) {
            throw new Exception('Invalid appointment time.');
        }

        // Validate status is provided and is a valid string (assuming status is something like 'confirmed', 'pending')
        if (empty($appointment['status']) || !is_string($appointment['status'])) {
            throw new Exception('Invalid status.');
        }

        // If validation passes, proceed to add the appointment
        $this->appointmentService->addAppointment($appointment);
    }


    // deletion with prior validation

    public function deleteAppointment($appointment_id)
    {
        // Validate if appointment_id is numeric and not empty
        if (empty($appointment_id) || !is_numeric($appointment_id)) {
            throw new Exception('Invalid appointment ID.');
        }

        // Check if the appointment exists before deleting
        $existingAppointment = $this->appointmentService->getAppointmentDate($appointment_id);
        if (!$existingAppointment) {
            throw new Exception('Appointment with the given ID does not exist.');
        }

        // Proceed to delete the appointment
        $this->appointmentService->deleteAppointment($appointment_id);
    }

    // update appointment with validation

    public function updateAppointment($appointmentId, $appointmentData)
    {
        // Validate required fields
        if (empty($appointmentData['appointment_date'])) {
            throw new Exception("Appointment date is required.");
        }
        if (empty($appointmentData['appointment_time'])) {
            throw new Exception("Appointment time is required.");
        }

        // Validate articleId
        if (empty($appointmentId)) {
            throw new Exception("Appointment ID cannot be empty.");
        }

        // Update the trainer information
        $this->appointmentService->updateAppointment($appointmentId, $appointmentData);

    }


}


?>