<?php

require_once __DIR__ . '/../dao/BaseDao.php';

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


    public function create(
        $data
    ) {
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

    public function register($user)
    {
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        if ($this->dao->get_by_email(email: $user['email'])) {
            throw new Exception("Email already exists.");
        }

        $password = $user['password'];
        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[0-9]/', $password) ||
            !preg_match('/[\W]/', $password)
        ) {
            throw new Exception("Weak password.");
        }

        if (!isset($user['role']) || empty($user['role'])) {
            throw new Exception("Role is required.");
        }

        $user['password'] = password_hash($password, PASSWORD_DEFAULT);

        return $this->dao->insert($user);
    }

    public function login($credentials)
    {
        $user = $this->dao->get_by_email($credentials['email']);

        if (!$user) {
            throw new Exception("Email not found.");
        }

        if (!password_verify($credentials['password'], $user['password'])) {
            throw new Exception("Incorrect password.");
        }

        return $user;
    }

}


?>