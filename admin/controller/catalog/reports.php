<?php 
class Controllercatalogreports extends Controller {

	public function index() {
			$month_start = date('Y-m-01');
			$month_end = date('Y-m-t');
			$data['attendances_header'] = $this->db->query("SELECT date FROM oc_attendance_record WHERE date BETWEEN '".$month_start."' AND '".$month_end."' GROUP BY date")->rows;

			$data['attendances_body'] = $this->db->query("SELECT date, user_id, office_in_time FROM oc_attendance_record WHERE date BETWEEN '".$month_start."' AND '".$month_end."' ORDER BY user_id, date, time")->rows;


			$data['username'] = $this->db->query("SELECT user_id, name FROM oc_attendance_record WHERE date BETWEEN '".$month_start."' AND '".$month_end."' GROUP BY user_id")->rows;

			// echo "<pre>";print_r($month_end);exit;
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
			$data['export'] = $this->url->link('catalog/export_csv', 'token=' . $this->session->data['token'] . $url, true);
			$data['archive'] = $this->url->link('catalog/reports/archive', 'token=' . $this->session->data['token'] . $url, true);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('catalog/reports',$data));
	}

	public function archive() {
		$year = date('Y') - 1;
		$create_table_query = $this->db->query("CREATE TABLE IF NOT EXISTS `oc_attendance_".$year."` LIKE oc_attendance_record;");
		$insert_data = $this->db->query("INSERT IGNORE INTO `oc_attendance_" . $year . "` SELECT * FROM `oc_attendance_record` WHERE YEAR(`date`) = YEAR(NOW()) - 1;");
		$delete_last_data = $this->db->query("DELETE FROM `oc_attendance_record` WHERE YEAR(`date`) = YEAR(NOW()) - 1;");
		$this->response->redirect($this->url->link('catalog/reports', 'token=' . $this->session->data['token'], true));
	}
}
?>
