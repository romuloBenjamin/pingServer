<?php
class Pinger_error_compound
{
    var $entry;
    var $build;

    public function __construct()
    {
        $this->build = array();
        $this->build["current_date"] = strtotime(date('Y-m-d'));
        $this->build["base"] = json_decode("{\"data\":\"" . trim(date('Y-m-d')) . "\", \"update\":\"" . trim(date("i")) . "\", \"FALHAS_CONEXAO\": {\"servidores\": \"\"}}");
        $this->build["array_node"] = json_decode("{\"ip\":\"\", \"nome\":\"\"}");
    }

    /*GET JSON LIST*/
    public function get_json()
    {
        return json_decode(file_get_contents(DIR_PATH . "cnt-modules/mail-module/jsons/lista-erros-ips-json.json"));
    }

    /*PUT JSON LIST*/
    public function put_json()
    {
        return file_put_contents(DIR_PATH . "cnt-modules/mail-module/jsons/lista-erros-ips-json.json", json_encode($this->build["lista"]));
    }

    /*COMPOUND*/
    public function set_listas_compound()
    {
        $erros = new Pinger_error_compound();
        $erros->entry = json_decode($this->entry);
        /*IF EMPTY LISTA*/
        if (empty($erros->get_json())) $this->build["lista"] = $this->build["base"];
        if (!empty($erros->get_json())) $this->build["lista"] = $erros->get_json();
        $erros->build = $this->build;
        /*IF ZERA LISTA*/
        $this->build["lista"] = $erros->zera_base_build();
        $erros->build = $this->build;
        /*IF IP EXISTS*/
        $this->build["lista"] = $erros->unique_ip();
        $erros->build = $this->build;
        $erros->put_json();
        return $erros->build["lista"];
    }

    /*SERA BUILD*/
    public function zera_base_build()
    {
        if ($this->build["current_date"] != strtotime($this->build["lista"]->data)) return $this->build["base"];
        if (($this->build["lista"]->update + 10) > date("i")) {
            return $this->build["lista"];
        }
        return $this->build["base"];
    }

    /*UNIQUE IPS*/
    public function unique_ip()
    {
        /*SET SERVIDORES AS ARRAY*/
        if (is_string($this->build["lista"]->FALHAS_CONEXAO->servidores))
            $this->build["lista"]->FALHAS_CONEXAO->servidores = array();

        /*SET nARRAY*/
        $nArray = $this->build["lista"]->FALHAS_CONEXAO->servidores;
        if (count($nArray) === 0) {
            //$this->build["array_node"]->ip = $this->entry->ip;
            $this->build["array_node"]->ip = $this->entry->ip;
            $this->build["array_node"]->nome = $this->entry->name;
            $nArray[] = $this->build["array_node"];
        } else {
            $u = 0;
            for ($i = 0; $i < count($nArray); $i++) {
                if ($nArray[$i]->ip == $this->entry->ip) $u++;
            }
            if ($u === 0) {
                $this->build["array_node"]->ip = $this->entry->ip;
                $this->build["array_node"]->nome = $this->entry->name;
                $nArray[] = $this->build["array_node"];
            }
        }
        $this->build["lista"]->FALHAS_CONEXAO->servidores = json_decode(json_encode($nArray));
        return $this->build["lista"];
    }

    /*SEND MAIL*/
    public function pinger_mail()
    {
        var_dump("not implemented");
    }
}
