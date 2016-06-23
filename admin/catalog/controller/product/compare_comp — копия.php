<?php
class ControllerProductCompareComp extends Controller {
	public function index() {
		$this->load->language('product/compare_comp');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');



		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('product/compare_comp')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$this->load->model('catalog/buket');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$data['options'] = array();
		
			foreach ($this->model_catalog_product->getProductOptions(81) as $option) {
				$product_option_value_data = array();

				foreach ($option['product_option_value'] as $option_value) {
					if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
						if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
							$price = $this->currency->format($this->tax->calculate($option_value['price'], 0, $this->config->get('config_tax') ? 'P' : false));
						} else {
							$price = false;
						}

						$product_option_value_data[] = array(
							'product_option_value_id' => $option_value['product_option_value_id'],
							'option_value_id'         => $option_value['option_value_id'],
							'name'                    => $option_value['name'],
							'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
							'price'                   => $price,
							'price_prefix'            => $option_value['price_prefix']
						);
					}
				}

				$data['options'][] = array(
					'product_option_id'    => $option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $option['option_id'],
					'name'                 => $option['name'],
					'type'                 => $option['type'],
					'value'                => $option['value'],
					'required'             => $option['required']
				);
			}

		$data['flowers'] = array();
		$data['groups_images'] = array();

		foreach ($this->model_catalog_buket->getGroupsFlowers() as $key => $flower){
			$data['groups_images'][$key] =  $this->model_tool_image->resize($this->model_catalog_buket->getGroupImage($key),80, 80);
			foreach ($flower as $value) {
				$data['flowers'][$key][] = array(
					'name' => $value['custom_name'],
					'price' => $value['price'],
					'id' => $value['id'],
					);
			}
		}

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/compare_comp.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/compare_comp.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/product/compare_comp.tpl', $data));
		}
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/buket');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_buket->getFlowers($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'id' => $result['id'],
					'name'        => strip_tags(html_entity_decode($result['custom_name'], ENT_QUOTES, 'UTF-8')),
					'price'       => $result['price'],
				);
			}
		}

		if (isset($this->request->get['filter_option'])) {

		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}