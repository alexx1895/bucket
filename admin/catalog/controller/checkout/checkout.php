<?php
class ControllerCheckoutCheckout extends Controller {
	private $error = array();
	public function index() {

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->response->redirect($this->url->link('checkout/cart'));
		}

		$data['isShare'] = (isset($this->session->data['share_discount'])) ? $this->session->data['share_discount'] : false;

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		$data['total_price'] = 0;

		foreach ($products as $product) {
			$product_total = 0;

			if(isset($product['special'])){
				$data['total_price'] += $product['special'] * $product['quantity'];
			} else {
				$data['total_price'] += $product['price'] * $product['quantity'];
			}
			

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$this->response->redirect($this->url->link('checkout/cart'));
			}
		}

		$this->load->language('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addStyle('catalog/view/theme/tt_pisces_flowers/stylesheet/bootstrap-slider.min.css');

		$this->document->addScript('catalog/view/javascript/bootstrap-slider.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		// Required by klarna
		if ($this->config->get('klarna_account') || $this->config->get('klarna_invoice')) {
			$this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		// $data['breadcrumbs'][] = array(
		// 	'text' => $this->language->get('text_cart'),
		// 	'href' => $this->url->link('checkout/cart')
		// );

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_cart'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_checkout_option'] = $this->language->get('text_checkout_option');
		$data['text_checkout_account'] = $this->language->get('text_checkout_account');
		$data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');
		$data['text_checkout_shipping_address'] = $this->language->get('text_checkout_shipping_address');
		$data['text_checkout_shipping_method'] = $this->language->get('text_checkout_shipping_method');
		$data['text_checkout_payment_method'] = $this->language->get('text_checkout_payment_method');
		$data['text_checkout_confirm'] = $this->language->get('text_checkout_confirm');

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		$data['logged'] = $this->customer->isLogged();

		if (isset($this->session->data['account'])) {
			$data['account'] = $this->session->data['account'];
		} else {
			$data['account'] = '';
		}

		$data['shipping_required'] = $this->cart->hasShipping();

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['content_block3'] = $this->load->controller('common/content_block3');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->getShipping();


		// Cart to checkout
		$products = $this->getProductsInCart();
		$data = array_merge($data, $products);

		$total = $this->getTotal();

		$data['payment_methods'] = $this->getPaymentMethods($total);

		$this->getPaymentHtml($total);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/checkout.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/checkout.tpl', $data));
		}
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function getProductsInCart(){
		if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {

			if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$data['error_warning'] = $this->language->get('error_stock');
			} elseif (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
				$data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
			} else {
				$data['attention'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['action'] = $this->url->link('checkout/cart/edit');

			if ($this->config->get('config_cart_weight')) {
				$data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			} else {
				$data['weight'] = '';
			}

			$this->load->model('tool/image');
			$this->load->model('tool/upload');

			$data['products'] = array();

			$products = $this->cart->getProducts();

			foreach ($products as $product) {
				$product_total = 0;

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$_flowers = $product['flowers'];
				foreach ($_flowers as $k => $flower) {
					$product['flowers'][$k] = $this->getFlowerName($flower);
				}

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				}

				$recurring = '';

				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year'),
					);

					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}

					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax'))), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}

				$data['products'][] = array(
					'key'       => $product['key'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'model'     => $product['model'],
					'flowers'   => $product['flowers'],
					'option'    => $option_data,
					'recurring' => $recurring,
					'quantity'  => $product['quantity'],
					'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'     => $price,
					'total'     => $total,
					'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			// Gift Voucher
			$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}

			// Totals
			$this->load->model('extension/extension');

			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);

						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}

				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}

			$data['totals'] = array();

			foreach ($total_data as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'])
				);
			}

		}

		return $data;
	}


	private function getPaymentMethods($total = 0) {
		$payment_address = array('country_id' => $this->config->get('config_country_id'), 'zone_id' => $this->config->get('config_zone_id'));
		if($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$this->load->model('account/address');
			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
		}

		$method_data = array();

		$this->load->model('extension/extension');

		$results = $this->model_extension_extension->getExtensions('payment');

		foreach($results as $result) {
			if($this->config->get($result['code'] . '_status')) {
				$this->load->model('payment/' . $result['code']);

				$method = $this->{'model_payment_' . $result['code']}->getMethod($payment_address, $total);

				if($method) {
					$method_data[$result['code']] = $method;
				}
			}
		}

		$sort_order = array();

		foreach($method_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $method_data);

		return $method_data;
	}

	private function getTotal() {
		$total_data = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();
		$sort_order = array();

		$this->load->model('extension/extension');

		$results = $this->model_extension_extension->getExtensions('total');
		foreach($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}
		array_multisort($sort_order, SORT_ASC, $results);

		foreach($results as $result) {
			if($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);

				$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
			}
		}

		$this->load->model('total/delivery');
		$this->model_total_delivery->getTotal($total_data, $total, $taxes);

		// $this->load->model('total/share');
		// $this->model_total_share->getTotal($total_data, $total, $taxes);

		$sort_order = array();
		foreach($total_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}
		array_multisort($sort_order, SORT_ASC, $total_data);
		return array('total' => $total, 'total_data' => $total_data);
	}

	public function doPayment(){

		$json = array();
		$json['post'] = $this->request->post;
		$json['order_id'] = $this->saveOrder();

		$payment_code = $this->request->post['payment_method'];
		if(isset($payment_code)) {
			$this->session->data['payment_method'] = $this->session->data['payment_methods'][$payment_code]['title'];
			$this->session->data['payment_code'] = $payment_code;
			$json['payment'] = $this->load->controller('payment/' . $payment_code);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function getPaymentHtml($total) {

		$payment_template = new Template();

		$method_data = $this->getPaymentMethods($total);
		$this->session->data['payment_methods'] = $method_data;

		if(isset($this->session->data['payment_methods']) && count($this->session->data['payment_methods']) > 0) {
			$payment_template->data['payment_methods'] = $this->session->data['payment_methods'];


			$payment_set = isset($this->session->data['payment_code']) && isset($this->session->data['payment_method']);
			if(!$payment_set || !in_array($this->session->data['payment_code'], array_keys($this->session->data['payment_methods']))) {
				$method_keys = array_keys($this->session->data['payment_methods']);
				$first_method = array_shift($method_keys);
				$payment_method = $this->session->data['payment_methods'][$first_method];

				$this->session->data['payment_code'] = $first_method;
				$this->session->data['payment_method'] = $payment_method['title'];
			}

			$payment_template->data['payment_code'] = $this->session->data['payment_code'];
			$payment_template->data['payment'] = $this->load->controller('payment/' . $payment_template->data['payment_code']);
		} else {
			$payment_template->data['payment_methods'] = array();
			$payment_template->data['payment_code'] = '';
			$payment_template->data['payment'] = '';
		}

		$payment_template->data['text_payment_method'] = $this->language->get('text_payment_method');
		$template_path = 'default/template/checkout/payment_data.tpl';
		if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/payment_data.tpl')) {
			$template_path = $this->config->get('config_template') . '/template/checkout/payment_data.tpl';
		}
		return $payment_template->fetch($template_path);
	}

	public function saveOrder(){


		if($this->validate()) {

			$product_data = $this->getProductsInCart();

			$_total = $this->getTotal();
			$total_data = $_total['total_data'];

			$total = $_total['total'];

			if(isset($this->request->post['shipping_method'])) {
				$shipping = explode('.', $this->request->post['shipping_method']);
				$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
			} else {
				$this->session->data['shipping_method'] = $this->session->data['shipping_methods']['flat']['quote']['flat'];
			}

			$data = array();

			$data['check'] = true;

			$data['comment'] = '';

			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');

			if($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');
			} else {
				$data['store_url'] = HTTP_SERVER;
			}
			$data['customer_id'] = 0;
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');

			if($this->customer->isLogged()) {
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getCustomerGroupId();
			}

			$data['firstname'] = $this->request->post['firstname'];
			$data['lastname'] = '';
			$data['email'] = '';
			$data['telephone'] = $this->request->post['telephone'];
			$data['fax'] = '';

			if(isset($this->request->post['comment'])){
				$data['comment'] = $this->request->post['comment'] ;
			}
			

			if(isset($this->request->post['email']) && isset($this->request->post['email'])){
				$data['email'] = $this->request->post['email'];
				if(isset($this->request->post['wantspam'])){
					$this->addClientMail($data['email']);
				}
			} 

			$surprice = 0;

			if(!isset($this->request->post['hacc'])){
				$namerec = $this->request->post['namerec'];
				$telephonerec = $this->request->post['telephonerec'];
				if(isset($this->request->post['surprice'])){
					$surprice = 1;
				}
			}


			$data['addres'] = $this->request->post['addres'];
			if(isset($this->request->post['ismcad'])){
				$ismcad = 1;
			} else {
				$ismcad = 0;
			}

			$manager = "";

			$d1 = strtotime("+1 day");
			$d2 = strtotime("+2 day");

			if(isset($this->request->post['when_del'])){
				switch ($this->request->post['when_del']) {
					case '1':
						$data['date'] = date("Y-m-d");
						$manager .= "Срочная доставка";
						break;
					case '2':
						$data['date'] = date("Y-m-d", $d1);
						break;
					case '3':
						$data['date'] = false;
						break;
					case '4':
						$data['date'] = date("Y-m-d", $d2);
						break;
				}
			}

			$time_range = $this->request->post['time_range'];

			if($time_range){
				$data['deliveryTime'] = "с ".$time_range. " по " . " 23:00";
			} else {
				$data['deliveryTime'] = false;
			}

			//$comment.= $when;

			if(!isset($this->request->post['hacc'])){
				$manager.= "\n Получать будет:". $namerec ." ". $telephonerec;
			}
			if($surprice){
				$manager.= "\n Это сюрприз! Звонить только в крайнем случае";
			}
			if($ismcad){
				$manager.= "\n Это в пределах МКАД";
			} else {
				$manager.= "\n Это за пределами МКАД";
			}



			$data['shipping_code'] = 'flat.flat';

			$data['payment_firstname'] = '';
			$data['payment_lastname'] = '';
			$data['payment_address_1'] = '';
			$data['shipping_address_1'] = $data['addres'];

			$this->load->model('localisation/country');			
			$country_info = $this->model_localisation_country->getCountry($this->config->get('config_country_id'));
			
			$country_name = "";
			if ($country_info) {
				$country_name = $country_info['name'];
			}

			$data['payment_city'] = '';
			$data['payment_country'] = $country_name;
			$data['payment_country_id'] = '';
			$data['shipping_city'] = '';
			$data['shipping_country'] = $country_name;
			$data['shipping_country_id'] = 176;
			$data['payment_postcode'] = '';
			$data['shipping_postcode'] = '';


			$data['payment_company'] = "";
			$data['shipping_company'] = "";
			$data['payment_address_2'] = "";
			$data['payment_zone'] = "";
			$data['payment_zone_id'] = "";
			$data['payment_address_format'] = "";

			$data['shipping_firstname'] = $this->request->post['firstname'];
			$data['shipping_lastname'] = '';
			$data['shipping_address_2'] = "";
			$data['shipping_zone'] = "";
			$data['shipping_zone_id'] = "";

			//$data['reward'] = $this->cart->getTotalRewardPoints();

			if(isset($this->session->data['shipping_method']['title'])) {
				$data['shipping_method'] = $this->session->data['shipping_method']['title'];
			} else {
				$data['shipping_method'] = '';
			}
			$data['payment_method'] = $this->session->data['payment_method'];

			$data['shipping_address_format'] = '{firstname} {lastname} {address_1}';

			$data['products'] = $this->getProductData();


			foreach ($data['products'] as $product) {
				$options = "\n";
				$tmp = array();

				if(!empty($product['option'])){
					$options .= "\n Состав " .$product['name']. " : \n";
					foreach ($product['option'] as $key => $value) {
						if(!in_array($value['name'], $tmp)){
							$tmp[] = $value['name'];
							$name = ' ' . $value['name'] . " - ";
						} else {
							$name = ', ';
						}
						$options .= $name . $value['value'];
					}

					$manager.= $options;
				}

				$flowers = "\n Цветы:";
				foreach ($product['flowers'] as $flower) {
					$flowers .= $this->getFlowerName($flower) . " - ".$product['f_quantity'][$flower][0]." шт. \n";
				}
			}

			$manager .= $flowers;

			if(isset($this->session->data['comp_comments'])){
				foreach ($this->session->data['comp_comments'] as $cc) {
					$manager .= $cc;
				}
			}


			$data['manager'] = $manager;

			$data['totals'] = $total_data;
			$data['total'] = $total;




			if (isset($this->request->cookie['tracking'])) {
				$data['tracking'] = $this->request->cookie['tracking'];

				$subtotal = $this->cart->getSubTotal();

				// Affiliate
				$this->load->model('affiliate/affiliate');

				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

				if ($affiliate_info) {
					$data['affiliate_id'] = $affiliate_info['affiliate_id'];
					$data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
				} else {
					$data['affiliate_id'] = 0;
					$data['commission'] = 0;
				}

				// Marketing
				$this->load->model('checkout/marketing');

				$marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

				if ($marketing_info) {
					$data['marketing_id'] = $marketing_info['marketing_id'];
				} else {
					$data['marketing_id'] = 0;
				}
			} else {
				$data['affiliate_id'] = 0;
				$data['commission'] = 0;
				$data['marketing_id'] = 0;
				$data['tracking'] = '';
			}

			$data['language_id'] = $this->config->get('config_language_id');
			$data['currency_id'] = $this->currency->getId();
			$data['currency_code'] = $this->currency->getCode();
			$data['currency_value'] = $this->currency->getValue($this->currency->getCode());
			$data['ip'] = $this->request->server['REMOTE_ADDR'];

			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
			} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
			} else {
				$data['forwarded_ip'] = '';
			}

			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
			} else {
				$data['user_agent'] = '';
			}

			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
			} else {
				$data['accept_language'] = '';
			}

			$data['payment_code'] = $this->request->post['payment_method'];

			$this->load->model('checkout/order');

			$order_id = $this->model_checkout_order->addOrder($data);
		
			//return false;
			$client = array();
			$client['telephone'] = $this->request->post['telephone'];
			$client['firstname'] = $this->request->post['firstname'];
			$client['email'] = $this->request->post['email'];

			$this->load->model('account/customer');
			$this->model_account_customer->addClient($client);

			$this->session->data['telephone'] = $this->request->post['telephone'];

			$this->session->data['order_id'] = $order_id;
			$this->session->data['last_order_id'] = $order_id;

			$json["status"] = "success";

			$this->response->setOutput(json_encode($json));
			return $order_id;
		}
	}

	private function getProductData(){


			$products = array();

			foreach ($this->cart->getProducts() as $product) {

				$option_data = array();

				foreach ($product['option'] as $option) {
					$option_data[] = array(
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'option_id'               => $option['option_id'],
						'option_value_id'         => $option['option_value_id'],
						'name'                    => $option['name'],
						'value'                   => $option['value'],
						'type'                    => $option['type'],
					);
				}

				$products[] = array(
					'product_id' => $product['product_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'download'   => $product['download'],
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
					'reward'     => $product['reward'],
					'flowers'    => $product['flowers'],
					'f_quantity'    => $product['f_quantity'],
				);
			}
		return $products;
	}

	public function updateDelivery(){

		$json = array();

		$this->load->model('account/customer');

		$time = $this->request->post['time_range'];
		$price = $this->request->post['total_price'];
		$cost = 0;
		$bad = false;

		
		if(isset($this->request->post['telephone'])&& $this->request->post['telephone']!=''){
			$this->checkDiscount($this->request->post['telephone']);
			$bad = $this->model_account_customer->checkIsBad(trim($this->request->post['telephone']));
		}

		if($time < 5){
			if($price > 3000){
				$cost = 350;
			} else {
				$cost = 200;
			}
		}

		$this->session->data['delivery_cost'] = $cost;

		$json['isBad'] = $bad;

		$json['total'] = $this->getTotal();
		$json['cost'] = $cost;
		$json['isShare'] = (isset($this->session->data['share_discount'])) ? $this->session->data['share_discount'] : false;
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function setDiscount(){
		$json = array();
		if(isset($this->request->post['telephone'])){
			$this->load->model('account/customer');
			$this->model_account_customer->addShareDiscount(trim($this->request->post['telephone']));
			$json['success'] = true;
		} else {
			$json['success'] = false;
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function checkDiscount($telephone){

		if($telephone!=''){
			$this->load->model('account/customer');
			$discount = $this->model_account_customer->getShareDiscount(trim($this->request->post['telephone']));
			if($discount){
				$this->session->data['share_discount'] = true;
			} 
		} 


	}

	public function addClientMail($mail = ''){

		$this->load->model('account/customer');

		if($mail != ''){
			$this->model_account_customer->addClientMail(trim($mail));
			return true;
		}

		$json = array();
		if(isset($this->request->post['mail'])){
			$this->model_account_customer->addClientMail(trim($this->request->post['mail']));
			$json['success'] = true;
		} else {
			$json['success'] = false;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function getShipping(){

			$quote_data = array();

			$this->load->model('extension/extension');

		$shipping_address = array('country_id' => $this->config->get('config_country_id'), 'zone_id' => $this->config->get('config_zone_id'));
		if($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {
			$this->load->model('account/address');

			$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);
		}

			$results = $this->model_extension_extension->getExtensions('shipping');

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);

					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address);

					if ($quote) {
						$quote_data[$result['code']] = array(
							'title'      => $quote['title'],
							'quote'      => $quote['quote'],
							'sort_order' => $quote['sort_order'],
							'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($quote_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $quote_data);

			$this->session->data['shipping_methods'] = $quote_data;
	}

	private function getFlowerName($flower_id){
		$this->load->model('catalog/buket');
		$flower = $this->model_catalog_buket->getFlower($flower_id);

		return $flower['name'];
	}

	private function validate() {

		if((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 64)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_teletelephone');
		}
		
		if(!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}