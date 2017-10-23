<?php
class users_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	

	}
	
	public function getUsers()
	{
		
		$array =  $this->db->get('tbl_employee')->result_array();
		

		return $array;
	}

	public function Validate_Great($ip_address)
	{
		$rs = $this->db->select('id_great')->where('ip_address', $ip_address)->get('great');
		if( $rs->num_rows() == 1 )
		{
			// have id great 
			$id_great = $rs->row()->id_great;
			return array("id"=>$id_great,"role"=>"great");
		}else{
			$data = array(
			   'ip_address' => $this->input->ip_address() 
			);
			$this->db->insert('great', $data); 
			$insert_id = $this->db->insert_id();
			return array("id"=>$insert_id,"role"=>"great");
		}
	}

	public function createUser()
	{

	}

	public function updateUser()
	{
		
	}
	
	public function deleteUser()
	{
		
	}

}// end class;


?>