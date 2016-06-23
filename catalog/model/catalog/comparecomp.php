<?php
class ModelCatalogBuket extends Model {
	public function getFlowers($data = array()){
		$sql = "SELECT * FROM " . DB_PREFIX . "buketbase ";
		$sql .= "WHERE 1";

		if (!empty($data['filter_name'])) {
			$sql .= " AND name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getFlower($id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "buketbase WHERE id='" . (int)$id . "'");
		return $query->row;
	}

	public function getProductFlowers($product_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bb_products WHERE product_id='" . (int)$product_id . "'");
		return $query->rows;
	}

	public function getImage($id){
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "bb_images WHERE bid=". (int)$id);
		if(isset($query->row['image'])){
			return $query->row['image'];
		} else {
			return false;
		}
	}

// функция получения заменителей цветов
	public function getCross($id){
		$cross = array();

		$query = $this->db->query("SELECT cross_ids FROM " . DB_PREFIX . "bb_cross WHERE cross_ids LIKE '%i" . (int)$id . ",%'");

		if(!empty($query->row)){
			$cross_ids = substr($query->row['cross_ids'], 1);
			$cross_ids = substr($cross_ids, 0, -1);
			$cross = explode(",i", $cross_ids);
		}

		if(in_array($id, $cross)){
			unset($cross[array_search($id,$cross)]);
		} else {
			return array();
		}

		return $cross;
	}

	public function getColors($id){
		$colors = array();
		$query = $this->db->query("SELECT color_id FROM " . DB_PREFIX . "bb_colors WHERE bid = '" . (int)$id . "'");
		foreach ($query->rows as $key => $value) {
			$colors[] = $value['color_id'];
		}

		return $colors;
	}

	public function getProductColors($product_id){
		$colors = array();
		$flowers = $this->getProductFlowers($product_id);

		foreach ($flowers as $key => $value) {
			$_colors = $this->getColors($value['flower_id']);

			$colors = array_merge($colors, $_colors);
		}

		return $colors;
	}


	public function getTotal(){
		$query = $this->db->query("SELECT COUNT(DISTINCT id) AS total FROM " . DB_PREFIX . "buketbase WHERE 1");

		return $query->row['total'];
	}
}
