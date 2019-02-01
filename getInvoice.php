<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
session_start();
echo "<pre>";
//print_r($_SESSION); die;
include('src/config.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;

// Prep Data Services
$dataService = DataService::Configure(array(
   		'auth_mode' 		=> 'oauth2',
     	'ClientID'          =>  "Q0ZCCaEyi4Mqs8WbUmkWCN2ahtvX7SLW9KDHmJktKcsTajyM6u",
        'ClientSecret'      =>  "9h0AQR06BMTc8zO6TDBnEFMqQOzJzASG6u0Zf7Ak",
     	'accessTokenKey' 	=> $_SESSION["getAccessToken"],
     	'accessTokenSecret' => $_SESSION["getRefreshToken"],
     	'QBORealmID' 		=> $_SESSION["realmID"],
     	'baseUrl'    		=> "development"
	));

$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");

// Run a query
$allInvoice = $dataService->Query("select * from Invoice");
$error = $dataService->getLastError();
if ($error) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
    exit();
}
// Echo some formatted output
echo "<pre>";
print_r($allInvoice);