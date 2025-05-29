<?php

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AppointmentDao.php';

class AppointmentService extends BaseService
{
    /** @var AppointmentDao */
    protected $dao;

    public function __construct()
    {
        $dao = new AppointmentDao();
        parent::__construct($dao); //*
        $this->dao = $dao;
    }


    // corresponding retrieval services 

    public function getAppointmentById($appointmentId)
    {

        return $this->dao->getAppointmentById($appointmentId);
    }

    public function getAppointmentDate($id)
    {
        return $this->dao->getAppointmentDate($id);
    }

    public function getByAppointmentDate($appointment_date)
    {

        return $this->dao->getByAppointmentDate($appointment_date);
    }

    public function getAppointmentTime($id)
    {

        return $this->dao->getAppointmentTime($id);
    }

    public function getByAppointmentTime($appointment_time)
    {

        return $this->dao->getByAppointmentTime($appointment_time);
    }

    public function getStatus($id)
    {

        return $this->dao->getStatus($id);
    }

    public function getByStatus($status)
    {

        return $this->dao->getByStatus($status);
    }

    // creation service

    public function addAppointment($appointment)
    {
        $this->dao->addAppointment($appointment);
    }

    // deletion service 

    public function deleteAppointment($appointment_id)
    {

        $this->dao->deleteAppointment($appointment_id);
    }

    // update service 

    public function updateAppointment($appointment_id, $appointment)
    {

        $this->dao->updateAppointment($appointment_id, $appointment);
    }


}



?>