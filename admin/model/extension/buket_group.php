<?php
class ModelExtensionBuketGroup extends Model {
	public function addbuketGroup($data) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "buket_groups SET language_id = '3', name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', image='" . $this->db->escape($data['image']) . "'");

	}

	public function editbuketGroup($buket_group_id, $data) {

			$this->db->query("UPDATE " . DB_PREFIX . "buket_groups SET language_id = '3', name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', image='" . $this->db->escape($data['image']) . "' WHERE id = '" . $buket_group_id . "' ");
	}

	public function deletebuketGroup($buket_group_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "buket_groups WHERE id = '" . (int)$buket_group_id . "'");
	}

	public function getbuketGroup($buket_group_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "buket_groups WHERE id = '" . (int)$buket_group_id . "' ");

		return $query->row;
	}

	public function getbuketGroups($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "buket_groups WHERE 1";

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


	public function getTotalBuketGroups() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "buket_groups");

		return $query->row['total'];
	}
}