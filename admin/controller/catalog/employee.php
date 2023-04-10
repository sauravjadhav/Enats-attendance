<?php
class ControllerCatalogEmployee extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/employee');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/employee');

		$this->getList();
	}

	public function add() {

		$this->load->language('catalog/employee');

		$this->document->setTitle($this->language->get('heading_title'));

		

		$this->load->model('catalog/employee');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_employee->addEmployee($this->request->post,$this->request->files);

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

			$this->response->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		// echo "<pre>";print_r($this->request->files);exit;
		$this->load->language('catalog/employee');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/employee');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_employee->editEmployee($this->request->get['employee_id'], $this->request->post);

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

			$this->response->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		// echo "<pre>";print_r($this->request->post);exit;
		$this->load->language('catalog/employee');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/employee');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $employee_id) {
				$this->model_catalog_employee->deleteEmployee($employee_id);
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

			$this->response->redirect($this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_numbers'])) {
			$filter_numbers = $this->request->get['filter_numbers'];
		} else {
			$filter_numbers = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
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

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_numbers'])) {
			$url .= '&filter_numbers=' . urlencode(html_entity_decode($this->request->get['filter_numbers'], ENT_QUOTES, 'UTF-8'));
		}

        if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/employee/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/employee/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['token'] = $this->session->data['token'];

		$data['employees'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_numbers'	  => $filter_numbers,
			'filter_email'	  => $filter_email,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$employee_total = $this->model_catalog_employee->getTotalEmployees();

		$results = $this->model_catalog_employee->getEmployees($filter_data);
		// echo "<pre>";print_r($results);exit;

		foreach ($results as $result) {
			$data['employees'][] = array(
				'employee_id' => $result['employee_id'],
				'name'            => $result['name'],
				'name'        => $result['name'],
				'numbers'            => $result['numbers'],
				'email'            => $result['email'],
				'status'      => $result['status'],
				'city'      => $result['city'],
				'edit'            => $this->url->link('catalog/employee/edit', 'token=' . $this->session->data['token'] . '&employee_id=' . $result['employee_id'] . $url, true)
			);
		}

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_numbers'	  => $filter_numbers,
			'filter_numbers'  => $filter_numbers,
			'filter_email'	  => $filter_email,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_filter'] = $this->language->get('text_filter');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');
		$data['column_address'] = $this->language->get('column_address');
		$data['column_numbers'] = $this->language->get('column_numbers');
		$data['column_email'] = $this->language->get('column_email');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_city'] = $this->language->get('column_city');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_numbers'] = $this->language->get('entry_numbers');
		$data['entry_email'] = $this->language->get('entry_email');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');


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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

	    $data['filter_name'] = $filter_name;
	    $data['filter_numbers'] = $filter_numbers;
	    $data['filter_email'] = $filter_email;

		$pagination = new Pagination();
		$pagination->total = $employee_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($employee_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($employee_total - $this->config->get('config_limit_admin'))) ? $employee_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $employee_total, ceil($employee_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/employee_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['employee_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');
		$data['text_country'] = $this->language->get('text_country');
	    $data['text_experienced'] = $this->language->get('text_experienced');
	    $data['text_fresher'] = $this->language->get('text_fresher');
  

        $data['entry_login'] = $this->language->get('entry_login');
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_father_name'] = $this->language->get('entry_father_name');
		$data['entry_surname'] = $this->language->get('entry_surname');
		$data['entry_dob'] = $this->language->get('entry_dob');
		$data['entry_doje'] = $this->language->get('entry_doje');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_numbers'] = $this->language->get('entry_numbers');
		$data['entry_pan'] = $this->language->get('entry_pan');
		$data['entry_adhaar'] = $this->language->get('entry_adhaar');
		$data['entry_bank_details'] = $this->language->get('entry_bank_details');
		
	

		$data['help_keyword'] = $this->language->get('help_keyword');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_filter'] = $this->language->get('button_filter');
		$data['button_upload'] = $this->language->get('button_upload');

		$months = array(
			'1' => '1 Month',
			'2' => '2 Months',
			'3' => '3 Months',
			'4' => '4 Months',
			'5' => '5 Months',
			'6' => '6 Months',
			'7' => '7 Months',
			'8' => '8 Months',
			'9' => '9 Months',
			'10' => '10 Months',
		);
		$data['Months']=$months;

		$years = array(
			'1' => '1 year',
			'2' => '2 years',
			'3' => '3 years',
			'4' => '4 years',
			'5' => '5 years',
			'6' => '6 years',
			'7' => '7 years',
			'8' => '8 years',
			'9' => '9 years',
			'10' => '10 years',
		);
		$data['Years']=$years;

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

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['numbers'])) {
			$data['error_numbers'] = $this->error['numbers'];
		} else {
			$data['error_numbers'] = '';
		}

		if (isset($this->error['city'])) {
			$data['error_city'] = $this->error['city'];
		} else {
			$data['error_city'] = '';
		}

		if (isset($this->error['filename'])) {
			$data['error_filename'] = $this->error['filename'];
		} else {
			$data['error_filename'] = '';
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
			'href' => $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['employee_id'])) {
			$data['action'] = $this->url->link('catalog/employee/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/employee/edit', 'token=' . $this->session->data['token'] . '&employee_id=' . $this->request->get['employee_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/employee', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['employee_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$manufacturer_info = $this->model_catalog_employee->getEmployee($this->request->get['employee_id']);
		}
		// echo "<pre>";print_r($manufacturer_info);exit;
		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($manufacturer_info)) {
			$data['name'] = $manufacturer_info['name'];
		} else {
			$data['name'] = '';
		}	
		
		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($manufacturer_info)) {
			$data['email'] = $manufacturer_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($manufacturer_info)) {
			$data['status'] = $manufacturer_info['status'];
		} else {
			$data['status'] = '';
		}

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} elseif (!empty($manufacturer_info)) {
			$data['password'] = $manufacturer_info['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['numbers'])) {
			$data['numbers'] = $this->request->post['numbers'];
		} elseif (!empty($manufacturer_info)) {
			$data['numbers'] = $manufacturer_info['numbers'];
		} else {
			$data['numbers'] = '';
		}

		if (isset($this->request->post['city'])) {
			$data['city'] = $this->request->post['city'];
		} elseif (!empty($manufacturer_info)) {
			$data['city'] = $manufacturer_info['city'];
		} else {
			$data['city'] = '';
		}

		if (isset($this->request->post['company'])) {
			$data['company'] = $this->request->post['company'];
		} elseif (!empty($manufacturer_info)) {
			$data['company'] = $manufacturer_info['company'];
		} else {
			$data['company'] = '';
		}

		if (isset($this->request->post['employed'])) {
			$data['employed'] = $this->request->post['employed'];
		} elseif (!empty($manufacturer_info)) {
			$data['employed'] = $manufacturer_info['employed'];
		} else {
			$data['employed'] = '';
		}

		if (isset($this->request->post['job_title'])) {
			$data['job_title'] = $this->request->post['job_title'];
		} elseif (!empty($manufacturer_info)) {
			$data['job_title'] = $manufacturer_info['job_title'];
		} else {
			$data['job_title'] = '';
		}

		if (isset($this->request->post['current_city'])) {
			$data['current_city'] = $this->request->post['current_city'];
		} elseif (!empty($manufacturer_info)) {
			$data['current_city'] = $manufacturer_info['current_city'];
		} else {
			$data['current_city'] = '';
		}

		if (isset($this->request->post['working_since'])) {
			$data['working_since'] = $this->request->post['working_since'];
		} elseif (!empty($manufacturer_info)) {
			$data['working_since'] = $manufacturer_info['working_since'];
		} else {
			$data['working_since'] = '';
		}

		if (isset($this->request->post['annual_salary'])) {
			$data['annual_salary'] = $this->request->post['annual_salary'];
		} elseif (!empty($manufacturer_info)) {
			$data['annual_salary'] = $manufacturer_info['annual_salary'];
		} else {
			$data['annual_salary'] = '';
		}

		if (isset($this->request->post['notice_period'])) {
			$data['notice_period'] = $this->request->post['notice_period'];
		} elseif (!empty($manufacturer_info)) {
			$data['notice_period'] = $manufacturer_info['noticed_period'];
		} else {
			$data['notice_period'] = '';
		}

		if (isset($this->request->post['type_of_quailification'])) {
			$data['type_of_quailification'] = $this->request->post['type_of_quailification'];
		} elseif (!empty($manufacturer_info)) {
			$data['type_of_quailification'] = $manufacturer_info['type_of_qualification'];
		} else {
			$data['type_of_quailification'] = '';
		}

		if (isset($this->request->post['field_of_study'])) {
			$data['field_of_study'] = $this->request->post['field_of_study'];
		} elseif (!empty($manufacturer_info)) {
			$data['field_of_study'] = $manufacturer_info['field_of_study'];
		} else {
			$data['field_of_study'] = '';
		}

		if (isset($this->request->post['quailification_id'])) {
			$data['quailification_id'] = $this->request->post['quailification_id'];
		} elseif (!empty($manufacturer_info)) {
			$data['quailification_id'] = $manufacturer_info['quailification_id'];
		} else {
			$data['quailification_id'] = '';
		}

		if (isset($this->request->post['institution_name'])) {
			$data['institution_name'] = $this->request->post['institution_name'];
		} elseif (!empty($manufacturer_info)) {
			$data['institution_name'] = $manufacturer_info['institution_name'];
		} else {
			$data['institution_name'] = '';
		}

		if (isset($this->request->post['institution_location'])) {
			$data['institution_location'] = $this->request->post['institution_location'];
		} elseif (!empty($manufacturer_info)) {
			$data['institution_location'] = $manufacturer_info['institution_location'];
		} else {
			$data['institution_location'] = '';
		}

		if (isset($this->request->post['graduation_date'])) {
			$data['graduation_date'] = $this->request->post['graduation_date'];
		} elseif (!empty($manufacturer_info)) {
			$data['graduation_date'] = $manufacturer_info['graduation_date'];
		} else {
			$data['graduation_date'] = '';
		}

		if (isset($this->request->post['gpa'])) {
			$data['gpa'] = $this->request->post['gpa'];
		} elseif (!empty($manufacturer_info)) {
			$data['gpa'] = $manufacturer_info['gpa_grade'];
		} else {
			$data['gpa'] = '';
		}

		if (isset($this->request->post['certifications'])) {
			$data['certifications'] = $this->request->post['certifications'];
		} elseif (!empty($manufacturer_info)) {
			$data['certifications'] = $manufacturer_info['relevant_courses_or_certifications'];
		} else {
			$data['certifications'] = '';
		}

		if (isset($this->request->post['awards'])) {
			$data['awards'] = $this->request->post['awards'];
		} elseif (!empty($manufacturer_info)) {
			$data['awards'] = $manufacturer_info['academic_honors_or_awards'];
		} else {
			$data['awards'] = '';
		}

		if (isset($this->request->post['resume_headline'])) {
			$data['resume_headline'] = $this->request->post['resume_headline'];
		} elseif (!empty($manufacturer_info)) {
			$data['resume_headline'] = $manufacturer_info['resume_headline'];
		} else {
			$data['resume_headline'] = '';
		}

		if (isset($this->request->post['suggestions'])) {
			$data['suggestions'] = $this->request->post['suggestions'];
		} elseif (!empty($manufacturer_info)) {
			$data['suggestions'] = $manufacturer_info['suggestions'];
		} else {
			$data['suggestions'] = '';
		}

		if (isset($this->request->post['preferred_work_locations'])) {
			$data['preferred_work_locations'] = $this->request->post['preferred_work_locations'];
		} elseif (!empty($manufacturer_info)) {
			$data['preferred_work_locations'] = $manufacturer_info['preferred_work_locations'];
		} else {
			$data['preferred_work_locations'] = '';
		}

		if (isset($this->request->post['preferred_salary'])) {
			$data['preferred_salary'] = $this->request->post['preferred_salary'];
		} elseif (!empty($manufacturer_info)) {
			$data['preferred_salary'] = $manufacturer_info['preferred_salary'];
		} else {
			$data['preferred_salary'] = '';
		}

		if (isset($this->request->post['gender'])) {
			$data['gender'] = $this->request->post['gender'];
		} elseif (!empty($manufacturer_info)) {
			$data['gender'] = $manufacturer_info['gender'];
		} else {
			$data['gender'] = '';
		}

		if (isset($this->request->post['work_experience_months'])) {
			$data['work_experience_months'] = $this->request->post['work_experience_months'];
		} elseif (!empty($manufacturer_info)) {
			$data['work_experience_months'] = $manufacturer_info['work_experience_months'];
		} else {
			$data['work_experience_months'] = '';
		}

		if (isset($this->request->post['work_experience_year'])) {
			$data['work_experience_year'] = $this->request->post['work_experience_year'];
		} elseif (!empty($manufacturer_info)) {
			$data['work_experience_year'] = $manufacturer_info['work_experience_year'];
		} else {
			$data['work_experience_year'] = '';
		}


	    if (isset($this->request->files['resume'])) {
			$target_file = DIR_IMAGE . basename($_FILES["resume"]["name"]);
		    move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file);
			$data['resume'] = $target_file;
		} elseif (!empty($manufacturer_info)) {
			$data['resume'] = $manufacturer_info['resume'];
			$data['resume_file'] = $manufacturer_info['resume'];
		} else {
			$data['resume'] = '';
			$data['resume_file'] = '';
		}



		// echo "<pre>";print_r($data);exit;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/employee_form', $data));
	}

	protected function validateForm() {
		
		if (!$this->user->hasPermission('modify', 'catalog/employee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 2) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['email']) < 2) || (utf8_strlen($this->request->post['email']) > 64)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['password']) < 2) || (utf8_strlen($this->request->post['password']) > 64)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/employee')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $employee_id) {
			$product_total = $this->model_catalog_product->getTotalProductsByManufacturerId($employee_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/employee');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_employee->autocompleteemp($filter_data);
			foreach ($results as $result) {
				$json[] = array(
					'employee_id' => $result['employee_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			// echo "<pre>";print_r($value);exit;
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete1() {
		// echo "<pre>";print_r($this->request->get);exit;
		$json = array();

		if (isset($this->request->get['filter_numbers'])) {
			$this->load->model('catalog/employee');

			$filter_data = array(
				'filter_numbers' => $this->request->get['filter_numbers'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_employee->autocompleteemp1($filter_data);
			// echo "<pre>";print_r($results);exit;
			foreach ($results as $result) {
				$json[] = array(
					'employee_id' => $result['employee_id'],
					'numbers'            => strip_tags(html_entity_decode($result['numbers'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['numbers'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function autocomplete2() {
		// echo "<pre>";print_r($this->request->get);exit;
		$json = array();

		if (isset($this->request->get['filter_email'])) {
			$this->load->model('catalog/employee');

			$filter_data = array(
				'filter_email' => $this->request->get['filter_email'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_employee->autocompleteemp2($filter_data);
			// echo "<pre>";print_r($results);exit;
			foreach ($results as $result) {
				$json[] = array(
					'employee_id' => $result['employee_id'],
					'email'            => strip_tags(html_entity_decode($result['email'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['email'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function autocomplete3() {
		// echo "<pre>";print_r($this->request->get['type_of_quailification']);exit;
		$json = array();

		if (isset($this->request->get['type_of_quailification'])) {
			$this->load->model('catalog/employee');

			$filter_data = array(
				'type_of_quailification' => $this->request->get['type_of_quailification'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_employee->autocompleteemp3($filter_data);
			// echo "<pre>";print_r($results);exit;
			foreach ($results as $result) {
				$json[] = array(
					'id' => $result['id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}