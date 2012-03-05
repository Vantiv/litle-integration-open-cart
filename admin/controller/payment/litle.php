<?php
require_once($vqmod->modCheck(DIR_SYSTEM . 'library/litle/LitleOnline.php'));

class ControllerPaymentLitle extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/litle');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('litle', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_authorization'] = $this->language->get('text_authorization');
		$this->data['text_sale'] = $this->language->get('text_sale');
		$this->data['text_cert'] = $this->language->get('text_cert');
		$this->data['text_precert'] = $this->language->get('text_precert');
		$this->data['text_sandbox'] = $this->language->get('text_sandbox');
		$this->data['text_production'] = $this->language->get('text_production');

		$this->data['merchant_id'] = $this->language->get('merchant_id');
		$this->data['merchant_user_name'] = $this->language->get('merchant_user_name');
		$this->data['merchant_password'] = $this->language->get('merchant_password');
		$this->data['default_report_group'] = $this->language->get('default_report_group');
		$this->data['entry_mode'] = $this->language->get('entry_mode');
		$this->data['entry_transaction'] = $this->language->get('entry_transaction');
		$this->data['entry_debug'] = $this->language->get('entry_debug');
		$this->data['entry_total'] = $this->language->get('entry_total');

		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['merchant_id'])) {
			$this->data['error_merchant_id'] = $this->error['merchant_id'];
		} else {
			$this->data['error_merchant_id'] = '';
		}

		if (isset($this->error['merchant_user_name'])) {
			$this->data['error_merchant_user_name'] = $this->error['merchant_user_name'];
		} else {
			$this->data['error_merchant_user_name'] = '';
		}

		if (isset($this->error['merchant_password'])) {
			$this->data['error_merchant_password'] = $this->error['merchant_password'];
		} else {
			$this->data['error_merchant_password'] = '';
		}

		if (isset($this->error['url'])) {
			$this->data['error_url'] = $this->error['url'];
		} else {
			$this->data['error_url'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),      		
      		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/litle', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/litle', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['litle_merchant_id'])) {
			$this->data['litle_merchant_id'] = $this->request->post['litle_merchant_id'];
		} else {
			$this->data['litle_merchant_id'] = $this->config->get('litle_merchant_id');
		}

		if (isset($this->request->post['litle_merchant_user_name'])) {
			$this->data['litle_merchant_user_name'] = $this->request->post['litle_merchant_user_name'];
		} else {
			$this->data['litle_merchant_user_name'] = $this->config->get('litle_merchant_user_name');
		}

		if (isset($this->request->post['litle_merchant_password'])) {
			$this->data['litle_merchant_password'] = $this->request->post['litle_merchant_password'];
		} else {
			$this->data['litle_merchant_password'] = $this->config->get('litle_merchant_password');
		}

		if (isset($this->request->post['litle_default_report_group'])) {
			$this->data['litle_default_report_group'] = $this->request->post['litle_default_report_group'];
		} else {
			$this->data['litle_default_report_group'] = "Default Report Group";
		}

		if (isset($this->request->post['litle_url'])) {
			$this->data['litle_url'] = $this->request->post['litle_url'];
		} else {
			$this->data['litle_url'] = $this->config->get('litle_url');
		}

		if (isset($this->request->post['litle_transaction'])) {
			$this->data['litle_transaction'] = $this->request->post['litle_transaction'];
		} else {
			$this->data['litle_transaction'] = $this->config->get('litle_transaction');
		}

		if (isset($this->request->post['litle_debug'])) {
			$this->data['litle_debug'] = $this->request->post['litle_debug'];
		} else {
			$this->data['litle_debug'] = $this->config->get('litle_debug');
		}

		if (isset($this->request->post['litle_total'])) {
			$this->data['litle_total'] = $this->request->post['litle_total'];
		} else {
			$this->data['litle_total'] = $this->config->get('litle_total');
		}

		$this->data['litle_timeout'] = 65;
		$this->data['litle_proxy_addr'] = "smoothproxy";
		$this->data['litle_proxy_port'] = "8080";

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['litle_geo_zone_id'])) {
			$this->data['litle_geo_zone_id'] = $this->request->post['litle_geo_zone_id'];
		} else {
			$this->data['litle_geo_zone_id'] = $this->config->get('litle_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['litle_status'])) {
			$this->data['litle_status'] = $this->request->post['litle_status'];
		} else {
			$this->data['litle_status'] = $this->config->get('litle_status');
		}

		if (isset($this->request->post['litle_sort_order'])) {
			$this->data['litle_sort_order'] = $this->request->post['litle_sort_order'];
		} else {
			$this->data['litle_sort_order'] = $this->config->get('litle_sort_order');
		}

		$this->template = 'payment/litle.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/litle')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['litle_merchant_id']) {
			$this->error['merchant_id'] = $this->language->get('error_merchant_id');
		}

		if (!$this->request->post['litle_merchant_user_name']) {
			$this->error['merchant_user_name'] = $this->language->get('error_merchant_user_name');
		}

		if (!$this->request->post['litle_merchant_password']) {
			$this->error['merchant_password'] = $this->language->get('error_merchant_password');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	// ##############################################################################
	// ################ Call handlers from Orders Page -- admin side ################
	public function findLitleTxnId($txnType)
	{
		$order_id = $this->request->get['order_id'];
		$this->load->model('sale/order');
		$total_order_histories = $this->model_sale_order->getTotalOrderHistories($order_id);
		$all_order_history = $this->model_sale_order->getOrderHistories($order_id, 0, $total_order_histories);
		
		$i = 0;
		for($i = ($total_order_histories -1) ; $i >= 0; $i--)
		{
			if(strpos($all_order_history[$i]['comment'],$txnType) !== FALSE){
				break;
			}
		}
		
		preg_match("/.*Transaction ID: (\d+).*/", $all_order_history[$i]['comment'], $litleTxnID);
		
		return $litleTxnID[1];
	}
	
	public function getHashInWithLitleTxnId($textToLookFor)
	{
		return array(
				 					'litleTxnId'=>$this->findLitleTxnId($textToLookFor)
		);
	}
	
	public function makeTheTransaction($typeOfTransaction)
	{
		echo "in make the transaction <br>";
		restore_error_handler();
		$order_id = $this->request->get['order_id'];
		echo "order id found: " . $order_id . " <br>";
		
		$this->load->model('sale/order');
		$total_order_histories = $this->model_sale_order->getTotalOrderHistories($order_id);
		$latest_order_history = $this->model_sale_order->getOrderHistories($order_id, 0, $total_order_histories);
		echo "model loaded; total_order_histories: " . $total_order_histories . " <br>";
		
		//********************************************************	
		//TODO: add support for partial capture and partial refund
		//********************************************************
		
		$litleTextToLookFor = "";
		$litleTextToInsertInComment = "";
		$order_status_id = 1;
		$hash_in = array();
		$litleRequest = new LitleOnlineRequest();
		$litleResponse = "";
		
		if($typeOfTransaction == "Refund" || $typeOfTransaction == "PartialRefund")
		{
			echo "in refund <br>";
			//TODO: ADD SUPPORT!!
			// need to add to the $hash_in the amount and other required/optional fields
			if($typeOfTransaction == "PartialRefund")
			{
				$order_status_id = 5;
				$litleTxtToInsertInComment = "LitlePartialRefundTxn";
			}
			else
			{
				$order_status_id = 11;
				$litleTxtToInsertInComment = "LitleRefundTxn";
			}
			$litleTextToLookFor = "LitleRefundableTxn";
			$hash_in = $this->getHashInWithLitleTxnId($litleTextToLookFor);
			$litleResponse = $litleRequest->creditRequest($hash_in);
		}
		else if($typeOfTransaction == "Capture" || $typeOfTransaction == "PartialCapture")
		{
			echo "in capture <br>";
			//TODO: ADD SUPPORT!!
			// need to add to the $hash_in the amount and other required/optional fields
			if($typeOfTransaction == "PartialCapture")
			{
				$order_status_id = 2;
			}
			else
			{
				$order_status_id = 5;
			}
			$litleTextToLookFor = "LitleCapturableTxn";
			$litleTxtToInsertInComment = "LitleRefundableTxn";
			$hash_in = $this->getHashInWithLitleTxnId($litleTextToLookFor);
			var_dump($hash_in);
			echo "<br>";
			$litleResponse = $litleRequest->captureRequest($hash_in);
			var_dump($litleResponse);
			echo "<br>";
		}
		else if($typeOfTransaction == "ReAuthorize")
		{
			echo "in reauth <br>";
			$order_status_id = 1;
			$litleTextToLookFor = "LitleCapturableTxn";
			$litleTxtToInsertInComment = "LitleCapturableTxn";
			$hash_in = $this->getHashInWithLitleTxnId($litleTextToLookFor);
			$litleResponse = $litleRequest->authorizationRequest($hash_in);
		}
		else if($typeOfTransaction == "AuthReversal" || $typeOfTransaction == "PartialAuthReversal")
		{
			echo "in AuthReversal <br>";
			//TODO: ADD SUPPORT!!
			// need to add to the $hash_in the amount and other required/optional fields
			if($typeOfTransaction == "PartialAuthReversal")
			{
				$order_status_id = 7;
			}
			else
			{
				$order_status_id = 15;
			}
			$litleTextToLookFor = "LitleCapturableTxn";
			$litleTxtToInsertInComment = "LitleTxn";
			$hash_in = $this->getHashInWithLitleTxnId($litleTextToLookFor);
			$litleResponse = $litleRequest->authReversalRequest($hash_in);
		}
		echo "out of whatever type of transaction we were doing... <br>";
		
		
		if( isset($litleResponse))
		{
			echo "response code is: " . XMLParser::getNode($litleResponse,'response') . " <br>";
			if(XMLParser::getNode($litleResponse,'response') != "000")
			{
				$order_status_id = 1;
				if( $latest_order_history ){
					$order_status_id = $latest_order_history[0]['order_status_id'];
				}
			}
			$comment = $litleTxtToInsertInComment . ": " . XMLParser::getNode($litleResponse,'message') . " \n Transaction ID: " . XMLParser::getNode($litleResponse,'litleTxnId');
			$data = array(
									'order_status_id'=>$order_status_id,
									'comment'=>$comment
			);
				
			$this->model_sale_order->addOrderHistory($order_id, $data);
		}
		
		set_error_handler('error_handler');
		$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
	
	
	public function capture() {
// 		echo "in capture!";
// 		echo $this->request->get['order_id'];

// 		$order_id = $this->request->get['order_id'];

// 		$this->load->model('sale/order');
// 		$total_order_histories = $this->model_sale_order->getTotalOrderHistories($order_id);
// 		$latest_order_history = $this->model_sale_order->getOrderHistories($order_id, $total_order_histories-1, 1);

// 		echo "total order histories: " . $total_order_histories;
// 		echo "<br>";
		
// 		echo "<br><br>1: " . $latest_order_history;
// 		echo "<br><br>2: " . $latest_order_history[0];
// 		echo "<br><br>3: " . $latest_order_history[0]['comment'];

// 		echo "<br><br><br><br>";
// 		if( $latest_order_history )
// 			echo "latest order history comment: " . $latest_order_history[0]['comment'];

// 		preg_match("/.*Transaction ID: (\d+).*/", $latest_order_history[0]['comment'], $litleTxnID);
// 		//preg_match("/*Transaction ID: (\d+)*/", $latest_order_history[0]['comment'], $litleTxnID);
// 		echo "<br><br>4: " . $litleTxnID[0];
// 		echo '<br><br>litle txn ID = ' . $litleTxnID[1];
		$this->makeTheTransaction("Capture");
	}

	public function refund() {
// 		restore_error_handler();
// 		$order_id = $this->request->get['order_id'];
		
//  		$this->load->model('sale/order');
//  		$total_order_histories = $this->model_sale_order->getTotalOrderHistories($order_id);
//  		$latest_order_history = $this->model_sale_order->getOrderHistories($order_id, 0, $total_order_histories);
		
 		
//  		$hash_in = array(
//  					'litleTxnId'=>$this->findLitleTxnId("LitleRefundableTxn")
//  		);
		
// 		$litleRequest = new LitleOnlineRequest();
// 		$creditResponse = $litleRequest->creditRequest($hash_in);
		
// 		if( isset($creditResponse))
// 		{
// 			$order_status_id = 11;
// 			if(XMLParser::getNode($creditResponse,'response') != "000")
// 			{
// 				$order_status_id = 100;
// 				if( $latest_order_history ){
// 					$order_status_id = $latest_order_history[0]['order_status_id'];
// 				}
// 			}
// 			$comment = XMLParser::getNode($creditResponse,'message') . " \n Transaction ID: " . XMLParser::getNode($creditResponse,'litleTxnId');
// 			$data = array(
// 							'order_status_id'=>$order_status_id,
// 							'comment'=>$comment
// 			);
			
// 			$this->model_sale_order->addOrderHistory($order_id, $data);
// 		}	
		
// 		set_error_handler('error_handler');
//  		$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		$this->makeTheTransaction("Refund");
	}

	public function reauthorize() {
		echo "in reauthorize!";
	}
}

?>