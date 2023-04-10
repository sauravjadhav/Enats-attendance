<?php
class ModelCatalogEmployee extends Model {
	public function addEmployee($data,$data1) {

		$target_file = DIR_IMAGE .'catalog/'.basename($_FILES["resume"]["name"]);
        move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file);
	    $file_name = 'catalog/' . basename($_FILES["resume"]["name"]);
		// echo "<pre>";print_r($file_name);exit;
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "employee SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "',password = '" . $this->db->escape($data['password']) . "',numbers = '" . $this->db->escape($data['numbers']) . "',status = '" . $this->db->escape($data['status']) . "',city = '" . $this->db->escape($data['city']) . "',work_experience_months = '" . $this->db->escape($data['work_experience_months']) . "',work_experience_year = '" . $this->db->escape($data['work_experience_year']) . "',company = '" . $this->db->escape($data['company']) . "',working_since = '" . $this->db->escape($data['working_since']) . "',annual_salary = '" . $this->db->escape($data['annual_salary']) . "',noticed_period = '" . $this->db->escape($data['notice_period']) . "',job_title = '" . $this->db->escape($data['job_title']) . "',current_city = '" . $this->db->escape($data['current_city']) . "',field_of_study = '" . $this->db->escape($data['field_of_study']) . "',quailification_id = '" . $this->db->escape($data['quailification_id']) . "',type_of_qualification = '" . $this->db->escape($data['type_of_quailification']) . "',institution_name = '" . $this->db->escape($data['institution_name']) . "',institution_location = '" . $this->db->escape($data['institution_location']) . "',graduation_date = '" . $this->db->escape($data['graduation_date']) . "',gpa_grade = '" . $this->db->escape($data['gpa']) . "',relevant_courses_or_certifications = '" . $this->db->escape($data['certifications']) . "',academic_honors_or_awards = '" . $this->db->escape($data['awards']) . "',resume_headline = '" . $this->db->escape($data['resume_headline']) . "',suggestions = '" . $this->db->escape($data['suggestions']) . "', preferred_salary = '" . $this->db->escape($data['preferred_salary']) . "',preferred_work_locations = '" . $this->db->escape($data['preferred_work_locations']) . "',gender = '" . $this->db->escape($data['gender']) . "',employed = '" . $this->db->escape($data['employed']) . "', resume = '" . $file_name . "'");

		$employee_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "employee SET image = '" . $this->db->escape($data['image']) . "' WHERE employee_id = '" . (int)$employee_id . "'");
		}

		if (isset($data['employee_store'])) {
			foreach ($data['employee_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "employee_to_store SET employee_id = '" . (int)$employee_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'employee_id=" . (int)$employee_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('employee');

		return $employee_id;
	}

	public function editEmployee($employee_id, $data) {

		$target_file = DIR_IMAGE .'catalog/'.basename($_FILES["resume"]["name"]);
        move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file);
	    $file_name = 'catalog/' . basename($_FILES["resume"]["name"]);
		// echo "<pre>";print_r($this->request->post);exit;
		$this->db->query("UPDATE " . DB_PREFIX . "employee SET name = '" . $this->db->escape($data['name']) . "', email = '" . $this->db->escape($data['email']) . "',password = '" . $this->db->escape($data['password']) . "',numbers = '" . $this->db->escape($data['numbers']) . "',status = '" . $this->db->escape($data['status']) . "',city = '" . $this->db->escape($data['city']) . "',work_experience_months = '" . $this->db->escape($data['work_experience_months']) . "',work_experience_year = '" . $this->db->escape($data['work_experience_year']) . "',company = '" . $this->db->escape($data['company']) . "',working_since = '" . $this->db->escape($data['working_since']) . "',annual_salary = '" . $this->db->escape($data['annual_salary']) . "',noticed_period = '" . $this->db->escape($data['notice_period']) . "',job_title = '" . $this->db->escape($data['job_title']) . "',current_city = '" . $this->db->escape($data['current_city']) . "',field_of_study = '" . $this->db->escape($data['field_of_study']) . "',quailification_id = '" . $this->db->escape($data['quailification_id']) . "',type_of_qualification = '" . $this->db->escape($data['type_of_quailification']) . "',institution_name = '" . $this->db->escape($data['institution_name']) . "',institution_location = '" . $this->db->escape($data['institution_location']) . "',graduation_date = '" . $this->db->escape($data['graduation_date']) . "',gpa_grade = '" . $this->db->escape($data['gpa']) . "',relevant_courses_or_certifications = '" . $this->db->escape($data['certifications']) . "',academic_honors_or_awards = '" . $this->db->escape($data['awards']) . "',resume_headline = '" . $this->db->escape($data['resume_headline']) . "',suggestions = '" . $this->db->escape($data['suggestions']) . "', preferred_salary = '" . $this->db->escape($data['preferred_salary']) . "',preferred_work_locations = '" . $this->db->escape($data['preferred_work_locations']) . "',gender = '" . $this->db->escape($data['gender']) . "',employed = '" . $this->db->escape($data['employed']) . "', resume = '" . $file_name . "' WHERE employee_id = '" . (int)$employee_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "employee SET image = '" . $this->db->escape($data['image']) . "' WHERE employee_id = '" . (int)$employee_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "employee_to_store WHERE employee_id = '" . (int)$employee_id . "'");

		if (isset($data['manufacturer_store'])) {
			foreach ($data['manufacturer_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "employee_to_store SET employee_id = '" . (int)$employee_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'employee_id=" . (int)$employee_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'employee_id=" . (int)$employee_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('employee');
	}

	public function deleteEmployee($employee_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "employee WHERE employee_id = '" . (int)$employee_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "employee_to_store WHERE employee_id = '" . (int)$employee_id . "'");
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
		$employee_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "employee_to_store WHERE employee_id = '" . (int)$employee_id . "'");

		foreach ($query->rows as $result) {
			$employee_store_data[] = $result['store_id'];
		}

		return $employee_store_data;
	}


	public function getTotalEmployees() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "employee");

		return $query->row['total'];
	}
}