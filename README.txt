Litle Open Cart Integration
---------------------------

About Litle
------------
Litle & Co. powers the payment processing engines for leading companies that sell directly to consumers through  internet retail, direct response marketing (TV, radio and telephone), and online services. Litle & Co. is the leading, independent authority in card-not-present (CNP) commerce, transaction processing and merchant services.


About this Implementation
-------------------------
The Litle Open Cart integration enables processing payments through Litle for all Open Cart users.  
This allows simple integration with Litle's payment system.

See http://www.opencart.com/ for more information.


Setup
-----

1) To begin you must donwload and install v. 1.5.3.1 of Opencart. Follow the directions and find the download on the http://www.opencart.com/.

2) Install VQMOD-2.1.5-opencart. Follow the directions and find the download at http://code.google.com/p/vqmod/. Make sure that all files and folders in VQMOD are read/write enabled or the installation will cause Open Cart to fail.
 
3) Download the Litle Integration 

>git clone git://github.com/LitleCo/litle-integration-open-cart.git

4) Copy all of the files in the upload directory of litle-integration-open-cart into the root directory of open cart preserving directory structure.
   Note: The simplest way to do this is to select the folders inside the file browser and copy and paste them into the Open Cart root folder. This will copy the new Litle files while preserving the original Open Cart files.
   
5) Go to Open Cart admin and go to Extensions->Payments. Find Litle in the list and select Install. 

6) After successful installation, click the edit option and enter your configuration details.
   Note: For testing purposes please select Sandbox as the URL.
   Note: The only required fields are merchant_ID, username and password; they can be set to anything while using the sandbox.

7) Test that the system is working correctly. Proceed to the storefront and checkout. Select Litle Credit Card as the payment method and enter:VI for type, 4242424242424242 as the number and any three digits for the CVV as well as a future date for the exp Date.
 
8) After hitting submit, proceed to the admin panel and go to Sales->Orders. The new order should be dispayed here as well as the option to Capture, Reverse and View the auth. Click on "Capture" and a success message should be displayed on the top left of the form. 

Please contact Lilte & Co. with any further questions.   You can reach us at SDKSupport@litle.com