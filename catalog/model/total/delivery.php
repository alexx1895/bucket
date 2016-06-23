<?php
class ModelTotalDelivery extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if(isset($this->session->data['delivery_cost']) && $this->session->data['delivery_cost']>0){
			$total += $this->session->data['delivery_cost'];
		}
	}
}