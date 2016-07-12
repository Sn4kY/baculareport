<?php
require_once('settings.inc.php');

function FileSizeConvert($bytes) {
	$result='';
	$bytes = floatval($bytes);
	$arBytes = array(
                0 => array(
                    "UNIT" => "TB",
                    "VALUE" => pow(1024, 4)
                ),
                1 => array(
                    "UNIT" => "GB",
                    "VALUE" => pow(1024, 3)
                ),
                2 => array(
                    "UNIT" => "MB",
                    "VALUE" => pow(1024, 2)
                ),
                3 => array(
                    "UNIT" => "KB",
                    "VALUE" => 1024
                ),
                4 => array(
                    "UNIT" => "B",
                    "VALUE" => 1
                ),
            );

        foreach($arBytes as $arItem)
        {
            if($bytes >= $arItem["VALUE"])
            {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

function ConvertBaculaJobStatus($code) {
	switch ($code) {
		case "A";
			$status="Canceled by user";
			break;
		case "B";
			$status="Blocked";
			break;
		case "C";
			$status="Created, but not running";
			break;
		case "c";
			$status="Waiting for client resource";
			break;
		case "D";
			$status="Verify differences";
			break;
		case "d";
			$status="Waiting for maximum jobs";
			break;
		case "E";
			$status="Terminated in error";
			break;
		case "e";
			$status="Non-fatal error";
			break;
		case "f";
			$status="fatal error";
			break;
		case "F";
			$status="Waiting on File Daemon";
			break;
		case "j";
			$status="Waiting for job resource";
			break;
		case "M";
			$status="Waiting for mount";
			break;
		case "m";
			$status="Waiting for new media";
			break;
		case "p";
			$status="Waiting for higher priority jobs to finish";
			break;
		case "R";
			$status="Running";
			break;
		case "S";
			$status="Scan";
			break;
		case "s";
			$status="Waiting for storage resource";
			break;
		case "T";
			$status="Terminated normally";
			break;
		case "t";
			$status="Waiting for start time ";
			break;
		}
	return $status;
}

function ConvertBaculaBackupLevel($code) {
	switch ($code) {
		case "F";
			$status="Full";
			break;
		case "I";
			$status="Incremental";
			break;
		case "D";
			$status="Differential";
			break;
		case "C";
			$status="Verify from catalog";
			break;
		case "V";
			$status="Verify init db";
			break;
		case "O";
			$status="Verify volume to catalog";
			break;
		case "d";
			$status="Verify disk to catalog";
			break;
		case "A";
			$status="Verify data on volume";
			break;
		case "B";
			$status="Base job";
			break;
		case "";
			$status="Restore or admin job ";
			break;
		}
	return $status;
}

try
{
	$bdd = new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset='.$DB_CHARSET,$DB_USER, $DB_PASSWORD,
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
