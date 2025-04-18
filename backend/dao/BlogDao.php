<?php

require_once 'BaseDao.php';

class BlogDao extends BaseDao
{

    public function __construct()
    {
        parent::__construct('blogs');
    }

    //retrieval functions - READ(GET)

    public function getBlogById($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM blogs WHERE blog_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getContent($id)// get content by blog id
    {
        $stmt = $this->connection->prepare('SELECT content FROM blogs WHERE blog_id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getContentByAuthor($author_name) //retrieve all contents by a single author
    {
        $stmt = $this->connection->prepare('SELECT content FROM blogs WHERE user_name=:author_name');
        $stmt->bindParam(':author_name', $author_name);
        $stmt->execute();
        return $stmt->fetch();
    }

    // CREATE/INSERT (POST)

    public function addArticle($blog)
    {
        $stmt = $this->connection->prepare("
             INSERT INTO blogs (user_name, content, user_rating) 
             VALUES (:user_name, :content, :user_rating)
         ");

        // Bind parameters securely
        $stmt->bindParam(':user_name', $blog['user_name']);
        $stmt->bindParam(':content', $blog['content']);
        $stmt->bindParam(':user_rating', $blog['user_rating']);


        $stmt->execute();
        // return $this->connection->lastInsertId(); // Return the new user's ID - bool
    }


    // DELETE

    public function deleteArticle($blog_id)
    {
        $stmt = $this->connection->prepare("DELETE FROM blogs WHERE blog_id = :blog_id");
        $stmt->bindParam(':blog_id', $blog_id);
        $stmt->execute();
    }

    // UPDATE

    public function updateBlog($blog_id, $blog)
    {
        try {
            // Prepare update statement
            $stmt = $this->connection->prepare("UPDATE blogs SET 
            user_id = :user_id, 
            user_name = :user_name, 
            content = :content, 
            user_rating = :user_rating 
            WHERE blog_id = :blog_id");

            $stmt->bindParam(':user_id', $blog['user_id']);
            $stmt->bindParam(':user_name', $blog['user_name']);
            $stmt->bindParam(':content', $blog['content']);
            $stmt->bindParam(':user_rating', $blog['user_rating']);
            $stmt->bindParam(':blog_id', $blog_id);

            return $stmt->execute();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

}


?>