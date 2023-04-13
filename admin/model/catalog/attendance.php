<?php
class ModelCatalogAttendance extends Model {
	public function addattendance($data) {

		if(!empty($data['user_id'])){
			$user_id = $data['user_id'];
		} else {
			$user_id = $this->session->data['user_id'];
		}

		$this->db->query("INSERT INTO " . DB_PREFIX . "attendance_record SET name = '" . $this->db->escape($data['name']) . "',date = '" . $this->db->escape($data['date']) . "',time = '" . $this->db->escape($data['time']) . "',user_id = '" . $this->db->escape($user_id) . "', office_in_time = '" . $this->db->escape($data['office_in_time']) . "'");

		$attendance_id = $this->db->getLastId();

		

		$this->cache->delete('attendance');

		return $attendance_id;
	}

	public function editattendance($attendance_id, $data) {

		// echo "<pre>";print_r($this->request->post);exit;
		$this->db->query("UPDATE " . DB_PREFIX . "attendance_record SET name = '" . $this->db->escape($data['name']) . "', office_in_time = '" . $this->db->escape($data['office_in_time']) . "' WHERE attendance_id = '" . (int)$attendance_id . "'");

		$this->cache->delete('attendance');
	}

	public function deleteattendance($attendance_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "attendance_record WHERE attendance_id = '" . (int)$attendance_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "attendance_record WHERE attendance_id = '" . (int)$attendance_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'attendance_id=" . (int)$attendance_id . "'");

		$this->cache->delete('attendance');
	}

	public function getattendance($attendance_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'attendance_id=" . (int)$attendance_id . "') AS keyword FROM " . DB_PREFIX . "attendance_record WHERE attendance_id = '" . (int)$attendance_id . "'");

		return $query->row;
	}

	public function autocompleteatt($data = array()){
		// echo "<pre>";print_r($sql);exit;
		$sql = "SELECT attendance_id, name FROM oc_attendance_record WHERE 1=1";


		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY name";
		$query = $this->db->query($sql);

		return $query->rows;
	}

    public function autocompleteatt1($data = array()){
		$sql = "SELECT * FROM oc_attendance_record WHERE 1=1";

		if (!empty($data['filter_office_in_time'])) {
			$sql .= " AND office_in_time LIKE '" . $this->db->escape($data['filter_office_in_time']) . "%'";
		}

		$sql .= " GROUP BY office_in_time";
		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query);exit;

		return $query->rows;
	}

	public function autocompleteatt2($data = array()){
		$sql = "SELECT * FROM oc_user WHERE 1=1";

		if (!empty($data['name'])) {
			$sql .= " AND firstname LIKE '" . $this->db->escape($data['name']) . "%'";
		}

		$sql .= " GROUP BY firstname";
		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query);exit;

		return $query->rows;
	}

	public function getAttendances($data = array()) {
		// echo "<pre>"; print_r($data);exit;
		$sql = "SELECT * FROM " . DB_PREFIX . "attendance_record ";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_office_in_time'])) {
			$sql .= " WHERE office_in_time LIKE '" . $this->db->escape($data['filter_office_in_time']) . "%'";
		}


		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
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

	public function getAttandanceStores($attendance_id) {
		$attendance = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "attendance_record WHERE attendance_id = '" . (int)$attendance_id . "'");

		foreach ($query->rows as $result) {
			$attendance[] = $result['store_id'];
		}

		return $attendance;
	}


	public function getTotalattendances() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "attendance_record");

		return $query->row['total'];
	}
}