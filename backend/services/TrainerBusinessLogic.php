<?php

require_once './BaseBusinessLogic.php';
require_once './TrainerService.php';

class TrainerBusinessLogic extends BaseBusinessLogic
{
    protected $trainerService;

    public function __construct()
    {
        $this->trainerService = new TrainerService();
        parent::__construct();
    }

    // Get Trainer's Specialization
    public function getTrainerSpecialization($trainerId)
    {
        // Validate trainerId
        if (empty($trainerId)) {
            throw new Exception("Trainer ID cannot be empty.");
        }

        $specialization = $this->trainerService->getSpecialization($trainerId);
        if (!$specialization) {
            throw new Exception("Specialization not found for this trainer.");
        }

        return $specialization;
    }

    // Get Trainers by Specialization
    public function getTrainersBySpecialization($specialization)
    {
        // Validate specialization
        if (empty($specialization)) {
            throw new Exception("Specialization cannot be empty.");
        }

        $trainers = $this->trainerService->getBySpecialization($specialization);
        if (!$trainers) {
            throw new Exception("No trainers found for the given specialization.");
        }

        return $trainers;
    }

    // Get Trainer's Bio
    public function getTrainerBio($trainerId)
    {
        // Validate trainerId
        if (empty($trainerId)) {
            throw new Exception("Trainer ID cannot be empty.");
        }

        $bio = $this->trainerService->getBio($trainerId);
        if (!$bio) {
            throw new Exception("Bio not found for this trainer.");
        }

        return $bio;
    }

    // Get Trainer's Experience
    public function getTrainerExperience($trainerId)
    {
        // Validate trainerId
        if (empty($trainerId)) {
            throw new Exception("Trainer ID cannot be empty.");
        }

        $experience = $this->trainerService->getExperience($trainerId);
        if (!$experience) {
            throw new Exception("Experience not found for this trainer.");
        }

        return $experience;
    }

    // Get Trainers by Experience
    public function getTrainersByExperience($experience)
    {
        // Validate experience
        if (empty($experience)) {
            throw new Exception("Experience cannot be empty.");
        }

        $trainers = $this->trainerService->getByExperience($experience);
        if (!$trainers) {
            throw new Exception("No trainers found with the given experience.");
        }

        return $trainers;
    }

    // Get Trainer's Rating
    public function getTrainerRating($trainerId)
    {
        // Validate trainerId
        if (empty($trainerId)) {
            throw new Exception("Trainer ID cannot be empty.");
        }

        $rating = $this->trainerService->getRating($trainerId);
        if (!$rating) {
            throw new Exception("Rating not found for this trainer.");
        }

        return $rating;
    }

    // Get Trainers by Rating
    public function getTrainersByRating($rating)
    {
        // Validate rating
        if (empty($rating)) {
            throw new Exception("Rating cannot be empty.");
        }

        $trainers = $this->trainerService->getByRating($rating);
        if (!$trainers) {
            throw new Exception("No trainers found with the given rating.");
        }

        return $trainers;
    }

    // Get Trainer by ID
    public function getTrainerById($trainerId)
    {
        // Validate trainerId
        if (empty($trainerId)) {
            throw new Exception("Trainer ID cannot be empty.");
        }

        $trainer = $this->trainerService->getTrainerById($trainerId);
        if (!$trainer) {
            throw new Exception("Trainer not found with this ID.");
        }

        return $trainer;
    }

    // Add a New Trainer
    public function addTrainer($trainerData)
    {
        // Validate required fields
        if (empty($trainerData['specialization'])) {
            throw new Exception("Specialization is required.");
        }
        if (empty($trainerData['experience'])) {
            throw new Exception("Experience is required.");
        }
        if (empty($trainerData['bio'])) {
            throw new Exception("Bio is required.");
        }
        if (empty($trainerData['rating'])) {
            throw new Exception("Rating is required.");
        }

        // Check if the specialization is valid
        $validSpecializations = ['Yoga', 'Fitness', 'Strength Training', 'Group Trainings', 'Cardio']; // Example list
        if (!in_array($trainerData['specialization'], $validSpecializations)) {
            throw new Exception("Invalid specialization.");
        }

        // Add the trainer to the system
        $this->trainerService->addTrainer($trainerData);
        return true;
    }

    // Delete a Trainer by ID
    public function deleteTrainer($trainerId)
    {
        // Validate trainerId
        if (empty($trainerId)) {
            throw new Exception("Trainer ID cannot be empty.");
        }

        // Check if trainer exists before deletion
        $trainer = $this->trainerService->getTrainerById($trainerId);
        if (!$trainer) {
            throw new Exception("Trainer not found for deletion.");
        }

        // Delete the trainer
        $this->trainerService->deleteTrainer($trainerId);
        return true;
    }

    // Update Trainer Information
    public function updateTrainer($trainerId, $trainerData)
    {
        // Validate required fields
        if (empty($trainerData['specialization'])) {
            throw new Exception("Specialization is required.");
        }
        if (empty($trainerData['experience'])) {
            throw new Exception("Experience is required.");
        }
        if (empty($trainerData['bio'])) {
            throw new Exception("Bio is required.");
        }
        if (empty($trainerData['rating'])) {
            throw new Exception("Rating is required.");
        }

        // Validate trainerId
        if (empty($trainerId)) {
            throw new Exception("Trainer ID cannot be empty.");
        }

        // Update the trainer information
        $updated = $this->trainerService->updateTrainer($trainerId, $trainerData);
        if (!$updated) {
            throw new Exception("Failed to update trainer information.");
        }

        return $updated; //bool = true, indicating successful update
    }
}

?>