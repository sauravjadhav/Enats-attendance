<?php
class ModelCatalogNotification extends Model {

	public function getData() {
		// echo "<pre>";print_r($this->user);exit;
		$user_id = $this->session->data['user_id'];
    	$query = "SELECT * FROM oc_task WHERE user_id = $user_id AND date_time = (SELECT MAX(date_time) FROM oc_task WHERE user_id = $user_id)";
    	$result = $this->db->query($query)->rows;
		return $result;
	}					
}
?>