<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class pingServer_modules extends Main
{
    public $listagemIP;
    public $listagemNode;
    public $pinger;
    public $pingerNodes;
    public $nPinger;
    public $nPingerNodes;
    public $sendMail_pinger;
    public $mailNode;

    function _construct()
    {
        //PARA LISTAGEM
        $this->listagemIP = array();
        $this->listagemIP->listagemNode = array();
        $listagemNode["IPS"] = "";
        $listagemNode["SERVER"] = "";
        $listagemNode["DESCRICAO"] = "";
        $listagemNode["OPERACAO"] = "";
        $listagemNode["FILIAL"] = "";

        //PARA PINGER
        $this->pinger = array();
        $this->pinger->pingerNodes = array();
        $pingerNodes["IPS"] = "";
        $pingerNodes["SERVER"] = "";
        $pingerNodes["DESCRICAO"] = "";
        $pingerNodes["FILIAL"] = "";

        $this->$nPinger = array();
        $this->$nPinger->nPingerNodes = array();
        $nPingerNodes["IPS"] = "";
        $nPingerNodes["COUNT"] = "";
        $nPingerNodes["SPNAME"] = "";
        $nPingerNodes["TBNAME"] = "";

        //PARA PINGER SEND MAIL
        $this->sendMail_pinger = array();
        $this->sendMail_pinger->mailNode = array();
        $mailNode["IPS"] = "";
        $mailNode["SERVER"] = "";
        $mailNode["DESCRICAO"] = "";
        $mailNode["FILIAL"] = "";
    }

    //COMPOUND
    public function ping_compound($swit)
    {
        switch ($swit) 
        {
            case 'listar-servidores-batua': $resultSet = pingServer_modules::ping_filiais_sql("batua"); break;
            case 'listar-servidores-hasegawa': $resultSet = pingServer_modules::ping_filiais_sql("hasegawa"); break;
            case 'get-pinger-batua': $resultSet = pingServer_modules::get_pinger_filiais_sql("batua"); break;
            case 'get-pinger-hasegawa': $resultSet = pingServer_modules::get_pinger_filiais_sql("hasegawa"); break;
            case 'update-status-pingServer-batua': $resultSet = pingServer_modules::ping_update_status_filiais_sql("batua"); break;
            case 'update-status-pingServer-hasegawa': $resultSet = pingServer_modules::ping_update_status_filiais_sql("hasegawa"); break;
            //default:break;
        } return $resultSet;
    }

    //SQL
    public function ping_filiais_sql($entry)
    {
        //IF ENTRY BATUA OU HASEGAWA
        ($entry == "batua")?$servidor='1':$servidor='2';
        
        //SQL
        $sql = "SELECT * FROM uni_ps_servers"; $sql .= " ";
        $sql .= "WHERE"; $sql .= " ";
        $sql .= "unipss_servidor = '".trim($servidor)."'"; $sql .= " ";
        $sql .= "AND"; $sql .= " ";
        $sql .= "unipss_status = '1'"; $sql .= " ";
        $sql .= "ORDER BY unipss_ip ASC"; //var_dump($sql);

        //GO TO EXEC
        ($entry == "batua")?$swit='servidores-batua':$swit='servidores-hasegawa';
        $resultSet = pingServer_modules::ping_filiais_exec($sql, $swit);
        return $resultSet;
    }
    public function ping_update_status_filiais_sql($entry)
    {
        //IF ENTRY BATUA OU HASEGAWA
        ($entry == "batua")?$servidor='1':$servidor='2';
        
        //SQL
        $sql = "SELECT * FROM uni_ps_servers"; $sql .= " ";
        $sql .= "WHERE"; $sql .= " ";
        $sql .= "unipss_servidor = '".trim($servidor)."'"; $sql .= " ";
        $sql .= "AND"; $sql .= " ";
        $sql .= "unipss_status = '1'"; $sql .= " ";
        $sql .= "ORDER BY unipss_ip ASC"; //var_dump($sql);

        //GO TO EXEC
        ($entry == "batua")?$swit='update-status-batua':$swit='update-status-hasegawa';
        $resultSet = pingServer_modules::ping_filiais_exec($sql, $swit);
        return $resultSet;
    }
    public function get_pinger_filiais_sql($entry)
    {
        //IF ENTRY BATUA OU HASEGAWA
        ($entry == "batua")?$servidor='1':$servidor='2';
        
        //SQL
        $sql = "SELECT * FROM uni_ps_servers"; $sql .= " ";
        $sql .= "WHERE"; $sql .= " ";
        $sql .= "unipss_servidor = '".trim($servidor)."'"; $sql .= " ";
        $sql .= "AND"; $sql .= " ";
        $sql .= "unipss_status = '1'"; $sql .= " ";
        $sql .= "ORDER BY unipss_ip ASC"; //var_dump($sql);

        //GO TO EXEC
        ($entry == "batua")?$swit='pinger-batua':$swit='pinger-hasegawa';
        $resultSet = pingServer_modules::ping_filiais_exec($sql, $swit);
        return $resultSet;
    }
    public function pingerServer_update_status($entry, $swit, $stat)
    {
        ($swit == "batua")?$servidor = '1':$servidor = '2';
        $sql = "UPDATE uni_ps_servers SET"; $sql .= " ";
        $sql .= "unipss_operacao = '".$stat."'"; $sql .= " ";
        $sql .= "WHERE"; $sql .= " ";
        $sql .= "unipss_servidor = '".$servidor."'"; $sql .= " ";
        $sql .= "AND"; $sql .= " ";
        $sql .= "unipss_ip = '".$entry."'"; //var_dump($sql);
        $resultSet = pingServer_modules::ping_filiais_exec($sql, "update-pingserver");
        return $resultSet;
    }

    //EXEC
    public function ping_filiais_exec($sql, $swit)
    { 
        $result = parent::executeQuery($sql);
        switch ($swit) {
            case 'servidores-batua': $resultSet = pingServer_modules::ping_get_ips($result, "batua"); break;
            case 'servidores-hasegawa': $resultSet = pingServer_modules::ping_get_ips($result, "hasegawa"); break;
            case 'update-pingserver': $resultSet = pingServer_modules::pingServer_updateStatus($result); break;
            case 'pinger-batua': $resultSet = pingServer_modules::pinger_get_ips($result, "batua"); break;
            case 'pinger-hasegawa': $resultSet = pingServer_modules::pinger_get_ips($result, "hasegawa"); break;
            case 'update-status-batua': $resultSet = pingServer_modules::ping_get_ips_update($result, "batua"); break;
            case 'update-status-hasegawa': $resultSet = pingServer_modules::ping_get_ips_update($result, "hasegawa"); break;
            //default:break;
        } return $resultSet;
    }

    //BUILD -> DATA
    public function pingServer_updateStatus($build_exec)
    {
        if($build_exec == true)
        { //var_dump("atualizacao realizada com sucesso!");
        }
        else{ var_dump("erro ao atualizar DB"); }
    }
    public function ping_get_ips_update($build_exec, $swit)
    {
        while($item = $build_exec->fetch_array())
        { $this->listagemIP[] = pingServer_modules::ping_get_ips_innerElements($item); }
        return json_encode($this->listagemIP);
    }
    public function ping_get_ips($build_exec, $swit)
    {
        while($item = $build_exec->fetch_array())
        { $this->listagemIP[] = pingServer_modules::ping_get_ips_innerElements($item); }
        $resultSet = pingServer_modules::pingServer_structures($swit);
        return $resultSet;
    }
    public function ping_get_ips_innerElements($entry)
    {
        $listagemNode["IPS"] = $entry["unipss_ip"];
        $listagemNode["SERVER"] = $entry["unipss_nome_servidor"];
        $listagemNode["DESCRICAO"] = $entry["unipss_descricao"];
        $listagemNode["OPERACAO"] = $entry["unipss_operacao"];
        $listagemNode["FILIAL"] = $entry["unipss_servidor"];
        return $listagemNode;
    }
    //BUILD -> DATA PINGER
    public function pinger_get_ips($build_exec, $swit)
    {
        while($item = $build_exec->fetch_array())
        { $this->pinger[] = pingServer_modules::pinger_get_ips_innerElements($item, $swit); }
        $resultSet = pingServer_modules::get_pinger($swit);
        return $resultSet;
    }
    public function pinger_get_ips_innerElements($entry, $swit)
    {
        $pingerNodes["IPS"] = $entry["unipss_ip"];
        $pingerNodes["SERVER"] = $entry["unipss_nome_servidor"];
        $pingerNodes["DESCRICAO"] = $entry["unipss_descricao"];
        $pingerNodes["FILIAL"] = mb_strtoupper($swit, "UTF-8");
        return $pingerNodes;
    }

    //BUILD -> STRUCTURES
    public function pingServer_structures($swit)
    {
        $build = '<tr>';
        $build .= pingServer_modules::pingServer_structures_td();
        $build .= '</tr>';
        $build .= '<tr><td colspan="3">Verificando Status - <span class="serverDNS">'.ucfirst($swit).'</span> <div class="spinner-border custom-spinner d-none" role="status"><span class="sr-only">Loading...</span></div> </td></tr>';
        return $build;
    }
    public function pingServer_structures_td()
    {
        $build_td = "";
        for ($i=0; $i < count($this->listagemIP); $i++)
        {
            $build_td .= '<td><span id="serverIPS">'.$this->listagemIP[$i]["IPS"].'</span></td>';
            $build_td .= '<td><span id="serverName">[IDENT. ... ]</span></td>';
            if($this->listagemIP[$i]["OPERACAO"] == 1)
            { $build_td .= '<td><span id="serverStatus">OPERANTE</span></td>'; }
            else if($this->listagemIP[$i]["OPERACAO"] == 0)
            { $build_td .= '<td><span id="serverStatus">FALHA</span></td>'; }
            else{ $build_td .= '<td><span id="serverStatus">[IDENT...]</span></td>'; }
            $build_td .= '</tr><tr>';
        } return $build_td;
    }

    //TRY PINGer
    public function get_pinger($swit)
    {
        $filial = mb_strtoupper($swit, "UTF-8");
        for ($i=0; $i < count($this->pinger); $i++)
        { 
            if($this->pinger[$i]["FILIAL"] == $filial)
            {
                $this->nPinger[] = pingServer_modules::goPing($this->pinger[$i], $swit);
                if($this->nPinger[$i]["COUNT"] < 50)
                { 
                    $updatePinger = pingServer_modules::pingerServer_update_status($this->pinger[$i]["IPS"], $swit, "0");
                    $listagemIP[$i]["OPERACAO"] = "FAIL";
                }
                else{ 
                    $updatePinger = pingServer_modules::pingerServer_update_status($this->pinger[$i]["IPS"], $swit, "1"); 
                    $listagemIP[$i]["OPERACAO"] = "OPERANTE";
                }
            }
        }
        $sendMail = pingServer_modules::prepareto_sendmail();
        return $sendMail;
    }

    public function goPing($entry, $swit)
    { $entryi = $entry["IPS"];

        //GO PING
        $pings = `ping -a $entryi -n 1`;
        $str1 = str_replace(">", ":", $pings);
        $str2 = str_replace(" ", ":", $str1);
        $pingExplod = explode(":", $str2);
        $pingCount_splitterParts = count($pingExplod);

        //PINGER NODES
        $nPingerNodes["IPS"] = $entryi;
        $nPingerNodes["COUNT"] = $pingCount_splitterParts;
        $nPingerNodes["SPNAME"] = $pingExplod[1];
        $nPingerNodes["TBNAME"] = $swit;
        return $nPingerNodes;                        
    }

    //TO SEND MAIL
    public function prepareto_sendmail()
    { date_default_timezone_set('America/Sao_Paulo'); 
        //
        for ($i=0; $i < count($this->nPinger); $i++) 
        {
            if($this->nPinger[$i]["COUNT"] < 50)
            { $this->sendMail_pinger[] = pingServer_modules::prepareto_sendmail_innernodes($i); }
        } $sendMail = pingServer_modules::to_sendmail();
        return $sendMail;
    }
    public function prepareto_sendmail_innernodes($nodes)
    {
        $mailNode["IPS"] = $this->pinger[$nodes]["IPS"];
        $mailNode["SERVER"] = $this->pinger[$nodes]["SERVER"];
        $mailNode["DESCRICAO"] = $this->pinger[$nodes]["DESCRICAO"];
        $mailNode["FILIAL"] = $this->pinger[$nodes]["FILIAL"];
        return $mailNode;
    }
    public function to_sendmail()
    {
        if(count($this->sendMail_pinger) > 0)
        {
            require "../../../../../vendor/autoload.php";
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            
            $mail->Host = 'ssl://smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_STARTTLS';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->SMTPAuth = true;
            $mail->Username = "sales.cleaner.externo@gmail.com";
            $mail->Password = "cleanersales";
            
            $mail->setFrom('sales.cleaner.externo@gmail.com', 'PING MONITOR SALES');
            $mail->addReplyTo('sales.cleaner.externo@gmail.com', 'PING MONITOR SALES');
            $mail->addAddress("luiz.gustavo.devasconcelos@gmail.com", "Luiz Gustavo");
            $mail->addAddress("gustavo.vasconcelos@cleaner.com.br", "Luiz Gustavo");
            
            $mail->addCC("mos.marcelo@gmail.com", "Marcelo Oliveira");
            $mail->addCC("mos.marcelo@cleaner.com.br", "Marcelo Oliveira");
            $mail->addCC("romulo.franco@cleaner.com.br", "Romulo Franco");
            $mail->addCC("fhelipe.santos@cleaner.com.br", "Fhelipe Santos");
            $mail->addBCC("sales.cleaner.externo@gmail.com", "PING MONITOR SALES");

            $mail->Subject = '::AVISO PingServer::';
            $bds = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">';
            $bds .= '<div class="d-flex justify-content-start align-items-center w-100" style="background-color:#6695BC;"> <div class="d-flex" style="width: 15rem;"><img src="http://www.intra.cleaner.com.br/img/logo_min.png"></div> <div class="d-flex" style="color: #fff;">Ping Server Status</div> </div>';
            $bds .= '<table class="table">';
            $bds .= '<thead> ';
            $bds .= '<tr> <th scope="col">NOME SERVIDOR</th><th scope="col">IP</th><th scope="col">DESCRI&Ccedil;&Atilde;O</th><th scope="col">STATUS</th><th scope="col">HORARIOS</th></tr> </thead>';
            $bds .= '<tbody>';
            for ($i=0; $i < count($this->sendMail_pinger); $i++)
            { $bds .= '<tr> <td>'.$this->sendMail_pinger[$i]["SERVER"].'</td><td>'.$this->sendMail_pinger[$i]["IPS"].'</td><td>'.$this->sendMail_pinger[$i]["DESCRICAO"].'</td><td>FALHA NA ENTREGA DO PACOTE</td><td>'.date('d/m/Y')." ".(intval(date('H'))-1).":".date("s").":".date("i").'</td></tr>';  }
            $bds .= '</tbody> </table>';
            $mail->Body = $bds;
            //Replace the plain text body with one created manually
            $mail->AltBody = 'FALHA NA ENTREGA DO PACOTE';
            //send the message, check for errors
            if (!$mail->send()) 
            { return json_encode(array("status" => "0", "msn" => "Mailer Error: " . $mail->ErrorInfo)); }
            else{ return json_encode(array("status" => "1", "msn" => "MENSAGEM ENVIADA")); }
        }else{ return json_encode(array("status" => "0", "msn" => "SEM FALHAS ENCONTRADAS!")); } 
    }
}
?>