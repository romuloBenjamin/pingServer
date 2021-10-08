/*LISTAS JSON*/
var pingBatua = "cnt-files/cnt-modules/public-module/jsons/lista-batua.json";
var pingDVRS = "cnt-files/cnt-modules/public-module/jsons/lista-dvreliane.json";
var pingRelogios = "cnt-files/cnt-modules/public-module/jsons/lista-relogios.json";
var pingHasegawa = "cnt-files/cnt-modules/public-module/jsons/lista-hasegawa.json";

/*EVENT ON LOUD*/
window.addEventListener("load", function(){
    var readBatuaJSONS = requestLoud(pingBatua, "batua");
    var readDVREJSONS = requestLoud(pingDVRS, "dvreliane");
    var readRelogios = requestLoud(pingRelogios, "relogios");
    var readHasegawaJSONS = requestLoud(pingHasegawa, "hasegawa");
});

/*GET DADOS LISTA*/
function requestLoud(lista, tableName) {
    /*TABLE PING NAMES*/
    var placer = document.querySelector("table#tabela-"+tableName+" > tbody");
    /*REQUEST*/

    /*HEADERS to FETCH REQUEST*/
    var myHeaders = new Headers();
    myHeaders.append('pragma', 'no-cache');
    myHeaders.append('cache-control', 'no-cache');

    var myInit = { 
        method: 'GET',
        headers: myHeaders,
    };

    var pinBatua = new Request(lista);
    fetch(pinBatua, myInit)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            data.forEach(nArray => {
                const cloneNode = placer.querySelectorAll("tr")[0].cloneNode(true);
                cloneNode.querySelectorAll("td")[0].innerHTML = nArray.ip;
                cloneNode.querySelectorAll("td")[1].innerHTML = nArray.name;
                $.post("cnt-files/cnt-modules/doPing-module/core/pingIP-core.php", {data: nArray.ip}, function(pin){
                    var jPIN = JSON.parse(pin);
                    if(parseInt(jPIN.status) === 0) {
                        cloneNode.style.backgroundColor = "rgba(255,0,0,.24)";
                        $.get("cnt-files/cnt-modules/mail-module/core/mailSender-core.php", {data: nArray}, function(nData){
                            console.log(nData);
                        });
                    }
                    cloneNode.querySelectorAll("td")[2].innerHTML = jPIN.msn;
                });
                placer.appendChild(cloneNode);
            });
            placer.querySelectorAll("tr")[0].classList.add("d-none");
        })
        .catch(console.error);
}

var data = new Date();
var cData = data.toString();
if(cData.split(" ")[0]){
    if(cData.split(" ")[0] === "sat"){ /*ATUALIZA DE TEMPO EM TEMPO -> 2.5M*/
        setTimeout(function(){ location.reload(); }, 150000);
    }else{ /*ATUALIZA DE TEMPO EM TEMPO -> 5M*/
        setTimeout(function(){ location.reload(); }, 300000);
    }
}
