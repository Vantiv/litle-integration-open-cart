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
require_once realpath(dirname(__FILE__)) . "/LitleOnline.php";

class XMLFields
{
	public static function returnArrayValue($hash_in, $key)
	{
		$retVal = array_key_exists($key, $hash_in)? $hash_in[$key] : null;
		return $retVal;
	}

	public static function contact($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"name"=>XMLFields::returnArrayValue($hash_in, "name"),
						"firstName" =>XMLFields::returnArrayValue($hash_in, "firstName"),
						"middleInitial"=>XMLFields::returnArrayValue($hash_in, "middleInitial"),
						"lastName"=>XMLFields::returnArrayValue($hash_in, "lastName"),
						"companyName"=>XMLFields::returnArrayValue($hash_in, "companyName"),
						"addressLine1"=>XMLFields::returnArrayValue($hash_in, "addressLine1"),
						"addressLine2"=>XMLFields::returnArrayValue($hash_in, "addressLine2"),
						"addressLine3"=>XMLFields::returnArrayValue($hash_in, "addressLine3"),
						"city"=>XMLFields::returnArrayValue($hash_in, "city"),
						"state"=>XMLFields::returnArrayValue($hash_in, "state"),
						"zip"=>XMLFields::returnArrayValue($hash_in, "zip"),
						"country"=>XMLFields::returnArrayValue($hash_in, "country"),
						"email"=>XMLFields::returnArrayValue($hash_in, "email"),
						"phone"=>XMLFields::returnArrayValue($hash_in, "phone")
			);
			return $hash_out;
		}

	}

	public static function customerInfo($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out=	array(
						"ssn"=>XMLFields::returnArrayValue($hash_in, "ssn"),
						"dob"=>XMLFields::returnArrayValue($hash_in, "dob"),
						"customerRegistrationDate"=>XMLFields::returnArrayValue($hash_in, "customerRegistrationDate"),
						"customerType"=>XMLFields::returnArrayValue($hash_in, "customerType"),
						"incomeAmount"=>XMLFields::returnArrayValue($hash_in, "incomeAmount"),
						"incomeCurrency"=>XMLFields::returnArrayValue($hash_in, "incomeCurrency"),
						"customerCheckingAccount"=>XMLFields::returnArrayValue($hash_in, "customerCheckingAccount"),
						"customerSavingAccount"=>XMLFields::returnArrayValue($hash_in, "customerSavingAccount"),
						"customerWorkTelephone"=>XMLFields::returnArrayValue($hash_in, "customerWorkTelephone"),
						"residenceStatus"=>XMLFields::returnArrayValue($hash_in, "residenceStatus"),
						"yearsAtResidence"=>XMLFields::returnArrayValue($hash_in, "yearsAtResidence"),
						"yearsAtEmployer"=>XMLFields::returnArrayValue($hash_in, "yearsAtEmployer")
			);
			return $hash_out;
		}
	}

	public static function billMeLaterRequest($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"bmlMerchantId"=>XMLFields::returnArrayValue($hash_in, "bmlMerchantId"),
						"termsAndConditions"=>XMLFields::returnArrayValue($hash_in, "termsAndConditions"),
						"preapprovalNumber"=>XMLFields::returnArrayValue($hash_in, "preapprovalNumber"),
						"merchantPromotionalCode"=>XMLFields::returnArrayValue($hash_in, "merchantPromotionalCode"),
						"customerPasswordChanged"=>XMLFields::returnArrayValue($hash_in, "customerPasswordChanged"),
						"customerEmailChanged"=>XMLFields::returnArrayValue($hash_in, "customerEmailChanged"),
						"customerPhoneChanged"=>XMLFields::returnArrayValue($hash_in, "customerPhoneChanged"),
						"secretQuestionCode"=>XMLFields::returnArrayValue($hash_in, "secretQuestionCode"),
						"secretQuestionAnswer"=>XMLFields::returnArrayValue($hash_in, "secretQuestionAnswer"),
						"virtualAuthenticationKeyPresenceIndicator"=>XMLFields::returnArrayValue($hash_in, "virtualAuthenticationKeyPresenceIndicator"),
						"virtualAuthenticationKeyData"=>XMLFields::returnArrayValue($hash_in, "virtualAuthenticationKeyData"),
						"itemCategoryCode"=>XMLFields::returnArrayValue($hash_in, "itemCategoryCode"),
						"authorizationSourcePlatform"=>XMLFields::returnArrayValue($hash_in, "authorizationSourcePlatform")
			);
			return $hash_out;
		}
	}

	public static function fraudCheckType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out =	array(
						"authenticationValue"=>XMLFields::returnArrayValue($hash_in, "authenticationValue"),
						"authenticationTransactionId"=>XMLFields::returnArrayValue($hash_in, "authenticationTransactionId"),
						"customerIpAddress"=>XMLFields::returnArrayValue($hash_in, "customerIpAddress"),
						"authenticatedByMerchant"=>XMLFields::returnArrayValue($hash_in, "authenticatedByMerchant")
			);
			return $hash_out;
		}
	}

	public static function authInformation($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"authDate"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "authDate"))),
						"authCode"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "authCode"))),
						"fraudResult"=>XMLFields::fraudResult(returnArrayValue($hash_in, "fraudResult")),
						"authAmount"=>XMLFields::returnArrayValue($hash_in, "authAmount")
			);
			return $hash_out;
		}
	}

	public static function fraudResult($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out= 	array(
						"avsResult"=>XMLFields::returnArrayValue($hash_in, "avsResult"),
						"ardValidationResult"=>XMLFields::returnArrayValue($hash_in, "cardValidationResult"),
						"authenticationResult"=>XMLFields::returnArrayValue($hash_in, "authenticationResult"),
						"advancedAVSResult"=>XMLFields::returnArrayValue($hash_in, "advancedAVSResult")
			);
			return $hash_out;
		}
	}

	public static function healthcareAmounts($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"totalHealthcareAmount"=>XMLFields::returnArrayValue($hash_in, "totalHealthcareAmount"),
						"RxAmount"=>XMLFields::returnArrayValue($hash_in, "RxAmount"),
						"visionAmount"=>XMLFields::returnArrayValue($hash_in, "visionAmount"),
						"clinicOtherAmount"=>XMLFields::returnArrayValue($hash_in, "clinicOtherAmount"),
						"dentalAmount"=>XMLFields::returnArrayValue($hash_in, "dentalAmount")
			);
			return $hash_out;
		}
	}

	public static function healthcareIIAS($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"healthcareAmounts"=>(XMLFields::healthcareAmounts(XMLFields::returnArrayValue($hash_in, "healthcareAmounts"))),
						"IIASFlag"=>XMLFields::returnArrayValue($hash_in, "IIASFlag")
			);
			return $hash_out;
		}
	}

	public static function pos($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"capability"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "capability"))),
						"entryMode"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "entryMode"))),
						"cardholderId"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "cardholderId")))
			);
			return $hash_out;
			echo 'here';
		}
	}

	public static function detailTax($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"taxIncludedInTotal"=>XMLFields::returnArrayValue($hash_in, "taxIncludedInTotal"),
						"taxAmount"=>XMLFields::returnArrayValue($hash_in, "taxAmount"),
						"taxRate"=>XMLFields::returnArrayValue($hash_in, "taxRate"),
						"taxTypeIdentifier"=>XMLFields::returnArrayValue($hash_in, "taxTypeIdentifier"),
						"cardAcceptorTaxId"=>XMLFields::returnArrayValue($hash_in, "cardAcceptorTaxId")
			);
			return $hash_out;
		}
	}

	public static function lineItemData($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"itemSequenceNumber"=>XMLFields::returnArrayValue($hash_in, "itemSequenceNumber"),
						"itemDescription"=>XMLFields::returnArrayValue($hash_in, "itemDescription"),
						"productCode"=>XMLFields::returnArrayValue($hash_in, "productCode"),
						"quantity"=>XMLFields::returnArrayValue($hash_in, "quantity"),
						"unitOfMeasure"=>XMLFields::returnArrayValue($hash_in, "unitOfMeasure"),
						"taxAmount"=>XMLFields::returnArrayValue($hash_in, "taxAmount"),
						"lineItemTotal"=>XMLFields::returnArrayValue($hash_in, "lineItemTotal"),
						"lineItemTotalWithTax"=>XMLFields::returnArrayValue($hash_in, "lineItemTotalWithTax"),
						"itemDiscountAmount"=>XMLFields::returnArrayValue($hash_in, "itemDiscountAmount"),
						"commodityCode"=>XMLFields::returnArrayValue($hash_in, "commodityCode"),
						"unitCost"=>XMLFields::returnArrayValue($hash_in, "unitCost"),
						"detailTax"=>(XMLFields::detailTax(returnArrayValue($hash_in, "detailTax")))
			);
			return $hash_out;
		}
	}

	public static function enhancedData($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"customerReference"=>XMLFields::returnArrayValue($hash_in, "customerReference"),
						"salesTax"=>XMLFields::returnArrayValue($hash_in, "salesTax"),
						"deliveryType"=>XMLFields::returnArrayValue($hash_in, "deliveryType"),
						"taxExempt"=>XMLFields::returnArrayValue($hash_in, "taxExempt"),
						"discountAmount"=>XMLFields::returnArrayValue($hash_in, "discountAmount"),
						"shippingAmount"=>XMLFields::returnArrayValue($hash_in, "shippingAmount"),
						"dutyAmount"=>XMLFields::returnArrayValue($hash_in, "dutyAmount"),
						"shipFromPostalCode"=>XMLFields::returnArrayValue($hash_in, "shipFromPostalCode"),
						"destinationPostalCode"=>XMLFields::returnArrayValue($hash_in, "destinationPostalCode"),
						"destinationCountryCode"=>XMLFields::returnArrayValue($hash_in, "destinationCountryCode"),
						"invoiceReferenceNumber"=>XMLFields::returnArrayValue($hash_in, "invoiceReferenceNumber"),
						"orderDate"=>XMLFields::returnArrayValue($hash_in, "orderDate"),
						"detailTax"=>(XMLFields::detailTax(returnArrayValue($hash_in, "detailTax"))),
						"lineItemData"=>(XMLFields::lineItemData(returnArrayValue($hash_in, "lineItemData")))
			);
			return $hash_out;
		}
	}

	public static function amexAggregatorData($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"sellerId"=>XMLFields::returnArrayValue($hash_in, "sellerId"),
						"sellerMerchantCategoryCode"=>XMLFields::returnArrayValue($hash_in, "sellerMerchantCategoryCode")
			);
			return $hash_out;
		}
	}

	public static function cardType($hash_in)
	{
		echo "in cardType";
		if (isset($hash_in))
		{
			echo "hash is set";
			var_dump($hash_in);
			$hash_out= 	array(
						"type"=>XMLFields::returnArrayValue($hash_in, "type"),
						"track"=>XMLFields::returnArrayValue($hash_in, "track"),
						"number"=>XMLFields::returnArrayValue($hash_in, "number"),
						"expDate"=>XMLFields::returnArrayValue($hash_in, "expDate"),
						"cardValidationNum"=>XMLFields::returnArrayValue($hash_in, "cardValidationNum")
			);
			echo "returning";
			return $hash_out;
		}
	}

	public static function cardTokenType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"litleToken"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "litleToken"))),
						"expDate"=>XMLFields::returnArrayValue($hash_in, "expDate"),
						"cardValidationNum"=>XMLFields::returnArrayValue($hash_in, "cardValidationNumber"),
						"type"=>XMLFields::returnArrayValue($hash_in, "type")
			);
			return $hash_out;
		}
	}

	public static function cardPaypageType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"paypageRegistrationId"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "paypageRegistrationId"))),
						"expDate"=>XMLFields::returnArrayValue($hash_in, "expDate"),
						"cardValidationNum"=>XMLFields::returnArrayValue($hash_in, "cardValidationNumber"),
						"type"=>XMLFields::returnArrayValue($hash_in, "type")
			);
			return $hash_out;
		}
	}

	public static function paypal($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"payerId"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "payerId"))),
						"token"=>XMLFields::returnArrayValue($hash_in, "token"),
						"transactionId"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "transactionId")))
			);
			return $hash_out;
		}
	}

	#paypal field for credit transaction
	public static function credit_paypal($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"payerId"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "payerId"))),
						"payerEmail" =>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "payerEmail")))
			);
			return $hash_out;
		}
	}

	public static function customBilling($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"phone"=>XMLFields::returnArrayValue($hash_in, "phone"),
						"city" =>XMLFields::returnArrayValue($hash_in, "city"),
						"url" =>XMLFields::returnArrayValue($hash_in, "url"),
						"descriptor" =>XMLFields::returnArrayValue($hash_in, "descriptor")
			);
			return $hash_out;
		}
	}

	public static function taxBilling($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"taxAuthority"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "taxAuthority"))),
						"state" =>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "state"))),
						"govtTxnType" =>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "govtTxnType")))
			);
			return $hash_out;
		}
	}

	public static function processingInstructions($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"bypassVelocityCheck"=>XMLFields::returnArrayValue($hash_in, "bypassVelocityCheck")
			);
			return $hash_out;
		}
	}

	public static function echeckForTokenType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"accNum"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "accNum"))),
						"routingNum" =>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "routingNum")))
			);
			return $hash_out;
		}
	}

	public static function filteringType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"prepaid"=>XMLFields::returnArrayValue($hash_in, "prepaid"),
						"international" =>XMLFields::returnArrayValue($hash_in, "international"),
						"chargeback" =>XMLFields::returnArrayValue($hash_in, "chargeback")
			);
			return $hash_out;
		}
	}

	public static function echeckType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"accType"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "accType"))),
						"accNum" =>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "accNum"))),
						"routingNum" =>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "routingNum"))),
						"checkNum" =>XMLFields::returnArrayValue($hash_in, "checkNum")
			);
			return $hash_out;
		}
	}

	public static function echeckTokenType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"litleToken"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "litleToken"))),
						"routingNum" =>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "routingNum"))),
						"accType" =>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "accType"))),
						"checkNum" =>XMLFields::returnArrayValue($hash_in, "checkNum")
			);
			return $hash_out;
		}
	}

	public static function recyclingRequestType($hash_in)
	{
		if (isset($hash_in))
		{
			$hash_out = array(
						"recycleBy"=>(Checker::requiredField(XMLFields::returnArrayValue($hash_in, "recycleBy")))
			);
			return $hash_out;
		}
	}


}
