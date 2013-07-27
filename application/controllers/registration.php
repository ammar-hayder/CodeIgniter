<?php
class Registration extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Task_model');
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->helper('form');
		
		$this->load->library('form_validation');
		
		$this->load->helper('captcha');
		$original_string = array_merge(range(0,6), range('a','z'), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $captcha = substr(str_shuffle($original_string), 0, 6);
		$vals = array(
		    'word'       => $captcha,
		    'img_path'	 => './captcha/',
		    'img_url'	 => 'http://localhost/CodeIgniter2.1/captcha/',
		    'font_path'	 => '',
		    'img_width'	 => '150',
		    'img_height' => 30,
		    'expiration' => 7200
		    );
		$cap = create_captcha($vals);
		
		$data['checkimg'] = $cap['image'];
		$data['title'] = 'Registration Form';

		$this->form_validation->set_rules('email', 'Email', 'callback_email_check[email]|trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'callback_username_check[username]
			|trim|required|min_length[5]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');


		if ($this->form_validation->run() === FALSE)
		{
			 if(file_exists(BASEPATH."../captcha/".$this->session->userdata['image']))
            unlink(BASEPATH."../captcha/".$this->session->userdata['image']);

        	$this->session->set_userdata(array('captcha'=>$captcha, 'image' => $cap['time'].'.jpg'));
        
			$this->load->view('registration/header', $data);
			$this->load->view('registration/index', $data);
			$this->load->view('registration/footer');

		}
		else
		{
			if(file_exists(BASEPATH."../captcha/".$this->session->userdata['image']))
                unlink(BASEPATH."../captcha/".$this->session->userdata['image']);

			$this->session->set_flashdata('item', 'Your Registration form has been successfully submitted.');
			$this->Task_model->set_register();
			redirect('default_controller');
		}
	}
	public function username_check($str)
	{
		$check_username = $this->Task_model->get_register($str);
		// print_r($check_username);
		if (count($check_username) >0)
		{
			$this->form_validation->set_message('username_check', 'The %s is already exist.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function email_check($str1)
	{
		$check_email = $this->Task_model->get_register($str1);
		
		if (count($check_email) >0)
		// if($str1 =='ammar.hayder@gmail.com')
		{
			$this->form_validation->set_message('email_check', 'The %s is already exist.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	public function validate_captcha()
	{
	    if($this->input->post('captcha') != $this->session->userdata['captcha'])
	    {
	        $this->form_validation->set_message('validate_captcha', 'Wrong captcha code.');
	        return false;
	    }else{
	        return true;
	    }
    }
	
	
}