<?php
class ModelCatalogProject extends Model {
	public function addProject($data) {
		// echo "<pre>";print_r($data);exit;

		$this->db->query("INSERT INTO " . DB_PREFIX . "project SET project_name = '" . $this->db->escape($data['project_name']) . "',contact_person = '" . $this->db->escape($data['contact_person']) . "',project_company = '" . $this->db->escape($data['project_company']) . "',phone = '" . $this->db->escape($data['phone']) . "',email = '" . $this->db->escape($data['email']) . "',project_start_date = '" . $this->db->escape($data['project_start_date']) . "', project_end_date = '" . $this->db->escape($data['project_end_date']) . "'");

		$project_id = $this->db->getLastId();

		$this->cache->delete('manufacturer');

		return $project_id;
	}

	public function editProject($project_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "project SET project_name = '" . $this->db->escape($data['project_name']) . "',contact_person = '" . $this->db->escape($data['contact_person']) . "',project_company = '" . $this->db->escape($data['project_company']) . "',phone = '" . $this->db->escape($data['phone']) . "',email = '" . $this->db->escape($data['email']) . "',project_start_date = '" . $this->db->escape($data['project_start_date']) . "', project_end_date = '" . $this->db->escape($data['project_end_date']) . "' WHERE project_id = '" . (int)$project_id . "'");

		$this->cache->delete('manufacturer');
	}

	public function deleteProject($project_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "project WHERE project_id = '" . (int)$project_id . "'");

		$this->cache->delete('manufacturer');
	}

	public function getProject($project_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "project WHERE project_id = '" . (int)$project_id . "'");

		return $query->row;
	}

	public function getProjects($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "project";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE project_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array(
			'project_name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY project_name";
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

		return $query->rows;
	}

	public function getManufacturerStores($manufacturer_id) {
		$manufacturer_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer_to_store WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		foreach ($query->rows as $result) {
			$manufacturer_store_data[] = $result['store_id'];
		}

		return $manufacturer_store_data;
	}

	public function getTotalProjects() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "project");

		return $query->row['total'];
	}
}
