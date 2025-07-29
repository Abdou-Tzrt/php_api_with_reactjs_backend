<?php

namespace App\Controllers;
use App\Models\UserModel as User;

class UserController
{
    private $model;

    public function __construct() 
    {
        $this->model = new User;
    }

    public function register($request)
    {
        $user = $this->model->getUser($request);

        if($user) {
            echo json_encode([
                'error'     => true,
                'message'   => 'You have already an account try to login.'
            ]);
        }else {
            $this->model->auth($user, $login = false);
            $options = [
                'const' => 12
            ];
            $password = password_hash($request['password'], PASSWORD_BCRYPT, $options);
            $request['password'] = $password;
            $this->model->store($request);
            echo json_encode([
                'message'   => 'Account created successfully.'
            ]);
        }
    }

    public function login($request)
    {
        $user = $this->model->getUser($request);

        if(!$user || !password_verify($request['password'], $user['password']) ) {
            echo json_encode([
                'error'     => true,
                'message'   => 'These credentials do not match any of our records.'
            ]);
        }else {
            $this->model->auth($user, $login = true);
            unset($user['password']);
            echo json_encode([
                'user'     => $user,
            ]);
        }
    }

    public function logout($request)
    {
        if(!$request['api_key'] || empty($request['api_key']) || !$this->model->checkIfApiKeyIsValid($request['api_key'], $request['user_id'])) {
            http_response_code(401);
            echo json_encode([
                'error'     => true,
                'message'   => 'Unauthenticatad'
            ]);
        }else {
            $this->model->signout($request['api_key'], $request['user_id']);
            echo json_encode([
                'message'   => 'Logout Successfully.'
            ]);
        }
    }

}