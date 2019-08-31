<?php

/********************************************************************************************************************
 * @Execution : default node : cmd> api.php
 * @Purpose : rest api for fundoo app
 * @description: Create an Rest Api in codeigniter
 * @overview:api for login,signup,delete,passwordreset, etc
 * @author : yathin k <yathink3@gmail.com>
 * @version : 1.0
 * @since : 31-aug-2019
 *******************************************************************************************************************/
require APPPATH . 'libraries/REST_Controller.php';
/**
 * class api which extends from REST_Controller
 */
class Api extends REST_Controller
{
    private $service = '';
    public function __construct()
    {
        parent::__construct();

        //load user models
        $this->load->model('user');
        $this->load->library('session', 'service');
        $this->load->helper('url');
    }


    /**
     * @method:post
     * @description:login is used to login user
     * @return :response 
     */

    public function login_post()
    {
        $userData = array();
        $userData['email'] = $this->post('email');
        $userData['password'] = $this->post('password');
        if (!empty($userData['email']) && !empty($userData['password'])) {
            if ($id = $this->isEmailPresent($userData['email'])) {
                $users = $this->user->getRows($id);
                if ($users['password'] == md5($userData['password'])) {
                    $this->response([
                        'status' => TRUE,
                        'message' => 'User login successful.',
                        'data' => $users
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => "password is mismatch"
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => "wrong email address"
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'message' => "invalid data"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @method post
     * @description:registration is used to signup user
     * @return :response 
     */


    public function registration_post()
    {
        $userData = array();
        $userData['firstname'] = $this->post('firstname');
        $userData['lastname'] = $this->post('lastname');
        $userData['email'] = $this->post('email');
        $userData['password'] = $this->post('password');
        if (!empty($userData['firstname']) && !empty($userData['lastname']) && !empty($userData['email']) && !empty($userData['password'])) {
            if (!$this->isEmailPresent($userData['email'])) {
                //insert user data
                $userData['password'] = md5($userData['password']);
                $insert = $this->user->insert($userData);

                //check if the user data inserted
                if ($insert) {
                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'User account has been created successfully.'
                    ], REST_Controller::HTTP_OK);
                } else {
                    //set the response and exit
                    $this->response([
                        'status' => FALSE,
                        'message' => "Some problems occurred, please try again."
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => "user already exists"
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            //set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => "Provide complete user information to create."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @method :post
     * @description:forgot is used to create token when user enters the mailid
     * @return :response 
     */
    public function forgot_post()
    {

        $userData = array();
        $userData['email'] = $this->post('email');
        if (!empty($userData['email'])) {
            if ($id = $this->isEmailPresent($userData['email'])) {
                $token = JWT::encode($id, "secure_key");
                if ($this->sendMail('http://localhost/fundoo/#/resetPassword/?token=' . $token)) {
                    $this->response([
                        'status' => TRUE,
                        'message' => "token generated && email sent successfully"
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => "token generated && email not sent"
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => "wrong email address"
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'message' => "invalid data"
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }



    /**
     * @method :post
     * @description:reset password
     * @return :response 
     */
    public function reset_post($token)
    {
        try {
            $id = JWT::decode($token, "secure_key", true);
            $users = $this->user->getRows($id);
            //check if the user data exists
            if (!empty($users)) {
                $userData = array();
                $userData['password'] = $this->post('password');
                //update user data
                $userData['password'] = md5($userData['password']);
                $update = $this->user->update($userData, $id);
                //check if the user data updated
                if ($update) {
                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'password has been updated successfully.'
                    ], REST_Controller::HTTP_OK);
                } else {
                    //set the response and exit
                    $this->response([
                        'status' => FALSE,
                        'message' => "Some problems occurred, please try again."
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                //set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'unknown person'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            $this->response([
                'status' => FALSE,
                'message' => 'unknown person'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    /**
     * @method :get
     * @description:userdata to get
     * @return :response 
     */
    public function user_get($id = 0)
    {
        //returns all rows if the id parameter doesn't exist,
        //otherwise single row will be returned
        $users = $this->user->getRows($id);

        //check if the user data exists
        if (!empty($users)) {
            //set the response and exit
            $this->response([
                'status' => TRUE,
                'data' => $users
            ], REST_Controller::HTTP_OK);
        } else {
            //set the response and exit
            $this->response([
                'status' => FALSE,
                'message' => 'No user were found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    /**
     * @method :put
     * @description:user_to edit
     * @return :response 
     */

    public function user_put($id = 0)
    {

        if ($id) {
            $users = $this->user->getRows($id);

            //check if the user data exists
            if (!empty($users)) {
                $userData = array();
                $userData['firstname'] = $this->put('firstname');
                $userData['lastname'] = $this->put('lastname');
                $userData['email'] = $this->put('email');
                $userData['password'] = $this->put('password');
                if ($this->isEmailPresent($userData['email'], $id)) {
                    $this->response([
                        'status' => FALSE,
                        'message' => "user already exists"
                    ], REST_Controller::HTTP_BAD_REQUEST);
                } else {
                    if (!empty($id) && !empty($userData['firstname']) && !empty($userData['lastname']) && !empty($userData['email']) && !empty($userData['password'])) {
                        //update user data
                        $userData['password'] = md5($userData['password']);
                        $update = $this->user->update($userData, $id);

                        //check if the user data updated
                        if ($update) {
                            //set the response and exit
                            $this->response([
                                'status' => TRUE,
                                'message' => 'User has been updated successfully.'
                            ], REST_Controller::HTTP_OK);
                        } else {
                            //set the response and exit
                            $this->response([
                                'status' => FALSE,
                                'message' => "Some problems occurred, please try again."
                            ], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    } else {
                        //set the response and exit
                        $this->response([
                            'status' => FALSE,
                            'message' => "Provide complete user information to update."
                        ], REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            } else {
                //set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No user were found.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'message' => "please specify the user id."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @method :delete
     * @description:user_to delte
     * @return :response 
     */
    public function user_delete($id = 0)
    {
        if ($id) {
            $users = $this->user->getRows($id);

            //check if the user data exists
            if (!empty($users)) {
                $delete = $this->user->delete($id);

                if ($delete) {
                    //set the response and exit
                    $this->response([
                        'status' => TRUE,
                        'message' => 'User has been removed successfully.'
                    ], REST_Controller::HTTP_OK);
                } else {
                    //set the response and exit
                    $this->response([
                        'status' => FALSE,
                        'message' => "Some problems occurred, please try again."
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                //set the response and exit
                $this->response([
                    'status' => FALSE,
                    'message' => 'No user were found.'
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $this->response([
                'status' => FALSE,
                'message' => "please specify the user id."
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    /**
     * @param: $email,$id
     * @description:isemailpresent to check wheather the email is present or not
     * @return :true or false
     */
    public function isEmailPresent($email, $id = 0)
    {
        $users = $this->user->getRows();
        foreach ($users as $user) {
            if ($user['email'] == $email && $user['id'] != $id)
                return $user['id'];
        }
        return false;
    }
    /**
     * @param: $message
     * @description:sendmail will send email 
     * @return :true or false
     */
    function sendMail($message)
    {
        //Load email library
        $this->load->library('email');

        //SMTP & mail configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'manoj.mk.24.mk@gmail.com',
            'smtp_pass' => '123manoj24$',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $htmlContent = '<h1>please click below link to reset your password</h1>';
        $htmlContent .= '<p>' . $message . '</p>';
        $this->email->set_newline("\r\n");
        $this->email->from('xxx@gmail.com', 'www.fundoo.com'); // change it to yours
        $this->email->to('yathink3@gmail.com'); // change it to yours
        $this->email->subject('for recovering email');
        $this->email->message($htmlContent);
        //Send email
        if ($this->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}