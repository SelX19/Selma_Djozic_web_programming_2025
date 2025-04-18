<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/WorkoutService.php';

class WorkoutBusinessLogic
{
    private $workoutService;

    public function __construct()
    {
        $this->workoutService = new WorkoutService();
    }

    // Validating retrieval methods (services->dao methods)

    public function getDescription($id)
    {
        if (empty($id))
            throw new Exception("Workout ID cannot be empty.");
        return $this->workoutService->getDescription($id);
    }

    public function getVideoURL($workout_name)
    {
        if (empty($workout_name))
            throw new Exception("Workout name cannot be empty.");
        return $this->workoutService->getVideoURL($workout_name);
    }

    public function getDuration($id)
    {
        if (empty($id))
            throw new Exception("Workout ID cannot be empty.");
        return $this->workoutService->getDuration($id);
    }

    public function getWorkoutById($id)
    {
        if (empty($id))
            throw new Exception("Id field cannot be empty.");
        return $this->workoutService->getWorkoutById($id);
    }

    public function getByDifficulty($difficulty)
    {
        if (empty($difficulty))
            throw new Exception("Difficulty field cannot be empty.");
        return $this->workoutService->getByDifficulty($difficulty);
    }

    public function getByDuration($duration)
    {
        if ($duration == 0)
            throw new Exception("Duration of a workout cannot be zero.");
        return $this->workoutService->getByDuration($duration);
    }

    // validating CREATE/INSERT(POST) method (logic)

    public function addWorkout($workout)
    {

        // Check if all required fields are present - all at once
        if (empty($workout['name'])) {
            throw new Exception('Workout name cannot be empty.');
        }
        if (empty($workout['video_url'])) {
            throw new Exception('Workout video URL cannot be empty.');
        }
        if (empty($workout['description'])) {
            throw new Exception('Workout description cannot be empty.');
        }
        if (empty($workout['duration']) || !is_numeric($workout['duration']) || $workout['duration'] <= 0) {
            throw new Exception('Workout duration must be a positive number.');
        }
        if (empty($workout['difficulty']) || !in_array($workout['difficulty'], ['easy', 'medium', 'hard'])) {
            throw new Exception('Workout difficulty must be one of the following: easy, medium, hard.');
        }

        // Validate the video URL (check if it's a valid URL)
        if (!filter_var($workout['video_url'], FILTER_VALIDATE_URL)) {
            throw new Exception('Workout video URL is not a valid URL.');
        }

        // Add the workout (after validation)
        $this->workoutService->addWorkout($workout);
    }



    // DELETE with validating first - that workout exists (before deletion)

    public function deleteWorkout($workout_id)
    {

        // Validation: Check if workout ID is provided and is a valid integer
        if (empty($workout_id) || !is_numeric($workout_id)) {
            throw new Exception('Invalid workout ID.');
        }

        // Check if the workout exists before attempting to delete
        $existingWorkout = $this->workoutService->getWorkoutById($workout_id);
        if (!$existingWorkout) {
            throw new Exception('Workout with the given ID does not exist.');
        }

        // If validation passes, proceed with deletion
        $this->workoutService->deleteWorkout($workout_id);
    }


    // UPDATE with validation

    public function updateWorkout($workout_id, $workout)
    {
        // Validation: Ensure workout ID is valid
        if (empty($workout_id) || !is_numeric($workout_id)) {
            throw new Exception('Invalid workout ID.');
        }

        // Ensure the workout data is valid
        if (empty($workout['name']) || strlen($workout['name']) < 3) {
            throw new Exception('Workout name must be at least 3 characters long.');
        }
        if (empty($workout['video_url']) || !filter_var($workout['video_url'], FILTER_VALIDATE_URL)) {
            throw new Exception('Invalid video URL.');
        }
        if (empty($workout['description']) || strlen($workout['description']) > 500) {
            throw new Exception('Workout description must not exceed 500 characters.');
        }
        if (empty($workout['difficulty']) || !in_array($workout['difficulty'], ['easy', 'medium', 'hard'])) {
            throw new Exception('Invalid workout difficulty. Allowed values: easy, medium, hard.');
        }

        // Validation: Check if the workout exists before updating
        $existingWorkout = $this->workoutService->getWorkoutById($workout_id);
        if (!$existingWorkout) {
            throw new Exception('Workout with the given ID does not exist.');
        }

        // Proceed with the update if validation passes
        $this->workoutService->updateWorkout($workout_id, $workout);
    }


}

?>