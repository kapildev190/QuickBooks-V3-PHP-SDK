<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
session_start();

include('src/config.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;

//    'RedirectURI'  => "http://localhost/QuickBooks-V3-PHP-SDK/getToken.php",
//    'RedirectURI'  => "https://a54e8b33.ngrok.io/QuickBooks-V3-PHP-SDK/getToken.php",
// $dataService  = DataService::Configure(array(
//     'auth_mode'    => 'oauth2',
//     'ClientID'     => "Q0GFPqZaxqnhoIerwjgkz4zS382QmsAd2Rzf7DZuXADRC2M6Lb",
//     'ClientSecret' => "K5VyFJGMEOhMayN87Du8YyDQhQxR8ehzoBImFxz4",
//     'RedirectURI'  => "https://a54e8b33.ngrok.io/QuickBooks-V3-PHP-SDK/getToken.php",
//     'scope'        => "com.intuit.quickbooks.accounting",
//     'baseUrl'      => "development"
// ));


$dataService  = DataService::Configure(array(
    'auth_mode'    => 'oauth2',
    'ClientID'     => "Q0ZCCaEyi4Mqs8WbUmkWCN2ahtvX7SLW9KDHmJktKcsTajyM6u",
    'ClientSecret' => "9h0AQR06BMTc8zO6TDBnEFMqQOzJzASG6u0Zf7Ak",
    'RedirectURI'  => "http://localhost/QuickBooks-V3-PHP-SDK/getToken.php",
    'scope'        => "com.intuit.quickbooks.accounting",
    'baseUrl'      => "development"
));

$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
$url = $OAuth2LoginHelper->getAuthorizationCodeURL();

if (isset($_GET["code"]))
{
    $code    = $_GET["code"];
    $realmId = $_GET["realmId"];
    //It will return something like:https://b200efd8.ngrok.io/OAuth2_c/OAuth_2/OAuth2PHPExample.php?state=RandomState&code=Q0115106996168Bqap6xVrWS65f2iXDpsePOvB99moLCdcUwHq&realmId=193514538214074
    //get the Code and realmID, use for the exchangeAuthorizationCodeForToken
    $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, $realmId);
    $error = $OAuth2LoginHelper->getLastError();
    if ($error != null)
    {
        echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
        echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
        echo "The Response message is: " . $error->getResponseBody() . "\n";
        return;
    }
    // $_SESSION["accessTokenKey"]    = $accessToken->getAccessTokenKey();
    // $_SESSION["accessTokenSecret"] = $accessToken->getClientSecret();
    $_SESSION["realmID"]         = $accessToken->getRealmID();
    $_SESSION["getAccessToken"]  = $accessToken->getAccessToken();
    $_SESSION["getRefreshToken"] = $accessToken->getRefreshToken();
    header("Location: http://localhost/QuickBooks-V3-PHP-SDK/getToken.php");
    exit();

    // var_dump($accessToken);

    // $dataService->updateOAuth2Token($accessToken);
    // $dataService->throwExceptionOnError(true);
    // $CompanyInfo = $dataService->getCompanyInfo();
    // $nameOfCompany = $CompanyInfo->CompanyName;
    // echo "Test for OAuth Complete. Company Name is {$nameOfCompany}. Returned response body:\n\n";
    // echo "<br>";
    // echo "<br>";
    // print_r($CompanyInfo);
    // $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($CompanyInfo, $somevalue);
    // echo $xmlBody . "\n";
}
else if (isset($_SESSION["realmID"]))
{
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    // session_destroy();
}
else
{
    ?>
    <h3> Click on the button below to start...... "<a href="<?php echo $url; ?>">Connect to QuickBooks</a>"</h3>
    <?php
}
die();






//It will return something like:https://b200efd8.ngrok.io/OAuth2_c/OAuth_2/OAuth2PHPExample.php?state=RandomState&code=Q0115106996168Bqap6xVrWS65f2iXDpsePOvB99moLCdcUwHq&realmId=193514538214074
//get the Code and realmID, use for the exchangeAuthorizationCodeForToken
$accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken("Q011510688430mhfd9mAwpsiB8eWAMPqjDO4j2WKmMWyeN96Ru", "193514538214074");
$dataService->updateOAuth2Token($accessToken);
$dataService->throwExceptionOnError(true);
$CompanyInfo = $dataService->getCompanyInfo();
$nameOfCompany = $CompanyInfo->CompanyName;
echo "Test for OAuth Complete. Company Name is {$nameOfCompany}. Returned response body:\n\n";
$xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($CompanyInfo, $somevalue);
echo $xmlBody . "\n";

//$result = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken("Q0115103503429HrpsLMzMwNXyd3phqSFStBXsUsEPffiPlvzQ");

/*
$error = $OAuth2LoginHelper->getLastError();
if ($error != null) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
    return;
}

$CompanyInfo = $dataService->getCompanyInfo();
$error = $dataService->getLastError();
if ($error != null) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
} else {
    $nameOfCompany = $CompanyInfo->CompanyName;
    echo "Test for OAuth Complete. Company Name is {$nameOfCompany}. Returned response body:\n\n";
    $xmlBody = XmlObjectSerializer::getPostXmlFromArbitraryEntity($CompanyInfo, $somevalue);
    echo $xmlBody . "\n";
}

/*

Example output:

Account[0]: Travel Meals
     * Id: NG:42315
     * AccountType: Expense
     * AccountSubType:

Account[1]: COGs
     * Id: NG:40450
     * AccountType: Cost of Goods Sold
     * AccountSubType:

...

*/
 ?>
