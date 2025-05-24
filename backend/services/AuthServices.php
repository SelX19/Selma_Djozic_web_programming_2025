<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AuthDao.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthService extends BaseService
{
    private $auth_dao;
    public function __construct()
    {
        $this->auth_dao = new AuthDao();
        parent::__construct(new AuthDao);
    }


    public function get_user_by_email($email)
    {
        return $this->auth_dao->get_user_by_email($email);
    }


    public function register($entity)
    {
        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }


        $email_exists = $this->auth_dao->get_user_by_email($entity['email']);
        if ($email_exists) {
            return ['success' => false, 'error' => 'Email already registered.'];
        }


        $entity['password'] = password_hash($entity['password'], PASSWORD_BCRYPT);


        $insert_success = parent::create($entity);

        if ($insert_success === true) {
            unset($entity["password"]);
            return ['success' => true, 'data' => $entity];
        } else {
            return ['success' => false, 'error' => 'User could not be created.'];
        }


    }


    public function login($entity)
    {
        if (empty($entity['email']) || empty($entity['password'])) {
            return ['success' => false, 'error' => 'Email and password are required.'];
        }

        $user = $this->auth_dao->get_user_by_email($entity['email']);

        if (!$user) {
            return ['success' => false, 'error' => 'Invalid username or password.'];
        }


        if (!$user || !password_verify($entity['password'], $user['password']))
            return ['success' => false, 'error' => 'Invalid username or password.'];


        //otherwise if successful authentication, JWT token is generated, and valid for 24 hours
        unset($user['password']);


        $jwt_payload = [
            // instead of 'user' => $user, I am including in the payload only the necessary input user info for the authentication and generating JWT, without passing sensitive data such as password nor including redundant info
            'id' => $user['user_id'],
            'email' => $user['email'],
            'role' => $user['role'],
            'iat' => time(),
            // If this parameter is not set, JWT will be valid for life. This is not a good approach
            'exp' => time() + (60 * 60 * 24) // valid for day
        ];

        //encoding a JWT token and preparing it for return/issue to authenticated user
        $token = JWT::encode(
            $jwt_payload,
            Config::JWT_SECRET(),
            'HS256'
        );


        //returning JWT token and user info merged together as single set of data to be returned
        return [
            'success' => true,
            'data' => array_merge([
                'user' => [
                    'id' => $user['user_id'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ]
            ], ['token' => $token])
        ]; //token, and user data without a password, only the necessary data, returned back to the authenticated user

    }
}
