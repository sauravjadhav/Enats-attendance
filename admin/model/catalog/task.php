<?php
class ModelCatalogTask extends Model {
	public function addTask($data) {
		// echo "<pre>";print_r($data);exit;

		$this->db->query("INSERT INTO " . DB_PREFIX . "task SET project = '" . $this->db->escape($data['project']) . "',project_start_time = '" . $this->db->escape($data['project_start_time']) . "',project_end_time = '" . $this->db->escape($data['project_end_time']) . "',task = '" . $this->db->escape($data['task']) . "',status = '" . $this->db->escape($data['status']) . "',commit_no = '" . $this->db->escape($data['commit_no']) . "'");

		$task_id = $this->db->getLastId();

		$this->cache->delete('task');

		return $task_id;
	}

	public function editTask($task_id, $data) {
	 // echo "<pre>";print_r($this->request->post);exit;

		$this->db->query("UPDATE " . DB_PREFIX . "task SET project = '" . $this->db->escape($data['project']) . "',project_start_time = '" . $this->db->escape($data['project_start_time']) . "',project_end_time = '" . $this->db->escape($data['project_end_time']) . "',task = '" . $this->db->escape($data['task']) . "',status = '" . $this->db->escape($data['status']) . "',commit_no = '" . $this->db->escape($data['commit_no']) . "' WHERE task_id = '" . (int)$task_id . "'");

		$this->cache->delete('task');
	}

	public function deleteTask($task_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "task WHERE task_id = '" . (int)$task_id . "'");

		$this->cache->delete('task');
	}

	public function gettask($task_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'task_id=" . (int)$task_id . "') AS keyword FROM " . DB_PREFIX . "task WHERE task_id = '" . (int)$task_id . "'");
		return $query->row;
	}


	public function autocompletetas($data = array()){
		// echo "<pre>";print_r($data);exit;
		$sql = "SELECT * FROM oc_task WHERE 1=1";

		if (!empty($data['filter_project'])) {
			$sql .= " AND project LIKE '" . $this->db->escape($data['filter_project']) . "%'";
		}

		$sql .= " GROUP BY project";
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function autocomplete1($data = array()){
		// echo "<pre>";print_r($data);exit;
		$sql = "SELECT * FROM oc_project WHERE 1=1";

		if (!empty($data['project'])) {
			$sql .= " AND project_name LIKE '" . $this->db->escape($data['project']) . "%'";
		}

		$sql .= " GROUP BY project_name";
		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTasks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "task";

		if (!empty($data['filter_project'])) {
			$sql .= " WHERE project LIKE '" . $this->db->escape($data['filter_project']) . "%'";
		}

		$sort_data = array(
			'project',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY project";
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
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "task");

		return $query->row['total'];
	}
}
