<?php //LISTA SITE HASEGAWA
require("../../../cnt-php/defines.php");
require("../../../cnt-php/functions.php");
if(!class_exists("Main")){ include(DIR_JPATH."cnt-sql/".DIR_SQL."/main".ucfirst(DIR_SQL).DIR_EXT); }
if(!class_exists("pingServer_modules")){ call_jSubFolder('public', 'class', 'pingServerMods-class'); } $SN192 = new pingServer_modules();

//PROCESS
$array_roteador_hasegawa = array("192.168.1.200");
$array_dvr_hasegawa = array("172.16.0.105", "172.16.0.106", "172.16.0.107", "172.16.0.108", "172.16.0.109", "172.16.0.110", "172.16.0.111", "172.16.0.112", "172.16.0.113", "172.16.0.114", "172.16.0.115");
$array_nvr_hasegawa = array("172.16.0.116");
$array_camerasIP = array("192.168.1.201", "192.168.1.202", "192.168.1.203", "192.168.1.204");
$array_antenas = array("192.168.1.151", "192.168.1.152", "192.168.1.153", "192.168.1.154", "192.168.1.155", "192.168.1.157", "192.168.1.158");


$ips = $_GET["e"];
$pings = `ping -a $ips -n 1`;
$str_replace1 = str_replace(">", ":", $pings);
$str_replace2 = str_replace(" ", ":", $str_replace1);
$hsname = explode(":", $str_replace2);

if(in_array($hsname[1], $array_roteador_hasegawa))
{ $nameServer = "ROTEADOR HASEGAWA"; }
else if(in_array($hsname[1], $array_nvr_hasegawa))
{ $nameServer = "NVR HASEGAWA"; }
else if(in_array($hsname[1], $array_dvr_hasegawa))
{ $nameServer = "DVR HASEGAWA"; }
else if(in_arraY($hsname[1], $array_antenas))
{ $nameServer = "ANTENAS HASEGAWA"; }
else{ $nameServer = $hsname[1]; }
$array = array("name" => $nameServer, "ping" => count($hsname), "key" => $_GET["i"], "ips" => $ips);
echo json_encode($array);

//SENDMAIL IF IDT FALHA
if(count($hsname) < 50)
{ $MAILH = $SN192->registerServer($ips, "hasegawa"); }
?>