<?php session_start();
include "cnt-files/cnt-php/defines.php";
include "cnt-files/cnt-php/tryVars.php";
$try = new TryVars();
$try->module = "loud";
/*CARREGA CONEXOES & listas*/
$try->loudConections();
$listas = $try->loudListas();
$try->loudMods();
/*LOUD HTML -> HEADER & BODY*/
$tryHTML = new TryVars();
$tryHTML->module = "html";
echo "<!DOCTYPE html><html lang=\"pt-BR\">";
$tryHTML->loudHeader();
$tryHTML->loudBody();
echo "</html>";
