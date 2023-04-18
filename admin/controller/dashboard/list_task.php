<?php
class Controllerdashboardlisttask extends Controller {
	public function index() {
		$this->load->language('dashboard/list_task');

		$data['token'] = $this->session->data['token'];
		$user_id = $this->session->data['user_id'];

		if ($user_group_id == 11) {
			// echo "<pre>";print_r($$this->user->$user_group_id);exit;
			$data['tasks'] = $this->db->query("SELECT * FROM oc_user_group WHERE user_group_id = '$user_group_id' ORDER BY user_group_id DESC")->rows;
		}else {
			$data['tasks'] = $this->db->query("SELECT * FROM oc_user_group WHERE user_group_id = '$user_group_id' ORDER BY user_group_id DESC")->rows;
		} 
		
		$data['tasks'] = $this->db->query("SELECT * FROM oc_task ORDER BY task_id DESC")->rows;
		

		return $this->load->view('dashboard/list_task', $data);
	}
}