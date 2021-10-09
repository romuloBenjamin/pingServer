<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;

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
        if (($this->build["lista"]->update + 5) > date("i")) {
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
        date_default_timezone_set('America/Sao_Paulo');
        require '../../../../vendor/autoload.php';
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        //$mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->Username = "";
        $mail->Password = "";

        $mail->setFrom('sales.cleaner.externo@gmail.com', 'PING MONITOR SALES');
        $mail->addReplyTo('sales.cleaner.externo@gmail.com', 'PING MONITOR SALES');
        $mail->addAddress("luiz.gustavo.devasconcelos@gmail.com", "Luiz Gustavo");
        $mail->addAddress("gustavo.vasconcelos@cleaner.com.br", "Luiz Gustavo");
        $mail->addCC("mos.marcelo@gmail.com", "Marcelo Oliveira");
        $mail->addCC("mos.marcelo@cleaner.com.br", "Marcelo Oliveira");
        $mail->addCC("romulo.franco@cleaner.com.br", "Romulo Franco");
        $mail->addCC("matheus.vello@cleaner.com.br", "Matheus Vello");
        $mail->addCC("fhelipe.santos@cleaner.com.br", "Fhelipe Santos");
        $mail->addBCC("sales.cleaner.externo@gmail.com", "PING MONITOR SALES");

        $mail->Subject = '::AVISO PingServer::';

        $bds = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">';
        $bds .= '<div class="d-flex justify-content-start align-items-center w-100" style="background-color:#6695BC;"> <div class="d-flex" style="width: 15rem;"><img src="http://www.intra.cleaner.com.br/img/logo_min.png"></div> <div class="d-flex" style="color: #fff;">Ping Server Status</div> </div>';
        $bds .= '<table class="table">';
        $bds .= '<thead> <tr> <th scope="col">IP</th> <th scope="col">Status</th> <th scope="col">Servidor</th> </tr> </thead>';
        $bds .= '<tbody>';
        $patterns = $this->entry->FALHAS_CONEXAO->servidores;
        for ($i = 0; $i < count($patterns); $i++) {
            $bds .= '<tr>';
            $bds .= '<td>' . trim($patterns[$i]->ip) . '</td>';
            $bds .= '<td>FALHA NA ENTRGA DO PACOTE (' . date('d/m/Y H:i:s') . ')</td>';
            $bds .= '<td>' . trim($patterns[$i]->nome) . '</td>';
            $bds .= '</tr>';
        }
        $bds .= '</tbody> </table>';
        $mail->Body = $bds;
        //Replace the plain text body with one created manually
        $mail->AltBody = 'FALHA NA ENTRGA DO PACOTE';
        //send the message, check for errors
        if (!$mail->send()) {
            return json_encode("Mailer Error: " . $mail->ErrorInfo);
        } else {
            return json_encode("Message sent!");
        }
    }
}
