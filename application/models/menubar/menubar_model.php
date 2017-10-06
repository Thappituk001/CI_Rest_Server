<?php
class menubar_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	

	}
	
	public function getMenuBar()
	{
		
		$this->db->select("*");
		$this->db->from("menu_parents");
		$q = $this->db->get();

		$final = array();
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$c = $this->db->select("*")
				->from("menu_children")
				->where("parent_id", $row->parent_id)
				->get();

				if($c->num_rows() > 0 ){
					$row->child = $c->result();

					foreach ($row->child as $r) {

						foreach ($r as $s) {
							$sc = $this->db->select("*")
							->from("menu_sub_children")
							->where("parent_id", $r->parent_id)
							->where("child_id", $r->id_child)
							->get();
							$r->sub_child = '';
							if($sc->num_rows() > 0 ){
								$r->sub_child = $sc->result();
							}
						}
					}

				}

				array_push($final, $row);
			}
		}
		return $final;
	}
	

	public function createMenuBar()
	{

	}

	public function updateMenuBar()
	{

	}
	public function deleteMenuBar()
	{

	}

}// end class;


?>