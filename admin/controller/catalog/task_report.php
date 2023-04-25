<?php 
class Controllercatalogtaskreport  extends Controller {

	public function index() {
			$data['tasks'] = array();
			$month_start = date('Y-m-01');
			$month_end = date('Y-m-t');
			$task_data = $this->db->query("SELECT * FROM oc_task WHERE CAST(date_time as DATE) BETWEEN '".$month_start."' AND '".$month_end."'")->rows;
			foreach ($task_data as $task){
				$user_id = $task['user_id'];
				$user = $this->db->query("SELECT username FROM oc_user WHERE user_id = $user_id")->row;
				$project_id = $task['project_id'];
				$project = $this->db->query("SELECT project_name FROM oc_project WHERE project_id = $project_id")->row;
				$data['tasks'][] = array(
					'date' 	        		    => $task['date_time'],
					'project_name'          	=> $project['project_name'],
					'username'          		=> $user['username'],
					'remark'      				=> $task['remark'],
					'subject'          		=> $task['subject'],
					'project_start_time'      	=> $task['project_start_time'],
					'project_end_time'        	=> $task['project_end_time'],
					'task'   		        	=> $task['task'],
					'status'                	=> $task['status'],
					'commit_no'    				=> $task['commit_no'],
				);
				// echo "<pre>";print_r($data['tasks']);exit;
			}
			// echo "<pre>";print_r($data['tasks']);exit;
			$url ="";

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('catalog/task_report', 'token=' . $this->session->data['token'] . $url, true)
			);

			$data['button_add'] = $this->language->get('button_add');
			$data['add'] = $this->url->link('catalog/exp_task', 'token=' . $this->session->data['token'] . $url, true);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('catalog/task_report',$data));

	}
}
?>
