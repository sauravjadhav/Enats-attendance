<?php
class ControllerCatalogTask extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/task');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/task');

		$this->getList();
	}

	public function add() {
		// echo "<pre>";print_r($this->request->post);exit;
		$this->load->language('catalog/task');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/task');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_catalog_task->addTask($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		//echo "<pre>";print_r($this->request->post);exit;

		$this->load->language('catalog/task');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/task');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_catalog_task->editTask($this->request->get['task_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/task');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/task');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $task_id) {
				$this->model_catalog_task->deleteTask($task_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

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

			$this->response->redirect($this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['filter_project'])) {
			$filter_project = $this->request->get['filter_project'];
		} else {
			$filter_project = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_project'])) {
			$url .= '&filter_project=' . urlencode(html_entity_decode($this->request->get['filter_project_name'], ENT_QUOTES, 'UTF-8'));
		}

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
			'href' => $this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/task/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/task/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['tasks'] = array();

		$filter_data = array(
			'filter_project' => $filter_project,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$task_total = $this->model_catalog_task->getTotalTasks();

		$results = $this->model_catalog_task->getTasks($filter_data);

		// echo "<pre>";print_r($results);exit;
		foreach ($results as $result) {
			$data['tasks'][] = array(
				'task_id' 	        => $result['task_id'],
				'project'          => $result['project'],
				'project_start_time'       => $result['project_start_time'],
				'project_end_time'        => $result['project_end_time'],
				'task'   		        => $result['task'],
				'status'                 => $result['status'],
				'commit_no'    => $result['commit_no'],
				'edit'            => $this->url->link('catalog/task/edit', 'token=' . $this->session->data['token'] . '&task_id=' . $result['task_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_project'] = $this->language->get('column_project');
		$data['column_project_start_time'] = $this->language->get('column_project_start_time');
		$data['column_project_end_time'] = $this->language->get('column_project_end_time');
		$data['column_task'] = $this->language->get('column_task');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_commit_no'] = $this->language->get('column_commit_no');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_project'] = $this->language->get('entry_project');
		$data['entry_project_start_time'] = $this->language->get('entry_project_start_time');
		$data['entry_project_end_time'] = $this->language->get('entry_project_end_time');
		$data['entry_task'] = $this->language->get('entry_task');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_commit_no'] = $this->language->get('entry_commit_no');

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/task', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/task', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);

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
		$pagination->url = $this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($task_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($task_total - $this->config->get('config_limit_admin'))) ? $task_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $task_total, ceil($task_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['filter_project'] = $filter_project;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/task_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['task_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_project'] = $this->language->get('entry_project');
		$data['entry_project_start_time'] = $this->language->get('entry_project_start_time');
		$data['entry_project_end_time'] = $this->language->get('entry_project_end_time');
		$data['entry_task'] = $this->language->get('entry_task');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_commit_no'] = $this->language->get('entry_commit_no');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
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
			'href' => $this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['task_id'])) {
			$data['action'] = $this->url->link('catalog/task/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/task/edit', 'token=' . $this->session->data['token'] . '&task_id=' . $this->request->get['task_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['task_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$task_info = $this->model_catalog_task->gettask($this->request->get['task_id']);
		}


		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['project'])) {
			$data['project'] = $this->request->post['project'];
		} elseif (!empty($project_info)) {
			$data['project'] = $project_info['project'];
		} else {
			$data['project'] = '';
		}

		if (isset($this->request->post['project_start_time'])) {
			$data['project_start_time'] = $this->request->post['project_start_time'];
		} elseif (!empty($project_info)) {
			$data['project_start_time'] = $project_info['project_start_time'];
		} else {
			$data['project_start_time'] = '';
		}

		if (isset($this->request->post['project_end_time'])) {
			$data['project_end_time'] = $this->request->post['project_end_time'];
		} elseif (!empty($project_info)) {
			$data['project_end_time'] = $project_info['project_end_time'];
		} else {
			$data['project_end_time'] = '';
		}

		if (isset($this->request->post['task'])) {
			$data['task'] = $this->request->post['task'];
		} elseif (!empty($project_info)) {
			$data['task'] = $project_info['task'];
		} else {
			$data['task'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($project_info)) {
			$data['status'] = $project_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['commit_no'])) {
			$data['commit_no'] = $this->request->post['commit_no'];
		} elseif (!empty($project_info)) {
			$data['commit_no'] = $project_info['commit_no'];
		} else {
			$data['commit_no'] = '';
		}

	

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/task_form', $data));
	}

	public function autocomplete() {

		$json = array();

		if (isset($this->request->get['filter_project'])) {
			$this->load->model('catalog/task');

			$filter_data = array(
				'filter_project' => $this->request->get['filter_project'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_project->getProjects($filter_data);
		// echo "<pre>";print_r($results);exit;

			foreach ($results as $result) {
				$json[] = array(
					'project_id' => $result['project_id'],
					'project'            => strip_tags(html_entity_decode($result['project'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['project'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}