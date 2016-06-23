<?php
class ModelExtensionBuket extends Model {
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

	public function updateProductFlowers($id, $data, $fquantity = array()){
		
		if(!empty($data)){

			$this->db->query("DELETE FROM " . DB_PREFIX . "bb_products WHERE product_id = '" . (int)$id . "'");

			foreach ($data as $key => $bid) {

				$quantity = isset($fquantity[$bid][0])?$fquantity[$bid][0]:0;

				$this->db->query("INSERT INTO " . DB_PREFIX . "bb_products SET product_id = '" . (int)$id . "', flower_id = '". (int)$bid . "', quantity = '" . $quantity . "'");
			}
		}
	}

	public function getImage($id){
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "bb_images WHERE bid=". (int)$id);
		if(isset($query->row['image'])){
			return $query->row['image'];
		} else {
			return false;
		}
	}

	public function edit($data){

		$ids = array();

		$query = $this->db->query("SELECT id FROM " . DB_PREFIX . "buketbase WHERE 1");
		foreach ($query->rows as $row) {
			$ids[] = $row['id'];
		}

		foreach ($data['b_item'] as $key => $row) {

			if(!in_array($key, $ids)){
				$this->add($row);
				continue;
			}

			if(isset($row['stock']) ){
				$stock = 1;
			} else {
				$stock = 0;
			}

			if(isset($row['cross']) ){
				$cross = $row['cross'];
				$cross[] = $key;
				$this->updateCross($cross);
			} 

			if(isset($row['colors']) ){
				$colors = $row['colors'];
				$this->updateColors($key, $colors);
			} 

			if($row['image']){
				 $this->db->query("UPDATE " . DB_PREFIX . "bb_images SET image = '" . $this->db->escape($row['image']) . "' WHERE bid = ". (int)$key);
			}

			 $this->db->query("UPDATE " . DB_PREFIX . "buketbase SET name = '" . $this->db->escape($row['name']) . "', custom_name = '" . $this->db->escape($row['customname']) . "', durability = '" . $this->db->escape($row['durability']) . "', area = '" . $this->db->escape($row['area']) . "', stock = '" . $stock . "', price = '" . $this->db->escape($row['price']) . "', group_id = '" . $this->db->escape($row['group']) . "' WHERE id=". (int)$key);
		}

		if(isset($data['remove_cross']) && $data['remove_cross'] != ''){
			$remove_cross = explode(",", $data['remove_cross']);
			$this->deleteCross($remove_cross);
		}
	}

	private function add($data){
			if(isset($data['stock']) ){
				$stock = 1;
			} else {
				$stock = 0;
			}

			
			if(empty($data['name'])||!isset($data['name'])){
				return false;
			}

			 $this->db->query("INSERT INTO " . DB_PREFIX . "buketbase SET name = '" . $this->db->escape($data['name']) . "', custom_name = '" . $this->db->escape($data['customname']) . "', durability = '" . $this->db->escape($data['durability']) . "', area = '" . $this->db->escape($data['area']) . "', stock = '" . $stock . "', price = '" . $this->db->escape($data['price']) . "', group_id = '" . $this->db->escape($data['group']) . "' ");

			 $id = $this->db->getLastId();

			if($data['image']){
				 $this->db->query("INSERT INTO " . DB_PREFIX . "bb_images SET image = '" . $this->db->escape($data['image']) . "', bid = '". (int)$id . "'");
			}

			if(isset($data['cross']) ){
				$cross = $data['cross'];
				$cross[] = $id;
				$this->updateCross($cross);
			} 

			if(isset($data['colors']) ){
				$colors = $data['colors'];
				$this->updateColors($id, $colors);
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

	public function updateCross($data = array()){

		if(count($data)<2) return;

		$has_id = 0;

		if(!empty($data)) {
			// если цветка нет в кросах ищем запись среди прикрепленных кроссов
			foreach ($data as $k => $bid) {
				$cross = $this->getCross($bid);
				if(!empty($cross)){
					$has_id = $bid;
					break;
				}
			}
			if($has_id > 0){
				$this->updateRecordCross($has_id, $data);
			} else {
				$this->addRecordCross($data);
			}
		}

	}

	private function updateRecordCross($id, $data){;
		$cross = array();
		$cross_ids_str = "";
		$_data = $data;

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bb_cross WHERE cross_ids LIKE '%i" . $id . ",%'");

		if(!empty($query->row)){
			$cross_ids_str = $query->row['cross_ids'];
			$cross_ids = substr($query->row['cross_ids'], 1);
			$cross_ids = substr($cross_ids, 0, -1);
			$cross = explode(",i", $cross_ids);
		}

		if(in_array($id, $cross)){
			// удаляем все совпашие id из $_data чтоб в нем остались только новые id
			foreach ($data as $bid) {
				if(in_array($bid, $cross)){
					unset($_data[array_search($bid,$_data)]);
				}
			}

			if(!empty($_data)){
				$cross_string = implode(",i", $_data);
				$cross_string = "i".$cross_string.",";

				$cross_ids_str .= $cross_string;

				$c_id = $query->row['id'];
				$this->db->query("UPDATE " . DB_PREFIX . "bb_cross SET cross_ids = '" . $cross_ids_str . "' WHERE id = '" . $c_id . "'");
			}
		}
	}

	private function addRecordCross($data){
		if(!empty($data)){
			$cross_string = implode(",i", $data);
			$cross_string = "i".$cross_string.",";

			$this->db->query("INSERT INTO " . DB_PREFIX . "bb_cross SET cross_ids = '" . $cross_string . "' ");
		}
	}

	private function deleteCross($data){

		if(!empty($data)) {
			foreach ($data as $k => $bid) {
				$cross = $this->getCross($bid);
				if(!empty($cross)){
					$this->deleteRecordCross($bid, $data);
				}
			}
		}

	}

	private function deleteRecordCross($id, $data){

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bb_cross WHERE cross_ids LIKE '%i" . $id . ",%'");

		if(!empty($query->row)){
			$cross_ids = substr($query->row['cross_ids'], 1);
			$cross_ids = substr($cross_ids, 0, -1);
			$cross = explode(",i", $cross_ids);

			$_cross = $cross;

			foreach ($cross as $bid) {
				if(in_array($bid, $data)){
					if(in_array($bid, $_cross)){
						unset($_cross[array_search($bid,$_cross)]);
					}
				}
			}



			$cross_string = implode(",i", $_cross);
			$cross_string = "i".$cross_string.",";

			$c_id = $query->row['id'];

			if(count($_cross)<2){
				$this->db->query("DELETE FROM " . DB_PREFIX . "bb_cross WHERE id = '" . $c_id . "' ");
			} else {
				$this->db->query("UPDATE " . DB_PREFIX . "bb_cross SET cross_ids = '" . $cross_string . "' WHERE id = '" . $c_id . "'");
			}

		}
	}

	private function updateColors($id, $data){

			$this->db->query("DELETE FROM " . DB_PREFIX . "bb_colors WHERE bid = '" . (int)$id . "'");

			foreach ($data as $key => $color_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "bb_colors SET bid = '" . (int)$id . "', color_id = '". (int)$color_id . "'");
			}
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

	public function deleteFlower($id){
		$del_cross = array($id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "buketbase WHERE id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "bb_colors WHERE bid = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "bb_products WHERE product_id = '" . (int)$id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "bb_images WHERE bid = '" . (int)$id . "'");

		$this->deleteCross($del_cross);
	}

	public function getTotal(){
		$query = $this->db->query("SELECT COUNT(DISTINCT id) AS total FROM " . DB_PREFIX . "buketbase WHERE 1");

		return $query->row['total'];
	}
}