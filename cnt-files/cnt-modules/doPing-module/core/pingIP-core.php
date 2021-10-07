<?php
$desconciderar = array("", " ", "=", ",", "\n", "\'", ":", "(", ")", "[", "]", "<", ">");
$isPingin = $_POST["data"];
$ping = `ping -a $isPingin -n 1`;
$nVazios = array();
$arrayPing = explode("\n", $ping);
for ($i = 0; $i < count($arrayPing); $i++) {
    $nVazios[] = str_replace($desconciderar, "", trim($arrayPing[$i]));
}
$nVazios2 = array();
for ($i = 0; $i < count($nVazios); $i++) {
    if ($nVazios[$i] != "") $nVazios2[] = $nVazios[$i];
}
if (count($nVazios2) > 5) echo "{\"ip\": \"" . $isPingin . "\", \"status\":\"1\" ,\"msn\": \"OPERANTE\"}";
if (count($nVazios2) <= 5) echo "{\"ip\": \"" . $isPingin . "\", \"status\":\"0\" ,\"msn\": \"FALHA NA CONEXÃO\"}";
exit();
