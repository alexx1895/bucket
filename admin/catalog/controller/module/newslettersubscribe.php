<?php  
class ControllerModuleNewslettersubscribe extends Controller {
  	private $error = array();
	
	public function index($setting) {
	
		$this->language->load('module/newslettersubscribe');
		$this->document->addScript('catalog/view/javascript/opentheme/jquery.bpopup.min.js');
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/opentheme/newslettersubscribe/css/newslettersubscribe.css')) {
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/opentheme/newslettersubscribe/css/newslettersubscribe.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/opentheme/newslettersubscribe/css/newslettersubscribe.css');
		}

      	$data['heading_title'] = $this->language->get('heading_title');	
		$data['newletter_lable'] = $this->language->get('newletter_lable');	
		
      	$data['entry_name'] = $this->language->get('entry_name');	
      	$data['entry_email'] = $this->language->get('entry_email');	
		$data['entry_button'] = $this->language->get('entry_button');	
		$data['entry_unbutton'] = $this->language->get('entry_unbutton');	
		$data['option_unsubscribe'] = $this->config->get('option_unsubscribe');	
		$data['thickbox'] = $setting['newslettersubscribe_thickbox'];	
		
		$data['text_subscribe'] = $this->language->get('text_subscribe');	
		
		$this->id = 'newslettersubscribe';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/newslettersubscribe.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/newslettersubscribe.tpl', $data);
		} else {
			return $this->load->view('default/template/module/newslettersubscribe.tpl', $data);
		}
	 
	   	$this->load->model('account/newslettersubscribe');
	   	//check db
	   	$this->model_account_newslettersubscribe->check_db();
	}
	
	public function subscribe() {
	
		$prefix_eval = "";
	  
		$this->language->load('module/newslettersubscribe');
	 
		$this->load->model('account/newslettersubscribe');
	  
		if (isset($this->request->post['subscribe_email']) and filter_var($this->request->post['subscribe_email'],FILTER_VALIDATE_EMAIL)) {
			   
			   if ($this->config->get('newslettersubscribe_registered') and $this->model_account_newslettersubscribe->checkRegisteredUser($this->request->post)) {
				   
					$this->model_account_newslettersubscribe->UpdateRegisterUsers($this->request->post,1);
					
					echo('$("'.$prefix_eval.' #notification").html("<div class=\"success\"> '.$this->language->get('subscribe').'</div>");$("'.$prefix_eval.' #subscribe")[0].reset();');
				   
				
			   } else if (!$this->model_account_newslettersubscribe->checkmailid($this->request->post)) {
				 
					$this->model_account_newslettersubscribe->subscribe($this->request->post);
					
					echo('$("'.$prefix_eval.' #notification").html("<div class=\"success\"> '.$this->language->get('subscribe').'</div>");$("'.$prefix_eval.' #subscribe")[0].reset();');
				 
					if ($this->config->get('newslettersubscribe_mail_status')) {
				   
						$subject = $this->language->get('mail_subject');	
						
						$message = '<table width="60%" cellpadding="2"  cellspacing="1" border="0"> 
									 <tr>
									   <td> Email Id </td>
									   <td> '.$this->request->post['subscribe_email'].' </td>
									 </tr>
									 <tr>
									   <td> Name  </td>
									   <td> '.$this->request->post['subscribe_name'].' </td>
									 </tr>';
						$message .= '</table>';
			 
						$mail = new Mail();
						$mail->protocol = $this->config->get('config_mail_protocol');
						$mail->parameter = $this->config->get('config_mail_parameter');
						$mail->hostname = $this->config->get('config_smtp_host');
						$mail->username = $this->config->get('config_smtp_username');
						$mail->password = $this->config->get('config_smtp_password');
						$mail->port = $this->config->get('config_smtp_port');
						$mail->timeout = $this->config->get('config_smtp_timeout');				
						$mail->setTo($this->config->get('config_email'));
						$mail->setFrom($this->config->get('config_email'));
						$mail->setSender($this->config->get('config_name'));
						$mail->setSubject($subject);
						$mail->setHtml($message);
						$mail->send();
					}
				 
				} else {
					  
					  echo('$("'.$prefix_eval.' #notification").html("<div class=\"warning\"> '.$this->language->get('alreadyexist').'</div>");$("'.$prefix_eval.' #subscribe")[0].reset();');
					  
				}
			   
			} else {
				
				echo('$("'.$prefix_eval.' #notification").html("<div class=\"warning\"> '.$this->language->get('error_invalid').'</div>")');
				
			}
	  
	}

	public function unsubscribe(){
	  
		if ($this->config->get('newslettersubscribe_thickbox')) {
			  $prefix_eval = "";
		} else {
			  $prefix_eval = "";
		}
	  
		$this->language->load('module/newslettersubscribe');
	 
		$this->load->model('account/newslettersubscribe');
	  
		if (isset($this->request->post['subscribe_email']) and filter_var($this->request->post['subscribe_email'],FILTER_VALIDATE_EMAIL)) {
				
			if ($this->config->get('newslettersubscribe_registered') and $this->model_account_newslettersubscribe->checkRegisteredUser($this->request->post)) {
				   
					$this->model_account_newslettersubscribe->UpdateRegisterUsers($this->request->post,0);
					
					echo('$("'.$prefix_eval.' #notification").html("<div class=\"success\"> '.$this->language->get('unsubscribe').'</div>");$("'.$prefix_eval.' #subscribe")[0].reset();');
				   
				
			} else if (!$this->model_account_newslettersubscribe->checkmailid($this->request->post)) {
				 
					echo('$("'.$prefix_eval.' #notification").html("<div class=\"warning\"> '.$this->language->get('notexist').'</div>");$("'.$prefix_eval.' #subscribe")[0].reset();');
				 
			} else {
				   
					if ($this->config->get('option_unsubscribe')) {
						
					 $this->model_account_newslettersubscribe->unsubscribe($this->request->post);
					 
					 echo('$("'.$prefix_eval.' #notification").html("<div class=\"success\"> '.$this->language->get('unsubscribe').'</div>");$("'.$prefix_eval.' #subscribe")[0].reset();');
					 
					}
			}
			   
		} else {
			
				echo('$("'.$prefix_eval.' #notification").html("<div class=\"warning\"> '.$this->language->get('error_invalid').'</div>")');
				
		}
	  
	}

	protected function loadmodule() {
		
		$this->language->load('module/newslettersubscribe');

      	$data['heading_title'] = $this->language->get('heading_title');	
		
      	$data['entry_name'] = $this->language->get('entry_name');	
      	$data['entry_email'] = $this->language->get('entry_email');	
		$data['entry_button'] = $this->language->get('entry_button');	
		$data['entry_unbutton'] = $this->language->get('entry_unbutton');	
		$data['option_unsubscribe'] = $this->config->get('option_unsubscribe');	
		$data['thickbox'] = $this->config->get('newslettersubscribe_thickbox');	
		
		$data['text_subscribe'] = $this->language->get('text_subscribe');	
		
		$this->id = 'newslettersubscribe';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/newslettersubscribe.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/newslettersubscribe.tpl', $data);
		} else {
			return $this->load->view('default/template/module/newslettersubscribe.tpl', $data);
		}
		
	}
}
?>