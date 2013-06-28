<?php
require_once DIR_SYSTEM . 'library/litle/LitleOnline.php';

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
		$this->data['litle_proxy'] = $this->language->get('litle_proxy');
		$this->data['litle_timeout'] = $this->language->get('litle_timeout');
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
			$this->data['litle_default_report_group'] = ($this->config->get('litle_default_report_group') == "") ? "Default Report Group" : $this->config->get('litle_default_report_group');
		}

		if (isset($this->request->post['litle_url'])) {
			$this->data['litle_url'] = $this->request->post['litle_url'];
		} else {
			$this->data['litle_url'] = $this->config->get('litle_url');
		}
		
		if (isset($this->request->post['litle_proxy_value'])) {
			$this->data['litle_proxy_value'] = $this->request->post['litle_proxy_value'];
		} else {
			$this->data['litle_proxy_value'] = $this->config->get('litle_proxy_value');
		}
		
		if (isset($this->request->post['litle_timeout_value'])) {
			$this->data['litle_timeout_value'] = $this->request->post['litle_timeout_value'];
		} else {
			$this->data['litle_timeout_value'] = $this->config->get('litle_timeout_value');
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
		set_error_handler('error_handler');
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
	
	public function findLitleTxnId($txnType=NULL)
	{
		$order_id = $this->request->get['order_id'];
		$this->load->model('sale/order');
		$total_order_histories = $this->model_sale_order->getTotalOrderHistories($order_id);
		$all_order_history = $this->model_sale_order->getOrderHistories($order_id, 0, $total_order_histories);
		
		if( $txnType == NULL )
			$txnType = "Litle";
		
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

/* 
+-----------------+-------------+-------------------+
| order_status_id | language_id | name              |
+-----------------+-------------+-------------------+
|               1 |           1 | Pending           | 
|               2 |           1 | Processing        | 
|               3 |           1 | Shipped           | 
|               5 |           1 | Complete          | 
|               7 |           1 | Canceled          | 
|               8 |           1 | Denied            | 
|               9 |           1 | Canceled Reversal | 
|              10 |           1 | Failed            | 
|              11 |           1 | Refunded          | 
|              12 |           1 | Reversed          | 
|              13 |           1 | Chargeback        | 
|              14 |           1 | Expired           | 
|              15 |           1 | Processed         | 
|              16 |           1 | Voided            | 
+-----------------+-------------+-------------------+
*/
	public function makeTheTransaction($typeOfTransaction)
	{
		restore_error_handler();
		$this->load->language('payment/litle');
		
		$order_id = $this->request->get['order_id'];
		
		$this->load->model('sale/order');
		$total_order_histories = $this->model_sale_order->getTotalOrderHistories($order_id);
		$latest_order_history = $this->model_sale_order->getOrderHistories($order_id, 0, $total_order_histories);
		$latest_order_status_id = $latest_order_history[0]['order_status_id'];

		$merchantConfig = $this->merchantDataFromOC();
		$litleRequest = new LitleOnlineRequest($treeResponse=true);
		
		// Refunds
		if($typeOfTransaction == "Refund")
		{
			$litleTextToLookFor = $this->language->get('text_litle_capture_txn');
			$hash_in = array_merge($merchantConfig, $this->getHashInWithLitleTxnId("Litle Transaction ID:"));
			$response = $litleRequest->creditRequest($hash_in);
			$code = strval($response->creditResponse->response);
			$responseMessage = strval($response->creditResponse->message);
			$litleTxnId = strval($response->creditResponse->litleTxnId);
			$comment = "LitleRefundTxn:\nLitle Response Code: " . $code . "\nLitle Transaction ID: " . $litleTxnId . "\nLitle Message: " . $responseMessage;
			if($code == "000") {
			    $data = array('order_status_id'=>11,'comment'=>$comment); //Refunded			                
                $this->model_sale_order->addOrderHistory($order_id, $data);
			}
			else {
			    $this->error['warning'] = $comment;
                $data = array('order_status_id'=>$latest_order_status_id,'comment'=>$comment); //Don't change the status                            
                $this->model_sale_order->addOrderHistory($order_id, $data);
			}
		}
        else if($typeOfTransaction == "Capture")
        {
            $litleTextToLookFor = $this->language->get('text_litle_capture_txn');
            $hash_in = array_merge($merchantConfig, $this->getHashInWithLitleTxnId("Litle Transaction ID:"));
            $response = $litleRequest->captureRequest($hash_in);
            $code = strval($response->captureResponse->response);
            $responseMessage = strval($response->captureResponse->message);
            $litleTxnId = strval($response->captureResponse->litleTxnId);
            $comment = "LitleCaptureTxn:\nLitle Response Code: " . $code . "\nLitle Transaction ID: " . $litleTxnId . "\nLitle Message: " . $responseMessage;
            if($code == "000") {
                $data = array('order_status_id'=>2,'comment'=>$comment); //Processing                            
                $this->model_sale_order->addOrderHistory($order_id, $data);
            }
            else {
                $this->error['warning'] = $comment;
                $data = array('order_status_id'=>$latest_order_status_id,'comment'=>$comment); //Don't change the status                            
                $this->model_sale_order->addOrderHistory($order_id, $data);
            }
        }
        else if($typeOfTransaction == "Capture")
        {
            $litleTextToLookFor = $this->language->get('text_litle_capture_txn');
            $hash_in = array_merge($merchantConfig, $this->getHashInWithLitleTxnId("Litle Transaction ID:"));
            $response = $litleRequest->authReversalRequest($hash_in);
            $code = strval($response->authReversalResponse->response);
            $responseMessage = strval($response->authReversalResponse->message);
            $litleTxnId = strval($response->authReversalResponse->litleTxnId);
            $comment = "LitleCaptureTxn:\nLitle Response Code: " . $code . "\nLitle Transaction ID: " . $litleTxnId . "\nLitle Message: " . $responseMessage;
            if($code == "000") {
                $data = array('order_status_id'=>2,'comment'=>$comment); //Processing                            
                $this->model_sale_order->addOrderHistory($order_id, $data);
            }
            else {
                $this->error['warning'] = $comment;
                $data = array('order_status_id'=>$latest_order_status_id,'comment'=>$comment); //Don't change the status                            
                $this->model_sale_order->addOrderHistory($order_id, $data);
            }
        }
		if( isset($response))
		{
			$code = XMLParser::getNode($litleResponse,'response');
			if($litleResponseCode != "000")
			{
				$order_status_id = 1;
				if( $latest_order_history ){
					$order_status_id = $latest_order_history[(count($latest_order_history)-1)]['order_status_id'];
				}
				$this->error['warning'] = "There was an error processing requested transaction. Please try again or contact Litle.";
			}
			
			$this->session->data['success'] = "Litle " . $successMessageString . " Transaction Successful!";
			
			$comment = $litleTxtToInsertInComment . ": " . XMLParser::getNode($litleResponse,'message') . " \n ". $this->language->get('text_litle_response_code') . " " . $litleResponseCode . "\n ". $this->language->get('text_litle_transaction_id'). " " . XMLParser::getNode($litleResponse,'litleTxnId');
			
			$data = array(
						'order_status_id'=>$order_status_id,
						'comment'=>$comment
			);
				
			$this->model_sale_order->addOrderHistory($order_id, $data);
		}
		else {
			$this->error['warning'] = "There was an error processing requested transaction. Please try again or contact Litle.";
		}
		
*/		
		if (isset($this->error['warning'])) {
			$this->session->data['litle_warning'] = $this->error['warning'];
		}
		set_error_handler('error_handler');
		$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}
	
	
	public function capture() {
		$this->makeTheTransaction("Capture");
	}

	public function refund() {
		$this->makeTheTransaction("Refund");
	}

	public function reauthorize() {
		$this->makeTheTransaction("ReAuthorize");
	}
	
	public function authReversal() {
		$this->makeTheTransaction("AuthReversal");
	}
	
	public function voidTxn() {
		$this->makeTheTransaction("VoidTxn");
	}
}
?>