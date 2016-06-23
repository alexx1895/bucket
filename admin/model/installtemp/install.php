<?php
class ModelInstalltempInstall extends Model {

	public function settup() {
		$this->setLayout(); 
		$this->createTableSequence();
		$this->createTableCms();
		$this-> settupSequence(); 
		$this->settupCmsblock(); 
	}
	
	public function setLayout() {
		    $this->db->query("TRUNCATE  TABLE " . DB_PREFIX . "module");
			$this->load->model('extension/extension');
			$this->load->model('setting/setting');	
			$this->load->model('design/layout');
			$this->load->model('user/user_group');
		
			$exts = array(
				0 => 'bannersequence',
				1 => 'cmsblock',
				2 => 'hozmegamenu',
				3 => 'octabproductslider',
				4 => 'special',
				5 => 'ocnewproductslider',
				6 => 'themeoption',
				7 => 'carousel',
				8 => 'newslettersubscribe',
				9 => 'testimonial',
			); 
			
			foreach($exts as $ext) {
				$this->model_extension_extension->install('module', $ext);
				$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'module/' . $ext);
				$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'module/' . $ext);
			}
			
			
			
			//set config for banner sequence 
			$configs = array(
				'bannersequence' => Array(
							'name' => 'Slider Bannersequence',
							'status' => 1,
							'banner' => 14,
							'width' => 1920,
							'height' => 696,
						),
				 'cmsblock' => array(		
					0 => array(
							'name' => 'Banner Left',
							'status' => 1,
							'cmsblock' => 2,
					 ),
					1 => array(
							'name' => 'Banner Static',
							'status' => 1,
							'cmsblock' => 1,
					),
					2 => array(
							'name' => 'Footer Static Top',
							'status' =>1,
							'cmsblock' => 3,
					)
				  ),
				
				  'hozmegamenu' => Array(
					'name' => 'Menu',
					'status' => 1,
					'hhome' => 1,
					'hdepth' => 4,
					'hlevel' => 4,
					'hactive' => 'CAT20,CAT18,CAT25,CAT17,CAT24,CAT33,CAT34'
				),
				'octabproductslider' => array(
						'name' => 'Tab Product',
						'status' => 1,
						'limit' => 8,
						'width' => 300,
						'height' => 300,
					    'product' => Array(
								0 => 42,
								1 => 47,
								2 => 28,
								3 => 41
							)
				),
				'special' => array(
						'name' => 'Oc Special',
						'status' => 1,
						'limit' => 3,
						'width' => 78,
						'height' => 78,
						 'product' => Array(
								0 => 42,
								1 => 47,
								2 => 28,
								3 => 41
							)
				),
				'ocnewproductslider' => array(
						'name' => 'Newproduct Slider',
						'status' => 1,
						'limit' => 12,
						'item' => 4,
						'speed' => 10000,
						'autoplay' => 0,
						'rows' => 1,
						'showprice' => 1,
						'showdes' => 0,
						'showaddtocart' => 1,
						'shownextback' => 1,
						'shownav' => 0,
						'width' => 300,
						'height' => 300,
				),
				'themeoption' => array(
						'name' => 'Color',
						'status' => 1,
						'colorlink' => '#ffffff',
						'colorbg' => '#ffffff',
						'colormain' => '#ffffff',
						'color_default' => 'red',
						'hide_option' => 1,
				),
				'carousel' => array(
						'name' => 'Corasouse',
						'status' => 1,
						'banner_id' => 8,
						'width' => 78,
						'height' => 78
					
				),
				'newslettersubscribe' => array(
					'status' => 1,
					'newslettersubscribe_unsubscribe' => 1,
					'newslettersubscribe_mail_status' => 1,
					'newslettersubscribe_thickbox' => 1,
					'newslettersubscribe_registered' => 1,
					'name' => 'Newsletter'
				),
				'newslettersubscribe' => array(
					'status' => 1,
				)
				  
			 
			);
			
			//set layout 
			$layout = Array(
					'name' => 'Home',
					'layout_route' => Array
						(
							0 => Array
								(
									'store_id' => 0,
									'route' => 'common/home'
								)
						),
					'layout_module' => Array
						(
							0 => Array
								(
									'code' => 'cmsblock.13',
									'position' => 'content_block3',
									'sort_order' => 3
								),
							1 => Array
							  (
								'code' => 'cmsblock.3',
								'position' => 'content_block',
								'sort_order' => 3
							  ),
							2 => Array
								(
									'code' => 'bannersequence.1',
									'position' => 'content_block',
									'sort_order' => 2
								),
							3 => Array
								(
									'code' => 'hozmegamenu.5',
									'position' => 'content_block',
									'sort_order' => 1
								),
							4 => Array
								(
									'code' => 'octabproductslider.12',
									'position' => 'content_top',
									'sort_order' => 1
								),
							5=> Array
								(
									'code' => 'ocnewproductslider.8',
									'position' => 'content_block2',
									'sort_order' => 1
								),
							6 => Array
								(
									'code' => 'themeoption.9',
									'position' => 'content_top',
									'sort_order' => 1
								),	
							7 => Array
								(
									'code' => 'carousel.10',
									'position' => 'content_block3',
									'sort_order' => 1
								),
							8 => Array
								(
									'code' => 'testimonial',
									'position' => 'content_block3',
									'sort_order' => 2
								),								
									
								
						
						)
				);

			foreach($configs as $module => $config) {
				if($module == 'cmsblock') {
					foreach($config as $cms) {
						$this->model_extension_module->addModule($module, $cms);				
					}
				} else {
					$this->model_extension_module->addModule($module, $config);				
				}
			}
			$this->model_design_layout->editLayout(1, $layout);
		
			$config_template = "config_template";
			$template = 'tt_alexis'; 
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $template . "' WHERE `key` = '" . $config_template . "' ");
	}
	
	public function createTableCms(){
			$sql = " SHOW TABLES LIKE '".DB_PREFIX."cmsblock'";
			$query = $this->db->query( $sql );
			if( count($query->rows) >0 ){
				return true;
			}
			$sql = array();
			$sql[] = "
					CREATE TABLE IF NOT EXISTS `".DB_PREFIX."cmsblock` (
							  `cmsblock_id` int(11) NOT NULL AUTO_INCREMENT,
							  `status` tinyint(1) NOT NULL,
							  `sort_order` tinyint(1) DEFAULT NULL,
							  `identify` varchar(255) DEFAULT NULL,
							  `link` varchar(255) DEFAULT NULL,
							  `type` tinyint(1) DEFAULT NULL,
							  `banner_store` varchar(100) DEFAULT 0,
						  PRIMARY KEY (`cmsblock_id`)
						) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
			";

			$sql[] = "
					CREATE TABLE IF NOT EXISTS `".DB_PREFIX."cmsblock_description` (
					      `cmsblock_des_id` int(11) NOT NULL AUTO_INCREMENT,
						  `language_id` int(11) NOT NULL,
						  `cmsblock_id` int(11) NOT NULL,
						  `title` varchar(64) NOT NULL,
						  `sub_title` varchar(64) DEFAULT NULL,
						  `description` text,
					  PRIMARY KEY (`cmsblock_des_id`,`language_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
			
			
			$sql[] = " 
				CREATE TABLE IF NOT EXISTS `".DB_PREFIX."cmsblock_to_store` (
				  `cmsblock_id` int(11) DEFAULT NULL,
				  `store_id` tinyint(4) DEFAULT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=latin1;
			";
			
			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
			return true;
			
	}
	
	public function createTableSequence(){
			$sql = " SHOW TABLES LIKE '".DB_PREFIX."bannersequence'";
			$query = $this->db->query( $sql );
			if( count($query->rows) >0 ){
				return true;
			}
			$sql = array();
			$sql[] = "
					CREATE TABLE IF NOT EXISTS `".DB_PREFIX."bannersequence` (
						  `bannersequence_id` int(11) NOT NULL AUTO_INCREMENT,
						  `name` varchar(64) NOT NULL,
						  `status` tinyint(1) NOT NULL,
						  `auto` tinyint(1) DEFAULT NULL,
						  `delay` int(11) DEFAULT NULL,
						  `hover` tinyint(1) DEFAULT NULL,
						  `nextback` tinyint(1) DEFAULT NULL,
						  `contrl` tinyint(1) DEFAULT NULL,
						  PRIMARY KEY (`bannersequence_id`)
						) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
			";
			$sql[] = "
				CREATE TABLE IF NOT EXISTS `".DB_PREFIX."bannersequence_image` (
				  `bannersequence_image_id` int(11) NOT NULL AUTO_INCREMENT,
				  `bannersequence_id` int(11) NOT NULL,
				  `link` varchar(255) NOT NULL,
				  `type` int(11) NOT NULL,
				  `banner_store` varchar(100) DEFAULT 0,
				  `image` varchar(255) NOT NULL,
				  `image1` varchar(255) DEFAULT NULL,
				  PRIMARY KEY (`bannersequence_image_id`)
				) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8;
				";
			$sql[] = "
					CREATE TABLE IF NOT EXISTS `".DB_PREFIX."bannersequence_image_description` (
					  `bannersequence_image_id` int(11) NOT NULL,
					  `language_id` int(11) NOT NULL,
					  `bannersequence_id` int(11) NOT NULL,
					  `title` varchar(64) NOT NULL,
					  `sub_title` varchar(64) DEFAULT NULL,
					  `description` text,
					  PRIMARY KEY (`bannersequence_image_id`,`language_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			";
			
			foreach( $sql as $q ){
				$query = $this->db->query( $q );
			}
			return true;
			
	}
	
	public function reset() {
			//reset Sequence
			$this->db->query("TRUNCATE TABLE ". DB_PREFIX ."bannersequence");
			$this->db->query("TRUNCATE TABLE ". DB_PREFIX ."bannersequence_image");
			$this->db->query("TRUNCATE TABLE ". DB_PREFIX ."bannersequence_image_description");
			//reset cms block 
			$this->db->query("TRUNCATE TABLE ". DB_PREFIX ."cmsblock");
			$this->db->query("TRUNCATE TABLE ". DB_PREFIX ."cmsblock_description");
			$this->db->query("TRUNCATE TABLE ". DB_PREFIX ."cmsblock_to_store");
			
			//uninstall module 
			$this->load->model('extension/extension');
			$this->load->model('extension/module');	
			$ex_modules = array(
				0 => 'bannersequence',
				1 => 'cmsblock',
				2 => 'hozmegamenu',
				3 => 'featured',
				4 => 'special',
				5 => 'ocnewproductslider',
				6 => 'themeoption',
				7 => 'carousel',
				8 => 'newslettersubscribe',
				9 => 'testimonial',
			);
			
			foreach($ex_modules as $module) {
				$this->model_extension_extension->uninstall('module', $module);

				$this->model_extension_module->deleteModulesByCode($module);

				$this->load->model('setting/setting');

				$this->model_setting_setting->deleteSetting($module);
				// Call uninstall method if it exsits
				$this->load->controller('module/' . $module . '/uninstall');
			}
			
			$config_template = "config_template";
			$template = 'default'; 
			$this->db->query("UPDATE " . DB_PREFIX . "setting SET `value` = '" . $template . "' WHERE `key` = '" . $config_template . "' ");
			
		
			
	}
	
	
	public function  settupCmsblock() {
		  $doc = new DOMDocument();
			
			$file = DIR_APPLICATION.'model/installtemp/sample/cms.xml';
			$doc->load($file);
			$cmsblocks = $doc->getElementsByTagName("cms");
		
			foreach ($cmsblocks as $block) {
			
				 $ids = $block->getElementsByTagName("cmsblock_id");
				 $cmsblock_id = $ids->item(0)->nodeValue;
				 
				 $statuss = $block->getElementsByTagName("status");
				 $status = $statuss->item(0)->nodeValue;				 
				 
				 $sort_orders = $block->getElementsByTagName("sort_order");
				 $sort_order = $sort_orders->item(0)->nodeValue;
				 
				 $identifys = $block->getElementsByTagName("identify");
				 $identify = $identifys->item(0)->nodeValue;
				
				 $links = $block->getElementsByTagName("link");
				 $link = $links->item(0)->nodeValue;
				 
				 $types = $block->getElementsByTagName("type");
				 $type = $types->item(0)->nodeValue;
				 
				 $this->db->query("INSERT INTO " . DB_PREFIX . "cmsblock SET cmsblock_id = '" . (int)$cmsblock_id . "', sort_order = '" . $sort_order . "', status = '" . $status . "', identify = '" . $identify . "', link = '" . $link . "', type = '" . $type . "'");
				 
		}
		
		
		   $cmsblock_des = $doc->getElementsByTagName("cms_des");
		
			foreach ($cmsblock_des as $block1) {
			
				 $cmsblock_des_ids = $block1->getElementsByTagName("cmsblock_des_id");
				 $cmsblock_des_id = $cmsblock_des_ids->item(0)->nodeValue;
				 
				 $language_ids = $block1->getElementsByTagName("language_id");
				 $language_id = $language_ids->item(0)->nodeValue;				 
				 
				 $cmsblock_ids = $block1->getElementsByTagName("cmsblock_id");
				 $cmsblock_id = $cmsblock_ids->item(0)->nodeValue;
				 
				 $titles = $block1->getElementsByTagName("title");
				 $title = $titles->item(0)->nodeValue;
				
				 $sub_titles = $block1->getElementsByTagName("sub_title");
				 $sub_title = $sub_titles->item(0)->nodeValue;
				 
				 $descriptions = $block1->getElementsByTagName("description");
				 $description = $descriptions->item(0)->nodeValue;
				 
				 $this->db->query("INSERT INTO " . DB_PREFIX . "cmsblock_description SET cmsblock_des_id = '" . (int)$cmsblock_des_id . "', language_id = '" . $language_id . "', cmsblock_id = '" . $cmsblock_id . "', title = '" . $title . "', sub_title = '" . $sub_title . "', description = '" . $description . "'");
		}
	
	
	}
	
	public function settupSequence()  {
		    $doc = new DOMDocument();
			
			//$file = 'E:\workingust\opencart\demo1551\admin\model\installtemp\sample\sequence.xml';
			$file = DIR_APPLICATION.'model/installtemp/sample/sequence.xml';
			$doc->load($file);
			$sequences = $doc->getElementsByTagName("sequence");
		
			foreach ($sequences as $block) {
			
				 $ids = $block->getElementsByTagName("bannersequence_id");
				 $id = $ids->item(0)->nodeValue;
				 
				 $names = $block->getElementsByTagName("name");
				 $name = $names->item(0)->nodeValue;
				
				 $statuss = $block->getElementsByTagName("status");
				 $status = $statuss->item(0)->nodeValue;
				 
				 $autos = $block->getElementsByTagName("auto");
				 $auto = $autos->item(0)->nodeValue;
				
				 $delays = $block->getElementsByTagName("delay");
				 $delay = $delays->item(0)->nodeValue;
				 
				 $hovers = $block->getElementsByTagName("hover");
				 $hover = $hovers->item(0)->nodeValue;
				 
				 $nextbacks = $block->getElementsByTagName("nextback");
				 $nextback = $nextbacks->item(0)->nodeValue;
				
				 $contrls = $block->getElementsByTagName("contrl");
				 $contrl = $contrls->item(0)->nodeValue;
				 $this->db->query("INSERT INTO " . DB_PREFIX . "bannersequence SET bannersequence_id = '" . (int)$id . "', name = '" . $name . "', status = '" . $status . "', auto = '" . $auto . "', delay = '" . $delay . "', hover = '" . $hover . "', nextback = '" . $nextback . "', contrl = '" . $contrl . "'");
				 
		}
		// sequence images
			$sequence_images = $doc->getElementsByTagName("sequence_image");
			foreach ($sequence_images as $block_image) {
				 $bannersequence_image_ids = $block_image->getElementsByTagName("bannersequence_image_id");
				 $bannersequence_image_id = $bannersequence_image_ids->item(0)->nodeValue;
				 
				 $bannersequence_ids = $block_image->getElementsByTagName("bannersequence_id");
				 $bannersequence_id = $bannersequence_ids->item(0)->nodeValue;
				 
				  $links = $block_image->getElementsByTagName("link");
				  $link = $links->item(0)->nodeValue;
				  
				  $images = $block_image->getElementsByTagName("image");
				  $image = $images->item(0)->nodeValue;
				  $types = $block_image -> getElementsByTagName('type'); 
				  $type = $types->item(0)->nodeValue;
				  
				  $image1s = $block_image->getElementsByTagName("image1");
				  $image1 = $image1s->item(0)->nodeValue;
				   $this->db->query("INSERT INTO " . DB_PREFIX . "bannersequence_image SET bannersequence_image_id = '" . (int)$bannersequence_image_id . "',bannersequence_id = '" . (int)$bannersequence_id . "', link = '" . $link . "', image = '" . $image . "', image1 = '" . $image1 . "', type = '" .$type. "'");
				   //echo $bannersequence_image_id.'--'.$bannersequence_id.'-'.$link.'--'.$image.'--'.$image1.'</br>';
		   }
		   
		   	// sequence description
			$sequence_descriptions = $doc->getElementsByTagName("sequence_description");
			foreach ($sequence_descriptions as $block_des) {
				 $bannersequence_image_ids = $block_des->getElementsByTagName("bannersequence_image_id");
				 $bannersequence_image_id = $bannersequence_image_ids->item(0)->nodeValue;
				 
				 $language_ids = $block_des->getElementsByTagName("language_id");
				 $language_id = $language_ids->item(0)->nodeValue;
				 
				 $bannersequence_ids = $block_des->getElementsByTagName("bannersequence_id");
				 $bannersequence_id = $bannersequence_ids->item(0)->nodeValue;
				 
				 $titles = $block_des->getElementsByTagName("title");
				 $title = $titles->item(0)->nodeValue;
				 
				 $sub_titles = $block_des->getElementsByTagName("sub_title");
				 $sub_title = $sub_titles->item(0)->nodeValue;
				 
				 $descriptions = $block_des->getElementsByTagName("description");
				 $description = $descriptions->item(0)->nodeValue;
				 
				   $this->db->query("INSERT INTO " . DB_PREFIX . "bannersequence_image_description SET bannersequence_image_id = '" . (int)$bannersequence_image_id . "',language_id = '" . (int)$language_id . "', bannersequence_id = '" . (int)$bannersequence_id . "', title = '" . $title . "', sub_title = '" . $sub_title . "', description = '" . $description . "'");
			}
		   
	}

	 
}
?>