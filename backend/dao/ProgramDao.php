<?php

require_once 'BaseDao.php';

class ProgramDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct('programs');
    }

    //retrieval functions - READ(GET)

    public function getProgramById($programId)
    {
        $stmt = $this->connection->prepare('SELECT * FROM programs WHERE program_id=:programId');
        $stmt->bindParam(':programId', $programId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getDescription($name)// get program description by its name
    {
        $stmt = $this->connection->prepare('SELECT description FROM programs WHERE name=:name');
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    // CREATE/INSERT (POST)

    public function addProgram($program)
    {
        $stmt = $this->connection->prepare("
             INSERT INTO programs (name, description) 
             VALUES (:name, :description)
         ");

        // Bind parameters securely
        $stmt->bindParam(':name', $program['name']);
        $stmt->bindParam(':description', $program['description']);



        $stmt->execute();
        // return $this->connection->lastInsertId(); // Return the new user's ID - bool
    }

    // DELETE

    public function deleteProgram($program_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM programs WHERE program_id = :program_id");
        $stmt->bindParam(':program_id', $program_id);
        $stmt->execute();
    }

    // UPDATE

    public function updateProgram($program_id, $program)
    {
        try {
            // Prepare update statement
            $stmt = $this->connection->prepare("UPDATE programs SET 
            program_id = :program_id, 
            name = :name, 
            description = :description,  
            WHERE program_id = :program_id");

            $stmt->bindParam(':program_id', $program['program_id']);
            $stmt->bindParam(':name', $program['name']);
            $stmt->bindParam(':description', $program['description']);

            return $stmt->execute();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

}


?>