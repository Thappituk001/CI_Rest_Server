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