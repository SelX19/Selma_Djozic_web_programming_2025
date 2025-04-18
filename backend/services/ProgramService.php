<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/BaseService.php';
require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/dao/ProgramDao.php';

class ProgramService extends BaseService
{
    /** @var ProgramDao */
    protected $dao;

    public function __construct()
    {
        $dao = new ProgramDao();
        parent::__construct($dao);
        $this->dao = $dao;
    }

    //retrieval service functions / services

    public function getProgramById($programId)
    {

        return $this->dao->getProgramById($programId);
    }

    public function getDescription($name)
    {
        return $this->dao->getDescription($name);
    }

    // insertion/creation function

    public function addProgram($program)
    {

        $this->dao->addProgram($program);
    }

    // deletion function

    public function deleteProgram($program_id)
    {

        $this->dao->deleteProgram($program_id);
    }

    // update function

    public function updateProgram($program_id, $program)
    {

        $this->dao->updateProgram($program_id, $program);
    }


}

?>