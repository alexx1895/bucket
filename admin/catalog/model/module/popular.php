<?php
class ModelModulePopular extends Model {

	public function getPopularByViwed($setting){
		$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC LIMIT " . (int)$setting['limit']);

		$product_data = array();

		foreach ($query->rows as $result) { 
			$product_data[] = $result['product_id'];
		}

		return $product_data;
	}


	public function getPopularByOrdered($setting){
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "order_product WHERE 1");

		$product_data = array();

		foreach ($query->rows as $result) { 		
			$product_data[] = $result['product_id'];
		}

		$product_data = array_count_values($product_data);

		arsort($product_data);
		//$product_data = array_flip($product_data);
		//$product_data = array_unique($product_data);


		return $product_data;
	}


}
?>