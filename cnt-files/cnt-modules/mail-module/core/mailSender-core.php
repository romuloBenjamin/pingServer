<?php
$jdata = $_GET["data"];
$listaErrosContent = file_get_contents("../jsons/lista-erros-ips-json.json");
/*LISTAR ERROS CONTENT*/
if (empty($listaErrosContent)) {
    $valorIni = "{\"FALHAS_CONEXAO\": {\"servidores\": []}}";
    file_put_contents("../jsons/lista-erros-ips-json.json", $valorIni);
}
$getListaErros = file_get_contents("../jsons/lista-erros-ips-json.json");
