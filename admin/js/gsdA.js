var gsdAClass = new gsdA_Class();
var ret = "";

$(document).ready(function () {
	if (gsdAClass.latitude == '' || gsdAClass.longitude == '') {
            AC_Geral();
	}
	if (gsdAClass.aviso_tovivo == '') {
           gsdAClass.aviso_tovivo=60;
	}
	//ret = setInterval(AC_SERV, 3600 * 1000 );	//gsdAClass.aviso_tovivo
	// clearInterval(ret);	
});

function AC_Geral()
{
    // Pegar a Latitude e Longitude
    var latitude = 0;
    var longitude = 0;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (posicao) {
            // console.log( posicao.coords.latitude, posicao.coords.longitude );
            latitude = posicao.coords.latitude;
            longitude = posicao.coords.longitude;

            $.ajax({
                type: 'POST',
                url: ajax_sistema + '?tipo=LatitudeLongitude',
                data: {
                    cas: conteudo_abrir_sistema,
                    latitude: latitude,
                    longitude: longitude
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Erro [LALO] no ajax no: ' + textStatus + ' - ' + errorThrown);
                },
                async: false
            });
        });
    }
    
    AC_Pat();
    AC_Midia();
}

function AC_Pat()
{
    var href      = window.location.href;
    var protocolo = window.location.protocol;
    var host      = window.location.host;
    var pathname  = window.location.pathname;
    // alert(protocolo+' - '+host+' - '+pathname);
}

function AC_Midia()
{

    function hasGetUserMedia() {
        // Note: Opera builds are unprefixed.
        return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia || navigator.msGetUserMedia);
    }

    if (hasGetUserMedia()) {
        // Good to go!
        //alert('getUserMedia() is OK supported in your browser');
    } else {
        //alert('getUserMedia() is not supported in your browser');
    }
}

function AC_SERV()
{
//	alert('to vivo');
	
	//echo "    self.location = 'incentrada_indevida.php';";
	
	
	
	var to_vivo="S";
	$.ajax({
		dataType: 'json',
		type: 'POST',
		url: ajax_sistema + '?tipo=AC_SERV',
		data: {
			cas: conteudo_abrir_sistema,
			to_vivo:to_vivo
		},
		success: function (response) {
			//alert(' bbbb '+response.perdeu_session);
			var perdeu_session = response.perdeu_session;
			if (perdeu_session!='')
			{
			   alert("O Sistema solicita que efetue um NOVO LOGIN. Clique em OK para prosseguir.");	
			   self.location = 'incentrada_indevida.php';
			}
			var registrar = response.registrar;
            if (registrar!='')
			{
			   alert("Erro registrando session. "+registrar);	
			}			
			var mensagem = response.mensagem;
            if (mensagem!='')
			{
			   alert("Atenção..."+"\n"+mensagem);	
			}			
		 
		},

		error: function (jqXHR, textStatus, errorThrown) {
			// alert('Erro [AC_SERV] no ajax no: ' + textStatus + ' - ' + errorThrown);
		},
		
		async: true
	});
	
}