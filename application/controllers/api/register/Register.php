<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Register extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('register/register_model','register_model');
        
        $this->methods['register_delete']['limit'] = 0; 
    }

    public function register_delete($id)
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

    public function proviance_get()
    {
        $proviance = $this->register_model->proviance();

        if ($proviance)
        {
            $this->response($proviance, REST_Controller::HTTP_OK); 
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No proviance were found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }

    }//function

    public function district_get()
    {
        $id = $this->get("id");
        $district = $this->register_model->district($id);

        if ($district)
        {
            $this->response($district, REST_Controller::HTTP_OK); 
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No district were found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }

    }//function

    public function subdistrict_get()
    {
        $id = $this->get("id");
        $subdistrict = $this->register_model->subdistrict($id);

        if ($subdistrict)
        {
            $this->response($subdistrict, REST_Controller::HTTP_OK); 
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No subdistrict were found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }

    }//function

    public function postcode_get()
    {
        $id = $this->get("id");
        $postcode = $this->register_model->postcode($id);

        if ($postcode)
        {
            $this->response($postcode, REST_Controller::HTTP_OK); 
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No postcode were found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }

    }//function
    
    public function register_post()
    {
        $post_data = $this->post();
       if ($post_data)
        {
            $response = $this->register_model->register($post_data);
            $this->response($response, REST_Controller::HTTP_OK); 
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No postcode were found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function checkDuplicate()
    {

    }

    public function addMemberAddr()
    {

    }




}//class
