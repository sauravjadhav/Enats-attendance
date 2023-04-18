<?php
class Controllerdashboardlisttask extends Controller {
	public function index() {
		$this->load->language('dashboard/list_task');

		$data['token'] = $this->session->data['token'];
		$user_group_id = $this->user->user_group_id;
		$user_id = $this->session->data['user_id'];

		$data['tasks'] = array();
		if ($user_group_id == 11) {
			// echo "<pre>";print_r($user_group_id);exit;
			$data['tasks'] = $this->db->query("SELECT * FROM oc_task WHERE user_id = '$user_id'")->rows;
		}else {
			$data['tasks'] = $this->db->query("SELECT * FROM oc_task")->rows;
		} 
		
		

		return $this->load->view('dashboard/list_task', $data);
	}
}