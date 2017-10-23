<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Cart extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('cart/cart_model','cart_model');
        
        $this->methods['cart_get']['limit'] = 50000; 
        $this->methods['cart_post']['limit'] = 5000; 
        $this->methods['cart_delete']['limit'] = 10000; 
    }

    public function cart_get()
    {
        $cart = $this->cart_model->getCart();

        $id = $this->get('id');


        if ($id === NULL)
        {
            if ($cart)
            {

                $this->response($cart, REST_Controller::HTTP_OK); // OK (200) 
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No cart were found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) 
            }
        }



        if ($id <= 0)
        {

            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) 
        }
        else
        {

            $user = NULL;

            if (!empty($cart))
            {
                foreach ($cart as $key => $value)
                {
                   if ( $value['id_cart'] === $id)
                   {
                    $user = $value;
                }
            }
        }


        if (!empty($user))
        {
                $this->set_response($user, REST_Controller::HTTP_OK); // OK (200) 
            }
            else
            {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User could not be found'
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) 
            }
        }
    }

    public function cart_post()
    {

        $result = $this->post();

        if($result === FALSE)
        {
            $this->response(array('status' => 'failed'));
        }
        else
        {
            $this->response($result);
            $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201)
        }

         
    }

    public function cart_delete($id)
    {
        if ($id <= 0)
        {

            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) 
        }
        
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204)
    }

    public function addToCart_post()
    {
        $post_data = $this->post();
        
       if($post_data === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
             $item = $this->product_model->addToCart($post_data);
            
            if(!empty($item))
            {
                $this->response($item, REST_Controller::HTTP_OK); 
            }
            else
            {
                $message = [
                    'message' => 'no resource'
                ];
                $this->response($message, REST_Controller::HTTP_OK); 
            }
        }
   
    }

}
