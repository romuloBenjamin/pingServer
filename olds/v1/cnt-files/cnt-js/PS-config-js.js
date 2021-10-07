var serverDNS = document.querySelectorAll("span.serverDNS");
for (let index = 0; index < serverDNS.length; index++)
{ const getServerIDS = serverDNS[index].innerText; getPingServerConst(getServerIDS); }

//GET CONSTANT TO PINGER
function getPingServerConst(e)
{
    var contantPinger = "get-pinger-"+e.toLowerCase(); //console.log(contantPinger);
    var updateStatus = "update-status-pingServer-"+e.toLowerCase();
    var gpinger = toAjax_pinger(contantPinger); //GET SEND MAIL FROM PINGER
    var atualizapinger = toAjax_pinger_updateStatus(updateStatus); //ATUALIZA STATUS TELA
}

//To AJAX
function toAjax_pinger(e)
{
    var customSpinner = document.querySelectorAll("div.custom-spinner");
    $.ajax({
        url: "v1/cnt-files/cnt-modules/public-module/core/pingserver-core.php",
        type: "POST",
        data: {e},
        beforeSend: function()
        {
            for (let index = 0; index < customSpinner.length; index++)
            { const spin = customSpinner[index];
                if(customSpinner[index].classList.contains("d-none"))
                {
                    customSpinner[index].classList.remove("d-none");
                    customSpinner[index].classList.add("d-flex");
                }
            }
        },
        success: function(data)
        {
            console.log(data);
        },
        complete: function()
        {
            for (let index = 0; index < customSpinner.length; index++)
            { const spin = customSpinner[index];
                if(customSpinner[index].classList.contains("d-flex"))
                {
                    customSpinner[index].classList.remove("d-flex");
                    customSpinner[index].classList.add("d-none");
                }
            }
        }
    });
}
function toAjax_pinger_updateStatus(e)
{
    $.ajax({
        url: "v1/cnt-files/cnt-modules/public-module/core/update-pingserver-core.php",
        type: "POST",
        data: {e},
        beforeSend: function(){},
        success: function(data)
        {
            var obj = JSON.parse(data);
            atualizaStatus_ip(obj);
        },
        complete: function(){}

    });
}
function atualizaStatus_ip(e)
{
    for (let index = 0; index < e.length; index++)
    { 
        if(e[index].FILIAL == 1){ var filial = "batua"; }else{ var filial = "hasegawa"; }        
        if(e[index].OPERACAO == 1){ var operacao = 'OPERANTE'; }else{ var operacao = 'FALHA'; }        
        var ips = e[index].IPS;
        changeLiner(filial, operacao, ips, index);
    }
}
function changeLiner(sede, statusService, ipServ, content)
{
    var tableRows = document.querySelectorAll("div.container-"+sede+" > table > tbody > tr")[content];
    tableRows.querySelector("td > span#serverStatus").innerHTML = statusService;

}