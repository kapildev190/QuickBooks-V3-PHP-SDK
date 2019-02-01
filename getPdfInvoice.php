<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
session_start();
echo "<pre>";
// print_r($_SESSION);
include('src/config.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Invoice;

// Prep Data Services
$dataService = DataService::Configure(array(
									       		'auth_mode' 		=> 'oauth2',
									         	'ClientID' 			=> "Q0DBvYb4Gg9GJhUP46QscmzFKBwjdvK7Bh5uSVVgNutxTKtCvR",
									         	'ClientSecret' 		=> "cGlMNdeTqUdNuhueIshv8UrCcXpeNyuunHAHenXJ",
									         	'accessTokenKey' 	=> $_SESSION["getAccessToken"],
									         	'accessTokenSecret' => $_SESSION["getRefreshToken"],
									         	'QBORealmID' 		=> $_SESSION["realmID"],
									         	'baseUrl'    		=> "development"
											));

$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");

$invoice = Invoice::create([
              "Id" => 1039
            ]);
            
$directoryForThePDF = $dataService->DownloadPDF($invoice, getcwd()."/pdf");
print_r($directoryForThePDF);