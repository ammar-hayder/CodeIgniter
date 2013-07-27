<?php
class User extends CI_Controller {
	
	// The Constructor
	public function __construct()
	{
		parent::__construct();
		
		// Load Model
		$this->load->model('user_model');
		$this->load->helper('url');
		$this->load->database();
		$this->load->library('session');
	}
	
	// The Controller Root index
	public function index()
	{
		//CHECK FOR LOGIN FIRST
		$this->user_model->is_logged_in();
		
		//CHECK MODULE ACCESS
		$this->my_functions->check_module_access('Controller Management');
		
		// Clear unwanted sessions
		$this->session->set_userdata('search_query',"");
		
		// Redirect to Manager page
		redirect(base_url().'user/manage');
	}

	// List Records
	public function manage($orderby=NULL, $orderby_opt=NULL, $page=0)
	{
		//CHECK FOR LOGIN FIRST
		$this->user_model->is_logged_in();
		// sort order settings
		if(!$orderby || is_numeric($orderby))	$orderby='full_name';
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
		$config['base_url'] = base_url().'user/manage/'.$orderby.'/'.$orderby_opt;
		$config['total_rows'] = $this->user_model->total_records();
		$config['per_page'] = 10; 
		$config['uri_segment'] = 5;
		$config['next_link'] = 'Next &raquo;';
		$config['prev_link'] = 'Prev &laquo;';
		
		$this->pagination->initialize($config); 
		$data['paging_links']=$this->pagination->create_links();
		$data['user_records']=$this->user_model->list_all($config['per_page'], (int)$this->uri->segment(5), $orderby, $orderby_opt);
		
		$this->load->view('user_view', $data);
	}
	
	
	// Search records
	public function search(){
		
		//get search keyword
		$keyword = $this->input->post('keyword', TRUE);
		
		//set search query in session
		if(empty($keyword))
		{
			$this->session->set_userdata('search_query',"");
		}
		else
		{
			$this->session->set_userdata('search_query',"SELECT * FROM user_mst 
															WHERE full_name LIKE '%".$keyword."%'");
		}
		
		//redirect to manage page
		redirect(base_url().'user/manage');
	}
	
	
	// List all records
	public function view_all()
	{
		//clear search session here
		$this->session->set_userdata('search_query',"");
		
		//redirect to manage page
		redirect(base_url().'user/manage');
	}
	
	// Return after update
	public function return_to_edit(){
		redirect(base_url()."user/update/0/full_name/asc/".$this->session->userdata('record_id'));
	}
	
	
	
	
	// Delete Checked
	public function delete($page=0, $orderby=NULL, $orderby_opt=NULL, $ids=NULL) {
		
		if(is_array($this->input->post('check_id')))
		{
			foreach($this->input->post('check_id') as $id)
			{
				$query = $this->db->query("SELECT * FROM user_mst WHERE user_id_pk=$id");
				$row = $query->row();
				
				if(empty($row->is_admin)){
					$ids=$id.','.$ids;
				}
			}
			$ids=rtrim($ids,",");
			$this->user_model->delete($ids);
		}
		else
		{
			$ids = $this->uri->segment(6);
			$this->user_model->delete($ids);
		}
		
		
		//set session for displaying notification
		$this->session->set_userdata('res', 'deleted');
		
		//redirect to manage page
		redirect(base_url()."user/manage/$orderby/$orderby_opt/$page");
	}
	
	// Load Login page
	public function login()
	{
		$this->load->helper('form');
		
		$this->load->library('form_validation');
		$data['title'] = 'Registration Form';
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() === FALSE)
		{
			 
        	$this->session->set_flashdata('error', 'Invalid user name or password.');
    		$this->load->view('templates/header');
    		$this->load->view('login_view');
    		$this->load->view('templates/footer');
        }
		else
		{
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$query = $this->db->query("SELECT * FROM registration WHERE username='$username' AND password='$password' AND is_admin=1");
			$records_found = $query->num_rows();
			if(!empty($records_found)) 
			{
				$row = $query->row();
				
				//set user details into session
				$this->session->set_userdata('s_user_id_pk', $row->id);
				$this->session->set_userdata('s_is_admin', $row->is_admin);
				$this->session->set_userdata('s_full_name', $row->username);
				
				$data['page_title']="Dashboard";
				redirect("admin");
	
			}
			else
			{
				$this->session->set_flashdata('error', 'Invalid User name or Password.');
				$this->load->view('templates/header');
        		$this->load->view('login_view');
        		$this->load->view('templates/footer');

			}
		}
		
	}
	
	
	// Logout from the system
	public function logout()
	{
		$user_id_pk=$this->session->userdata('s_user_id_pk');
		
		//Log this
		$this->my_functions->log_this("Controller logged out [id:$user_id_pk]");
				
		//set user details into session
		$this->session->set_userdata('s_user_id_pk', "");
		$this->session->set_userdata('s_is_admin', "");
		$this->session->set_userdata('s_full_name', "");
		
		$this->load->view('login_view');
	}
}
?>
