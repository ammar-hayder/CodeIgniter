<?php
class cart_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function get_items($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('items');
			return $query->result_array();
		}

		$query = $this->db->get_where('items', array('item_code' => $slug));
		$result=$query->row_array();
		$query1 = $this->db->get_where('items', array('item_name' => $slug));
		$result1=$query1->row_array();
		$query2 = $this->db->get_where('items', array('id' => $slug));
		$result2=$query2->row_array();
		if (count($result)>0)
		{
			return $result;
		}
		else if(count($result1)>0)
		{
			
			return $result1;
		}
		else if(count($result2)>0)
		{
			
			return $result2;
		}
	}
	public function get_cart($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query1 = $this->db->query("SELECT * FROM cart");
			$result1=$query1->result_array();
			return $result1;
		}
		else{
			$query = $this->db->query("SELECT *, items.id as id FROM items, cart WHERE items.id=cart.item_id AND cart.cart_no=$slug AND cart.item_quantity!= 0");
			$result=$query->result_array();
			return $result;
		}
		
		
	}

	public function insert_item()
	{
		$this->load->helper('url');
		$d_added=date("Y-m-d H:i:s");
		$d_updated="";
		$id= $this->input->post('item_id');
		$cart_no=$this->input->post('cart_no');
		// $slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			
			'item_id' => $id,
			'cart_no' => $cart_no,
			'item_quantity'=>1,
			'd_added' => $d_added,
			'd_updated' => $d_updated
		);

		return $this->db->insert('cart', $data);
		
	}
	public function update_item($quantity)
	{
		$this->load->helper('url');
		$d_added="";
		$d_updated=date("Y-m-d H:i:s");
		$id= $this->input->post('item_id');
		$cart_no=$this->input->post('cart_no');
		// $slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			
			'item_quantity'=>$quantity+1,
			'd_added' => $d_added,
			'd_updated' => $d_updated
		);

		return $this->db->update('cart', $data, array('item_id' => $id, 'cart_no'=>$cart_no));
		
	}
	public function update_item_less($quantity)
	{
		$this->load->helper('url');
		$d_added="";
		$d_updated=date("Y-m-d H:i:s");
		$item_id= $this->input->post('item_id');
		
		$cart_no=$this->input->post('cart_no');
		// $slug = url_title($this->input->post('title'), 'dash', TRUE);
		$update_quantity= $quantity-1;
		// echo "$update_quantity";
		// var_dump($update_quantity);

		if($update_quantity === 0 )
		{
			// echo "stir";
			$this->db->delete('cart', array('item_id' => $item_id, 'cart_no'=>$cart_no));
		}
		else
		{
			// echo "hello";
			$data = array(
			
			'item_quantity'=>$quantity-1,
			'd_added' => $d_added,
			'd_updated' => $d_updated
				);

			return $this->db->update('cart', $data, array('item_id' => $item_id, 'cart_no'=>$cart_no));
		}
	}

}