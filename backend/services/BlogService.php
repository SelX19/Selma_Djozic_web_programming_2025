<?php

require_once './BaseService.php';
require_once './BlogDao.php';

class BlogService extends BaseService
{
    /** @var BlogDao */
    protected $dao;

    public function __construct()
    {
        $dao = new BlogDao();
        parent::__construct($dao);
        $this->dao = $dao;
    }

    //retrieval service functions / services

    public function getBlogById($id)
    {

        return $this->dao->getBlogById($id);
    }

    public function getContent($id)
    {
        return $this->dao->getContent($id);
    }

    public function getContentByAuthor($author_name)
    {

        return $this->dao->getContentByAuthor($author_name);
    }

    // insertion/creation function

    public function addArticle($blog)
    {

        $this->dao->addArticle($blog);
    }

    // deletion function

    public function deleteArticle($id)
    {

        $this->dao->deleteArticle($id);
    }

    // update function

    public function updateBlog($blog_id, $blog)
    {

        $this->dao->updateBlog($blog_id, $blog);
    }


}

?>