<?php
class Cart extends CI_Controller {
	
	// The Constructor
	public function __construct()
	{
		parent::__construct();
		
		// Load Model
		$this->load->model('Cart_model');
		$this->load->model('Item_model');
		$this->load->model('user_model');
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		//CHECK FOR LOGIN FIRST
		$this->user_model->is_logged_in();
	}
	
	// The Controller Root index
	public function index()
	{	
		

		$this->load->view('admin/cart_header_view');
		$this->load->view('admin/cart_manage_view');
		$this->load->view('admin/footer_view');
	}

	public function manage($cart)
	{
		// echo $cart;
		// exit;
		$data['items']=$this->Item_model->get_items();
		$data['cart_items']=$this->Cart_model->get_cart($cart);
		// print_r($this->Cart_model->get_cart($cart));
		// exit;
		$data['cart']=$cart;
		
		$this->load->view('admin/cart_view', $data);
		
		
	}
	public function edit()
	{
		$item_id= $this->input->post('item_id');
		$cart_no=$this->input->post('cart_no');
		$query=$this->db->get_where('cart',array('item_id'=>$item_id, 'cart_no'=> $cart_no));
		$result=$query->row_array();
		
		if(count($result)>0)
		{
			$this->Cart_model->update_item($result['item_quantity']);
			$query1=$this->db->get_where('cart',array('item_id'=>$item_id, 'cart_no'=> $cart_no));
			$result1=$query1->row_array();
			echo "$result1[item_quantity]";
			// print_r($result1);
			// exit;
		}
		else
		{
			
			$this->Cart_model->insert_item();
			$query=$this->db->get_where('cart',array('item_id'=>$item_id, 'cart_no'=> $cart_no));
			$result=$query->row_array();
			echo 1;
			
		}
		 
	}
	public function delete() 
	{
		$item_id= $this->input->post('item_id');
		
		$cart_no=$this->input->post('cart_no');
		$query=$this->db->get_where('cart',array('item_id'=>$item_id, 'cart_no'=> $cart_no));
		$result=$query->row_array();

		$this->Cart_model->update_item_less($result['item_quantity']);

		$query1=$this->db->get_where('cart',array('cart_no'=> $cart_no));
		$result1=$query1->row_array();
		

		if(count($result1)>0)
		{
			// echo $result1
			$query2=$this->db->get_where('cart',array('item_id'=>$item_id, 'cart_no'=> $cart_no));
			$result2=$query2->row_array();
			if (count($result2)>0) {
				echo "$result2[item_quantity]";
			}
			else
			{
				echo 0;
			}
		}
		else
		{
			echo "no item";
		}
		
	}
	public function code_check($str)
	{
		$check_username = $this->Item_model->get_items($str);
		if (count($check_username) >0)
		{
			$this->form_validation->set_message('code_check', 'The %s is already exist.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function name_check($str1)
	{
		$check_email = $this->Item_model->get_items($str1);
		
		if (count($check_email) >0)
		{
			$this->form_validation->set_message('name_check', 'The %s is already exist.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
