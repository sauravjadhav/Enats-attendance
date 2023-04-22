<?php
class Controllerdashboardlisttask extends Controller {
	public function index() {
		$this->load->language('dashboard/list_task');

		$data['token'] = $this->session->data['token'];
		$user_group_id = $this->user->user_group_id;
		$data['user_group_id'] = $this->user->user_group_id;
		$user_id = $this->session->data['user_id'];
		$url = '';

		if ($user_group_id == 1) {
			$data['tasks'] = array();
			$current_date = date('Y-m-d');
			$task_data = $this->db->query("SELECT * FROM oc_task WHERE CAST(date_time as DATE) = '$current_date' OR status = 'pending' OR status = 'working' OR status = 'c/f-working' ORDER BY date_time DESC")->rows;

			foreach ($task_data as $task){
				$user_id = $task['user_id'];
				$user = $this->db->query("SELECT username FROM oc_user WHERE user_id = $user_id")->row;
				$project_id = $task['project_id'];
				$project = $this->db->query("SELECT project_name FROM oc_project WHERE project_id = $project_id")->row;
				$time = strtotime($task['date_time']);
				$date = date('d-m-Y',$time);
				$data['tasks'][] = array(
					'task_id' 	        		=> $task['task_id'],
					'date' 	        			=> $date,
					'project_name'          	=> $project['project_name'],
					'username'          		=> $user['username'],
					'remark'      				=> $task['remark'],
					'project_start_time'      	=> $task['project_start_time'],
					'project_end_time'        	=> $task['project_end_time'],
					'task'   		        	=> $task['task'],
					'status'                	=> $task['status'],
					'commit_no'    				=> $task['commit_no'],
					'edit'            => $this->url->link('catalog/task/edit', 'token=' . $this->session->data['token'] . '&task_id=' . $task['task_id'] . $url, true)

				);
				// echo "<pre>";print_r($data['tasks']);exit;
		}
		} else {
			// echo "<pre>";print_r($user_group_id);exit;
			$data['tasks'] = array();
			$task_data = $this->db->query("SELECT * FROM oc_task WHERE user_id = '$user_id' ORDER BY date_time DESC LIMIT 10")->rows;
				// echo "<pre>";print_r($task_data);exit;				
			foreach ($task_data as $task){
				$project_id = $task['project_id'];
				$project = $this->db->query("SELECT project_name FROM oc_project WHERE project_id = $project_id")->row;
				$time = strtotime($task['date_time']);
				$date = date('d-m-Y',$time);
				$data['tasks'][] = array(
					'task_id' 	        		=> $task['task_id'],
					'date' 	        			=> $date,
					'remark'      				=> $task['remark'],
					'project_name'          	=> $project['project_name'],
					'project_start_time'      	=> $task['project_start_time'],
					'project_end_time'        	=> $task['project_end_time'],
					'task'   		        	=> $task['task'],
					'status'                	=> $task['status'],
					'commit_no'    				=> $task['commit_no'],
					'edit'            => $this->url->link('catalog/task/edit', 'token=' . $this->session->data['token'] . '&task_id=' . $task['task_id'] . $url, true)
				);
			} 
		}

		return $this->load->view('dashboard/list_task', $data);
	}
}