<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/ProgramService.php';

class ProgramBusinessLogic
{

    protected $programService;

    public function __construct()
    {
        $this->programService = new ProgramService();

    }

    // retrieval functions' validation

    public function getProgramById($id)
    {

        // Validate if ID is provided and is a numeric value
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid blog ID.');
        }

        return $this->programService->getProgramById($id);
    }

    public function getDescription($name)
    {
        // Validate if ID is provided and is numeric
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid user ID.');
        }

        return $this->programService->getDescription($name);
    }


    //insertion with validation check first

    public function addProgram($program)
    {
        // Validate program_id is provided 
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid user ID.');
        }

        // Validate description is provided
        if (empty($program['description']) || strlen(trim($program['description'])) < 3 || strlen(trim($program['description'])) > 30) {
            throw new Exception('Invalid program description length. Must be greater than 3 characters and less than 30 characters.');
        }


        // If validation passes, proceed to add the program
        $this->programService->addProgram($program);
    }


    // deleting program with validation (if exists) first

    public function deleteProgram($program_id)
    {
        // Validate if program_id is numeric and not empty
        if (empty($program_id) || !is_numeric($program_id)) {
            throw new Exception('Invalid program ID.');
        }

        // Check if the program exists before deleting
        $existingProgram = $this->programService->getDescription($program_id);
        if (!$existingProgram) {
            throw new Exception('Program with the given ID does not exist.');
        }

        // Proceed to delete the appointment
        $this->programService->deleteProgram($program_id);
    }

    // update with validation

    public function updateProgram($program_id, $program)
    {
        // Validate program_id is numeric and not empty
        if (empty($program_id) || !is_numeric($program_id)) {
            throw new Exception('Invalid program ID.');
        }

        // Validate program description is provided and is valid
        if (empty($program['description']) || strlen(trim($program['description'])) < 3 || strlen(trim($program['description'])) > 30) {
            throw new Exception('Invalid program description length. Must be greater than 3 characters and less than 30 characters.');
        }

        // else:

        // Check if the program exists before updating
        $existingProgram = $this->programService->getDescription($program_id);
        if (!$existingProgram) {
            throw new Exception('Program with the given ID does not exist.');
        }

        // Proceed to update the program 
        $this->programService->updateProgram($program_id, $program);

    }

}


?>