<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 9/5/17
 * Time: 11:54 AM
 * ***!!!!!!   Never Add this file to the REPO  This needs to be installed manually via the deploy  !!!!!!!***
 */
//define("PROTECT_PAY_API_BASE_URL", "https://xmltestapi.propay.com");
define("PROTECT_PAY_API_BASE_URL", "https://api.propay.com/ProtectPay");
define("PROTECT_PAY_HOSTED_TRANSACTION_BASE_URL", "https://protectpay.propay.com");
define("PROTECT_PAY_BILLER_ID", "6265274863082724");
define("PROTECT_PAY_AUTH_TOKEN", "74b388c5-2a36-4071-9e79-8b87c4e34d0e");
define("PROTECT_PAY_MERCHANT_PROFILE_ID", "1507005");
define("PROTECT_PAY_PAYER_ACCOUNT_ID","9199035486971148");

/**
 * Protect Pay Methods
 *
 * Propay to Propay transfer.
 *
 * PropayApi
 *
 * Transfers/PropayToPropayTransfer
 *
 * <?xml version='1.0'?>
<!DOCTYPE Request.dtd>
<XMLRequest>
<certStr>MyCertStr</certStr>
<class>partner</class>
<XMLTrans>
<transType>13</transType>
<externalId>TEST</externalId>
</XMLTrans>
</XMLRequest>
Sample XML Response:
<XMLResponse>
<XMLTrans>
<transType>13</transType>
<accountNum>1148111</accountNum>
<tier>Premium</tier>
<expiration>11/27/2025 12:00:00 AM</expiration>
<signupDate>4/17/2008 3:17:00 PM</signupDate>
<affiliation>SRKUUW9 </affiliation>
<accntStatus>Ready</accntStatus>
<addr>123 Anywhere St</addr>
<city>Lehi</city>
<state>UT</state>
<zip>84043</zip>
<status>00</status>
<apiReady>Y</apiReady>
<currencyCode>USD</currencyCode>
<CreditCardTransactionLimit>65000</CreditCardTransactionLimit>
<CreditCardMonthLimit>250000</CreditCardMonthLimit>
<ACHPaymentPerTranLimit>1000</ACHPaymentPerTranLimit>
<ACHPaymentMonthLimit>5000</ACHPaymentMonthLimit>
<CreditCardMonthlyVolume>0</CreditCardMonthlyVolume>
<ACHPaymentMonthlyVolume>0</ACHPaymentMonthlyVolume>
<ReserveBalance>0</ReserveBalance>
</XMLTrans>
</XMLResponse>
 *
 *
 *
 * <?xml version='1.0'?>
<!DOCTYPE Request.dtd>
<XMLRequest>
<certStr>My certStr</certStr>
<class>partner</class>
<XMLTrans>
<transType>38</transType>
<amount>100</amount>
<accountNum>123456</accountNum>
</XMLTrans>
</XMLRequest>
Sample XML Response:
<XMLResponse>
<XMLTrans>
<transType>38</transType>
<accountNum>123456</accountNum>  //account number from signup or in main credentials
<status>00</status>
<transNum>1820</transNum>
</XMLTrans>
</XMLResponse>
 *
 *
 * Sample REST request URI:
https://xmltestapi.propay.com/protectpay/Payers/5823760912097888/PaymentMethods/ProcessedTransactions/
Sample JSON request data:
{
"PaymentMethodId":"deabf6cf-7325-4547-83e0-54ebeb06eeb4",
"IsRecurringPayment":false,
"CreditCardOverrides":
{
"FullName":"Test User",
"ExpirationDate":"1014",
"CVV":"999",
"Billing":
{
"Address1":"3400 N Ashton Blvd",
"Address2":"Suite 200",
"Address3":"",
"City":"Lehi",
"State":"UT",
"ZipCode":"84043",
"Country":"USA",
"TelephoneNumber":"8012223333",
"Email":"test@user.com"
}
},
"AchOverrides":null,
"PayerOverrides":
{
"IpAddress":"127.0.0.1"
},
"MerchantProfileId":1234,
"PayerAccountId":"5823760912097888",
"Amount":300,
"CurrencyCode":"USD",
"Invoice":"7e9e6542-febb-4883-95ec-956d305e0143",
"Comment1":"Credit Comment 1",
"Comment2":"Credit Comment 2",
©2017 – ProPay Inc. All rights reserved. Reproduction, adaptation, or translation of this document without ProPay Inc.’s prior written permission is prohibited except as allowed under copyright laws .
Page 125"IsDebtRepayment":"true"
}
Sample JSON response data:
{
"Transaction":
{
"AVSCode": "T",
"AuthorizationCode": "A11111",
"CurrencyConversionRate": 1,
"CurrencyConvertedAmount": 300,
"CurrencyConvertedCurrencyCode": "USD",
"ResultCode":
{
"ResultValue": "SUCCESS",
"ResultCode": "00",
"ResultMessage": ""
},
"TransactionHistoryId": "7911897",
"TransactionId": "528",
"TransactionResult": "Success",
"CVVResponseCode": "M",
"GrossAmt": 300,
"NetAmt": 255,
"PerTransFee": 35,
"Rate": 3.25,
"GrossAmtLessNetAmt": 45
},
"RequestResult":
{
"ResultValue": "SUCCESS",
"ResultCode": "00",
"ResultMessage": ""
}
}
 *
 */

