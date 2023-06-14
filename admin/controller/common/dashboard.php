<?php
class ControllerCommonDashboard extends Controller {
	public function index() {
		$this->load->language('common/dashboard');

		$data['user_group_id'] = $this->user->user_group_id;

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		if ($this->user->user_group_id == 1) {
			date_default_timezone_set('Asia/Kolkata');
			$current_date = date('m-d');
			$user_data    = $this->db->query("SELECT * FROM oc_employee WHERE DATE_FORMAT(dob, '%m-%d') = '$current_date' AND is_bd = 0")->rows;
			$show_bd      = $this->db->query("SELECT * FROM oc_employee WHERE DATE_FORMAT(dob, '%m-%d') = '$current_date'")->rows;
			$show_doje    = $this->db->query("SELECT * FROM oc_employee WHERE DATE_FORMAT(doje, '%m-%d') = '$current_date'")->rows;
			$data['user_data'] = $user_data;

			if($user_data){
			    foreach($user_data as $user){
			        $bd['name'] = $user['login'];
			        $bd['user_id'] = $user['user_id'];
			        $bd['text_birthday_popup_title'] = "Today is ".$user['login']."'s".' birthday';
			        $age = date_diff(date_create($user['dob']), date_create('today'))->y;
			        $bd['text_birthday_popup_message'] = $user['login'] . ' is now ' . $age . ' years old. Wish him on this birthday!';
			        $bd['text_close'] = "Close";
			        $data['user'][] = $bd; 
			// echo "<pre>";print_r($data);exit;
			        $this->db->query("UPDATE oc_employee SET is_bd = 1 WHERE is_bd = 0 AND user_id = {$user['user_id']}");
			    }
			} elseif ($show_bd) {
				foreach($show_bd as $user){
			        $bd1['name'] = $user['login'];
			        $bd1['user_id'] = $user['user_id'];
			        $bd1['doje']  = date("d-m-Y",strtotime($user['doje']));
			        $bd1['text_birthday_popup_title'] = "Today is ".$user['login']."'s".' birthday';
			        $age = date_diff(date_create($user['dob']), date_create('today'))->y;
			        $bd1['text_birthday_popup_message'] = $user['login'] . ' is now ' . $age . ' years old. Wish him on this birthday!';
			        $bd1['text_close'] = "Close";
			        $data['bduser'][] = $bd1;			    
			    }
			}
			 else {
			    $this->db->query("UPDATE oc_employee SET is_bd = 0 WHERE DATE_FORMAT(dob, '%m-%d') != '$current_date'");
			}
		}
		$data['token'] = $this->session->data['token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['list_attendance'] = $this->load->controller('dashboard/list_attendance');
		$data['list_task'] = $this->load->controller('dashboard/list_task');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('common/dashboard', $data));
	}
}