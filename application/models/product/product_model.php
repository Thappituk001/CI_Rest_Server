<?php
class product_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();	

	}
	
	public function createProduct()
	{

	}

	public function updateProduct()
	{
		
	}

	public function deleteProduct()
	{
		
	}
	public function getProduct()
	{

		$rs  = $this->db->select("tbl_product.id as product_id,
			tbl_product.code as product_code,
			tbl_product.name as product_name,
			tbl_product.price as product_price,
			promotion.discount_percent,
			promotion.discount_amount,
			tbl_product_style.id as style_id,
			tbl_product_style.code as style_code,
			tbl_product_style.name as style_name,
			tbl_color.id as color_id,
			tbl_color.code as color_code,
			tbl_color.name color_name,
			tbl_size.id as size_id,
			tbl_size.name as size_name,
			(SELECT SUM(tbl_stock.qty) from tbl_stock where tbl_stock.id_product = CAST(tbl_product.id AS UNSIGNED) ) AS qty
			")
		//----------------Remind--------------------------
		//remove qty by tbl_cancle , tbl_move , tbl_order
		//------------------------------
		->join('product_online','product_online.id_product_online = CAST(tbl_product.id AS UNSIGNED)')
		->join('promotion','promotion.id_product = product_online.id_product','left')
		->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id = tbl_product.id_color')
		->join('tbl_size','tbl_size.id = tbl_product.id_size')
		
		// ->where('tbl_product.show_in_online',1)
		// ->where('tbl_product.is_deleted',0)
		// ->where('tbl_product.active',1)
		->order_by('tbl_product.id_category', 'desc')
		->get('tbl_product');		
		
		if( $rs->num_rows() > 0 )
		{
			return $rs->result();	
		}
		else
		{
			return false;
		}
	}

	public function getNewProduct()
	{
		
		$qs  = $this->db->select('tbl_product.id as product_id,
			tbl_product.code as product_code,
			tbl_product.name as product_name,
			tbl_product.price as product_price,
			promotion.discount_percent,
			promotion.discount_amount,
			tbl_product_style.id as style_id,
			tbl_product_style.code as style_code,
			tbl_product_style.name as style_name,
			tbl_color.id as id_color,
			tbl_color.code as color_code,
			tbl_color.name as color_name,
			tbl_size.id as id_size,
			tbl_size.name as size_name,
			')
		->join('product_online','product_online.id_product = CAST(tbl_product.id AS UNSIGNED)')
		->join('promotion','promotion.id_product = product_online.id_product','left')
		->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id = tbl_product.id_color')
		->join('tbl_size','tbl_size.id = tbl_product.id_size')
		
		// ->where('tbl_product.show_in_online',1)
		// ->where('tbl_product.is_deleted',0)
		// ->where('tbl_product.active',1)
		->limit(12)
		->where('tbl_product.date_upd >=',"2017-06-01 00:00:00")
		->order_by('tbl_product.id_category', 'desc')
		->get('tbl_product');		
		
		if( $qs->num_rows() > 0 )
		{
			return $qs->result();	
		}
		else
		{
			return false;
		}

	}

	public function features()
	{

		$qs  = $this->db->select('tbl_product.id as product_id,
			tbl_product.code as product_code,
			tbl_product.name as product_name,
			tbl_product.price as product_price,
			promotion.discount_percent,
			promotion.discount_amount,
			tbl_product_style.id as style_id,
			tbl_product_style.code as style_code,
			tbl_product_style.name as style_name,
			tbl_color.id as id_color,
			tbl_color.code as color_code,
			tbl_color.name as color_name,
			tbl_size.id as id_size,
			tbl_size.name as size_name,
			')
		->join('product_online','product_online.id_product = CAST(tbl_product.id AS UNSIGNED)')
		->join('promotion','promotion.id_product = product_online.id_product','left')
		->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id = tbl_product.id_color')
		->join('tbl_size','tbl_size.id = tbl_product.id_size')
		
		// ->where('tbl_product.show_in_online',1)
		// ->where('tbl_product.is_deleted',0)
		// ->where('tbl_product.active',1)
		->limit(8)
		->order_by('tbl_product.id_category', 'desc')
		->get('tbl_product');		
		
		if( $qs->num_rows() > 0 )
		{
			return $qs->result();	
		}
		else
		{
			return false;
		}
	}

	public function getProduct_By_Menu($parent= 0,$child= 0,$sub_child= 0)
	{
		if($parent != 0 && $child == 0 && $sub_child == 0){
			$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_product_style.id as style_id,
				tbl_product_style.code as style_code,
				tbl_product_style.name as style_name
				
				')
			->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$parent)
			
			->limit(16,0)
			
			->order_by('tbl_product.id_category', 'desc')
			->get('tbl_product');		
			

		}else if($parent != 0 && $child != 0 && $sub_child == 0){
			
			$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_product_style.id as style_id,
				tbl_product_style.code as style_code,
				tbl_product_style.name as style_name
				
				')
			->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$parent)
			->where('product_online.id_child_menu',$child)

			->limit(16,0)
			
			->order_by('tbl_product.id_category', 'desc')
			->get('tbl_product');

		}else if($parent != 0 && $child != 0 && $sub_child != 0){
			
			$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_product_style.id as style_id,
				tbl_product_style.code as style_code,
				tbl_product_style.name as style_name
				
				')
			->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$parent)
			->where('product_online.id_child_menu',$child)
			->where('product_online.id_subchild_menu',$sub_child)
			->limit(16,0)
			
			->order_by('tbl_product.id_category', 'desc')
			->get('tbl_product');		
			
		}else{
			$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_product_style.id as style_id,
				tbl_product_style.code as style_code,
				tbl_product_style.name as style_name
				
				')
			->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$parent)
			->limit(16,0)
			->order_by('tbl_product.id_category', 'desc')
			->get('tbl_product');		
			
		}

		if( $rs->num_rows() > 0 )
		{
			return $rs->result();	
		}
		else
		{
			return array();
		}
	}

	public function product_detail($id)
	{
		$rs  = $this->db->select('tbl_product.id as product_id,
			tbl_product.code as product_code,
			tbl_product.name as product_name,
			tbl_product.price as product_price,
			promotion.discount_percent,
			promotion.discount_amount,
			tbl_product_style.id as style_id,
			tbl_product_style.code as style_code,
			tbl_product_style.name as style_name,
			tbl_color.id as id_color,
			tbl_color.code as color_code,
			tbl_color.name as color_name,
			tbl_color.id_group,
			tbl_color_group.name as color_group_name,
			tbl_size.id as id_size,
			tbl_size.name as size_name,
			')
		->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id = tbl_product.id_color')
		->join('tbl_size','tbl_size.id as id_size = tbl_product.id_size')
		->join('color_group','color_group.id_color_group = tbl_color.id_group')
		->join('promotion','promotion.id_product = tbl_product.id','left')
		->where('tbl_product.id',$id)
		->get('tbl_product');		


		if( $rs->num_rows() > 0 )
		{
			return $rs->result();	
		}
		else
		{
			return FALSE;
		}

	}	

	public function product_images($id)
	{
		$rs = $this->db->where('id_style', $id)->where('cover',1)->get('tbl_image');
		if( $rs->num_rows() > 0 )
		{
			return $rs->result();	
		}
		else
		{
			return FALSE;
		}
	}

	public function getSize_of_Style($id)
	{
		$rs = $this->db->select('tbl_product.id as product_id,
			tbl_size.id as id_size,
			tbl_size.size_name
			')
		->join('tbl_size','tbl_size.id as id_size = tbl_product.id_size')
		->where('tbl_product.id_style',$id)
		->get('tbl_product');	
		
		return $rs->result();
		
	}

	public function getColor_of_Style($id)
	{
		$rs = $this->db->select('tbl_product.id as product_id,
			tbl_product_style.id as style_id,
			tbl_color.id as id_color,
			tbl_color.code as color_code,
			tbl_color.name as color_name,
			tbl_color.id_group,
			tbl_color_group.name as color_group_name,
			tbl_color_group.code as code_color
			')
		->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id = tbl_product.id_color')
		->join('color_group','tbl_color_group.id_group = tbl_color.id_group')
		->where('tbl_product.id_style',$id)
		->get('tbl_product');	

		return $rs->result();
	}

	public function getColorToFilterColor($data)
	{
		$rs = $this->db->select("tbl_color.id,tbl_color.code,tbl_color.name,tbl_color_group.code as group_code,tbl_color_group.name as group_name")
		->join("tbl_color","tbl_color.id = tbl_product.id_color")
		->join("tbl_color_group","tbl_color_group.id = tbl_color.id_group")
		->where_in('tbl_product.id_style', $data)
		->group_by("tbl_color.id")
		->order_by("tbl_color.name", "acs")
		->get("tbl_product");
		return $rs->result();
	}

	public function getSizeToFilterSize($data)
	{
		$rs = $this->db->select("tbl_size.id,tbl_size.code,tbl_size.name")
		->join("tbl_size","tbl_size.id = tbl_product.id_size")
		->where_in('tbl_product.id_style', $data)
		->group_by("tbl_size.id")
		->order_by("tbl_size.name", "desc")
		->get("tbl_product");

		return $rs->result();
	}

	public function product_filter($data)
	{
		// $rs = $this->db->select("");
		$post = [];

		foreach ($data as $key => $value) {
			if($key == "color" || $key == "size")
			{
				$post[$key] = unserialize($value);
			}
			else{
				$post[$key] = $value;
			}
		}

		$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_product_style.id as style_id,
				tbl_product_style.code as style_code,
				tbl_product_style.name as style_name
				
				')
			->join('tbl_product_style' , 'tbl_product_style.id = tbl_product.id_style')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$post['parent'])
			->where('product_online.id_child_menu',$post['child'])
			->where('product_online.id_subchild_menu',$post['sub_child'])
			->where('tbl_product.price >=',$post['minPrice'])
			->where('tbl_product.price <=',$post['maxPrice'])
			->where_in('tbl_product.id_color', $post['color'])
			->where_in('tbl_product.id_size', $post['size'])
			->limit(32,0)
			->order_by('tbl_product.id_category', 'desc')
			->get('tbl_product');	


		return $rs->result();
	}
}// end class;


?>