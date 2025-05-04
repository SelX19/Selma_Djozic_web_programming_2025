<?php

require_once './BaseService.php';
require_once './TrainerDao.php';

class TrainerService extends BaseService
{
    /** @var TrainerDao */
    protected $dao;

    public function __construct()
    {
        $dao = new TrainerDao();
        parent::__construct($dao);
        $this->dao = $dao;
    }

    //retrieval service functions / services

    public function getSpecialization($id)
    {
        return $this->dao->getSpecialization($id);
    }

    public function getBySpecialization($specialization)
    {
        return $this->dao->getBySpecialization($specialization);
    }

    public function getBio($id)
    {
        return $this->dao->getBio($id);
    }

    public function getExperience($id)
    {
        return $this->dao->getExperience($id);
    }

    public function getByExperience($experience)
    {
        return $this->dao->getByExperience($experience);
    }

    public function getRating($id)
    {
        return $this->dao->getRating($id);
    }

    public function getByRating($rating)
    {
        return $this->dao->getByRating($rating);
    }

    public function getTrainerById($id)
    {
        return $this->dao->getTrainerById($id);
    }


    // insertion/creation function

    public function addTrainer($trainer)
    {

        $this->dao->addTrainer($trainer);
    }


    // deletion function

    public function deleteTrainer($trainer_id)
    {

        $this->dao->deleteTrainer($trainer_id);
    }


    // update function

    public function updateTrainer($trainer_id, $trainer)
    {

        return $this->dao->updateTrainer($trainer_id, $trainer);
    }

}

?>