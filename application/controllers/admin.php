<?php
class Admin extends CI_Controller {
	
	// The Constructor
	public function __construct()
	{
		parent::__construct();
		
		// Load Model
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
		

		$this->load->view('admin/header_view');
		$this->load->view('admin/admin_view');
		$this->load->view('admin/footer_view');
	}

	public function register_manage($orderby=NULL, $orderby_opt=NULL, $page=0)
	{
		
		// sort order settings
		if(!$orderby || is_numeric($orderby))	$orderby='username';
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
		$data['all_total_records']=$this->user_model->total_records();
		
		// pagination settings
		$this->load->library('pagination');
		$config['base_url'] = site_url("admin/register_manage/$orderby/$orderby_opt");
		
		$config['total_rows'] = $this->user_model->total_records();
		$config['per_page'] = 2; 
		$config['uri_segment'] = 5;
		$config['next_link'] = 'Next &raquo;';
		$config['prev_link'] = 'Prev &laquo;';
		
		$this->pagination->initialize($config); 
		$data['paging_links']=$this->pagination->create_links();
		
		$data['user_records']=$this->user_model->list_all($config['per_page'], (int)$this->uri->segment(5), $orderby, $orderby_opt);
		// echo $data['registration'];
		// exit;
		if (empty($data['user_records']))
		{
			show_404();
		}

		// $data['register'] = $data['registration']['username'];

		$this->load->view('admin/header_view', $data);
		$this->load->view('admin/register_manage_view', $data);
		$this->load->view('admin/footer_view');
	}

	public function register_edit($id=NULL)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'callback_email_check[email]|trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'callback_username_check[username]
			|trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
		

		$data['user_detail']= $this->user_model->get_register($id);
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/header_view');
			$this->load->view('admin/register_edit_view',$data);
			$this->load->view('admin/footer_view');
		}
		else
		{
			$this->session->set_flashdata('user_edited', 'User Edited Successfully');
			
			$this->user_model->set_register($id);
			redirect('admin/register_manage');
		}
	}
	public function delete($page=0, $orderby=NULL, $orderby_opt=NULL, $ids=NULL) 
	{
		// echo $this->input->post('check_id');
		// print_r($this->input->post('check_id'));
		// exit;
				
		if(is_array($this->input->post('check_id')))
		{
			foreach($this->input->post('check_id') as $id)
			{
				$this->db->delete('registration', array('id' => $id));
			}
			$this->session->set_flashdata('user_delete', 'User Deleted Successfully');
			redirect(site_url("admin/register_manage/$orderby/$orderby_opt/$page"));
		}
		else
		{
			// $ids = $this->uri->segment(6);
			$this->db->delete('registration', array('id' => $ids));
			$this->session->set_flashdata('user_delete', 'User Deleted Successfully');
			redirect(site_url("admin/register_manage/$orderby/$orderby_opt/$page"));
		}
		
	}
	public function logout()
	{
		$user_id_pk=$this->session->userdata('s_user_id_pk');
		
		// //Log this
		// $this->my_functions->log_this("Controller logged out [id:$user_id_pk]");
				
		//set user details into session
		$this->session->set_userdata('s_user_id_pk', "");
		$this->session->set_userdata('s_is_admin', "");
		$this->session->set_userdata('s_full_name', "");
		
		$this->load->view('welcome_message');
	}
}
