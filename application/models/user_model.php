<?
/**
* Table name : user_mst
* ------------------------------------
user_id_pk
full_name
login_code
password
user_info
d_added
d_updated
user_id_fk
*/

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	//List Records
	function list_all($limit=NULL, $offset=NULL, $orderby=NULL, $orderby_opt=NULL) {
		
		//set per page limit
		if(!empty($limit)) $limit="LIMIT $limit";
		
		$search_query=$this->session->userdata('search_query');
		
		$query = $this->db->query("SELECT * FROM registration ORDER BY $orderby $orderby_opt $limit OFFSET $offset");
		return $query->result_array();
		// $user_records = array();
 
		// foreach ($query->result() as $row) {
		// 	$user_records[] = array(
		// 		'user_id_pk' => $row->user_id_pk,
		// 		'full_name' => $row->full_name,
		// 		'login_code' => $row->login_code
		// 	);
		// }
		
		// return $user_records;
	}
	
	//Get Total Records
	function total_records() {
		$query = $this->db->query("SELECT * FROM registration");
		
		return $query->num_rows();
	}
	
		
	//Check if Logged in or not
	function is_logged_in(){
		$search_query=@$this->session->userdata('s_user_id_pk');
		if(empty($search_query)){
			//redirect to login page
			redirect(site_url('user/login'));
		}
			
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
	public function set_register($id)
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
			'is_admin' => $this->input->post('status'),
			'date_added' => $date_added,
			'date_updated' => $date_updated
		);

		return $this->db->update('registration', $data, array('id' => $id));
		
	}

	

}

?>