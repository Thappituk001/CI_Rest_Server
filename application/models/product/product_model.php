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
			tbl_style.id as style_id,
			tbl_style.code as style_code,
			tbl_style.name as style_name,
			tbl_color.id_color,
			tbl_color.color_code,
			tbl_color.color_name,
			tbl_size.id_size,
			tbl_size.size_name,
			(SELECT SUM(tbl_stock.qty) from tbl_stock where tbl_stock.id_product = CAST(tbl_product.id AS UNSIGNED) ) AS qty
			")
		//----------------Remind--------------------------
		//remove qty by tbl_cancle , tbl_move , tbl_order
		//------------------------------
		->join('product_online','product_online.id_product_online = CAST(tbl_product.id AS UNSIGNED)')
		->join('promotion','promotion.id_product = product_online.id_product','left')
		->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
		->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
		
		->where('tbl_product.show_in_online',1)
		->where('tbl_product.is_deleted',0)
		->where('tbl_product.active',1)
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
			tbl_style.id as style_id,
			tbl_style.code as style_code,
			tbl_style.name as style_name,
			tbl_color.id_color,
			tbl_color.color_code,
			tbl_color.color_name,
			tbl_size.id_size,
			tbl_size.size_name,
			')
		->join('product_online','product_online.id_product_online = tbl_product.id')
		->join('promotion','promotion.id_product = product_online.id_product','left')
		->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
		->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
		
		->where('tbl_product.show_in_online',1)
		->where('tbl_product.is_deleted',0)
		->where('tbl_product.active',1)
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

		$rs  = $this->db->select('tbl_product.id as product_id,
			tbl_product.code as product_code,
			tbl_product.name as product_name,
			tbl_product.price as product_price,
			promotion.discount_percent,
			promotion.discount_amount,
			tbl_style.id as style_id,
			tbl_style.code as style_code,
			tbl_style.name as style_name,
			tbl_color.id_color,
			tbl_color.color_code,
			tbl_color.color_name,
			tbl_size.id_size,
			tbl_size.size_name,
			tbl_product_kind.id as kind_id,
			tbl_product_kind.code as kind_code,
			tbl_product_kind.name as kine_name,
			tbl_product_type.id as type_name,
			tbl_product_type.code as type_code,
			tbl_product_type.name as type_name,
			tbl_product_group.id as group_id,
			tbl_product_group.code as group_code,
			tbl_product_group.name as group_name,
			tbl_product_category.id as category_id,
			tbl_product_category.code as category_code,
			tbl_product_category.name as category_name,
			')
		->join('product_online','product_online.id_product_online = tbl_product.id')
		->join('promotion','promotion.id_product = product_online.id_product','left')
		->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
		->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
		->join('tbl_product_kind','tbl_product_kind.id = tbl_product.id_kind')
		->join('tbl_product_type','tbl_product_type.id = tbl_product.id_type')
		->join('tbl_product_group','tbl_product_group.id = tbl_product.id_group')
		->join('tbl_product_category','tbl_product_category.id = tbl_product.id_category')

		->where('tbl_product.show_in_online',1)
		->where('tbl_product.is_deleted',0)
		->where('tbl_product.active',1)
		->limit(8,0)
		->order_by('tbl_product.price', 'desc')
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

	public function getProduct_By_Menu($parent= 0,$child= 0,$sub_child= 0)
	{
		if($parent != 0 && $child == 0 && $sub_child == 0){
			
			$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_style.id as style_id,
				tbl_style.code as style_code,
				tbl_style.name as style_name,
				tbl_color.id_color,
				tbl_color.color_code,
				tbl_color.color_name,
				tbl_color.id_color_group,
				color_group.color_group_name,
				tbl_size.id_size,
				tbl_size.size_name,
				')
			->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
			->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
			->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
			->join('color_group','color_group.id_color_group = tbl_color.id_color_group')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$parent)
			->limit(16,0)
			->group_by('tbl_product.id')
			->order_by('tbl_product.id_category','desc')
			->get('tbl_product');		
			

		}else if($parent != 0 && $child != 0 && $sub_child == 0){
			
			$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_style.id as style_id,
				tbl_style.code as style_code,
				tbl_style.name as style_name,
				tbl_color.id_color,
				tbl_color.color_code,
				tbl_color.color_name,
				tbl_color.id_color_group,
				color_group.color_group_name,
				tbl_size.id_size,
				tbl_size.size_name,
				')
			->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
			->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
			->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
			->join('color_group','color_group.id_color_group = tbl_color.id_color_group')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$parent)
			->where('product_online.id_child_menu',$child)
			->limit(16,0)
			->group_by('tbl_product.id')
			->order_by('tbl_product.id_category', 'desc')
			->get('tbl_product');

		}else if($parent != 0 && $child != 0 && $sub_child != 0){
			
			$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_style.id as style_id,
				tbl_style.code as style_code,
				tbl_style.name as style_name,
				tbl_color.id_color,
				tbl_color.color_code,
				tbl_color.color_name,
				tbl_color.id_color_group,
				color_group.color_group_name,
				tbl_size.id_size,
				tbl_size.size_name,
				')
			->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
			->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
			->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
			->join('color_group','color_group.id_color_group = tbl_color.id_color_group')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$parent)
			->where('product_online.id_child_menu',$child)
			->where('product_online.id_subchild_menu',$sub_child)
			->limit(16,0)
			->group_by('tbl_product.id')
			->order_by('tbl_product.id_category', 'desc')
			->get('tbl_product');		
			

		}else{
			$rs  = $this->db->select('tbl_product.id as product_id,
				tbl_product.code as product_code,
				tbl_product.name as product_name,
				tbl_product.price as product_price,
				promotion.discount_percent,
				promotion.discount_amount,
				tbl_style.id as style_id,
				tbl_style.code as style_code,
				tbl_style.name as style_name,
				tbl_color.id_color,
				tbl_color.color_code,
				tbl_color.color_name,
				tbl_color.id_color_group,
				color_group.color_group_name,
				tbl_size.id_size,
				tbl_size.size_name,
				')
			->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
			->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
			->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
			->join('color_group','color_group.id_color_group = tbl_color.id_color_group')
			->join('product_online','product_online.id_product = tbl_product.id')
			->join('promotion','promotion.id_product = product_online.id_product','left')
			->where('product_online.id_parent_menu',$parent)
			->limit(16,0)
			->group_by('tbl_product.id')
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
			tbl_style.id as style_id,
			tbl_style.code as style_code,
			tbl_style.name as style_name,
			tbl_color.id_color,
			tbl_color.color_code,
			tbl_color.color_name,
			tbl_color.id_color_group,
			color_group.color_group_name,
			tbl_size.id_size,
			tbl_size.size_name,
			')
		->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
		->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
		->join('color_group','color_group.id_color_group = tbl_color.id_color_group')
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
			tbl_size.id_size,
			tbl_size.size_name
			')
		->join('tbl_size','tbl_size.id_size = tbl_product.id_size')
		->where('tbl_product.id_style',$id)
		->get('tbl_product');	
		
		return $rs->result();
		
	}

	public function getColor_of_Style($id)
	{

		$rs = $this->db->select('tbl_product.id as product_id,
			tbl_style.id as style_id,
			tbl_color.id_color,
			tbl_color.color_code,
			tbl_color.color_name,
			tbl_color.id_color_group,
			color_group.color_group_name,
			color_group.code_color
			')
		->join('tbl_style' , 'tbl_style.id = tbl_product.id_style')
		->join('tbl_color','tbl_color.id_color = tbl_product.id_color')
		->join('color_group','color_group.id_color_group = tbl_color.id_color_group')
		->where('tbl_product.id_style',$id)
		->get('tbl_product');	

		
		return $rs->result();
		
		
	}




}// end class;


?>