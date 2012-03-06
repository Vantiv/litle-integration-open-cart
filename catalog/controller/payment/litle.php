<?php
require_once($vqmod->modCheck(DIR_SYSTEM . 'library/litle/LitleOnline.php'));

class ControllerPaymentLitle extends Controller {
	protected function index() {
		$this->language->load('payment/litle');
		
		$this->data['text_credit_card'] = $this->language->get('text_credit_card');
		$this->data['text_wait'] = $this->language->get('text_wait');
		
		$this->data['entry_cc_type'] = $this->language->get('entry_cc_type');
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
		
		$this->data['cardTypes'] = array();
		$this->data['cardTypes'][] = array( 'text' => "Visa", 'value' => "VI" );
		$this->data['cardTypes'][] = array( 'text' => "Mastercard", 'value' => "MC" );
		$this->data['cardTypes'][] = array( 'text' => "American Express", 'value' => "AX" );
		$this->data['cardTypes'][] = array( 'text' => "Discover", 'value' => "DI" );
		
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
	
	public function getAddressInfo($addressType)
	{
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$retArray = array();
 		$retArray["firstName"] = XMLFields::returnArrayValue($order_info, ($addressType + "_firstname") );
 		//$retArray["middleInitial"]= XMLFields::returnArrayValue($hash_in, ($addressType + "_lastname") );
 		$retArray["lastName"] = XMLFields::returnArrayValue($order_info, ($addressType + "_lastname") );
		//$retArray["name"] = XMLFields::returnArrayValue($order_info, ($addressType + "_firstname") );
 		$retArray["companyName"] = XMLFields::returnArrayValue($order_info, ($addressType + "_company") );
 		$retArray["addressLine1"] = XMLFields::returnArrayValue($order_info, ($addressType + "_address_1") );
 		$retArray["addressLine2"] = XMLFields::returnArrayValue($order_info, ($addressType + "_address_2") );
 		$retArray["city"] = XMLFields::returnArrayValue($order_info, ($addressType + "_city") );
 		$retArray["state"] = XMLFields::returnArrayValue($order_info, ($addressType + "_firstname") );
 		$retArray["zip"] = XMLFields::returnArrayValue($order_info, ($addressType + "_postcode") );
 		$retArray["country"] = XMLFields::returnArrayValue($order_info, ($addressType + "_country") );
 		$retArray["email"] = XMLFields::returnArrayValue($order_info, "email" );
 		$retArray["phone"] = XMLFields::returnArrayValue($order_info, "telephone" );
 		
 		return $retArray;
	}
	
	public function getCreditCardInfo()
	{
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		$retArray = array();
		$retArray["type"] = $this->request->post['cc_type'];
 		$retArray["number"] = str_replace(' ', '', $this->request->post['cc_number']);
 		//TODO: fix the logic for expDate
 		$retArray["expDate"] = $this->request->post['cc_expire_date_month'] . ($this->request->post['cc_expire_date_year']-2000);
 		$retArray["cardValidationNum"] = $this->request->post['cc_cvv2'];
 		
 		return $retArray;
	}
	
	public function send() {
 		$this->load->model('checkout/order');
 		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
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
		
 		$hash_in = array(
 					'orderId'=> $order_info['order_id'],
 					'amount'=> 5000,//$order_info['total'],
 					'orderSource'=> "ecommerce",
 					//'customerInfo'=> $order_info['payment_firstname'],
 					'billToAddress'=> $this->getAddressInfo("payment"),
 					'shipToAddress'=> $this->getAddressInfo("shipping"),
 					'card'=> $this->getCreditCardInfo(),
 					//'paypal'=> $order_info['payment_firstname'],
 					//'token'=> $order_info['payment_firstname'],
 					//'paypage'=> $order_info['payment_firstname'],
 					//'billMeLaterRequest'=> $order_info['payment_firstname'],
 					//'cardholderAuthentication'=> $order_info['payment_firstname'],
 					//'processingInstructions'=> $order_info['payment_firstname'],
 					//'pos'=>(XMLFields::pos($hash_in['pos'])),
 					//'customBilling'=>(XMLFields::customBilling($hash_in['customBilling'])),
 					//'taxBilling'=>(XMLFields::taxBilling($hash_in['taxBilling'])),
 					//'enhancedData'=>(XMLFields::enhancedData($hash_in['enhancedData'])),
 					//'amexAggregatorData'=>(XMLFields::amexAggregatorData($hash_in['amexAggregatorData'])),
 					//'allowPartialAuth'=>$hash_in['allowPartialAuth'],
 					//'healthcareIIAS'=>(XMLFields::healthcareIIAS($hash_in['healthcareIIAS'])),
 					//'filtering'=>(XMLFields::filteringType($hash_in['filtering'])),
 					//'merchantData'=>(XMLFields::filteringType($hash_in['merchantData'])),
 					//'recyclingRequest'=>(XMLFields::recyclingRequestType($hash_in['recyclingRequest']))
 		);
 		$litleResponseMessagePrefix = "";
 		$litleRequest = new LitleOnlineRequest();
		
 		$doingAuth = $this->config->get('litle_transaction') == "auth";
		if($doingAuth) {
			//auth txn
			$response = $litleRequest->authorizationRequest($hash_in);
			$litleResponseMessagePrefix = "LitleCapturableTxn: ";
		}
		else {
			//sale txn
			$response = $litleRequest->saleRequest($hash_in);
			$litleResponseMessagePrefix = "LitleRefundableTxn: ";
		}
		
		$code = XMLParser::getNode($response, "response");
		$litleValidationMessage = XMLParser::getNode($response, "message");
		$litleTxnId = XMLParser::getNode($response, "litleTxnId");
		
		$message = $litleResponseMessagePrefix . $litleValidationMessage . " \n Transaction ID: " . $litleTxnId . " \n";
		
		if($code == "000") { //Success
			if($doingAuth) {
				$orderStatusId = 1; //Pending
			}
			else {
				$orderStatusId = 5; //Processing
			}
		}
		else {
			$orderStatusId = 8; //Denied
		}
		
		$this->model_checkout_order->confirm(
			$order_info['order_id'], 
			$orderStatusId,
			$message,
			true
		);
		
		$json = array();
		$json['success'] = $this->url->link('checkout/success', '', 'SSL');
		$this->response->setOutput(json_encode($json));
	}
}
?>