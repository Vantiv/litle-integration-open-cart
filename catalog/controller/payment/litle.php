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
	
	public function getAddressInfo($order_info, $addressType)
	{
		$retArray = array();
		$retArray["firstName"] = XMLFields::returnArrayValue($order_info, ($addressType . "_firstname") );
 		//$retArray["middleInitial"]= XMLFields::returnArrayValue($hash_in, ($addressType . "_lastname") );
 		$retArray["lastName"] = XMLFields::returnArrayValue($order_info, ($addressType . "_lastname") );
		//$retArray["name"] = XMLFields::returnArrayValue($order_info, ($addressType . "_firstname") );
 		$retArray["companyName"] = XMLFields::returnArrayValue($order_info, ($addressType . "_company") );
 		$retArray["addressLine1"] = XMLFields::returnArrayValue($order_info, ($addressType . "_address_1") );
 		$retArray["addressLine2"] = XMLFields::returnArrayValue($order_info, ($addressType . "_address_2") );
 		$retArray["city"] = XMLFields::returnArrayValue($order_info, ($addressType . "_city") );
 		$retArray["state"] = XMLFields::returnArrayValue($order_info, ($addressType . "_firstname") );
 		$retArray["zip"] = XMLFields::returnArrayValue($order_info, ($addressType . "_postcode") );
 		//$retArray["country"] = XMLFields::returnArrayValue($order_info, ($addressType . "_country") );
 		$retArray["country"] = XMLFields::returnArrayValue($order_info, ($addressType . "_iso_code_2") );
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
	
	public function getAmountInCorrectFormat($amount) {
		$retVal = str_replace(",", '', $amount);
		$posOfDot = strpos($retVal, ".");
		if($posOfDot != FALSE){
			$retVal = substr($retVal, 0, $posOfDot + 3);
			$retVal = str_replace(".", '', $retVal);
		}
		return $retVal;
	}
	
	public function send() {
 		$this->load->model('checkout/order');
 		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
				
 		$orderAmountToInsert = $this->getAmountInCorrectFormat($order_info['total']);
 		$hash_in = array(
 					'orderId'=> $order_info['order_id'],
 					'amount'=> $orderAmountToInsert,
 					'orderSource'=> "ecommerce",
 					//'customerInfo'=> $order_info['payment_firstname'],
 					'billToAddress'=> $this->getAddressInfo($order_info, "payment"),
 					'shipToAddress'=> $this->getAddressInfo($order_info, "shipping"),
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
			$litleResponseMessagePrefix = "LitleAuthTxn: ";
		}
		else {
			//sale txn
			$response = $litleRequest->saleRequest($hash_in);
			$litleResponseMessagePrefix = "LitleCaptureTxn: ";
		}
		
		$code = XMLParser::getNode($response, "response");
		$litleValidationMessage = XMLParser::getNode($response, "message");
		$litleTxnId = XMLParser::getNode($response, "litleTxnId");
		
		$json = array();
		if($code == "000") { //Success
			if($doingAuth) {
				$orderStatusId = 1; //Pending
			}
			else {
				$orderStatusId = 5; //Processing
			}
			$message = $litleResponseMessagePrefix . $litleValidationMessage . " \n Litle Response Code: " . $code . "\n  Litle Transaction ID: " . $litleTxnId . " \n";
			$json['success'] = $this->url->link('checkout/success', '', 'SSL');
		}
		else if($code == "100" || $code == "101" || $code == "102" || $code == "110"){ //Need to try again
			$orderStatusId = 10; //Failed
			$litleResponseMessagePrefix = "LitleTxn: ";
			$message = $litleResponseMessagePrefix . $litleValidationMessage . " \n Litle Response Code: " . $code . "\n  Litle Transaction ID: " . $litleTxnId . " \n";
			$json['error'] = "Either your credit card was declined or there was an error. Please try again or contact us for further help.";
		}
		else {
			$xpath = new DOMXPath($response);
			$query = 'string(/litleOnlineResponse/@message)';
			$message = $xpath->evaluate($query);
			$orderStatusId = 8; //Denied
			$json['error'] = "Either your credit card was declined or there was an error. Please try again or contact us for further help.";
		}
		
		$this->model_checkout_order->confirm(
			$order_info['order_id'], 
			$orderStatusId,
			$message,
			true
		);
		
		$this->response->setOutput(json_encode($json));
	}
}
?>