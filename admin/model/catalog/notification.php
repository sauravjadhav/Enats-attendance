<?php
class ModelCatalogNotification extends Model {

	public function getData() {
		$user_id = $this->session->data['user_id'];
		$result = $this->db->query("SELECT * FROM oc_task WHERE user_id = $user_id")->rows;
		
		return $result;
	}	
	public function listNotificationUser($user){
		$sqlQuery = "SELECT * FROM ".$this->notifTable." WHERE username='$user' AND notif_loop > 0 AND notif_time <= CURRENT_TIMESTAMP()";
		return  $this->getData($sqlQuery);
	}					
}
?>