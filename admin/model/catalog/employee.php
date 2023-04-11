<?php
class ModelCatalogEmployee extends Model {
	public function addEmployee($data,$data1) {

		// echo "<pre>";print_r($file_name);exit;
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "employee SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "',password = '" . $this->db->escape($data['password']) . "',numbers = '" . $this->db->escape($data['numbers']) . "',login = '" . $this->db->escape($data['login']) . "',address = '" . $this->db->escape($data['address']) . "',father_name = '" . $this->db->escape($data['father_name']) . "',surname = '" . $this->db->escape($data['surname']) . "',dob = '" . $this->db->escape($data['dob']) . "',doje = '" . $this->db->escape($data['doje']) . "',pan = '" . $this->db->escape($data['pan']) . "',adhaar = '" . $this->db->escape($data['adhaar']) . "',bank_details = '" . $this->db->escape($data['bank_details']) . "',emergency_contact_person_details = '" . $this->db->escape($data['emergency_contact_person_details']) . "',laptop_model = '" . $this->db->escape($data['laptop_model']) . "'");

		$employee_id = $this->db->getLastId();

		if (isset($data['employee_store'])) {
			foreach ($data['employee_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "employee SET employee_id = '" . (int)$employee_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'employee_id=" . (int)$employee_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('employee');

		return $employee_id;
	}

	public function editEmployee($employee_id, $data) {

		// echo "<pre>";print_r($this->request->post);exit;
		$this->db->query("UPDATE " . DB_PREFIX . "employee SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "',password = '" . $this->db->escape($data['password']) . "',numbers = '" . $this->db->escape($data['numbers']) . "',login = '" . $this->db->escape($data['login']) . "',address = '" . $this->db->escape($data['address']) . "',father_name = '" . $this->db->escape($data['father_name']) . "',surname = '" . $this->db->escape($data['surname']) . "',dob = '" . $this->db->escape($data['dob']) . "',doje = '" . $this->db->escape($data['doje']) . "',pan = '" . $this->db->escape($data['pan']) . "',adhaar = '" . $this->db->escape($data['adhaar']) . "',bank_details = '" . $this->db->escape($data['bank_details']) . "',emergency_contact_person_details = '" . $this->db->escape($data['emergency_contact_person_details']) . "',laptop_model = '" . $this->db->escape($data['laptop_model'])  . "' WHERE employee_id = '" . (int)$employee_id . "'");

		$this->cache->delete('employee');
	}

	public function deleteEmployee($employee_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "employee WHERE employee_id = '" . (int)$employee_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "employee WHERE employee_id = '" . (int)$employee_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'employee_id=" . (int)$employee_id . "'");

		$this->cache->delete('employee');
	}

	public function getEmployee($employee_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'employee_id=" . (int)$employee_id . "') AS keyword FROM " . DB_PREFIX . "employee WHERE employee_id = '" . (int)$employee_id . "'");

		return $query->row;
	}

	public function autocompleteemp($data = array()){
		$sql = "SELECT * FROM oc_employee WHERE 1=1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY name";
		// echo "<pre>";print_r($sql);exit;
		$query = $this->db->query($sql);

		return $query->rows;
	}

    public function autocompleteemp1($data = array()){
		$sql = "SELECT * FROM oc_employee WHERE 1=1";

		if (!empty($data['filter_numbers'])) {
			$sql .= " AND numbers LIKE '" . $this->db->escape($data['filter_numbers']) . "%'";
		if (!empty($data['filter_number'])) {
			$sql .= " AND numbers LIKE '" . $this->db->escape($data['filter_number']) . "%'";
		}

		$sql .= " GROUP BY numbers";
		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query);exit;

		return $query->rows;
	}
}

    public function autocompleteemp2($data = array()){
		$sql = "SELECT * FROM oc_employee WHERE 1=1";

		if (!empty($data['filter_email'])) {
			$sql .= " AND email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		$sql .= " GROUP BY email";
		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query);exit;

		return $query->rows;
	}

	public function autocompleteemp3($data = array()){
		$sql = "SELECT * FROM oc_qualification WHERE 1=1";

		if (!empty($data['type_of_quailification'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['type_of_quailification']) . "%'";
		}

		$sql .= " GROUP BY name";
		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query);exit;

		return $query->rows;
	}

	public function getEmployees($data = array()) {
		// echo "<pre>"; print_r($sort_data);exit;
		$sql = "SELECT * FROM " . DB_PREFIX . "employee";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_numbers'])) {
			$sql .= " WHERE numbers LIKE '" . $this->db->escape($data['filter_numbers']) . "%'";
		}
		if (!empty($data['filter_number'])) {
			$sql .= " WHERE numbers LIKE '" . $this->db->escape($data['filter_number']) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$sql .= " WHERE email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
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

		return $query->rows;
    }

	public function getEmployeeStores($employee_id) {
		$employee = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "employee WHERE employee_id = '" . (int)$employee_id . "'");

		foreach ($query->rows as $result) {
			$employee[] = $result['store_id'];
		}

		return $employee;
	}


	public function getTotalEmployees() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "employee");

		return $query->row['total'];
	}
}