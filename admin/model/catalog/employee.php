<?php
class ModelCatalogEmployee extends Model {
	public function addEmployee($data,$data1) {

		$target_file = DIR_IMAGE .'pan/'.basename($_FILES["pan"]["name"]);
        move_uploaded_file($_FILES["pan"]["tmp_name"], $target_file);
	    $file_name = 'pan/' . basename($_FILES["pan"]["name"]);

	    $target_files = DIR_IMAGE .'adhaar/'.basename($_FILES["adhaar"]["name"]);
        move_uploaded_file($_FILES["adhaar"]["tmp_name"], $target_files);
	    $file_names = 'adhaar/' . basename($_FILES["adhaar"]["name"]);

	    $target_filess = DIR_IMAGE .'passbook/'.basename($_FILES["bank"]["name"]);
        move_uploaded_file($_FILES["bank"]["tmp_name"], $target_filess);
	    $file_namess = 'passbook/' . basename($_FILES["bank"]["name"]);
		
		// echo "<pre>";print_r($data);exit;
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "employee SET name = '" . $this->db->escape($data['name']) . "', login = '" . $this->db->escape($data['login']) . "',
		user_id = '" . $this->db->escape($data['user_id']) . "', email = '" . $this->db->escape($data['email']) . "',numbers = '" . $this->db->escape($data['numbers']) . "',address = '" . $this->db->escape($data['address']) . "',father_name = '" . $this->db->escape($data['father_name']) . "',surname = '" . $this->db->escape($data['surname']) . "',dob = '" . $this->db->escape($data['dob']) . "',doje = '" . $this->db->escape($data['doje']) . "',dole = '" . $this->db->escape($data['dole']) ."', pan = '" . $this->db->escape($data['pan_no']) . "',pan_path = '" . $this->db->escape($file_name) . "',adhaar_path = '" . $this->db->escape($file_names) . "',adhaar = '" . $this->db->escape($data['adhaar_no']) . "',bank_details = '" . $this->db->escape($data['bank_details']) . "',bank_path = '" . $this->db->escape($file_namess) . "',emergency_contact_person_details = '" . $this->db->escape($data['emergency_contact_person_details']) . "',emergency_contact_person_details1 = '" . $this->db->escape($data['emergency_contact_person_details1']) . "'");

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
		// echo "<pre>";print_r($_FILES);exit;

		if(isset($_FILES["pan"]["name"]) && $_FILES["pan"]["name"] != ''){	
			$target_file = DIR_IMAGE . "pan/" .basename($_FILES["pan"]["name"]);
			move_uploaded_file($_FILES["pan"]["tmp_name"], $target_file);
			$file_name = "pan/" . basename($_FILES["pan"]["name"]);
			$pan = $file_name;
		} else {
			$pan = $data['pan_path'];
		}

		if(isset($_FILES["adhaar"]["name"]) && $_FILES["adhaar"]["name"] != ''){	
			$target_files = DIR_IMAGE . "adhaar/" .basename($_FILES["adhaar"]["name"]);
			move_uploaded_file($_FILES["adhaar"]["tmp_name"], $target_files);
			$file_names = "adhaar/" . basename($_FILES["adhaar"]["name"]);
			$adhaar = $file_names;
		} else {
			$adhaar = $data['adhaar_path'];
		}

		if(isset($_FILES["bank"]["name"]) && $_FILES["bank"]["name"] != ''){	
			$target_filess = DIR_IMAGE . "passbook/" .basename($_FILES["bank"]["name"]);
			move_uploaded_file($_FILES["bank"]["tmp_name"], $target_filess);
			$file_namess = "passbook/" . basename($_FILES["bank"]["name"]);
			$bank = $file_namess;
		} else {
			$bank = $data['bank_path'];
		}

		$this->db->query("UPDATE " . DB_PREFIX . "employee SET name = '" . $this->db->escape($data['name']) . "', login = '" . $this->db->escape($data['login']) . "',user_id = '" . $this->db->escape($data['user_id']) . "', email = '" . $this->db->escape($data['email']) . "',numbers = '" . $this->db->escape($data['numbers']) . "',address = '" . $this->db->escape($data['address']) . "',father_name = '" . $this->db->escape($data['father_name']) . "',surname = '" . $this->db->escape($data['surname']) . "',dob = '" . $this->db->escape($data['dob']) . "',doje = '" . $this->db->escape($data['doje']) . "',dole = '" . $this->db->escape($data['dole']) ."',pan = '" . $this->db->escape($data['pan_no']) . "',adhaar = '" . $this->db->escape($data['adhaar_no']) . "',bank_details = '" . $this->db->escape($data['bank_details']) . "',pan_path = '" . $pan . "',adhaar_path = '" . $adhaar . "',bank_path = '" . $bank . "',emergency_contact_person_details = '" . $this->db->escape($data['emergency_contact_person_details']) . "',emergency_contact_person_details1 = '" . $this->db->escape($data['emergency_contact_person_details1']) . "' WHERE employee_id = '" . (int)$employee_id . "'");

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
		}

		$sql .= " GROUP BY numbers";
		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query);exit;

		return $query->rows;
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
		$sql = "SELECT * FROM oc_user WHERE 1=1";

		if (!empty($data['login'])) {
			$sql .= " AND username LIKE '" . $this->db->escape($data['login']) . "%'";
		}

		$sql .= " GROUP BY username";
		$query = $this->db->query($sql);
		// echo "<pre>";print_r($query);exit;

		return $query->rows;
	}

	public function getEmployees($data = array()) {
		// echo "<pre>"; print_r($sort_data);exit;

		$user_id = $this->session->data['user_id'];
		$user_data = $this->db->query("SELECT * FROM oc_user where user_id = '$user_id'")->rows;
		foreach ($user_data as $user) {
			$user_group_id = $user['user_group_id'];
			$data['user_group_id'] = $user['user_group_id'];
			$name_of_user = $user['firstname'] . ' ' . $user['lastname'];
		}

		// echo "<pre>";print_r($user_group_id);exit;
		if ($user_group_id != 1) {
			$sql = "SELECT * FROM " . DB_PREFIX . "employee";
			$sql .= " WHERE user_id LIKE '" . $user_id . "%'";
		} else{
			$sql = "SELECT * FROM " . DB_PREFIX . "employee";
		}

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