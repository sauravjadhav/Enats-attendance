<?php 
class Controllercatalogreports extends Controller {

	public function index() {
			$data['attendances_header'] = $this->db->query("SELECT date FROM oc_attendance_record GROUP BY date")->rows;

			$data['attendances_body'] = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record ORDER BY user_id, date, time")->rows;


			$data['username'] = $this->db->query("SELECT user_id, name FROM oc_attendance_record GROUP BY user_id")->rows;

			// echo "<pre>";print_r($data['username']);exit;
			$url ="";

			$data['breadcrumbs'] = array();

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
			);

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('catalog/reports', 'token=' . $this->session->data['token'] . $url, true)
			);

			$data['button_add'] = $this->language->get('button_add');
			$data['add'] = $this->url->link('catalog/export_csv', 'token=' . $this->session->data['token'] . $url, true);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('catalog/reports',$data));

	}
}
?>