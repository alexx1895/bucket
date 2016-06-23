<?php 
class ControllerModuleProductsFromCat extends Controller {

	
	public function index($setting) {

		$this->language->load('module/products_from_cat');
		
		$this->load->model('catalog/product');

		$this->load->model('tool/image');
		

		$this->load->model('module/products_from_cat');

		$data['heading_title'] = $this->language->get('heading_title_personal');
		
		$limit = html_entity_decode($setting['limit']);

		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['products'] = array();
		
		$results = $this->model_module_products_from_cat->getProducts($setting);

		foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}
							
			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => (int)$rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}
//print_r($data['products']);
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/products_from_cat.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/products_from_cat.tpl', $data);
		} else {
			return $this->load->view('default/template/module/filter.tpl', $data);
		}
		//return $this->load->view('module/products_from_cat.tpl', $data);

	}
}
?>