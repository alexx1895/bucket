<?php

class OpencartApiClient {

    private $opencartStoreId = 0;
    private $cookieFileName;
    private $registry;
    private $apiToken;

    /* Совместимость с объектами ОС, например $this->model_module_name */
    public function __get($name) {
        return $this->registry->get($name);
    }

    public function __construct(Registry &$registry) {
        $this->registry = $registry;

        $settings = $this->model_setting_setting->getSetting('retailcrm');
        $this->cookieFileName = $settings['retailcrm_apikey'];

        $this->auth();
    }

    private function getCookieValue($cookieName) {
        $cookieFile = file_get_contents(DIR_APPLICATION . '/' . $this->cookieFileName . '.txt');
        $cookieFile = explode("\n", $cookieFile);

        $cookies = array();
        foreach($cookieFile as $line) {
            if(empty($line) OR $line{0} == '#')
                continue;

            $params = explode("\t", $line);
            $cookies[$params[5]] = $params[6];
        }

        if(isset($cookies[$cookieName]))
            return $cookies[$cookieName];

        return false;
    }

    public function request($method, $getParams, $postParams) {
        $opencartStoreInfo = $this->model_setting_store->getStore($this->opencartStoreId);

        if(version_compare(VERSION, '2.1.0', '>=') && !empty($this->apiToken)) {
            $getParams['token'] = $this->apiToken;
        }

        $postParams['fromApi'] = true;

        if ($opencartStoreInfo) {
            $url = $opencartStoreInfo['ssl'];
        } else {
            $url = HTTPS_CATALOG;
        }

        $curl = curl_init();

        // Set SSL if required
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($curl, CURLOPT_PORT, 443);
        }

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url . 'index.php?route=api/' . $method . (!empty($getParams) ? '&' . http_build_query($getParams) : ''));

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postParams));

        curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_APPLICATION . '/' . $this->cookieFileName . '.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_APPLICATION . '/' . $this->cookieFileName . '.txt');

        $json = json_decode(curl_exec($curl), true);

        curl_close($curl);
//print_r($json);
        return $json;
    }

    private function auth() {
        $apiUsers = $this->model_user_api->getApis();

        $api = array();
        foreach ($apiUsers as $apiUser) {
            if($apiUser['status'] == 1) {
                if(version_compare(VERSION, '2.1.0', '>=')) {
                    $api = array(
                        'api_id' => $apiUser['api_id'],
                        'key' => $apiUser['key']
                    );
                } else {
                    $api = array(
                        'api_id' => $apiUser['api_id'],
                        'username' => $apiUser['username'],
                        'password' => $apiUser['password']
                    );
                }

                break;
            }
        }

        if(!isset($api['api_id']))
            return false;

        if(version_compare(VERSION, '2.1.0', '>=')) {
            $alreadyBinded = false;

            $innerIp = $this->getInnerIpAddr();
            $apiIps = $this->model_user_api->getApiIps($api['api_id']);
            foreach($apiIps as $apiIp) {
                if($apiIp['ip'] == $innerIp)
                    $alreadyBinded = true;
            }

            if(!$alreadyBinded) {
                $this->model_user_api->addApiIp($api['api_id'], $innerIp);
            }
        }

        $apiAnswer = $this->request('login', array(), $apiUser);

        if(version_compare(VERSION, '2.1.0', '>=')) {
            $this->apiToken = $apiAnswer['token'];
        }

        return $apiAnswer;
    }

    public function editOrder($order_id, $data) {
        $data['telephone'] = trim($data['telephone']);
        $customer = array(
            'currency' => isset($data['currency']) ? $data['currency'] : '',
            'customer' => $data['customer'],
            'customer_id' => $data['customer_id'],
            'customer_group_id' => $data['customer_group_id'],
            'firstname' => $data['firstname'],
            'lastname' => $data['telephone'],
            'email' => $data['email'],
            'telephone' => !empty($data['telephone']) ? $data['telephone'] : '0000',
            'fax' => $data['fax'],
        );

        if($data['customer_status']){
            $status = array('customer_status' => $data['customer_status'], 'telephone' => !empty($data['telephone']) ? $data['telephone'] : '0000' );
            $this->request('customer/changeStatus', array(), $status);
        }

        $this->request('customer', array(), $customer);

        $products = array();
        foreach ($data['order_product'] as $order_product) {
            $products[] = array(
                'product_id' => $order_product['product_id'],
                'quantity' => $order_product['quantity']
            );
        }
        $this->request('cart/add', array(), array('product' => $products));

        $payment_address = array(
            'payment_address' => $data['payment_address'],
            'firstname' => $data['payment_firstname'],
            'lastname' => (isset($data['payment_lastname'])&&strlen($data['payment_lastname']) >1 )?$data['payment_lastname']:'Customer' ,
            'company' => $data['payment_company'],
            'address_1' => $data['payment_address_1'],
            'address_2' => $data['payment_address_2'],
            'city' => (isset($data['payment_city'])&&strlen($data['payment_city']) >1 )?$data['payment_city']:'Moscow' ,//$data['payment_city'],
            'postcode' => $data['payment_postcode'],
            'country_id' => $data['payment_country_id'],
            'zone_id' => (isset($data['payment_zone_id'])&&strlen($data['payment_zone_id']) >1 )?$data['payment_city']:'176' ,//$data['payment_zone_id'],
        );
        $this->request('payment/address', array(), $payment_address);

        $this->request('payment/methods', array(), array());
        $payment_method = array(
            'payment_method' => $data['payment_code']
        );
        $this->request('payment/method', array(), $payment_method);

        $shipping_address = array(
            'shipping_address' => $data['shipping_address'],
            'firstname' => $data['shipping_firstname'],
            'lastname' => $data['telephone'],
            'company' => $data['shipping_company'],
            'address_1' => $data['shipping_address_1'],
            'address_2' => $data['shipping_address_2'],
            'city' => !empty($data['shipping_city']) ? $data['shipping_city'] : 'none',
            'postcode' => $data['shipping_postcode'],
            'country_id' => $data['shipping_country_id'],
            'zone_id' => !empty($data['shipping_zone_id']) ? $data['shipping_zone_id'] : 0,
        );
        $this->request('shipping/address', array(), $shipping_address);

        $this->request('shipping/methods', array(), array());
        $shipping_method = array(
            'shipping_method' => $data['shipping_code']
        );
        $this->request('shipping/method', array(), $shipping_method);

        $order = array(
            'shipping_method' => $data['shipping_code'],
            'payment_method' => $data['payment_code'],
            'order_status_id' => $data['order_status_id'],
            'comment' => $data['comment'],
            'affiliate_id' => $data['affiliate_id'],
        );

        $this->request('order/edit', array('order_id' => $order_id), $order);
    }


    public function clearOrders(){
        $this->request('order/clear', array(), array());
    }

    public function addOrder($data) {

        $currency = $this->getCookieValue('currency');
        if($currency) {
            $a = $this->request('currency', array(), array('currency' => $currency));
        }

        $customer = array(
            'store_id' => $data['store_id'],
            'currency' => $currency != false ? $currency : '',
            'customer' => $data['customer'],
            'customer_id' => $data['customer_id'],
            'customer_group_id' => $data['customer_group_id'],
            'firstname' => $data['firstname'],
            'lastname' => $data['telephone'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'fax' => $data['fax'],
            'customer_status' => $data['customer_status'],
        );
        $this->request('customer', array(), $customer);

        if($data['customer_status']){
            $status = array('customer_status' => $data['customer_status'], 'telephone' => !empty($data['telephone']) ? $data['telephone'] : '0000' );
            $this->request('customer/changeStatus', array(), $status);
        }

        $products = array();
        foreach($data['order_product'] as $product) {
            $product = array(
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
            );
            $products[] = $product;
        }
        $this->request('cart/add', array(), array('product' => $products));

        $payment_address = array(
            'payment_address' => $data['payment_address'],
            'firstname' => $data['payment_firstname'],
            'lastname' => (isset($data['payment_lastname'])&&strlen($data['payment_lastname']) >1 )?$data['payment_lastname']:'Customer' ,
            'company' => $data['payment_company'],
            'address_1' => $data['payment_address_1'],
            'address_2' => $data['payment_address_2'],
            'city' => (isset($data['payment_city'])&&strlen($data['payment_city']) >1 )?$data['payment_city']:'Moscow' ,//$data['payment_city'],
            'postcode' => $data['payment_postcode'],
            'country_id' => $data['payment_country_id'],
            'zone_id' => (isset($data['payment_zone_id'])&&strlen($data['payment_zone_id']) >1 )?$data['payment_city']:'176' ,//$data['payment_zone_id'],
        );
        $this->request('payment/address', array(), $payment_address);

        $shipping_address = array(
            'shipping_address' => $data['shipping_address'],
            'firstname' => $data['shipping_firstname'],
            'lastname' =>   (isset($data['shipping_lastname'])&&strlen($data['shipping_lastname']) >1 )?$data['shipping_lastname']:'Customer' ,
            'company' => $data['shipping_company'],
            'address_1' => $data['shipping_address_1'],
            'address_2' => $data['shipping_address_2'],
            'city' =>  (isset($data['shipping_city'])&&strlen($data['shipping_city']) >1 )?$data['shipping_city']:'Moscow' ,//$data['shipping_city'],
            'postcode' => $data['shipping_postcode'],
            'country_id' => $data['shipping_country_id'],
            'zone_id' => !empty($data['shipping_zone_id']) ? $data['shipping_zone_id'] : 0,
        );
        $this->request('shipping/address', array(), $shipping_address);

        $this->request('shipping/methods', array(), array());
        $shipping_method = array(
            'shipping_method' => $data['shipping_code']
        );
        $this->request('shipping/method', array(), $shipping_method);

        $this->request('payment/methods', array(), array());
        $payment_method = array(
            'payment_method' => $data['payment_code']
        );
        $this->request('payment/method', array(), $payment_method);

        $order = array(
            'shipping_method' => $data['shipping_code'],
            'payment_method' => $data['payment_code'],
            'order_status_id' => $data['order_status_id'],
            'comment' => $data['comment'],
            'affiliate_id' => $data['affiliate_id'],
        );

        $this->request('order/add', array(), $order);

    }

    private function getInnerIpAddr() {
        $opencartStoreInfo = $this->model_setting_store->getStore($this->opencartStoreId);

        if ($opencartStoreInfo) {
            $url = $opencartStoreInfo['ssl'];
        } else {
            $url = HTTPS_CATALOG;
        }

        $curl = curl_init();

        // Set SSL if required
        if (substr($url, 0, 5) == 'https') {
            curl_setopt($curl, CURLOPT_PORT, 443);
        }

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FORBID_REUSE, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url . 'system/cron/getmyip.php');

        return curl_exec($curl);
    }
}
