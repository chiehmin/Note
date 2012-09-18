<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Money extends CI_Controller {
	
	public function index() {
		$this->load->view('money');
	}
	
	public function add_Item() {
	
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('item', 'Item', 'required');
		$this->form_validation->set_rules('cost', 'Cost', 'required');
		
		if($this->form_validation->run() == true)
		{
		
			$data = array(
				'date' => $this->input->post('date'),
			    'name' => $this->input->post('item'),
			    'cost' => $this->input->post('cost')
			);	
			
			$this->db->insert('itemlist', $data);
			
			$data = array(
				'user' => $this->session->userdata('user'),
				'item_id' => $this->db->insert_id()
			);
			
			$this->db->insert('user_item_relation', $data);
		}
		$this->load->view('money');
	}
	
	public function get_Item() {
		
		$user = $this->session->userdata('user');
		
		$result = $this->db->from('user_item_relation AS UI')
						   ->join('itemlist AS IL', 'UI.item_id=IL.id')
						   ->where('UI.user', $user)
						   ->order_by('IL.date', 'asc')
						   ->select('IL.date, IL.name, IL.cost')
						   ->get()->result_array();
		echo json_encode($result);
		
	}
	
}
