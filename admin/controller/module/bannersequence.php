<?php 
class ControllerModuleBannersequence extends Controller {
	private $error = array();
	
	public function install() { 
	  $this->load->model('bannersequence/slide');
       //$this->model_bannersequence_slide->createTable(); 
	}
	
	public function uninstall() { 
		$this->load->model('bannersequence/slide');
        //$this->model_bannersequence_slide->deleteTable();
    }
	
	public function index() {
		$this->load->language('module/bannersequence');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			if (!isset($this->request->get['module_id'])) {
				$this->model_extension_module->addModule('bannersequence', $this->request->post);
			} else {
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post);
			}
			

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_bannersequence_slide'] = $this->language->get('text_bannersequence_slide');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_limit'] = $this->language->get('entry_limit');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_banner'] = $this->language->get('entry_banner');
		$data['entry_store'] = $this->language->get('entry_store');
	
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['module_id'])) {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);			
		}

		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) {
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['banner'])) {
			$data['banner'] = $this->request->post['banner'];
		} elseif (!empty($module_info)) {
			$data['banner'] = $module_info['banner'];
		} else {
			$data['banner'] = 1;
		}
						
		

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = 200;
		}	
			
		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = 200;
		}		
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
		$data['link_to_module'] = $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'], 'SSL');
		$data['link_to_banner'] = $this->url->link('module/bannersequence/form', 'token=' . $this->session->data['token'], 'SSL');	
		
		$this->load->model('localisation/language');
		$this->load->model('bannersequence/slide');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		$data['bannersequences'] = $this->model_bannersequence_slide->getbannersequences();
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/bannersequence/config.tpl', $data));
	}
	
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/bannersequence')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		
		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}

		return !$this->error;
	}
 
	public function form() {
		$this->language->load('module/bannersequence');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bannersequence/slide');
		
		
		$this->getList();
	}

	public function insert() {
		$this->language->load('module/bannersequence');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bannersequence/slide');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_bannersequence_slide->addBannersequence($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('module/bannersequence');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bannersequence/slide');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
		
				//echo "<pre>"; print_r( $this->request->post); echo "</pre>"; die;
		
			$this->model_bannersequence_slide->editBannersequence($this->request->get['bannersequence_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->response->redirect($this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
 
	public function delete() { 

		$this->language->load('module/bannersequence');
 
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('bannersequence/slide');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $bannersequence_id) {
				$this->model_bannersequence_slide->deleteBannersequence($bannersequence_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		$data['text_list'] = $this->language->get('text_list');	
		$data['text_edit'] = $this->language->get('text_edit');	
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
			
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
		
		
		$data['insert'] = $this->url->link('module/bannersequence/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('module/bannersequence/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		 
		$data['bannersequences']= array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$banner_total = $this->model_bannersequence_slide->getTotalBannersequences();
		
		$results = $this->model_bannersequence_slide->getBannersequences($data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('module/bannersequence/update', 'token=' . $this->session->data['token'] . '&bannersequence_id=' . $result['bannersequence_id'] . $url, 'SSL')
			);

			$data['bannersequences'][] = array(
				'bannersequence_id' => $result['bannersequence_id'],
				'name'      => $result['name'],	
				'status'    => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),				
				'selected'  => isset($this->request->post['selected']) && in_array($result['bannersequence_id'], $this->request->post['selected']),				
				'action'    => $action
			);
		}


		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['column_name'] = $this->language->get('column_name');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');	

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_name'] = $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $banner_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();
		$data['results'] = sprintf($this->language->get('text_pagination'), ($banner_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($banner_total - $this->config->get('config_limit_admin'))) ? $banner_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $banner_total, ceil($banner_total / $this->config->get('config_limit_admin')));
		$data['sort'] = $sort;
		$data['order'] = $order;
	

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('module/bannersequence/bannersequence_list.tpl', $data));		
		
	}

	protected function getForm() {
	
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_image_manager'] = $this->language->get('text_image_manager');
 		$data['text_browse'] = $this->language->get('text_browse');
		$data['text_clear'] = $this->language->get('text_clear');			
		$data['text_list'] = $this->language->get('text_list');	
		$data['text_form'] = $this->language->get('text_form');	
				
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_auto'] = $this->language->get('entry_auto');
		$data['entry_delay'] = $this->language->get('entry_delay');
		$data['entry_hover'] = $this->language->get('entry_hover');
		$data['entry_nextback'] = $this->language->get('entry_nextback');
		$data['entry_contrl'] = $this->language->get('entry_contrl');
		$data['entry_type'] = $this->language->get('entry_type');
	
		$data['entry_title'] = $this->language->get('entry_title');
		$data['entry_subtitle'] = $this->language->get('entry_subtitle');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_image'] = $this->language->get('entry_image');		
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_store'] = $this->language->get('entry_store');
	
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_banner'] = $this->language->get('button_add_banner');
		$data['button_remove'] = $this->language->get('button_remove');
		
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');

		$data['entry_banner'] = $this->language->get('entry_banner');
		$data['entry_dimension'] = $this->language->get('entry_dimension'); 
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['tab_module'] = $this->language->get('tab_module');
		
		if (isset($this->request->post['bannersequence_module'])) {
			$modules = $this->request->post['bannersequence_module'];
		} elseif ($this->config->has('bannersequence_module')) {
			$modules = $this->config->get('bannersequence_module');
		} else {
			$modules = array();
		}

		$data['bannersequence_modules'] = array();
		
		foreach ($modules as $key => $module) {
			$data['bannersequence_modules'][] = array(
				'key'       => $key,
				//'banner_id' => $module['bannersequence_id'],
				'width'     => $module['width'],
				'height'    => $module['height']
			);
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

 		if (isset($this->error['bannersequence_image'])) {
			$data['error_bannersequence_image'] = $this->error['bannersequence_image'];
		} else {
			$data['error_bannersequence_image'] = array();
		}	
						
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
							
		if (!isset($this->request->get['bannersequence_id'])) { 
			$data['action'] = $this->url->link('module/bannersequence/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('module/bannersequence/update', 'token=' . $this->session->data['token'] . '&bannersequence_id=' . $this->request->get['bannersequence_id'] . $url, 'SSL');
		}
		
		$data['cancel'] = $this->url->link('module/bannersequence', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		if (isset($this->request->get['bannersequence_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$banner_info = $this->model_bannersequence_slide->getBannersequence($this->request->get['bannersequence_id']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($banner_info)) {
			$data['name'] = $banner_info['name'];
		} else {
			$data['name'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($banner_info)) {
			$data['status'] = $banner_info['status'];
		} else {
			$data['status'] = true;
		}
		
		if (isset($this->request->post['auto'])) {
			$data['auto'] = $this->request->post['auto'];
		} elseif (!empty($banner_info)) {
			$data['auto'] = $banner_info['auto'];
		} else {
			$data['auto'] = true;
		}
		
		if (isset($this->request->post['delay'])) {
			$data['delay'] = $this->request->post['delay'];
		} elseif (!empty($banner_info)) {
			$data['delay'] = $banner_info['delay'];
		} else {
			$data['delay'] = true;
		}
		
		if (isset($this->request->post['hover'])) {
			$data['hover'] = $this->request->post['hover'];
		} elseif (!empty($banner_info)) {
			$data['hover'] = $banner_info['hover'];
		} else {
			$data['hover'] = true;
		}
		
		if (isset($this->request->post['nextback'])) {
			$data['nextback'] = $this->request->post['nextback'];
		} elseif (!empty($banner_info)) {
			$data['nextback'] = $banner_info['nextback'];
		} else {
			$data['nextback'] = true;
		}
		
		if (isset($this->request->post['contrl'])) {
			$data['contrl'] = $this->request->post['contrl'];
		} elseif (!empty($banner_info)) {
			$data['contrl'] = $banner_info['contrl'];
		} else {
			$data['contrl'] = true;
		}

		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->load->model('tool/image');

		if (isset($this->request->post['bannersequence_image'])) {
			$bannersequence_images = $this->request->post['bannersequence_image'];
		} elseif (isset($this->request->get['bannersequence_id'])) {
		  
			$bannersequence_images = $this->model_bannersequence_slide->getBannersequenceImages($this->request->get['bannersequence_id']);	
		} else {
			$bannersequence_images = array();
		}
		
		$data['bannersequence_images'] = array();
	
		foreach ($bannersequence_images as $key =>  $bannersequence_image) {
			if ($bannersequence_image['image'] && file_exists(DIR_IMAGE . $bannersequence_image['image'])) {
				$image = $bannersequence_image['image'];
				
			} else {
				$image = 'no_image.jpg';
			}

			if ($bannersequence_image['image1'] && file_exists(DIR_IMAGE . $bannersequence_image['image1'])) {
				$image1 = $bannersequence_image['image1'];
				
			} else {
				$image1 = 'no_image.jpg';
			}			
			
			$data['bannersequence_images'][] = array(
				'key' => $key,
				'bannersequence_image_description' => $bannersequence_image['bannersequence_image_description'],
				'link'                     => $bannersequence_image['link'],
				'type'                     => $bannersequence_image['type'],
				'banner_store'             => $bannersequence_image['banner_store'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($image, 100, 100),
				'image1'                    => $image1,
				'thumb1'                    => $this->model_tool_image->resize($image1, 100, 100)
			);	
		} 
		

		$this->load->model('setting/store');
		
		$data['stores'] = $this->model_setting_store->getStores();
		$data['stores'][] = array('store_id'=>0,'name'=>'Default Store');
		$data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);		

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
				
		$this->response->setOutput($this->load->view('module/bannersequence/bannersequence_form.tpl', $data));
	}

	protected function validateForm() {
		
	
		if (!$this->user->hasPermission('modify', 'module/bannersequence')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}
		
		if (isset($this->request->post['bannersequence_image'])) {
			foreach ($this->request->post['bannersequence_image'] as $bannersequence_image_id => $bannersequence_image) {
			
				 if(isset($bannersequence_image['bannersequence_image_description'])) {
					foreach ($bannersequence_image['bannersequence_image_description'] as $language_id => $bannersequence_image_description) {
						if ((utf8_strlen($bannersequence_image_description['title']) < 2) || (utf8_strlen($bannersequence_image_description['title']) > 64)) {
							$this->error['bannersequence_image'][$bannersequence_image_id][$language_id] = $this->language->get('error_title'); 
						}					
					}
				}
			}	
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'module/bannersequence')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>