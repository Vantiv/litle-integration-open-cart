<?php
class ControllerPaymentLitle extends Controller {
	protected function index() {
		$this->language->load('payment/litle');
		
		$this->data['text_credit_card'] = $this->language->get('text_credit_card');
		$this->data['text_wait'] = $this->language->get('text_wait');
		
		$this->data['entry_cc_owner'] = $this->language->get('entry_cc_owner');
		$this->data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$this->data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$this->data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');
		
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		
		$this->data['months'] = array();
		
		for ($i = 1; $i <= 12; $i++) {
			$this->data['months'][] = array(
				'text'  => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)), 
				'value' => sprintf('%02d', $i)
			);
		}
		
		$today = getdate();

		$this->data['year_expire'] = array();

		for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
			$this->data['year_expire'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)) 
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/litle.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/litle.tpl';
		} else {
			$this->template = 'default/template/payment/litle.tpl';
		}	
		
		$this->render();		
	}
	
	public function send() {
// 		if ($this->config->get('authorizenet_aim_server') == 'live') {
//     		$url = 'https://secure.authorize.net/gateway/transact.dll';
// 		} elseif ($this->config->get('authorizenet_aim_server') == 'test') {
// 			$url = 'https://test.authorize.net/gateway/transact.dll';		
// 		}	
		
// 		//$url = 'https://secure.networkmerchants.com/gateway/transact.dll';	
		
 		$this->load->model('checkout/order');
		
// 		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
//         $data = array();

// 		$data['x_login'] = $this->config->get('authorizenet_aim_login');
// 		$data['x_tran_key'] = $this->config->get('authorizenet_aim_key');
// 		$data['x_version'] = '3.1';
// 		$data['x_delim_data'] = 'true';
// 		$data['x_delim_char'] = ',';
// 		$data['x_encap_char'] = '"';
// 		$data['x_relay_response'] = 'false';
// 		$data['x_first_name'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
// 		$data['x_last_name'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
// 		$data['x_company'] = html_entity_decode($order_info['payment_company'], ENT_QUOTES, 'UTF-8');
// 		$data['x_address'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
// 		$data['x_city'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
// 		$data['x_state'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
// 		$data['x_zip'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
// 		$data['x_country'] = html_entity_decode($order_info['payment_country'], ENT_QUOTES, 'UTF-8');
// 		$data['x_phone'] = $order_info['telephone'];
// 		$data['x_customer_ip'] = $this->request->server['REMOTE_ADDR'];
// 		$data['x_email'] = $order_info['email'];
// 		$data['x_description'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
// 		$data['x_amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], 1.00000, false);
// 		$data['x_currency_code'] = $this->currency->getCode();
// 		$data['x_method'] = 'CC';
// 		$data['x_type'] = ($this->config->get('authorizenet_aim_method') == 'capture') ? 'AUTH_CAPTURE' : 'AUTH_ONLY';
// 		$data['x_card_num'] = str_replace(' ', '', $this->request->post['cc_number']);
// 		$data['x_exp_date'] = $this->request->post['cc_expire_date_month'] . $this->request->post['cc_expire_date_year'];
// 		$data['x_card_code'] = $this->request->post['cc_cvv2'];
// 		$data['x_invoice_num'] = $this->session->data['order_id'];
	
// 		if ($this->config->get('authorizenet_aim_mode') == 'test') {
// 			$data['x_test_request'] = 'true';
// 		}	
				
		//$curl = curl_init($url);

		//curl_setopt($curl, CURLOPT_PORT, 443);
		//curl_setopt($curl, CURLOPT_HEADER, 0);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		//curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		//curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		//curl_setopt($curl, CURLOPT_POST, 1);
		//curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
		//curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
 
		//$response = curl_exec($curl);
		
		$json = array();
		
// 		if (curl_error($curl)) {
// 			$json['error'] = 'CURL ERROR: ' . curl_errno($curl) . '::' . curl_error($curl);
			
// 			$this->log->write('AUTHNET AIM CURL ERROR: ' . curl_errno($curl) . '::' . curl_error($curl));	
// 		} elseif ($response) {
// 			$i = 1;
			
		
		$doingAuth = $this->config->get('litle_transaction') == 'auth';
		if($doingAuth) {
			//auth txn
			$response = array('code'=>'000', 'message'=>'Approved', 'litleTxnId'=>'123456789012345678');
		}
		else {
			//sale txn
			$response = array('code'=>'000', 'message'=>'Approved', 'litleTxnId'=>'876543210987654321');
		}
		
		$code = $response['code'];
		$message = $response['message'] . " \n Transaction ID: " . $response['litleTxnId'] . " \n";
		
		if($code == '000') { //Success
			if($doingAuth) {
				$orderStatusId = 1; //Pending
			}
			else {
				$orderStatusId = 2; //Processing
			}
		}
		else {
			$orderStatusId = 8; //Denied
		}
		
		$this->model_checkout_order->confirm(
			$this->session->data['order_id'], 
			$orderStatusId,
			$message,
			true
		);
				
		$json['success'] = $this->url->link('checkout/success', '', 'SSL');
		
		$this->response->setOutput(json_encode($json));
	}
}
?>