<?php
$jdata = $_GET["data"];
$listaErrosContent = file_get_contents("../jsons/lista-erros-ips-json.json");
$dataDia = Date('Y-m-d');
if (empty($listaErrosContent)) $listaErrosContent = "{\"data\":\"" . trim($dataDia) . "\", \"update\":\"00:10:00\", \"FALHAS_CONEXAO\": {\"servidores\": \"\"}}";

$decodeListas = json_decode($listaErrosContent);
if (is_string($decodeListas->FALHAS_CONEXAO->servidores)) {
    $decodeListas->FALHAS_CONEXAO->servidores = json_decode("[{\"ip\":\"" . trim($jdata["ip"]) . "\", \"name\":\"" . trim($jdata["name"]) . "\"}]");
    var_dump($decodeListas);
    file_put_contents("../jsons/lista-erros-ips-json.json", json_encode($decodeListas));
}
if (!is_string($decodeListas->FALHAS_CONEXAO->servidores)) {
    $nArray = array();
    $nArray = json_decode(json_encode($decodeListas->FALHAS_CONEXAO->servidores), true);
    $u = 0;
    for ($i = 0; $i < count($decodeListas->FALHAS_CONEXAO->servidores); $i++) {
        if ($decodeListas->FALHAS_CONEXAO->servidores[$i]->ip === $jdata["ip"]) $u++;
    }
    if ($i >= 1 && $u === 0) $nArray[] = array("ip" => $jdata["ip"], "name" => $jdata["name"]);
    $decodeListas->FALHAS_CONEXAO->servidores = json_decode(json_encode($nArray));

    var_dump($decodeListas);
    file_put_contents("../jsons/lista-erros-ips-json.json", json_encode($decodeListas));
}
exit();
