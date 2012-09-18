<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal extends CI_Controller {

	public function index() {
		if($this->session->userdata('check'))
			$this->load->view('main');
		else
			$this->load->view('login');
	}
	
	public function login() {
		$this->form_validation->set_rules('name', 'Account', 'required');
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		
		if($this->form_validation->run() === false)
		{
			$this->load->view('login');
		}
		else
		{
			$data = array(
				'user' => $this->input->post('name'),
				'password' => $this->input->post('pwd')
			);
			$result = $this->db->select('*')
					   	   ->from('userlist')
					       ->where($data)
					       ->get()->result_array();
			if($result)
			{
				$this->session->set_userdata('user', $this->input->post('name'));
				$this->session->set_userdata('check', true);
				$this->load->view('main');
			}
			else
				$this->load->view('login');
		}
	}
	
	public function view($page)
	{
		if($page == 'money')
			$this->load->view('money');
		else if($page == 'weight')
			$this->load->view('weight');
	}
}
