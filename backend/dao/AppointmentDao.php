<?php

require_once 'BaseDao.php';

class AppointmentDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct('appointments');
    }

    //retrieval functions - READ(GET)

    public function getAppointmentDate($id)
    {
        $stmt = $this->connection->prepare('SELECT appointment_date FROM appointments WHERE user_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByAppointmentDate($appointment_date)
    {
        $stmt = $this->connection->prepare('SELECT * FROM appointments WHERE appointment_date=:appointment_date');
        $stmt->bindParam(':appointment_date', $appointment_date);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAppointmentTime($id)
    {
        $stmt = $this->connection->prepare('SELECT appointment_time FROM appointments WHERE user_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByAppointmentTime($appointment_time)
    {
        $stmt = $this->connection->prepare('SELECT * FROM appointments WHERE appointment_time=:appointment_time');
        $stmt->bindParam(':appointment_time', $appointment_time);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getStatus($id)
    {
        $stmt = $this->connection->prepare('SELECT status FROM appointments WHERE user_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByStatus($status)
    {
        $stmt = $this->connection->prepare('SELECT * FROM appointments WHERE status=:status');
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // CREATE/INSERT (POST)

    public function addAppointment($appointment)
    {
        $stmt = $this->connection->prepare("
             INSERT INTO appointments(appointment_date, appointment_time, status) 
             VALUES (:appointment_date :appointment_time, :status)
         ");

        // Bind parameters securely
        $stmt->bindParam(':appointment_date', $appointment['appointment_date']);
        $stmt->bindParam(':appointment_time', $appointment['appointment_time']);
        $stmt->bindParam(':status', $appointment['status']);


        $stmt->execute();
        // return $this->connection->lastInsertId(); // Return the new user's ID - bool
    }


    // DELETE

    public function deleteAppointment($appointment_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM appointments WHERE appointment_id = :appointment_id");
        $stmt->bindParam(':appointment_id', $appointment_id);
        $stmt->execute();
    }

    // UPDATE 

    public function updateAppointment($appointment_id, $appointment)
    {
        try {
            // Prepare update statement
            $stmt = $this->connection->prepare("UPDATE appointments SET 
            user_id = :user_id, 
            trainer_id = :trainer_id, 
            appointment_date = :appointment_date, 
            appointment_time = :appointment_time, 
            status = :status 
            WHERE appointment_id = :appointment_id");

            $stmt->bindParam(':user_id', $appointment['user_id']);
            $stmt->bindParam(':trainer_id', $appointment['trainer_id']);
            $stmt->bindParam(':appointment_date', $appointment['appointment_date']);
            $stmt->bindParam(':appointment_time', $appointment['appointment_time']);
            $stmt->bindParam(':status', $appointment['status']);
            $stmt->bindParam(':appointment_id', $appointment_id);

            return $stmt->execute();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

}


?>