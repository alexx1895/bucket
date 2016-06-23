<?php
class ModelBannersequenceSlide extends Model {
	public function addbannersequence($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "bannersequence SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "',auto = '" . (int)$data['auto'] . "',delay = '" . (int)$data['delay'] . "',hover = '" . (int)$data['hover'] . "',nextback = '" . (int)$data['nextback'] . "',contrl = '" . (int)$data['contrl'] . "'");
	
		$bannersequence_id = $this->db->getLastId();
	
		if (isset($data['bannersequence_image'])) {
			foreach ($data['bannersequence_image'] as $bannersequence_image) {
			
				$banner_store = ""; 
				if(isset($bannersequence_image['banner_store'])) {
					$banner_store = implode(',', $bannersequence_image['banner_store']); 
				}
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "bannersequence_image SET bannersequence_id = '" . (int)$bannersequence_id . "', link = '" .  $this->db->escape($bannersequence_image['link']) . "', type = '" .  $this->db->escape($bannersequence_image['type']) . "', image = '" .  $this->db->escape($bannersequence_image['image']) . "', image1 = '" .  $this->db->escape($bannersequence_image['image1']) . "',banner_store = '" .$banner_store. "'");
				
				$bannersequence_image_id = $this->db->getLastId();
				
				foreach ($bannersequence_image['bannersequence_image_description'] as $language_id => $bannersequence_image_description) {				
					$this->db->query("INSERT INTO " . DB_PREFIX . "bannersequence_image_description SET bannersequence_image_id = '" . (int)$bannersequence_image_id . "', language_id = '" . (int)$language_id . "', bannersequence_id = '" . (int)$bannersequence_id . "', title = '" .  $this->db->escape($bannersequence_image_description['title']) . "',sub_title = '" .  $this->db->escape($bannersequence_image_description['sub_title']) . "',description = '" .  $this->db->escape($bannersequence_image_description['description']) . "'");
				}
			}
		}		
	}
	
	public function editbannersequence($bannersequence_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "bannersequence SET name = '" . $this->db->escape($data['name']) . "', status = '" . (int)$data['status'] . "',auto = '" . (int)$data['auto'] . "',delay = '" . (int)$data['delay'] . "',hover = '" . (int)$data['hover'] . "',nextback = '" . (int)$data['nextback'] . "',contrl = '" . (int)$data['contrl'] . "' WHERE bannersequence_id = '" . (int)$bannersequence_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "bannersequence_image WHERE bannersequence_id = '" . (int)$bannersequence_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "bannersequence_image_description WHERE bannersequence_id = '" . (int)$bannersequence_id . "'");
			
		if (isset($data['bannersequence_image'])) {
			foreach ($data['bannersequence_image'] as $bannersequence_image) {
				$banner_store = ""; 
				if(isset($bannersequence_image['banner_store'])) {
					$banner_store = implode(',', $bannersequence_image['banner_store']); 
				}
				$this->db->query("INSERT INTO " . DB_PREFIX . "bannersequence_image SET bannersequence_id = '" . (int)$bannersequence_id . "', link = '" .  $this->db->escape($bannersequence_image['link']) . "', type = '" .  $this->db->escape($bannersequence_image['type']) . "', image = '" .  $this->db->escape($bannersequence_image['image']) . "', image1 = '" .  $this->db->escape($bannersequence_image['image1']) . "',banner_store = '" .  $banner_store . "'");
				
				$bannersequence_image_id = $this->db->getLastId();
				
				foreach ($bannersequence_image['bannersequence_image_description'] as $language_id => $bannersequence_image_description) {				
					$this->db->query("INSERT INTO " . DB_PREFIX . "bannersequence_image_description SET bannersequence_image_id = '" . (int)$bannersequence_image_id . "', language_id = '" . (int)$language_id . "', bannersequence_id = '" . (int)$bannersequence_id . "', title = '" .  $this->db->escape($bannersequence_image_description['title']) . "',sub_title = '" .  $this->db->escape($bannersequence_image_description['sub_title']) . "',description = '" .  $this->db->escape($bannersequence_image_description['description']) . "'");
				}
			}
		}			
	}
	
	public function deletebannersequence($bannersequence_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "bannersequence WHERE bannersequence_id = '" . (int)$bannersequence_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "bannersequence_image WHERE bannersequence_id = '" . (int)$bannersequence_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "bannersequence_image_description WHERE bannersequence_id = '" . (int)$bannersequence_id . "'");
	}
	
	public function getbannersequence($bannersequence_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "bannersequence WHERE bannersequence_id = '" . (int)$bannersequence_id . "'");
		
		return $query->row;
	}
		
	public function getbannersequences($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "bannersequence";
		
		$sort_data = array(
			'name',
			'status'
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
		
	public function getbannersequenceImages($bannersequence_id) {
		$bannersequence_image_data = array();
		
		$bannersequence_image_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bannersequence_image WHERE bannersequence_id = '" . (int)$bannersequence_id . "'");
		
		foreach ($bannersequence_image_query->rows as $bannersequence_image) {
			$bannersequence_image_description_data = array();
			 
			$bannersequence_image_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bannersequence_image_description WHERE bannersequence_image_id = '" . (int)$bannersequence_image['bannersequence_image_id'] . "' AND bannersequence_id = '" . (int)$bannersequence_id . "'");
			
			foreach ($bannersequence_image_description_query->rows as $bannersequence_image_description) {			
				$bannersequence_image_description_data[$bannersequence_image_description['language_id']] = array('title' => $bannersequence_image_description['title'],
				'sub_title' => $bannersequence_image_description['sub_title'],
				'description' => $bannersequence_image_description['description'],
				
				);
			}
		
			$bannersequence_image_data[] = array(
				'bannersequence_image_description' => $bannersequence_image_description_data,
				'link'                     => $bannersequence_image['link'],
				'type'                     => $bannersequence_image['type'],
				'image'                    => $bannersequence_image['image'],	
				'image1'                    => $bannersequence_image['image1'],
				'banner_store'                    => $bannersequence_image['banner_store']					
			);
		}
		
		return $bannersequence_image_data;
	}
		
	public function getTotalBannersequences() { 
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "bannersequence");
		
		return $query->row['total'];
	}


	
	public function deleteTable() {
			$sql = array(); 
			$sql[] = "DROP TABLE `".DB_PREFIX."bannersequence";
			$sql[] = "DROP TABLE `".DB_PREFIX."bannersequence_image";
			$sql[] = "DROP TABLE `".DB_PREFIX."bannersequence_image_description";
			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
			return true;
	}
}
?>