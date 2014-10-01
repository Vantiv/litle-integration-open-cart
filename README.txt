Litle Open Cart Integration
---------------------------

About Litle
------------
Litle & Co. powers the payment processing engines for leading companies that sell directly to consumers through internet retail, direct response marketing (TV, radio and telephone), and online services. Litle & Co. is the leading, independent authority in card-not-present (CNP) commerce, transaction processing and merchant services.


About this Implementation
-------------------------
The Litle Open Cart integration enables processing payments through Litle for all Open Cart users.  
This allows simple integration with Litle's payment system.

See http://www.litle.com/developers for more information.


Setup
-----

1) To begin you must download and install v. 1.5.5.1 of Open Cart. Follow the directions and find the download on the http://www.opencart.com/.

2) Install VQMOD-2.3.2-opencart. Follow the directions and find the download at http://code.google.com/p/vqmod/. Make sure that all files and folders in VQMOD are read/write enabled or the installation will cause Open Cart to fail.
 
3) Download the Litle Integration : http://www.opencart.com/index.php?route=extension/extension/info&extension_id=5816&filter_search=litle

4) Copy all of the files in the upload directory of litle-integration-open-cart into the root directory of open cart preserving directory structure.
   Note: The simplest way to do this is to select the folders inside the file browser and copy and paste them into the Open Cart root folder. This will copy the new Litle files while preserving the original Open Cart files.
   
5) Go to Open Cart admin and go to Extensions->Payments. Find Litle in the list and select Install. 

6) After successful installation, click the edit option and enter your configuration details.
   Note: For testing purposes please select Sandbox as the URL.
   Note: The only required fields are merchant_ID, username and password; they can be set to anything while using the sandbox.

7) Test that the system is working correctly. Proceed to the storefront and checkout. Select Litle Credit Card as the payment method and enter:VI for type, 4242424242424242 as the number and any three digits for the CVV as well as a future date for the exp Date.
 
8) After hitting submit, proceed to the admin panel and go to Sales->Orders. The new order should be dispayed here as well as the option to Capture, Reverse and View the auth. Click on "Capture" and a success message should be displayed on the top left of the form. 

Please contact Lilte & Co. with any further questions.   You can reach us at SDKSupport@litle.com

Questions and Answers
------------------------------------------------
1) I cannot choose Prelive as option in "URL" on admin page. How can I connect to Prelive now ?
A : This is known problem. We are working to fix this. Meanwhile, you can change the admin/view/template/payment/litle.tpl
    to add more options for different environments mentioned in system/library/litle/UrlMapper.php file. We added all right
    URLs to UrlMapper.php but didnot add to litle.tpl file. Once added in .tpl file, they should be exposed on admin page
    and it should work because real url mapped in UrlMapper.php are right urls.
