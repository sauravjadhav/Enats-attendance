<?php
class ModelCatalogTaskReport extends Model {

  public function getTasks($data = array()) {

    $user_id = $this->session->data['user_id'];
    $user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
    foreach ($user_data as $user) {
      $user_group_id = $user['user_group_id'];
      $data['user_group_id'] = $user['user_group_id'];
      $name_of_user = $user['firstname'] . ' ' . $user['lastname'];
    }
    
    $sql = "SELECT * FROM " . DB_PREFIX . "task WHERE 1=1";

    if (!empty($data['project_id'])) {
      $sql .= " AND project_id = '" . $this->db->escape($data['project_id']) . "%'";
    }

    if (!empty($data['user_id'])) {
      $sql .= " AND user_id = '" . $this->db->escape($data['user_id']) . "%'";
    }

    if (!empty($data['fromdate']) && !empty($data['todate'])) {
      $from_date = date('Y-m-d H:i:s', strtotime($data['fromdate']));
      $to_date = date('Y-m-d H:i:s', strtotime($data['todate']));
      $sql .= " AND DATE(date_time) >= '" . $this->db->escape($from_date) . "' AND DATE(date_time) <= '" . $this->db->escape($to_date) . "'";
    }elseif(!empty($data['fromdate'])){
      $from_date = date('Y-m-d', strtotime($data['fromdate']));
      $sql .= " AND DATE(date_time) =  '" . $this->db->escape($from_date) . "'";
      // echo "<pre>";print_r($sql);exit;
    }elseif(!empty($data['todate'])){
      $to_date = date('Y-m-d H:i:s', strtotime($data['todate']));
      $sql .= " AND DATE(date_time) = '" . $this->db->escape($to_date) . "'";
    }

    $sort_data = array(
      'project_id',
      'user_id',
    );

    if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
      $sql .= " ORDER BY " . $data['sort'];
    } else {
      $sql .= " ORDER BY date_time";
    }

    if (isset($data['order']) && ($data['order'] == 'DESC')) {
      $sql .= " DESC";
    } else {
      $sql .= " ASC";
    }

    if (isset($data['start']) || isset($data['limit'])) {
      if ($data['start'] < 0) {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1) {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }

    $query = $this->db->query($sql);

    // echo "<pre>";print_r($query->rows);exit;

    return $query->rows;
  }

  public function getTotalTasks() {

    $user_group_id = $this->user->user_group_id;
    $user_id = $this->session->data['user_id'];

    if($user_group_id == 1){
      $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "task");
    }elseif($user_group_id == 11){
      $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX ."task WHERE user_id = $user_id");
    // echo "<pre>";print_r($query);exit;
    }elseif($user_group_id == 12){
      $project_id = $this->db->query("SELECT project_id FROM oc_project WHERE user_id = '$user_id'")->row;
      $p_id = $project_id['project_id'];
      $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX ."task WHERE project_id = $p_id");
    }

    return $query->row['total'];
  }
}
?>