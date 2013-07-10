INSERT INTO oc_order (order_id,invoice_no,invoice_prefix,store_id,store_name,store_url,customer_id,customer_group_id,firstname,lastname,email,telephone,fax,payment_firstname,payment_lastname,payment_company,payment_company_id,payment_tax_id,payment_address_1,payment_address_2,payment_city,payment_postcode,payment_country,payment_country_id,payment_zone,payment_zone_id,payment_address_format,payment_method,payment_code,shipping_firstname,shipping_lastname,shipping_company,shipping_address_1,shipping_address_2,shipping_city,shipping_postcode,shipping_country,shipping_country_id,shipping_zone,shipping_zone_id,shipping_address_format,shipping_method,shipping_code,comment,total,order_status_id,affiliate_id,commission,language_id,currency_id,currency_code,currency_value,ip,forwarded_ip,user_agent,accept_language,date_added,date_modified) VALUES (1000,0,'INV-2013-00',0,'Your Store','http://localhost/opencart-1.5.5.1/upload/',1,1,'Greg','Dake','gdake@litle.com','123','','Greg','Dake','','','','456','','789','12345','United States',223,'Alabama',3613,'{firstname} {lastname}
{company}
{address_1}
{address_2}
{city}, {zone} {postcode}
{country}','Credit Card / Debit Card (Litle & Co.)','litle','Greg','Dake','','456','','789','12345','United States',223,'Alabama',3613,'{firstname} {lastname}
{company}
{address_1}
{address_2}
{city}, {zone} {postcode}
{country}','Flat Shipping Rate','flat.flat','',105.0000,2,0,0.0000,1,2,'USD',1.00000000,'127.0.0.1','','Mozilla/5.0 (X11; Linux i686 on x86_64; rv:11.0) Gecko/20100101 Firefox/11.0','en-us,en;q=0.5',{ts '2013-06-26 14:47:33'},{ts '2013-07-09 16:11:49'});

INSERT INTO oc_order_history (order_history_id,order_id,order_status_id,notify,comment,date_added) VALUES (5000,1000,1,true,'Approval
LitleCaptureTxn:  
 Litle Response Code: 000
  Litle Transaction ID: 819799086987265000',{ts '2013-07-03 14:46:48'});
