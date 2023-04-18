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
			$task_data = $this->db->query("SELECT * FROM oc_task WHERE user_id = '$user_id'")->rows;
				// echo "<pre>";print_r($task_data);exit;				
			foreach ($task_data as $task){
				$project_id = $task['project_id'];
		$data['task'] = array('');
			}
		}else {
			$data['tasks'] = $this->db->query("SELECT * FROM oc_task")->rows;
				$current_date = date('Y-m-d');
			$task_data = $this->db->query("SELECT * FROM oc_task WHERE date_time = $current_date")->rows;
				// echo "<pre>";print_r($task_data);exit;
			foreach ($task_data as $task){
				$project_id = $task['project_id'];
				$project_name = $this->db->query("SELECT project_name FROM oc_project WHERE project_id = $project_id")->row;
				$data['tasks'][] = array(
					'project_name' => $project_name['project_name'],
					'project_start_time' => $task['project_start_time'],
					'project_end_time' => $task['task'],
					'status' => $task['status'],
					'commit_no' => $task['commit_no']
				);		
				// echo "<pre>";print_r($data);exit;
		} 
	}
		
		

		return $this->load->view('dashboard/list_task', $data);
	}
}