<?php

require_once '/Applications/XAMPP/xamppfiles/htdocs/Selma_Djozic_web_programming_2025 01.51.58/backend/dao/BaseDao.php';

class BaseService
{

    protected $dao;

    public function __construct(BaseDao $dao)
    {
        $this->dao = $dao;
    }

    public function getAll()
    {
        return $this->dao->getAll();
    }

    public function create($data)
    {
        return $this->dao->insert($data);
    }

    public function update($id, $data)
    {
        return $this->dao->update($id, $data);
    }

    public function delete($id)
    {
        return $this->dao->delete($id);
    }


}


?>