<?php

require_once __DIR__ . '/BaseDao.php';

class WorkoutDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct('workouts');
    }

    //retrieval functions - READ(GET)

    public function getWorkoutById($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM workouts WHERE workout_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getDescription($id)// get workout description by its id
    {
        $stmt = $this->connection->prepare('SELECT description FROM workouts WHERE workout_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getVideoURL($workout_name)// get workout video URL by its name
    {
        $stmt = $this->connection->prepare('SELECT video_url FROM workouts WHERE name=:workout_name');
        $stmt->bindParam(':workout_name', $workout_name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getDuration($id)// get workout duration by its id
    {
        $stmt = $this->connection->prepare('SELECT duration FROM workouts WHERE workout_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getById($id)// get workout by its id
    {
        $stmt = $this->connection->prepare('SELECT * FROM workouts WHERE workout_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByDifficulty($difficulty)// get workout duration by its id
    {
        $stmt = $this->connection->prepare('SELECT * FROM workouts WHERE difficulty=:difficulty');
        $stmt->bindParam(':difficulty', $difficulty);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByDuration($duration)// get workout duration by its id
    {
        $stmt = $this->connection->prepare('SELECT * FROM workouts WHERE duration=:duration');
        $stmt->bindParam(':duration', $duration);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // CREATE/INSERT (POST)

    public function addWorkout($workout)
    {
        $stmt = $this->connection->prepare("
             INSERT INTO workouts (name, video_url, description, duration, difficulty) 
             VALUES (:name, :video_url, :description, :duration, :difficulty)
         ");

        // Bind parameters securely
        $stmt->bindParam(':name', $workout['name']);
        $stmt->bindParam(':video_url', $workout['video_url']);
        $stmt->bindParam(':description', $workout['description']);
        $stmt->bindParam(':duration', $workout['duration']);
        $stmt->bindParam(':difficulty', $workout['difficulty']);


        $stmt->execute();
        // return $this->connection->lastInsertId(); // Return the new user's ID - bool
    }

    // DELETE

    public function deleteWorkout($workout_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM workouts WHERE workout_id = :workout_id");
        $stmt->bindParam(':workout_id', $workout_id);
        $stmt->execute();
    }

    // UPDATE

    public function updateWorkout($workout_id, $workout)
    {
        try {
            // Prepare update statement
            $stmt = $this->connection->prepare("UPDATE workouts SET 
            workout_id = :workout_id, 
            program_id = :program_id, 
            name = :name, 
            video_url = :video_url, 
            content = :content, 
            description = :description,
            duration = :duration,
            difficulty = :difficulty
            WHERE workout_id = :workout_id");

            $stmt->bindParam(':program_id', $workout['program_id']);
            $stmt->bindParam(':name', $workout['name']);
            $stmt->bindParam(':video_url', $workout['video_url']);
            $stmt->bindParam(':content', $workout['content']);
            $stmt->bindParam(':description', $workout['description']);
            $stmt->bindParam(':duration', $workout['duration']);
            $stmt->bindParam(':difficulty', $workout['difficulty']);
            $stmt->bindParam(':workout_id', $workout_id);

            return $stmt->execute();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

}


?>