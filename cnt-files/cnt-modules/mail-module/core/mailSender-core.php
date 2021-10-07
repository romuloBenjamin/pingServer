<?php
$jdata = $_GET["data"];
$listaErrosContent = file_get_contents("../jsons/lista-erros-ips-json.json");
if (empty($listaErrosContent)) $listaErrosContent = "{\"FALHAS_CONEXAO\": {\"servidores\": \"\"}}";
$decodeListas = json_decode($listaErrosContent);
if (is_string($decodeListas->FALHAS_CONEXAO->servidores)) {
    $decodeListas->FALHAS_CONEXAO->servidores = json_decode("{\"ip\":\"" . trim($jdata["ip"]) . "\", \"name\":\"" . trim($jdata["name"]) . "\"}");
    var_dump($decodeListas);
    file_put_contents("../jsons/lista-erros-ips-json.json", $decodeListas);
}
if (!is_string($decodeListas->FALHAS_CONEXAO->servidores)) {
    $listaJSON = json_decode(file_get_contents("../jsons/lista-erros-ips-json.json"));
    var_dump($listaJSON);
}
