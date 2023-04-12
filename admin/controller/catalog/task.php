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
			$this->model_catalog_project->addTask($this->request->post);

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
			$this->model_catalog_project->editTask($this->request->get['project_id'], $this->request->post);

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
			foreach ($this->request->post['selected'] as $project_id) {
				$this->model_catalog_project->deleteTask($project_id);
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

		if (isset($this->request->get['filter_project_name'])) {
			$filter_project_name = $this->request->get['filter_project_name'];
		} else {
			$filter_project_name = null;
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

		if (isset($this->request->get['filter_project_name'])) {
			$url .= '&filter_project_name=' . urlencode(html_entity_decode($this->request->get['filter_project_name'], ENT_QUOTES, 'UTF-8'));
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
			'filter_project_name' => $filter_project_name,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$project_total = $this->model_catalog_project->getTotalTasks();

		$results = $this->model_catalog_project->getTasks($filter_data);

		// echo "<pre>";print_r($results);exit;
		foreach ($results as $result) {
			$data['tasks'][] = array(
				'task_id' 	        => $result['task_id'],
				'task_name'          => $result['task_name'],
				'task_company'       => $result['task_company'],
				'contact_person'        => $result['contact_person'],
				'phone'   		        => $result['phone'],
				'email'                 => $result['email'],
				'project_start_date'    => $result['project_start_date'],
				'project_end_date'      => $result['project_end_date'],
				'edit'            => $this->url->link('catalog/task/edit', 'token=' . $this->session->data['token'] . '&task_id=' . $result['task_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_project_company'] = $this->language->get('column_project_company');
		$data['column_contact_person'] = $this->language->get('column_contact_person');
		$data['column_phone'] = $this->language->get('column_phone');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_project_start_date'] = $this->language->get('column_project_start_date');
		$data['column_project_end_date'] = $this->language->get('column_project_end_date');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_project_name'] = $this->language->get('entry_project_name');

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
		$pagination->total = $project_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($project_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($project_total - $this->config->get('config_limit_admin'))) ? $project_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $project_total, ceil($project_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['filter_project_name'] = $filter_project_name;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/task_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['project_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_project_name'] = $this->language->get('entry_project_name');
		$data['entry_project_company'] = $this->language->get('entry_project_company');
		$data['entry_contact_person'] = $this->language->get('entry_contact_person');
		$data['entry_phone'] = $this->language->get('entry_phone');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_project_start_date'] = $this->language->get('entry_project_start_date');
		$data['entry_project_end_date'] = $this->language->get('entry_project_end_date');

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

		if (!isset($this->request->get['project_id'])) {
			$data['action'] = $this->url->link('catalog/task/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/task/edit', 'token=' . $this->session->data['token'] . '&project_id=' . $this->request->get['project_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/task', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['project_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$project_info = $this->model_catalog_project->getProject($this->request->get['project_id']);
		}


		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['project_name'])) {
			$data['project_name'] = $this->request->post['project_name'];
		} elseif (!empty($project_info)) {
			$data['project_name'] = $project_info['project_name'];
		} else {
			$data['project_name'] = '';
		}

		if (isset($this->request->post['project_company'])) {
			$data['project_company'] = $this->request->post['project_company'];
		} elseif (!empty($project_info)) {
			$data['project_company'] = $project_info['project_company'];
		} else {
			$data['project_company'] = '';
		}

		if (isset($this->request->post['contact_person'])) {
			$data['contact_person'] = $this->request->post['contact_person'];
		} elseif (!empty($project_info)) {
			$data['contact_person'] = $project_info['contact_person'];
		} else {
			$data['contact_person'] = '';
		}

		if (isset($this->request->post['phone'])) {
			$data['phone'] = $this->request->post['phone'];
		} elseif (!empty($project_info)) {
			$data['phone'] = $project_info['phone'];
		} else {
			$data['phone'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($project_info)) {
			$data['email'] = $project_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['project_start_date'])) {
			$data['project_start_date'] = $this->request->post['project_start_date'];
		} elseif (!empty($project_info)) {
			$data['project_start_date'] = $project_info['project_start_date'];
		} else {
			$data['project_start_date'] = '';
		}

		if (isset($this->request->post['project_end_date'])) {
			$data['project_end_date'] = $this->request->post['project_end_date'];
		} elseif (!empty($project_info)) {
			$data['project_end_date'] = $project_info['project_end_date'];
		} else {
			$data['project_end_date'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/task_form', $data));
	}

	public function autocomplete() {

		$json = array();

		if (isset($this->request->get['filter_project_name'])) {
			$this->load->model('catalog/task');

			$filter_data = array(
				'filter_project_name' => $this->request->get['filter_project_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_project->getProjects($filter_data);
		// echo "<pre>";print_r($results);exit;

			foreach ($results as $result) {
				$json[] = array(
					'project_id' => $result['project_id'],
					'project_name'            => strip_tags(html_entity_decode($result['project_name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['project_name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}