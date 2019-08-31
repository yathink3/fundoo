<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Service extends CI_Controller
{
    public function __construct()
    {
        $this->load->model('user');
    }
    public function signin($userData, $id)
    {
        $users = $this->user->getRows($id);
        if ($users['password'] == md5($userData['password']))
            return $users;
        else  return false;
    }
    public function signup($userData)
    {
        $userData['password'] = md5($userData['password']);
        $insert = $this->user->insert($userData);
        if ($insert) return true;
        else return false;
    }
    public function get_users($id)
    {
        $users = $this->user->getRows($id);
        if (!empty($users)) return $users;
        else return false;
    }
    public function isEmailPresent($email, $id = 0)
    {
        $users = $this->user->getRows();
        foreach ($users as $user) {
            if ($user['email'] == $email && $user['id'] != $id)
                return $user['id'];
        }
        return false;
    }
}