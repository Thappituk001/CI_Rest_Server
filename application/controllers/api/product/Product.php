<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Product extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('product/product_model','product_model');
        
        $this->methods['product_delete']['limit'] = 0; 
    }

    public function product_get()
    {


        $product = $this->product_model->getProduct();


        $id = $this->get('id');
        print_r($product);
        // if ($id === NULL)
        // {

        //     if ($product)
        //     {

        //         $this->response($product, REST_Controller::HTTP_OK); 
        //     }
        //     else
        //     {

        //         $this->response([
        //             'status' => FALSE,
        //             'message' => 'No product were found'
        //         ], REST_Controller::HTTP_NOT_FOUND); 
        //     }
        // }

        // if ($id <= 0)
        // {
        //     $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        // }
        // else
        // {

        //     $items = [];

        //     if (!empty($product))
        //     {
        //         foreach ($product as $key => $value)
        //         {
        //             if ( $value->product_id === $id)
        //             {
        //               array_push($items,$value);
        //           }
        //         }//foreach
        //     }//if


        //     if (!empty($items))
        //     {
        //         $this->set_response($items, REST_Controller::HTTP_OK); 
        //     }
        //     else
        //     {
        //         $this->set_response([
        //             'status' => FALSE,
        //             'message' => 'Product could not be found'
        //         ], REST_Controller::HTTP_NOT_FOUND); 
        //     }//else
        // }// else
    }//function

    public function product_detail_get()
    {  

        $id_product = $this->get('id_product');
        $id_style   = $this->get('id_style');
        $product['detail'] = $this->product_model->product_detail($id_product);
        $product['images'] = $this->product_model->product_images($id_style);
        $product['color']  = $this->product_model->getColor_of_Style($id_style);
        $product['size']   = $this->product_model->getSize_of_Style($id_style);
        if(!empty($product))
        {
            $this->set_response($product, REST_Controller::HTTP_OK); 
        }
        else
        {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Product could not be found'
            ], REST_Controller::HTTP_NOT_FOUND); 
        }
    }

    public function product_post()
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
    }

    public function product_delete($id)
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

    public function product_by_menu_post()
    {
        $result  = $this->post();
        $parent = $this->post('parent');
        $child   = $this->post('child');
        $sub_child = $this->post('sub_child');
        
        if($result === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->getProduct_By_Menu($parent,$child,$sub_child);


            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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

    public function newProduct_get()
    {
        $product = $this->product_model->getNewProduct();

            if ($product)
            {
                $this->response($product, REST_Controller::HTTP_OK); 
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No product were found'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }
       
    }//function

    public function features_get()
    {
        $product = $this->product_model->features();

            if ($product)
            {
                $this->response($product, REST_Controller::HTTP_OK); 
            }
            else
            {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No product were found'
                ], REST_Controller::HTTP_NOT_FOUND); 
            }
       
    }//function
    
    public function color_post()
    {
        $result  = $this->post();
       
        if($result === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->getColorToFilterColor($result);
          
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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

    public function size_post()
    {
        $result  = $this->post();
       
        if($result === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->getSizeToFilterSize($result);
          
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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

    public function product_filter_post()
    {
        $result  = $this->post();
        
        if($result === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->product_filter($result);
            // print_r($product);
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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

     public function product_grid_get()
    {
        $result  = $this->get('id',true);
        // print_r($result);
        if($result === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->product_grid($result);
            // print_r($product);
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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


    public function ProductDetail_get()
    {
       $result  = $this->get('id',true);
        // print_r($result);
        if($result === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->getProductDetail($result);
            // print_r($product);
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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


    public function product_images_get()
    {
       $result  = $this->get('id',true);
        // print_r($result);
        if($result === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->getproduct_images($result);
            // print_r($product);
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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

    public function moreFeatures_get()
    {
        $result  = $this->get('offset',true);
        // print_r($result);
        if($result === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->moreFeatures($result);
            // print_r($product);
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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


    public function moreProduct_get()
    {
        $offset  = $this->get('offset',true);
        $parent  = $this->get('parent',true);
        $child  = $this->get('child',true);
        $sub_child  = $this->get('sub_child',true);

        if($offset === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->moreProduct($offset,$parent,$child,$sub_child);
            // print_r($product);
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
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

    public function SizeByColor_get()
    {

        $style = $this->get('style',true);
        $color  = $this->get('color',true);
    
        if($offset === FALSE)
        {
         $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); 
        }
        else
        {
            $product = $this->product_model->getSizeByColor($style,$color);
            
            if(!empty($product))
            {
                $this->response($product, REST_Controller::HTTP_OK); 
            }
            else
            {
                $message = [
                    'message' => 'no resource'
                ];
                $this->response($message, REST_Controller::HTTP_OK); 
            }
        }//else
    }//function

   


}//class
