<?php

require_once 'BaseDao.php';

class UserDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct("users");
    }

    //retrieval functions - READ(GET)
    public function getByEmail($email)
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByFirstName($first_name)
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE first_name=:first_name');
        $stmt->bindParam(':first_name', $first_name);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByLastName($last_name)
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE last_name=:last_name');
        $stmt->bindParam(':last_name', $last_name);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPhone($id)
    {
        $stmt = $this->connection->prepare("SELECT phone FROM users WHERE user_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getRole($id)
    {
        $stmt = $this->connection->prepare("SELECT role FROM users WHERE user_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // CREATE/INSERT (POST)

    public function addUser($user)
    {
        try {
            $stmt = $this->connection->prepare("
            INSERT INTO users (first_name, last_name, email, password, phone, role) 
            VALUES (:first_name, :last_name, :email, :password, :phone, :role)
        ");

            // Bind parameters securely
            $stmt->bindParam(':first_name', $user['first_name']);
            $stmt->bindParam(':last_name', $user['last_name']);
            $stmt->bindParam(':email', $user['email']);
            $stmt->bindValue(':password', password_hash($user['password'], PASSWORD_DEFAULT)); // Hash password before storing
            $stmt->bindParam(':phone', $user['phone']);
            $stmt->bindParam(':role', $user['role']);

            $stmt->execute();
            // return $this->connection->lastInsertId(); // Return the new user's ID - bool
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry error code
                // Handle the duplicate entry case here
                echo "Email already exists!";
            } else {
                // Handle other errors
                die("Connection failed: " . $e->getMessage());
            }
        }
    }

    // DELETE

    public function deleteUser($user_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        //return $stmt->rowCount(); - Returns the number of affected rows
    }

    // UPDATE

    public function updateUser($user_id, $user)
    {
        try {
            // Check if the new email already exists for another user
            $stmt = $this->connection->prepare("SELECT COUNT(*) FROM users WHERE email = :email AND user_id != :user_id");
            $stmt->bindParam(':email', $user['email']);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $emailExists = $stmt->fetchColumn();

            if ($emailExists > 0) {
                throw new Exception("Email already exists.");
            }

            // Prepare update statement
            $stmt = $this->connection->prepare("UPDATE users SET 
            first_name = :first_name, 
            last_name = :last_name, 
            email = :email, 
            phone = :phone, 
            role = :role 
            WHERE user_id = :user_id");

            $stmt->bindParam(':first_name', $user['first_name']);
            $stmt->bindParam(':last_name', $user['last_name']);
            $stmt->bindParam(':email', $user['email']);
            $stmt->bindParam(':phone', $user['phone']);
            $stmt->bindParam(':role', $user['role']);
            $stmt->bindParam(':user_id', $user_id);

            return $stmt->execute();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

}

?>