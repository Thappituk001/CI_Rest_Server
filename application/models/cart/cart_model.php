<?php
class cart_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	

	}
	
	public function getCart()
	{
		
		
	}

	public function createCart()
	{

	}

	public function updateCart()
	{
		
	}
	public function deleteCart()
	{
		
	}

	public function addToCart($data)
	{
		if(!empty($data)){
			$x_insert = [];
			$x_ins = false;
			$x_upd = false;
			foreach ( $data as $k => $value) {

				$rs = $this->db->select('cart_product_online.id_product,cart_product_online.qty')
				->where('cart_product_online.id_product',$value['id_product'])
				->where('cart_product_online.id_cart_online',$value['id_cart_online'])
				->get('cart_product_online');

				if($rs->num_rows() <= 0)
				{
					array_push($x_insert,@array("id_cart_product_online"=>'',"id_cart_online"=>$value['id_cart_online'],"id_product"=>$value['id_product'],"qty"=>$value['qty']));
					
				}
				else//return id_product and qty of dupplicate item
				{
					if($this->db->where('cart_product_online.id_product',$value['id_product'])
				    ->where('cart_product_online.id_cart_online',$value['id_cart_online'])
					->update('cart_product_online',array("qty"=>$value['qty']+$rs->result()[0]->qty)))
					{
					  $x_upd = true;
					}

				}

			}//foreach

			if(!empty($x_insert)){
				if($this->db->where('cart_product_online.id_product',$value['id_product'])
					    ->where('cart_product_online.id_cart_online',$value['id_cart_online'])
						->insert_batch('cart_product_online',$x_insert))
				{
					$x_ins = true;
				}
			}

			$a_and_bool = $x_ins || $x_upd;
			if($a_and_bool){
				return "success";
			}
			else{
				return "false";
			}
			
			
		}//if
	

	}




}// end class;


?>