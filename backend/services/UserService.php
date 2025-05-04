<?php

require_once './BaseService.php';
require_once './UserDao.php';

class UserService extends BaseService
{
    /** @var UserDao */
    protected $dao;

    public function __construct()
    {
        $dao = new UserDao();
        parent::__construct($dao);
        $this->dao = $dao; // explicitly assign and type-hint it - so that IDE knows what class $this->dao really is

    }

    // auxilliary functions 

    public function emailExists($email)
    {

        return $this->dao->emailExists($email);
    }

    public function hasRelatedData($user_id)
    {

        return $this->dao->hasRelatedData($user_id);
    }

    //retrieval service functions / services

    public function getByEmail($email)
    {
        return $this->dao->getByEmail($email);
    }

    public function getByFirstName($first_name)
    {
        return $this->dao->getByFirstName($first_name);
    }

    public function getByLastName($last_name)
    {
        return $this->dao->getByLastName($last_name);
    }

    public function getPhone($id)
    {
        return $this->dao->getPhone($id);
    }

    public function getRole($id)
    {
        return $this->dao->getRole($id);
    }

    public function getByRole($role)
    {
        return $this->dao->getByRole($role);
    }

    public function getById($id)
    {

        return $this->dao->getById($id);
    }

    // insertion/creation function

    public function addUser($user)
    {

        $this->dao->addUser($user);
    }


    // deletion function

    public function deleteUser($user_id)
    {

        $this->dao->deleteUser($user_id);
    }


    // update function

    public function updateUser($user_id, $user)
    {

        $this->dao->updateUser($user_id, $user);
    }


}

?>