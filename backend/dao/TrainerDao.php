<?php

require_once __DIR__ . '/BaseDao.php';

class TrainerDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct('trainers');
    }

    //retrieval functions - READ(GET)

    public function getSpecialization($id)
    {
        $stmt = $this->connection->prepare('SELECT specialization FROM trainers WHERE trainer_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getBySpecialization($specialization)
    {
        $specialization = trim($specialization);  // remove whitespace
        $stmt = $this->connection->prepare('SELECT * FROM trainers WHERE LOWER(specialization) = LOWER(:specialization)');
        $stmt->bindParam(':specialization', $specialization);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getBio($id)
    {
        $stmt = $this->connection->prepare('SELECT bio FROM trainers WHERE trainer_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getExperience($id)
    {
        $stmt = $this->connection->prepare('SELECT experience FROM trainers WHERE trainer_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByExperience($experience)
    {
        $stmt = $this->connection->prepare('SELECT * FROM trainers WHERE experience=:experience');
        $stmt->bindParam(':experience', $experience);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRating($id)
    {
        $stmt = $this->connection->prepare('SELECT rating FROM trainers WHERE trainer_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByRating($rating)
    {
        $stmt = $this->connection->prepare('SELECT * FROM trainers WHERE rating=:rating');
        $stmt->bindParam(':rating', $rating);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTrainerById($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM trainers WHERE trainer_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // CREATE/INSERT (POST)

    public function addTrainer($trainer)
    {
        $stmt = $this->connection->prepare("
             INSERT INTO trainers (specialization, experience, bio, rating) 
             VALUES (:specialization, :experience, :bio, :rating)
         ");

        // Bind parameters securely
        $stmt->bindParam(':specialization', $trainer['specialization']);
        $stmt->bindParam(':experience', $trainer['experience']);
        $stmt->bindParam(':bio', $trainer['bio']);
        $stmt->bindParam(':rating', $trainer['rating']);

        $stmt->execute();
        // return $this->connection->lastInsertId(); // Return the new user's ID - bool
    }


    // DELETE

    public function deleteTrainer($trainer_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM trainers WHERE trainer_id = :trainer_id");
        $stmt->bindParam(':trainer_id', $trainer_id);
        $stmt->execute();
    }

    // UPDATE

    public function updateTrainer($trainer_id, $trainer)
    {
        try {
            // Ensure the trainer has a valid user_id before updating
            if (!isset($trainer['user_id']) || empty($trainer['user_id'])) {
                throw new Exception("Trainer must be linked to a valid user ID.");
            }

            // Prepare update statement
            $stmt = $this->connection->prepare("UPDATE trainers SET 
            specialization = :specialization, 
            experience = :experience, 
            bio = :bio, 
            rating = :rating, 
            user_id = :user_id 
            WHERE trainer_id = :trainer_id");

            $stmt->bindParam(':specialization', $trainer['specialization']);
            $stmt->bindParam(':experience', $trainer['experience']);
            $stmt->bindParam(':bio', $trainer['bio']);
            $stmt->bindParam(':rating', $trainer['rating']);
            $stmt->bindParam(':user_id', $trainer['user_id']);
            $stmt->bindParam(':trainer_id', $trainer_id);

            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }


}


?>