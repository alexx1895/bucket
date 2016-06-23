<?php
class ModelTotalShare extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if(isset($this->session->data['telephone']) && $this->session->data['share_cost']>0){
			$total += $this->session->data['delivery_cost'];
		}
	}
}