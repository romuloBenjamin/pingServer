$(document).ready(function(){
    var getServerIPS2 = document.querySelectorAll("div.container-hasegawa > table > tbody > tr > td > span#serverIPS");
    var getSpanServerIPS2 = "";
    for (let indexH = 0; indexH < getServerIPS2.length; indexH++)
    {
        const getSpanServerIPS2 = getServerIPS2[indexH].textContent;
        getData_byAjax2(getSpanServerIPS2, indexH);
    }   

});

//toAjax
function getData_byAjax2(e, i)
{
    var getServerNames = document.querySelectorAll("div.container-hasegawa > table > tbody > tr > td > span#serverName");
    var getServerStatus = document.querySelectorAll("div.container-hasegawa > table > tbody > tr > td > span#serverStatus");
    $.ajax({
        url: "cnt-files/cnt-modules/public-module/core/process2.php",
        type: "GET",
        data: { e, i },
        beforeSend(){},
        success(data){
            //console.log(data);
            var objH = JSON.parse(data);
            getServerNames[objH.key].innerHTML = objH.name;
            if(objH.ping > 50)
            { getServerStatus[objH.key].innerHTML = "OPERANTE"; }
            else{ getServerStatus[objH.key].innerHTML = "FALHA NA ENTREGA DO PACOTE"; }
        }
    })
}