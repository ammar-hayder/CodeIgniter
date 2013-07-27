<?php
class Task_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function get_register($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('registration');
			return $query->result_array();
		}

		$query = $this->db->get_where('registration', array('username' => $slug));
		$result=$query->row_array();
		$query1 = $this->db->get_where('registration', array('email' => $slug));
		$result1=$query1->row_array();
		$query2 = $this->db->get_where('registration', array('id' => $slug));
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
	public function set_register()
	{
		$this->load->helper('url');
		$date_added=date("Y-m-d H:i:s");
		$date_updated="";
		$is_admin=0;
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'email' => $this->input->post('email'),
			'is_admin' => $is_admin,
			'date_added' => $date_added,
			'date_updated' => $date_updated
		);

		return $this->db->insert('registration', $data);
	}
	public function update_register()
	{
		$this->load->helper('url');
		$date_added=date("Y-m-d H:i:s");
		$date_updated="";
		$is_admin=0;
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'email' => $this->input->post('email'),
			'is_admin' => $is_admin,
			'date_added' => $date_added,
			'date_updated' => $date_updated
		);

		return $this->db->insert('registration', $data);
	}
}