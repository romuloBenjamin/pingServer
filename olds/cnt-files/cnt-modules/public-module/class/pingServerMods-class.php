<?php 
class pingServer_modules
{
    //COMPOUND
    public function arrayListServers($swit)
    {
        //SWIT BASE
        switch ($swit) 
        {
            case 'batua': $tableArray = array("172.16.0.1", "172.16.0.3", "172.16.0.4", "172.16.0.8", "172.16.0.10", "172.16.0.11", "172.16.0.12", "172.16.0.14", "172.16.0.18", "172.16.0.19", "172.16.0.20", "172.16.0.21", "172.16.0.25", "172.16.0.30", "172.16.0.31", "172.16.0.32", "172.16.0.33", "172.16.0.36", "172.16.0.51", "172.16.0.55", "172.16.0.77", "172.16.0.87", "172.16.0.100", "172.16.0.101", "172.16.0.102", "172.16.0.103", "172.16.0.120"); break;
            case 'hasegawa': $tableArray = array("172.16.0.105", "172.16.0.106", "172.16.0.107", "172.16.0.108", "172.16.0.109", "172.16.0.110", "172.16.0.111", "172.16.0.112", "172.16.0.113", "172.16.0.114", "172.16.0.115", "172.16.0.116", "192.168.1.151", "192.168.1.153", "192.168.1.152", "192.168.1.154", "192.168.1.155", "192.168.1.157", "192.168.1.158", "192.168.1.200"); break;
            case 'batua-sendMail': $tableArray = array("172.16.0.1", "172.16.0.3", "172.16.0.4", "172.16.0.8", "172.16.0.10", "172.16.0.11", "172.16.0.12", "172.16.0.14", "172.16.0.18", "172.16.0.19", "172.16.0.20", "172.16.0.21", "172.16.0.25", "172.16.0.30", "172.16.0.31", "172.16.0.32", "172.16.0.33", "172.16.0.36", "172.16.0.51", "172.16.0.55", "172.16.0.77", "172.16.0.87", "172.16.0.100", "172.16.0.101", "172.16.0.102", "172.16.0.103", "172.16.0.120"); break;
            case 'hasegawa-sendMail': $tableArray = array("172.16.0.105", "172.16.0.106", "172.16.0.107", "172.16.0.108", "172.16.0.109", "172.16.0.110", "172.16.0.111", "172.16.0.112", "172.16.0.113", "172.16.0.114", "172.16.0.115", "172.16.0.116", "192.168.1.151", "192.168.1.153", "192.168.1.152", "192.168.1.154", "192.168.1.155", "192.168.1.157", "192.168.1.158", "192.168.1.200"); break;
            default:break;
        }        
        //BUILD TABLE BODY
        if($swit == "batua-sendMail")
        { $build = pingServer_modules::process_sendMail($tableArray); }
        else if($swit == "hasegawa-sendMail")
        { $build = pingServer_modules::process_sendMail($tableArray); }
        else{ $build = pingServer_modules::process_arrayList($tableArray); }
        return $build;
    }
    public function registerServer($entry, $swit)
    {
        switch ($swit) {
            case 'batua': $cll = $swit."-sendMail"; $sendMail = pingServer_modules::arrayListServers($cll); break;
            case 'hasegawa': $cll = $swit."-sendMail"; $sendMail = pingServer_modules::arrayListServers($cll); break;
            //default:break;
        } return $sendMail;
    }
    public function process_arrayList($tableArrayRaw)
    { $splitNumber = 5;
        $arrayTableSplit = array_chunk($tableArrayRaw, $splitNumber); //var_dump($arrayTableSplit);
        $buildTable = pingServer_modules::build_pre_table($arrayTableSplit);
        return $buildTable;
    }
    
    //BUILD
    public function build_pre_table($preTable)
    {
        $preTab = "";
        for ($i=0; $i < count($preTable); $i++)
        { $preTab .= pingServer_modules::build_table($preTable[$i]); }
        return $preTab;
    }
    public function build_table($table)
    {
        $build_tr = "<tr>";
        $build_tr .= pingServer_modules::build_listarIps($table);
        $build_tr .= "</tr>";
        return $build_tr;
    }
    public function build_listarIps($ips)
    {
        $build_tr = "";
        for ($i=0; $i < count($ips); $i++)
        {
            $build_tr .= '<td><span id="serverIPS">'.$ips[$i].'</span></td>';
            $build_tr .= '<td><span id="serverName">[IDENT. ... ]</span></td>';
            $build_tr .= '<td><span id="serverStatus">[IDENT. ... ]</span></td>';
            $build_tr .= "</tr><tr>";
        } return $build_tr;
    }
    public function process_sendMail($entry)
    {
        $nArray = array();
        for ($i=0; $i < count($entry); $i++)
        { 
            $getPng = pingServer_modules::getPing($entry[$i]);
            if($getPng <= 50)
            { $nArray[] .= $entry[$i]; }
        }
        //QTD FALHAS
        //var_dump($nArray);
        if(count($nArray) > 0)
        { $goToSendMail = pingServer_modules::toSendMail(serialize($nArray)); return $goToSendMail; } 
        return "";
    }
    //SEND MAIL
    public function toSendMail($entry)
    { $ips = unserialize($entry); date_default_timezone_set('America/Sao_Paulo');
        require("../../../cnt-assets/phpmailer-5.5.3/PHPMailerAutoload.php");
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 2;
        $mail->Debugoutput = 'html';
        $mail->Host = 'ssl://smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = "sales.cleaner.externo2@gmail.com";
        $mail->Password = "Cle@nnerSales";
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
        $bds .= '<thead> <tr> <th scope="col">IP</th> <th scope="col">Status</th> <th scope="col">HORARIOS</th> </tr> </thead>';
        $bds .= '<tbody>';
        for ($i=0; $i < count($ips); $i++)
        { $bds .= '<tr> <td>'.$ips[$i].'</td> <td>FALHA NA ENTRGA DO PACOTE</td> <td>'.date('d/m/Y')." ".(intval(date('H'))-1).":".date("s").":".date("i").'</td> </tr>'; }    
        $bds .= '</tbody> </table>';
        $mail->Body = $bds;
        //Replace the plain text body with one created manually
        $mail->AltBody = 'FALHA NA ENTRGA DO PACOTE';
        //send the message, check for errors
        if (!$mail->send()) 
        { return json_encode("Mailer Error: " . $mail->ErrorInfo); }
        else{ return json_encode("Message sent!"); }
    }
    //STAFF data ping Responser
    public function getPing($entry)
    { 
        $pings = `ping -a $entry -n 1`;
        $str1 = str_replace(">", ":", $pings);
        $str2 = str_replace(" ", ":", $str1);
        $pingExplod = explode(":", $str2);
        $pingCount_splitterParts = count($pingExplod);
        return $pingCount_splitterParts;
    }
}
?>