<?php
class ModelBannersequenceSlide extends Model {	

	public function getBannersequence($banner_id) {
		$select ="SELECT * FROM " . DB_PREFIX . "bannersequence_image bi LEFT JOIN " . DB_PREFIX . "bannersequence_image_description bid ON (bi.bannersequence_image_id  = bid.bannersequence_image_id) WHERE bi.bannersequence_id = '" . (int)$banner_id . "' AND bid.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY bid.order";
		$query = $this->db->query($select);
		
		return $query->rows;
	}
	
	public function getSettingSlide($banner_id = null) {
		$query = "SELECT * FROM " . DB_PREFIX .  "bannersequence"; 
		$result = $this->db->query($query);
		return $result->rows;
	}
}
?>