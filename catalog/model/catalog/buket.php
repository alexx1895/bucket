<?php
class ModelCatalogBuket extends Model {
	public function getFlowers($data = array()){
		$sql = "SELECT * FROM " . DB_PREFIX . "buketbase ";
		$sql .= "WHERE stock = 1";

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

	public function getOptions() {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE 1 AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = ". $product_option['option_id'] ." AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'option_value_id'         => $product_option_value['option_value_id'],
					'name'                    => $product_option_value['name'],
					'image'                   => $product_option_value['image'],
				);
			}

			$product_option_data[] = array(
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
			);
		}

		return $product_option_data;
	}

	public function getGroupsFlowers(){
		$groups_flowers = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "buket_groups WHERE 1 ");

		foreach ($query->rows as $key => $group) {
			$query_flowers = $this->db->query("SELECT * FROM " . DB_PREFIX . "buketbase WHERE group_id = '" . $group['id'] . "' AND stock = 1");

			foreach ($query_flowers->rows as $key => $value) {
				$groups_flowers[$group['name']][] = $value;
			}
			
		}

		return $groups_flowers;
	}

	public function getGroupImage($name){
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "buket_groups WHERE name = '" . $name . "' ");

		if(isset($query->row['image'])){
			return $query->row['image'];
		} else {
			return false;
		}
	}
}
