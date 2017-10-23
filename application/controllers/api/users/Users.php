<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Users extends REST_Controller {

    function __construct()
    {

        parent::__construct();
        $this->load->model('users/users_model','users_model');
        
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function users_get()
    {

        $users = $this->users_model->getUsers();

        $id = $this->get('id');
        

        if ($id === NULL)
        {
            if ($users)
            {

                $this->response($users, REST_Controller::HTTP_OK);
            }
            else
            {

                $this->response([
                    'status' => FALSE,
                    'message' => 'No users were found'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }
        }//if id ==null

        if ($id <= 0)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $user = NULL;

            if (!empty($users))
            {
                foreach ($users as $key => $value)
                {
                    if ( $value['id_employee'] === $id)
                    {
                        $user = $value;
                    }
                }
            }
        }//else

        if (!empty($user))
        {
            $this->set_response($user, REST_Controller::HTTP_OK); 
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'User could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }//else
    }




    public function users_post()
    {

        $result = $this->post();

        if($result === FALSE)
        {
            $this->response(array('status' => 'failed'));
        }
        else
        {
            $this->response($result);
        }

        $this->set_response($message, REST_Controller::HTTP_CREATED); 
    }

     public function Validate_Great_post()
    {

        $result  = $this->post();
        $ip      = $this->post('ip_address');
        // print_r($ip);
       
        if($result === FALSE)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $user = $this->users_model->Validate_Great($ip);
            // print_r($user);
            if(!empty($user))
            {
                $this->response($user, REST_Controller::HTTP_OK); 
            }
            else
            {
                $message = [
                    'message' => 'no resource'
                ];
                $this->response($message, REST_Controller::HTTP_OK); 
            }
        }//else

    }

    public function users_delete($id)
    {
        if ($id <= 0)
        {

            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }

        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); 
    }

}
