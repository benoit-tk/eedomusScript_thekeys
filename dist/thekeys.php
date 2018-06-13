<?php
/** ****************************************************************************
* eedomus Script The keys
********************************************************************************
* Plugin version : 0.1
* Author : Benoit
* Origine : 
*******************************************************************************/

/** Utile en cours de dev uniquement */
//$eedomusScriptsEmulatorDatasetPath = "eedomusScriptsEmulator_dataset.json";
//require_once ("eedomusScriptsEmulator.php");

/** Initialisation de la réponse */
$response = null;

$code = getArg("share");
$locker_id = getArg("locker_id");
$action = getArg("action");


$gateway_ip = getArg('gateway_ip');




$ts = time();
$key = hash_hmac('sha256',$ts,$code,true);
$hash = base64_encode($key);

switch($action){
	case 1:
		$type = "open";
		break;
	case 2:
		$type = "close";
		break;
	case 3:
		$type = "locker_status";
		break;
}



$url = "http://$gateway_ip/$type";

$response = httpQuery($url, 'POST', "hash=$hash&identifier=$locker_id&ts=$ts");

/** ****************************************************************************
* Fin du script, affichage du résultat au format XML
*/
sdk_header('text/xml');
echo jsonToXML($response);
