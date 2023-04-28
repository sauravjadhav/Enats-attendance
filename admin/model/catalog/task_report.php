<?php
class ModelCatalogTaskReport extends Model {
  
    public function gettask($task_id) {
    
     $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'task_id=" . (int)$task_id . "') AS keyword FROM " . DB_PREFIX . "task WHERE task_id = '" . (int)$task_id . "'");
    return $query->row;
  }

  public function autocompletetas($data = array()){
    // echo "<pre>";print_r($data);exit;
    $sql = "SELECT * FROM oc_project WHERE 1=1";

    if (!empty($data['filter_project'])) {
      $sql .= " AND project_name LIKE '" . $this->db->escape($data['filter_project']) . "%'";
    }

    $sql .= " GROUP BY project_name";
    $query = $this->db->query($sql);

    return $query->rows;
  }

  public function autocomplete2($data = array()){
    // echo "<pre>";print_r($data);exit;
    $sql = "SELECT * FROM oc_user WHERE 1=1";

    if (!empty($data['username'])) {
      $sql .= " AND username LIKE '" . $this->db->escape($data['username']) . "%'";
    }

    $sql .= " GROUP BY username";
    $query = $this->db->query($sql);

    return $query->rows;
  }

  public function getTasks($data = array()) {

    $user_id = $this->session->data['user_id'];
    $user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
    foreach ($user_data as $user) {
      $user_group_id = $user['user_group_id'];
      $data['user_group_id'] = $user['user_group_id'];
      $name_of_user = $user['firstname'] . ' ' . $user['lastname'];
    }

    // echo "<pre>";print_r($user_group_id);exit;
    if ($user_group_id == 11) {
      $sql = "SELECT * FROM " . DB_PREFIX . "task";
      $sql .= " WHERE user_id LIKE '" . $user_id . "%'";

      if (!empty($data['project_id'])) {
        $sql .= " AND project_id LIKE '" . $this->db->escape($data['project_id']) . "%'";
      }

      if (!empty($data['date'])) {
        $sql .= " AND date LIKE '" . $this->db->escape($data['date']) . "%'";
      }

    } elseif($user_group_id == 1) {
      $sql = "SELECT * FROM " . DB_PREFIX . "task";

      if (!empty($data['project_id'])) {
        $sql .= " WHERE project_id = '" . $this->db->escape($data['project_id']) . "%'";
      }

      if (!empty($data['user_id'])) {
        $sql .= " WHERE user_id = '" . $this->db->escape($data['user_id']) . "%'";
      }

      if (!empty($data['date'])) {
        $sql .= " WHERE date LIKE '" . $this->db->escape($data['date']) . "%'";
      }
    } elseif ($user_group_id == 12) {
      $project_id = $this->db->query("SELECT project_id FROM oc_project WHERE user_id = '$user_id'")->row;
      $p_id = $project_id['project_id'];
      $sql = "SELECT * FROM " . DB_PREFIX . "task";
      $sql .= " WHERE project_id = '$p_id'";
      if (!empty($data['date'])) {
        $sql .= " AND date LIKE '" . $this->db->escape($data['date']) . "%'";
      }
      // echo "<pre>";print_r($sql);exit;
    }

    // echo "<pre>";print_r($sql);exit;

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