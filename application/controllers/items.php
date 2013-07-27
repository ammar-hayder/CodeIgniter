<?php
class Items extends CI_Controller {
	
	// The Constructor
	public function __construct()
	{
		parent::__construct();
		
		// Load Model
		$this->load->model('Item_model');
		$this->load->model('user_model');
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
		//CHECK FOR LOGIN FIRST
		$this->user_model->is_logged_in();
	}
	
	// The Controller Root index
	public function index($orderby=NULL, $orderby_opt=NULL, $page=0)
	{	
		// sort order settings
		if(!$orderby || is_numeric($orderby))	$orderby='id';
		if(!$orderby_opt)	$orderby_opt='asc';

		// toggle sortorder & toggle its header css
		if($orderby_opt=='asc')
		{	$orderby_opt_next='desc';
			$data['orderby_css']="bottom_arrow";
		}
		else
		{	$orderby_opt_next='asc';
			$data['orderby_css']="top_arrow";
		}
		
		// setup page data
		$data['page'] = @$page;
		$data['orderby'] = @$orderby;
		$data['orderby_opt'] = @$orderby_opt;
		$data['orderby_opt_next'] = @$orderby_opt_next;
		$data['all_total_records']=$this->Item_model->total_records();
		
		// pagination settings
		$this->load->library('pagination');
		$config['base_url'] = site_url("items/index/$orderby/$orderby_opt");

		$config['total_rows'] = $this->Item_model->total_records();
		$config['per_page'] = 3; 
		$config['uri_segment'] = 5;
		$config['next_link'] = 'Next &raquo;';
		$config['prev_link'] = 'Prev &laquo;';
		
		$this->pagination->initialize($config); 
		$data['paging_links']=$this->pagination->create_links();
		$data['user_records']=$this->Item_model->list_all($config['per_page'], (int)$this->uri->segment(5), $orderby, $orderby_opt);
		
		// $data['registration'] = $this->user_model->get_register($config['per_page'], (int)$this->uri->segment(5), $orderby, $orderby_opt);
		// echo $data['registration'];
		// exit;
		

		// $data['register'] = $data['registration']['username'];

		$this->load->view('admin/header_view');
		$this->load->view('admin/item_manage_view', $data);
		$this->load->view('admin/footer_view');
	}

	public function create()
	{
		$this->load->helper('form');
		
		$this->load->library('form_validation');
		

		$this->form_validation->set_rules('item_code', 'Item Code', 'callback_code_check[item_code]|trim|required|xss_clean');
		$this->form_validation->set_rules('item_name', 'Item Name', 'callback_name_check[item_name]
			|trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('item_info', 'Item Info', 'trim|required');
		

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/header_view');
			$this->load->view('admin/item_create_view');
			$this->load->view('admin/footer_view');
		}
		else
		{
			$this->session->set_flashdata('item_create', 'Item has been Successfully created.');
			$this->Item_model->create_items();
			redirect('items');
		}
	}
	public function edit($id=NULL)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item_code', 'Item Code', 'trim|required|xss_clean');
		$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('item_info', 'Item Info', 'trim|required');
		

		$data['user_detail']= $this->Item_model->get_items($id);
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/header_view');
			$this->load->view('admin/item_edit_view', $data);
			$this->load->view('admin/footer_view');
		}
		else
		{
			$this->session->set_flashdata('item_edit', 'Item Edited Successfully');
			
			$this->Item_model->set_items($id);
			redirect('items');
		}
	}
	public function delete($ids=NULL) 
	{
		if(is_array($this->input->post('check_id')))
		{
			foreach($this->input->post('check_id') as $id)
			{
				$this->db->delete('items', array('id' => $id));
				$this->db->delete('cart', array('id' => $id));
			}
			$this->session->set_flashdata('item_delete', 'Items deleted Successfully');
			redirect(site_url('items'));
		}
		else
		{
			// $ids = $this->uri->segment(6);
			$this->db->delete('items', array('id' => $ids));
			$this->session->set_flashdata('item_delete', 'Item Delete Successfully');
			redirect(site_url('items'));
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
