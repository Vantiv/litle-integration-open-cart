Litle Open Cart Integration
---------------------------

About Litle
------------
[Litle &amp; Co.](http://www.litle.com) powers the payment processing engines for leading companies that sell directly to consumers through  internet retail, direct response marketing (TV, radio and telephone), and online services. Litle & Co. is the leading, independent authority in card-not-present (CNP) commerce, transaction processing and merchant services.


About this SDK
--------------
The Litle Open Cart integration enables processing payments through Litle for all users of Open Cart.  
This allows simple integration with Litle's payment system.

See [Open Cart]("http://www.opencart.com/") for more information.


Setup
-----

1) To begin you mmust donwload and install v. 1.5.3.1 of Opencart. Follow the directions and find the download on the [Open Cart Website]("http://www.opencart.com/").

2) Install VQMOD-2.1.5-opencart. Follow the directions and find the download at  [VQMOD Website]("http://code.google.com/p/vqmod/"). Make sure that all files in VQMOD are read/writeable or the installation will cause opencart to fail.
 
3) Download the Litle Integration 

>git clone git://github.com/LitleCo/litle-integration-open-cart.git

4) Copy all of the files in the upload directory of litle-integration-open-cart into the upload directory of open cart preserving directory structure.
   Note: The simplist way to do this is in a fliw browser select folders inside upload and copy and paste them into the open cart upload folder. This will write in teh new Litle files while preserving the original opencart files.
   
5) Open open cart admin and go to Extensions->Payments. Find Litle in the list and select Install. 

6) After successful installation, click the edit option and enter your configuration details.
   Note: For testing purposes please select Sandbox as the URL.
   Note: The only required fields are merchant_ID, username and password, which can be set to anything while using the sandbox.

7) Test that the system is working correctly.

   - proceed to the storefront and checkout. Select Litle Credit Card as the payment method and enter:
     VI for type, 4242424242424242 as the number and any three digits for the CVV as well as a futre date for the exp Date
 
  - after hitting submit, proceed to the admin panel and go to Sales->orders. The new order should be dispayed here as well as the option to capture, reverse and view the auth. Select Capture and a success message should be displayed on the top left of the form. 

Please contact Lilte & Co. with any further questions.   You can reach us at SDKSupport@litle.com