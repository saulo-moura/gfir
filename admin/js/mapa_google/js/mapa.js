var map;
var idInfoBoxAberto;
var infoBox = [];
var markers = [];

var latlng = "";
var latitude_central  = -13.0075688;
var longitude_central = -47.05878999999999
				
function initialize() {	
	//var latlng = new google.maps.LatLng(-18.8800397, -47.05878999999999);

//    latlng = new google.maps.LatLng(-13.0075688, -38.4970038);
	
	
	
    var options = {
        zoom: 0,
		center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);
}


//initialize();

function abrirInfoBox(id, marker) {
	if (typeof(idInfoBoxAberto) == 'number' && typeof(infoBox[idInfoBoxAberto]) == 'object') {
		infoBox[idInfoBoxAberto].close();
	}

	infoBox[id].open(map, marker);
	idInfoBoxAberto = id;
}

var marker = "";
var latlngbounds = "";

function carregarPontos() {
	
	$.getJSON('js/mapa_google/js/pontos.json', function(pontos) {
		
		latlngbounds = new google.maps.LatLngBounds();
		
		$.each(pontos, function(index, ponto) {
			
			
			
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(ponto.Latitude, ponto.Longitude),
				title: "Meu ponto personalizado! :-D",
				icon: 'js/mapa_google/img/marcador.png'
			});
			
			var myOptions = {
				content: "<p>" + ponto.Descricao + "</p>",
				pixelOffset: new google.maps.Size(-150, 0)
        	};

			infoBox[ponto.Id] = new InfoBox(myOptions);
			infoBox[ponto.Id].marker = marker;
			
			infoBox[ponto.Id].listener = google.maps.event.addListener(marker, 'click', function (e) {
				abrirInfoBox(ponto.Id, marker);
			});
			
			markers.push(marker);
			
			latlngbounds.extend(marker.position);
			
		});
		
		var markerCluster = new MarkerClusterer(map, markers);
		
		map.fitBounds(latlngbounds);
		
	});
	
}

carregarPontos();


function carregarNoMapa(endereco) {
	geocoder = new google.maps.Geocoder();
	geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
		//var status = google.maps.GeocoderStatus.OK;
		//alert(' status = '+status);
		if (status == google.maps.GeocoderStatus.OK) {
			status = results[0];
			
			if (results[0]) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
                var enderecof =results[0].formatted_address;
				//$('#txtEndereco').val(results[0].formatted_address);
				//$('#txtLatitude').val(latitude);
				//$('#txtLongitude').val(longitude);
                alert(' enderecof = '+enderecof+" latitude "+latitude+"  longitude "+longitude);	
				
				latitude_central = latitude;
				longitude_central= longitude;
				
				var location = new google.maps.LatLng(latitude, longitude);
				
				marker = new google.maps.Marker({
					  position: location, // variável com as coordenadas Lat e Lng
					  map: map,
					  title:"Farol de Aveiro",
					icon: 'js/mapa_google/img/marcador.png'
				  });
			var Descricao = "meu ponto 3";	
	        var myOptions = {
				content: "<p>" + Descricao + "</p>",
				pixelOffset: new google.maps.Size(-150, 0)
        	};
            var Idw=3;
			infoBox[Idw] = new InfoBox(myOptions);
			infoBox[Idw].marker = marker;
			
			infoBox[Idw].listener = google.maps.event.addListener(marker, 'click', function (e) {
				abrirInfoBox(Idw, marker);
			});
				
				//marker.setPosition(location);
				
				map.setCenter(location);
				map.setZoom(8);
			}
		}
	});
}
 
carregarNoMapa('40060-000');


latlng = new google.maps.LatLng(latitude_central, longitude_central);
// alert(" latitude xxxx "+latitude_central+"  longitude "+longitude_central);	
initialize();
