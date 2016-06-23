<?php
class ControllerExtensionBuketBase extends Controller {
	private $error = array();
	
	public function index() {

		$this->document->addStyle('/admin/view/stylesheet/buket.css');
		$this->load->language('extension/buketbase');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['action'] = $this->url->link('extension/buketbase', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');		

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		

		$data['token'] = $this->session->data['token'];

						
  		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/buketbase', 'token=' . $this->session->data['token'], 'SSL'),
   		);
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);

		$this->load->model('extension/buket');
		$this->load->model('extension/buket_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_extension_buket->edit($this->request->post);
		}

		$this->load->model('catalog/filter');
		$data['filters'] = $this->model_catalog_filter->getFilterDescriptions(5);

		$filter = array(
			'start'    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'    => $this->config->get('config_limit_admin')
			);

		$data['buket_groups'] = array();

		$groups = $this->model_extension_buket_group->getBuketGroups();

		foreach ($groups as $result) {
			$data['buket_groups'][] = array(
				'buket_group_id' => $result['id'],
				'name'              => $result['name'],
			);
		}

		$results = $this->model_extension_buket->getFlowers($filter);

		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 80, 80);

		foreach ($results as $key => $result) {
			
			$image = $this->model_extension_buket->getImage($result['id']);

			if($image){
				$thumb = $this->model_tool_image->resize($image, 80, 80);;
				$image = $image;
			} else {
				$thumb = $data['placeholder'];
				$image = 'no_image.png';
			}

			$_cross = $this->model_extension_buket->getCross($result['id']);
			$cross = array();

			foreach ($_cross as $id) {
				$c = $this->model_extension_buket->getFlower($id);

				if(empty($c))continue;

				$cross[] = array(
					'name' => $c['name'],
					'id' => $c['id'],
					);
			}

			$colors = $this->model_extension_buket->getColors($result['id']);

			$data['flowers'][] = array(
				'id' => $result['id'],
				'name' => $result['name'],
				'custom_name' => $result['custom_name'],
				'area' => $result['area'],
				'durability' => $result['durability'],
				'stock' => (int)$result['stock'],
				'price' => $result['price'],
				'image' => $image,
				'thumb' => $thumb,
				'cross' => $cross,
				'colors' => $colors,
				'group' => $result['group_id'],
				);
		}

		$total = $this->model_extension_buket->getTotal();

		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/buketbase', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('extension/buketbase.tpl', $data));
	}
	
	public function delete(){
		$this->load->model('extension/buket');

		$this->model_extension_buket->deleteFlower($this->request->get['id']);
		
		$this->response->redirect($this->url->link('extension/buketbase', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/buket');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_extension_buket->getFlowers($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'id' => $result['id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validateForm() {
		return !$this->error;
	}
}
?>