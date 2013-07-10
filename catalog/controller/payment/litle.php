<?php
require_once DIR_SYSTEM . 'library/litle/LitleOnline.php';

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
	
	public function merchantDataFromOC()
	{
		$hash = array('user'=> $this->config->get('litle_merchant_user_name'),
		 					'password'=> $this->config->get('litle_merchant_password'),
							'merchantId'=>$this->config->get('litle_merchant_id'),
							'reportGroup'=>$this->config->get('litle_default_report_group'),
							'url'=>UrlMapper::getUrl(trim($this->config->get('litle_url'))),	
							'proxy'=>$this->config->get('litle_proxy_value'),
							'timeout'=>$this->config->get('litle_timeout_value')
		);
		return $hash;
	}

/*	
+-----------------+-------------+-------------------+
| order_status_id | language_id | name              |
+-----------------+-------------+-------------------+
|               1 |           1 | Pending           | 
|               2 |           1 | Processing        | 
|               3 |           1 | Shipped           | 
|               5 |           1 | Complete          | 
|               7 |           1 | Canceled          | 
|               8 |           1 | Denied            | we use this for soft decline, hard decline and config issues
|               9 |           1 | Canceled Reversal | 
|              10 |           1 | Failed            |
|              11 |           1 | Refunded          | 
|              12 |           1 | Reversed          | 
|              13 |           1 | Chargeback        | 
|              15 |           1 | Processed         | 
|              14 |           1 | Expired           | 
|              16 |           1 | Voided            | 
+-----------------+-------------+-------------------+
*/
	public function send() {
		$this->load->model('checkout/order');
		$orderId = $this->session->data['order_id'];
 		$order_info = $this->model_checkout_order->getOrder($orderId);
 		$orderAmountToInsert = $this->getAmountInCorrectFormat($order_info['total']);
 		$litle_order_info = array(
 					'orderId'=> $order_info['order_id'],
 					'amount'=> $orderAmountToInsert,
 					'orderSource'=> "ecommerce",
 					'billToAddress'=> $this->getAddressInfo($order_info, "payment"),
 					'shipToAddress'=> $this->getAddressInfo($order_info, "shipping"),
 					'card'=> $this->getCreditCardInfo(),
 		);
 		
 		$hash_in = array_merge($this->merchantDataFromOC(), $litle_order_info);
 		
 		$litleResponseMessagePrefix = "";
 		$litleRequest = new LitleOnlineRequest($treeResponse=true);
 		$doingAuth = $this->config->get('litle_transaction') == "auth";
		if($doingAuth) {
			//auth txn
			$response = $litleRequest->authorizationRequest($hash_in);
			$litleResponseMessagePrefix = "LitleAuthTxn: ";
			$code = strval($response->authorizationResponse->response);
			$litleTxnId = strval($response->authorizationResponse->litleTxnId);
			$avsResponse = strval($response->authorizationResponse->fraudResult->avsResult);
			$cvvResponse = strval($response->authorizationResponse->fraudResult->cardValidationResult);
			$authCode = strval($response->authorizationResponse->authCode);
		}
		else {
			//sale txn
			$response = $litleRequest->saleRequest($hash_in);
			$litleResponseMessagePrefix = "LitleSaleTxn: ";
			$code = strval($response->saleResponse->response);
			$litleTxnId = strval($response->saleResponse->litleTxnId);
            $avsResponse = strval($response->saleResponse->fraudResult->avsResult);
            $cvvResponse = strval($response->saleResponse->fraudResult->cardValidationResult);
            $authCode = strval($response->saleResponse->authCode);
		}
		
		$cvvResponseMap = array(
                "M"=>"Match",
                "N"=>"No Match",
                "P"=>"Not Processed",
                "S"=>"CVV2/CVC2/CID should be on the card, but the merchant has indicated CVV2/CVC2/CID is not present",
                "U"=>"Issuer is not certified for CVV2/CVC2/CID processing",
                ""=>"Check was not done for an unspecified reason"
        );
        $cvvResponse = $cvvResponse . " - " . $cvvResponseMap[$cvvResponse];
		$avsResponseMap = array(
            "00" => "5-Digit zip and address match",
            "01" => "9-Digit zip and address match",
            "02" => "Postal code and address match",
            "10" => "5-Digit zip matches, address does not match",
            "11" => "9-Digit zip matches, address does not match",
            "12" => "Zip does not match, address matches",
            "13" => "Postal code does not match, address matches",
            "14" => "Postal code matches, address not verified",
            "20" => "Neither zip nor address match",
            "30" => "AVS service not supported by issuer",
            "31" => "AVS system not available",
            "32" => "Address unavailable",
            "33" => "General error",
            "34" => "AVS not performed",
            "40" => "Address failed Litle & Co. edit checks"
		);
		if(array_key_exists($avsResponse, $avsResponseMap)) {
			$avsResponse = $avsResponse . " - " . $avsResponseMap[$avsResponse];
		}  
		
		$litleValidationMessage = $response->message;
		
		$softDeclineCodes = array("100","101","102","110","120","349","350","356","368","372","601","602");
		$genericErrorSoftDecline = "This method of payment has been declined.  Please try another method of payment or contact us for further help";
		$genericErrorHardDecline = "This method of payment has been declined.  Please try another method of payment or contact us for further help";
		
		$json = array();
		if($code == "000") { //Success
			if($doingAuth) {
				$orderStatusId = 1; //Pending
			}
			else {
				$orderStatusId = 2; //Processing
			}
			$message = "Approval\n" . $litleResponseMessagePrefix . $litleValidationMessage . " \n Litle Response Code: " . $code . "\n  Litle Transaction ID: " . $litleTxnId . " \nAVS Response: " . $avsResponse . "\nCard Validation Response: " . $cvvResponse . "\nAuthCode: " . $authCode;
			$json['success'] = $this->url->link('checkout/success', '', 'SSL');
            $this->model_checkout_order->confirm(
                $order_info['order_id'], 
                $orderStatusId,
                $message,
                true
            );
		}
		else if(in_array($code, $softDeclineCodes)){ //Soft decline
			$orderStatusId = 8; //Denied
            $message = "Soft Decline\n" . $litleResponseMessagePrefix . $litleValidationMessage . " \n Litle Response Code: " . $code . "\n  Litle Transaction ID: " . $litleTxnId . " \nAVS Response: " . $avsResponse . "\nCard Validation Response: " . $cvvResponse . "\nAuthCode: " . $authCode;
			$json['error'] = $genericErrorSoftDecline;
            $this->model_checkout_order->update(
                $order_info['order_id'], 
                $orderStatusId,
                $message,
                false
            );
		}
		else {
		    //Do we have a code, if so, hard decline
		    $orderStatusId = 8; //Denied
		    $json['error'] = $genericErrorHardDecline;
		    if(!empty($code)) {
                $message = $litleResponseMessagePrefix . $litleValidationMessage . " \n Litle Response Code: " . $code . "\n  Litle Transaction ID: " . $litleTxnId . " \nAVS Response: " . $avsResponse . "\nCard Validation Response: " . $cvvResponse . "\nAuthCode: " . $authCode;
			}
			else { //The xml is invalid, incorrect username/password, or other configuration error
			    //scrub the card number and password
                $hash_in['password'] = preg_replace("/./", "*", $hash_in['password']);
                $hash_in['card']['number'] = preg_replace("/./","*",$hash_in['card']['number'],strlen($hash_in['card']['number'])-4);
			    $message = "The xml sent to Litle failed.\nRequest XML:\n" . print_r($hash_in, TRUE) . "\nResponse XML:\n" . htmlentities($response->asXML());
			}
            $this->model_checkout_order->update(
                $order_info['order_id'], 
                $orderStatusId,
                $message,
                false
            );
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>