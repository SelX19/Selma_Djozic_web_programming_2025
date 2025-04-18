<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/BaseService.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/dao/WorkoutDao.php';

class WorkoutService extends BaseService
{
    /** @var WorkoutDao */
    protected $dao;

    public function __construct()
    {
        $dao = new WorkoutDao();
        parent::__construct($dao);
        $this->dao = $dao;
    }

    //retrieval service functions / services

    public function getWorkoutById($id)
    {
        return $this->dao->getWorkoutById($id);
    }

    public function getDescription($id)
    {
        return $this->dao->getDescription($id);
    }

    public function getVideoURL($workout_name)
    {
        return $this->dao->getVideoURL($workout_name);
    }

    public function getDuration($id)
    {
        return $this->dao->getDuration($id);
    }

    public function getByDifficulty($difficulty)
    {
        return $this->dao->getByDifficulty($difficulty);
    }

    public function getByDuration($duration)
    {
        return $this->dao->getByDuration($duration);
    }

    // insertion/creation function

    public function addWorkout($workout)
    {

        $this->dao->addWorkout($workout);
    }

    // deletion function

    public function deleteWorkout($workout_id)
    {

        $this->dao->deleteWorkout($workout_id);
    }


    // update function

    public function updateWorkout($workout_id, $workout)
    {

        $this->dao->updateWorkout($workout_id, $workout);
    }


}

?>