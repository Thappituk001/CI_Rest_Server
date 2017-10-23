<?php
class register_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	

	}
	
	public function proviance(){

		$result = $this->db->select("PROVINCE_ID, PROVINCE_NAME")
		->order_by("PROVINCE_NAME")
		->get("province");
		
		return $result->result();
	}

	public function district($ID){

		$result= $this->db->select("AMPHUR_ID, AMPHUR_NAME")
		->where("PROVINCE_ID",$ID)
		->get("amphur");

		return $result->result() ;
	}

	public function subdistrict($ID){

		$result = $this->db->select("DISTRICT_ID, DISTRICT_NAME")
		->where("AMPHUR_ID",$ID)
		->get("district");

		return $result->result() ;
	}

	public function postcode($ID){

		$result= $this->db->select("POST_CODE")
		->where("AMPHUR_ID",$ID)
		->get("amphur_postcode");
		
		return $result->result();
	}


	public function register($data)
	{
		$check_duplicate_data = $this->checkDuplicateData($data['ip_address']['ip_address']);

		if($check_duplicate_data != FALSE)
		{
			$this->db->insert('customer_online', $data['customer']);
			$last_id_customer = $this->db->insert_id();//last id

			$data['address']["id_customer_online"] =  $last_id_customer;
			$data['account']["id_customer_online"] =  $last_id_customer;

			$this->db->insert('customer_online_address', $data['address']);
			$this->db->insert('customer_online_account', $data['account']);

			$id_great = $check_duplicate_data;

			$checkCart = $this->db->select('id_cart')
			->where('id_great',$id_great)
			->where('id_customer','0')
			->get('cart_online');

			$id_cart = $checkCart->row()->id_cart;

					//update id customer and great id in cart
			$data = array(
				'id_customer' => $last_id_customer,
				'id_great' => '0'
			);

			$this->db->where('id_cart', $id_cart);
			$this->db->update('cart_online', $data); 
			
			return array('status'=>'success');
			
		}
		else
		{
			return $check_duplicate_data;
		}//check duplicate
	}

	private function checkDuplicateData($ip)
	{
		$rs = $this->db->select('id_great')->where('ip_address', $ip)->get('great');

		if( $rs->num_rows() == 1 )
		{
			return $rs->row()->id_great;
		}
		else
		{
			return FALSE;
		}
	}

	

}// end class;


?>