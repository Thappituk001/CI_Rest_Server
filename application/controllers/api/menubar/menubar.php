<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Menubar extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('menubar/menubar_model','menubar_model');
        
        $this->methods['menubar_post']['limit'] = 0; 
        $this->methods['menubar_delete']['limit'] = 0; 
    }

    public function menubar_get()
    {
        $menubar = $this->menubar_model->getMenuBar();

        if($menubar === FALSE)
        {
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            if (!empty($menubar))
            {
                $this->set_response($menubar, REST_Controller::HTTP_OK); 
            }else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'menubar could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }//else
        }//else
    }//function get()
}//class
