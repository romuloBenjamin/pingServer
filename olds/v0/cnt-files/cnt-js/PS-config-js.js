$(document).ready(function(){
    var getServerIPS = document.querySelectorAll("div.container-batua > table > tbody > tr > td > span#serverIPS");
    var getSpanServerIPS = "";
    for (let indexB = 0; indexB < getServerIPS.length; indexB++)
    {
        const getSpanServerIPS = getServerIPS[indexB].textContent;
        getData_byAjax(getSpanServerIPS, indexB);
    }   

});

//toAjax
function getData_byAjax(e, i)
{
    var getServerNames = document.querySelectorAll("div.container-batua > table > tbody > tr > td > span#serverName");
    var getServerStatus = document.querySelectorAll("div.container-batua > table > tbody > tr > td > span#serverStatus");
    $.ajax({
        url: "cnt-files/cnt-modules/public-module/core/process.php",
        type: "GET",
        data: { e, i },
        beforeSend(){},
        success(data){
            //console.log(data);
            var objB = JSON.parse(data);
            getServerNames[objB.key].innerHTML = objB.name;
            if(objB.ping > 50)
            { getServerStatus[objB.key].innerHTML = "OPERANTE"; }
            else{ getServerStatus[objB.key].innerHTML = "FALHA NA ENTREGA DO PACOTE"; }
        }
    });
}