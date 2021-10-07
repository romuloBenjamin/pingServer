/*LISTAS JSON*/
var pingBatua = "cnt-files/cnt-modules/public-module/jsons/lista-batua.json";
var pingHasegawa = "cnt-files/cnt-modules/public-module/jsons/lista-hasegawa.json";

/*EVENT ON LOUD*/
window.addEventListener("load", function(){
    var readBatuaJSONS = requestLoud(pingBatua, "batua");
    var readHasegawaJSONS = requestLoud(pingHasegawa, "hasegawa");
});

/*GET DADOS LISTA*/
function requestLoud(lista, tableName) {
    /*TABLE PING NAMES*/
    var placer = document.querySelector("table#tabela-"+tableName+" > tbody");
    /*REQUEST*/
    var pinBatua = new Request(lista);
    fetch(pinBatua)
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
/*ATUALIZA DE TEMPO EM TEMPO -> 10M*/
setTimeout(function(){ location.reload(); }, 600000);