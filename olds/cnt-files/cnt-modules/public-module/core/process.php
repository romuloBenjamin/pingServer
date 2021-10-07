<?php //LISTA SITE BATUA
require("../../../cnt-php/defines.php");
require("../../../cnt-php/functions.php");
if(!class_exists("Main")){ include(DIR_JPATH."cnt-sql/".DIR_SQL."/main".ucfirst(DIR_SQL).DIR_EXT); }
if(!class_exists("pingServer_modules")){ call_jSubFolder('public', 'class', 'pingServerMods-class'); } $SN172 = new pingServer_modules();
//PROCESS
$array_dvr_eliane = array("172.16.0.100", "172.16.0.101", "172.16.0.102", "172.16.0.103");
$array_dvr_sonic = array("172.16.0.55");
$array_dvr_sankhya = array("172.16.0.55");
$array_blackArmor = array("172.16.0.3", "172.16.0.14", "172.16.0.19", "172.16.0.21", "172.16.0.32");

$ips = $_GET["e"];
$pings = `ping -a $ips -n 1`;
$str_replace1 = str_replace(">", ":", $pings);
$str_replace2 = str_replace(" ", ":", $str_replace1);
$hsname = explode(":", $str_replace2);
if(in_array($hsname[1], $array_dvr_eliane))
{ $nameServer = "DVR ELIANE"; }
else if(in_array($hsname[1], $array_dvr_sonic))
{ $nameServer = "SONIC WALL"; }
else if(in_array($hsname[1], $array_dvr_sankhya))
{ $nameServer = "SANKHYA"; }
else if(in_array($hsname[1], $array_blackArmor))
{ $nameServer = "BLACK ARMOR"; }
else{ $nameServer = $hsname[1]; }
$array = array("name" => $nameServer, "ping" => count($hsname), "key" => $_GET["i"], "ips" => $ips);
echo json_encode($array);

//SENDMAIL IF IDT FALHA
if(count($hsname) == 50)
{ $MAIL = $SN172->registerServer($ips, "batua"); }
else if(count($hsname) < 50)
{ $MAIL = $SN172->registerServer($ips, "batua"); }
?>