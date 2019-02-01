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

// Prep Data Services
$dataService = DataService::Configure(array(
   		'auth_mode' 		=> 'oauth2',
     	'ClientID'     => "Q0uhtrUWioQ5cGk7dfg48r3zfaqcihv5Ld9xvT9t46G7MjQ57G",
        'ClientSecret' => "x6utU84zqleh3g9MR6Emmz3yekHRpH8yGcbI35g6",
     	'accessTokenKey' 	=> $_SESSION["getAccessToken"],
     	'accessTokenSecret' => $_SESSION["getRefreshToken"],
     	'QBORealmID' 		=> $_SESSION["realmID"],
     	'baseUrl'    		=> "production"
	));

$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");

// echo "<pre>";
// die();

$allCompanies = $dataService->FindAll('CompanyInfo');
// print_r($_SESSION);
// die();


echo "<pre>";
print_r($allCompanies);
die;

foreach ($allCompanies as $oneCompany) {
    $oneCompanyReLookedUp = $dataService->FindById($oneCompany);
    echo "Company Name: {$oneCompanyReLookedUp->CompanyName}<br>";
}

/*

Example output:

Company Name: MyCo Production LLC
Company Name: ACME Inc.
Company Name: Jones Corp

*/
