<?php
/*
 * Copyright (c) 2011 Litle & Co.
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

if(!defined("UNIT_TESTING")) {
	define("UNIT_TESTING",true);
}

require_once realpath(dirname(__FILE__)) . "/OpenCartTest.php";

class LitlePaymentControllerAdminTest extends OpenCartTest
{
	public function setUp() {
		system("mysql -u root opencart1551 < " . dirname(__FILE__) . "/cleanup.sql");
	}
	
	function test_successful_authReversal()
	{
		system("mysql -u root opencart1551 < " . dirname(__FILE__) . "/loadSuccessfulAuth.sql");
		$order_id = 1000;
				
		$controller = $this->loadControllerByRoute("payment/litle");
		
		$this->request->get['order_id'] = $order_id;;
		
		$controller->authReversal();
		$redirectArgs = $controller->getRedirectArgs();
		$this->assertEquals("http://sdk2/opencart-1.5.5.1/upload/admin/index.php?route=sale/order",$redirectArgs['url']);
		$this->assertEquals(302,$redirectArgs['status']);
		$this->load->model('sale/order');
		$order = $this->model_sale_order->getOrder($order_id);
		$latest_order_status_id = $order['order_status_id'];
		$this->assertEquals(12, $latest_order_status_id);		
	}
	
	function test_expiredAuth_authReversal()
	{
		system("mysql -u root opencart1551 < " . dirname(__FILE__) . "/loadExpiredAuth.sql");
		$order_id = 1000;
	
		$controller = $this->loadControllerByRoute("payment/litle");
	
		$this->request->get['order_id'] = $order_id;;
	
		$controller->authReversal();
		$redirectArgs = $controller->getRedirectArgs();
		$this->assertEquals("http://sdk2/opencart-1.5.5.1/upload/admin/index.php?route=sale/order",$redirectArgs['url']);
		$this->assertEquals(302,$redirectArgs['status']);
		$this->load->model('sale/order');
		$order = $this->model_sale_order->getOrder($order_id);
		$latest_order_status_id = $order['order_status_id'];
		$this->assertEquals(14, $latest_order_status_id);
	}
	
	function test_successful_capture()
	{
		system("mysql -u root opencart1551 < " . dirname(__FILE__) . "/loadSuccessfulCapture.sql");
		$order_id = 1000;
	
		$controller = $this->loadControllerByRoute("payment/litle");
	
		$this->request->get['order_id'] = $order_id;;
	
		$controller->refund();
		$redirectArgs = $controller->getRedirectArgs();
		$this->assertEquals("http://sdk2/opencart-1.5.5.1/upload/admin/index.php?route=sale/order",$redirectArgs['url']);
		$this->assertEquals(302,$redirectArgs['status']);
		$this->load->model('sale/order');
		$order = $this->model_sale_order->getOrder($order_id);
		$latest_order_status_id = $order['order_status_id'];
		$this->assertEquals(11, $latest_order_status_id);
	}
	
	function test_refund_chargebackAlreadyExists()
	{
		system("mysql -u root opencart1551 < " . dirname(__FILE__) . "/loadChargedBackCapture.sql");
		$order_id = 1000;
	
		$controller = $this->loadControllerByRoute("payment/litle");
	
		$this->request->get['order_id'] = $order_id;;
	
		$controller->refund();
		$redirectArgs = $controller->getRedirectArgs();
		$this->assertEquals("http://sdk2/opencart-1.5.5.1/upload/admin/index.php?route=sale/order",$redirectArgs['url']);
		$this->assertEquals(302,$redirectArgs['status']);
		$this->load->model('sale/order');
		$order = $this->model_sale_order->getOrder($order_id);
		$latest_order_status_id = $order['order_status_id'];
		$this->assertEquals(11, $latest_order_status_id);
	}
	
	function test_refund_alreadyRefundedByFcps()
	{
		system("mysql -u root opencart1551 < " . dirname(__FILE__) . "/loadCaptureAlreadyRefundedByFcps.sql");
		$order_id = 1000;
	
		$controller = $this->loadControllerByRoute("payment/litle");
	
		$this->request->get['order_id'] = $order_id;;
	
		$controller->refund();
		
		$redirectArgs = $controller->getRedirectArgs();
		$this->assertEquals("http://sdk2/opencart-1.5.5.1/upload/admin/index.php?route=sale/order",$redirectArgs['url']);
		$this->assertEquals(302,$redirectArgs['status']);
		
		$this->load->model('sale/order');
		$order = $this->model_sale_order->getOrder($order_id);
		$latest_order_status_id = $order['order_status_id'];
		$this->assertEquals(11, $latest_order_status_id);
	}
	
}
