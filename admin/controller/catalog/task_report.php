<?php 
class Controllercatalogtaskreport  extends Controller {

	public function index()
    {

        $this->load->language('catalog/task_report');
 
        $this->document->setTitle($this->language->get('Task Report'));

        $this->load->model('catalog/task_report');

        $this->getList();

    }

    protected function getList()
    {

    	$user_id = $this->session->data['user_id'];
        $user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
        foreach ($user_data as $user) {
            $user_group_id = $user['user_group_id'];
            $data['user_group_id'] = $user['user_group_id'];
            $name_of_user = $user['firstname'] . ' ' . $user['lastname'];
        }

        if (isset($this->request->get['user_id'])) {
            $user_id = $this->request->get['user_id'];
            $users = $this->db->query("SELECT * FROM oc_user")->rows;
            foreach ($users as $val) {
                $username[$val['user_id']] = $val['firstname'] . ' ' . $val['lastname'];
            }
            $data['username'] = $username;
        } else {
            $users = $this->db->query("SELECT * FROM oc_user")->rows;
            foreach ($users as $val) {
                $username[$val['user_id']] = $val['firstname'] . ' ' . $val['lastname'];
            }
            $data['username'] = $username;
            $user_id = 0;
        }

        if (isset($this->request->get['project_id'])) {
            $data['project'] = array();
            $projects = $this->db->query("SELECT * FROM oc_project")->rows;
            foreach ($projects as $val) {
                $pro[$val['project_id']] = $val['project_name'];
            }
            $project_id = $this->request->get['project_id'];
            $data['project'] = $pro;
        } else {
            $data['project'] = array();
            $projects = $this->db->query("SELECT * FROM oc_project")->rows;
            foreach ($projects as $val) {
                $pro[$val['project_id']] = $val['project_name'];
            }
            $project_id = $val['project_id'];
            $data['project'] = $pro;
            $project_id = 0;
        }

        if (isset($this->request->get['fromdate'])) {
            $fromdate = $this->request->get['fromdate'];
        } else {
            $fromdate = '';
        }

        if (isset($this->request->get['todate'])) {
            $todate = $this->request->get['todate'];
        } else {
            $todate = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';



        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }


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
        

         $data['tasks'] = array();
		 $data['user_id'] = array();

        $filter_data = array(
            'project_id' => $project_id,
            'user_id' => $user_id,
            'fromdate'  => $fromdate,    
            'todate'  => $todate,    
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        );

        $task_total = $this->model_catalog_task_report->getTotalTasks();
        $task_data = $this->model_catalog_task_report->getTasks($filter_data);

		$data['tasks'] = array();
		$month_start = date('Y-m-01');
		$month_end = date('Y-m-t');
		// $task_data = $this->db->query("SELECT * FROM oc_task WHERE CAST(date_time as DATE) BETWEEN '".$month_start."' AND '".$month_end."'")->rows;
		foreach ($task_data as $task){
			$user_id = $task['user_id'];
			$user = $this->db->query("SELECT username FROM oc_user WHERE user_id = $user_id")->row;
			$project_id = $task['project_id'];
			$project = $this->db->query("SELECT project_name FROM oc_project WHERE project_id = $project_id")->row;
			$data['tasks'][] = array(
				'date' 	        		    => $task['date_time'],
				'project_name'          	=> $project['project_name'],
				'username'          		=> $task['username'],
				'user'          		=> $user['username'],
				'remark'      				=> $task['remark'],
				'subject'          		=> $task['subject'],
				'project_start_time'      	=> $task['project_start_time'],
				'start_date'      	=> $task['date'],
				'project_end_time'        	=> $task['project_end_time'],
				'task'   		        	=> $task['task'],
				'status'                	=> $task['status'],
				'commit_no'    				=> $task['commit_no'],
			);
			// echo "<pre>";print_r($data['tasks']);exit;
		}
		// echo "<pre>";print_r($data['tasks']);exit;

	    $data['heading_title'] = $this->language->get('heading_title');

        $data['text_list'] = $this->language->get('text_list');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');


        $data['entry_project'] = $this->language->get('entry_project');
        
        $data['button_add'] = $this->language->get('button_add');
        $data['button_edit'] = $this->language->get('button_edit');
        $data['button_delete'] = $this->language->get('button_delete');
        $data['button_filter'] = $this->language->get('button_filter');

        $data['token'] = $this->session->data['token'];


        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';

        if (isset($this->request->get['project_id'])) {
            $url .= '&project_id=' . urlencode(html_entity_decode($this->request->get['project_id'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['user_id'])) {
            $url .= '&user_id=' . urlencode(html_entity_decode($this->request->get['user_id'], ENT_QUOTES, 'UTF-8'));
        } 

        if (isset($this->request->get['date'])) {
            $url .= '&date=' . urlencode(html_entity_decode($this->request->get['date'], ENT_QUOTES, 'UTF-8'));
        }

        
        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['sort_name'] = $this->url->link('catalog/task_report', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
        $data['sort_date'] = $this->url->link('catalog/task_report', 'token=' . $this->session->data['token'] . '&sort=date' . $url, true);

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $task_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('catalog/task_report', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();

        $data['results'] = sprintf($this->language->get('text_pagination'), ($task_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($task_total - $this->config->get('config_limit_admin'))) ? $task_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $task_total, ceil($task_total / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

        $data['project_id'] = $project_id;
        $data['user_id'] = $user_id;
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
       
        $this->response->setOutput($this->load->view('catalog/task_report',$data));

	}
}
?>
