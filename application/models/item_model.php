<?
/**
* Table name : user_mst
* ------------------------------------
id
item_name
item_code
item_info
d_added
d_updated
*/

class Item_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	//List Records
	function list_all($limit=NULL, $offset=NULL, $orderby=NULL, $orderby_opt=NULL) {
		
		if(!empty($limit)) $limit="LIMIT $limit";
		
		$search_query=$this->session->userdata('search_query');
		//set per page limit
		
		$query = $this->db->query("SELECT * FROM items ORDER BY $orderby $orderby_opt $limit OFFSET $offset");
		return $query->result_array();
		
	}
	
	//Get Total Records
	function total_records() {
		$query = $this->db->query("SELECT * FROM items");
		
		return $query->num_rows();
	}
	
		
	//Check if Logged in or not
	function is_logged_in(){
		$search_query=@$this->session->userdata('s_user_id_pk');
		if(empty($search_query)){
			//redirect to login page
			redirect(base_url()."user/login");
		}
			
	}


	public function get_items($slug = FALSE)
	{
		if ($slug === FALSE)
		{
			$query = $this->db->get('items');
			return $query->result_array();
		}

		$query = $this->db->get_where('items', array('item_name' => $slug));
		$result=$query->row_array();
		$query1 = $this->db->get_where('items', array('item_code' => $slug));
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
	public function create_items()
	{
		$this->load->helper('url');
		$d_added=date("Y-m-d H:i:s");
		$d_updated="";
		$is_admin=0;
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			'item_name' => $this->input->post('item_name'),
			'item_code' => $this->input->post('item_code'),
			'item_info' => $this->input->post('item_info'),
			'd_added' => $d_added,
			'd_updated' => $d_updated
		);

		return $this->db->insert('items', $data);
		
	}
	public function set_items($id)
	{
		$this->load->helper('url');
		$d_added="";
		$d_updated=date("Y-m-d H:i:s");
		$is_admin=0;
		$slug = url_title($this->input->post('title'), 'dash', TRUE);

		$data = array(
			'item_name' => $this->input->post('item_name'),
			'item_code' => $this->input->post('item_code'),
			'item_info' => $this->input->post('item_info'),
			'd_added' => $d_added,
			'd_updated' => $d_updated
		);

		return $this->db->update('items', $data, array('id' => $id));
		
	}

	

}

?>