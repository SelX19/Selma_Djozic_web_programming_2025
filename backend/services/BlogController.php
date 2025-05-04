<?php

require_once './BlogBusinessLogic.php';

class BlogController
{
    protected $blogBusinessLogic;

    public function __construct()
    {
        $this->blogBusinessLogic = new BlogBusinessLogic();
    }

    public function handleRequest()
    {

        switch ($_SERVER['REQUEST_METHOD']) {

            case 'POST': // adding blog to the system - by user/trainer
                $data = $_POST; //reading from the request 
                try {
                    $this->blogBusinessLogic->addArticle($data);
                    echo json_encode(['message' => 'Blog article added to the system successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'GET': //retrieval of data about program
                $id = $_GET['blog_id'] ?? null;
                $author_name = $_GET['author_name'] ?? null;

                try {
                    if ($author_name) {
                        $blog = $this->blogBusinessLogic->getContentByAuthor($author_name);
                        echo json_encode($blog);
                    } else if ($id) {
                        $blog = $this->blogBusinessLogic->getBlogById($id);
                        echo json_encode($blog);
                    } else {
                        echo json_encode(['error' => 'Please provide specific data about the blog article (its id or a name of author) in order to retrieve the target article.']);
                    }
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'PUT':
                parse_str(file_get_contents("php://input"), $putData);
                $blog_id = $putData['blog_id'] ?? null;

                try {
                    if (!$blog_id) {
                        throw new Exception("Blog ID is required for update.");
                    }
                    $this->blogBusinessLogic->updateArticle($blog_id, $putData);
                    echo json_encode(['message' => 'Blog data updated successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            case 'DELETE':
                parse_str(file_get_contents("php://input"), $deleteData);
                $blog_id = $deleteData['blog_id'] ?? null;

                try {
                    if (!$blog_id) {
                        throw new Exception("Blog ID is required for deletion.");
                    }

                    $this->blogBusinessLogic->deleteArticle($blog_id);
                    echo json_encode(['message' => 'Blog article deleted successfully.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => $e->getMessage()]);
                }
                break;

            default:
                http_response_code(405);
                echo json_encode(['error' => 'Method not allowed.']);
                break;
        }
    }
}



?>