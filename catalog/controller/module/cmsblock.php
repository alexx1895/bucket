<?php  
class ControllerModuleCmsblock extends Controller {
	public function index($setting) { 
		
		$this->load->model('cmsblock/info');
		$this->load->model('tool/image');
	///	echo "<pre>"; print_r($setting); echo "</pre>"; 
		
		
		$data['cmsblocks'] = array();

		
		if (isset($setting['cmsblock'])) {
			$results = $this->model_cmsblock_info->getcmsblocks();
			$store_id  = $this->config->get('config_store_id'); 
			$banner_store = array();
			foreach ($results as $result) {
				  if(isset($result['banner_store'])) {
					$banner_store = explode(',',$result['banner_store']);
				  }
				  
				  if(in_array($store_id,$banner_store)) {
					if($result['cmsblock_id'] == $setting['cmsblock']) {
						$data['cmsblocks'][] = array(
							'title' => $result['title'],
							'link'  => $result['link'],
							'description'  => $result['description'],

						);
					}
				  }	
			}
		}

		if(!$data['cmsblocks']) return;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cmsblock.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/cmsblock.tpl', $data);
		} else {
			return $this->load->view('default/template/module/cmsblock.tpl', $data);
		}
						
	}
}
?>