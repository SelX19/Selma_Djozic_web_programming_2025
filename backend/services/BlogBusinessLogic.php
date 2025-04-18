<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/services/BlogService.php';

class BlogBusinessLogic
{

    protected $blogService;

    public function __construct()
    {
        $this->blogService = new BlogService();

    }

    // retrieval functions' validation

    public function getBlogById($id)
    {

        // Validate if ID is provided and is a numeric value
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid blog ID.');
        }

        return $this->blogService->getBlogById($id);
    }

    public function getContent($id)
    {
        // Validate if ID is provided and is a numeric value
        if (empty($id) || !is_numeric($id)) {
            throw new Exception('Invalid blog ID.');
        }

        return $this->blogService->getContent($id);
    }

    public function getContentByAuthor($author_name)
    {
        // Validate if the author name is provided and is a non-empty string
        if (empty($author_name) || !is_string($author_name)) {
            throw new Exception('Invalid author name.');
        }

        return $this->blogService->getContentByAuthor($author_name);
    }

    //insertion with validation check first

    public function addArticle($blog)
    {
        // Validate user_name is non-empty
        if (empty($blog['user_name']) || !is_string($blog['user_name'])) {
            throw new Exception('Author name must be provided.');
        }

        // Validate content is non-empty and within length constraints
        if (empty($blog['content']) || strlen($blog['content']) < 50) {
            throw new Exception('Blog content must be at least 50 characters long.');
        }

        // Validate user_rating is a valid number between 1 and 5
        if (empty($blog['user_rating']) || !is_numeric($blog['user_rating']) || $blog['user_rating'] < 1 || $blog['user_rating'] > 5) {
            throw new Exception('User rating must be between 1 and 5.');
        }

        // If validation passes, proceed to add the article
        $this->blogService->addArticle($blog);
    }


    // deleting blog with validation (if exists) first

    public function deleteArticle($blog_id)
    {
        // Validate if blog ID is numeric and not empty
        if (empty($blog_id) || !is_numeric($blog_id)) {
            throw new Exception('Invalid blog ID.');
        }

        // Check if the blog exists before deleting
        $existingBlog = $this->blogService->getBlogById($blog_id);
        if (!$existingBlog) {
            throw new Exception('Blog with the given ID does not exist.');
        }

        // Proceed to delete the blog
        $this->blogService->deleteArticle($blog_id);
    }

    // updating blog/article content

    public function updateArticle($articleId, $articleData)
    {
        // Validate required fields
        if (empty($articleData['user_name'])) {
            throw new Exception("Name of owner of article is required.");
        }
        if (empty($articleData['content'])) {
            throw new Exception("Content is required.");
        }

        // Validate articleId
        if (empty($articleId)) {
            throw new Exception("Article ID cannot be empty.");
        }

        // Update the trainer information
        $this->blogService->updateBlog($articleId, $articleData);

    }


}


?>