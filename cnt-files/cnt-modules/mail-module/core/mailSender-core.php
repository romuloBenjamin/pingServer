<?php session_start();
$core = "core";
require_once "../../../cnt-php/defines.php";
require DIR_PATH . "cnt-php/tryVars.php";
$try = new TryVars();
$try->module = "loud";
/*CARREGA CONEXOES & listas*/
$try->loudConections();
$listas = $try->loudListas();
$try->loudMods();
/*CREATE LISTA PING ERRORS*/
$ping = new Pinger_error_compound();
$ping->entry = json_encode($_GET["data"]);
$buildLista = $ping->set_listas_compound();
$ping->entry = $buildLista;
$ping->pinger_mail();
