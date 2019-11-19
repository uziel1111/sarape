$(function() {
    obj_mapa = new Mapa();
});

function Mapa(){
  _thismap = this;
}

$("#slt_municipio_mapa").change(function() {
	obj_mapa.get_Niveles();
});

$("#slt_nivel_mapa").change(function() {
	obj_mapa.get_Sostenimientos();
});

$("#btn_buscar_mapa").click(function(){
	obj_mapa.get_marcadores_filtro();
});

Mapa.prototype.get_Niveles =function(){
	$.ajax({
		url: base_url+'mapa/get_niveles',
		type: 'POST',
		dataType: 'JSON',
		data: {idmunicipio: $("#slt_municipio_mapa").val()},
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {
		$("#slt_nivel_mapa").empty();
		$("#slt_nivel_mapa").append(result.options);
	})
	.fail(function(e) {
		console.error("Error in get_Niveles()"); console.table(e);
	})
	.always(function() {
    swal.close();
	});

}

Mapa.prototype.get_Sostenimientos =function(){
	$.ajax({
		url: base_url+'mapa/get_sostenimientos',
		type: 'POST',
		dataType: 'JSON',
		data: {idnivel: $("#slt_nivel_mapa").val()},
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {
		$("#slt_sostenimiento_mapa").empty();
		$("#slt_sostenimiento_mapa").append(result.options);
	})
	.fail(function() {
		console.error("Error in get_Sostenimientos()"); console.table(e);
	})
	.always(function() {
		swal.close();
	});
}

Mapa.prototype.get_marcadores_filtro = function(){
	$.ajax({
		url: base_url+'mapa/get_marcadores_filtro',
		type: 'POST',
		dataType: 'JSON',
		data: {idmunicipio: $("#slt_municipio_mapa").val(), idnivel: $("#slt_nivel_mapa").val(),
		idsostenimiento: $("#slt_sostenimiento_mapa").val(), nombre: $("#txt_nombre_escuela").val(), cct: $("#txt_cct_escuela").val()},
		beforeSend: function(xhr) {
	        Notification.loading("Cargando");
	  },
	})
	.done(function(result) {
		var marcadores = result.response;
	    obj_mapa.pinta_en_mapa(marcadores);
	     swal.close();
	})
	.fail(function(e) {
		console.error("Error in get_marcadores_filtro()"); console.table(e);
		 swal.close();

	})
	.always(function() {
    swal.close();
	});

}

Mapa.prototype.retur_icon = function(nivel){
	switch(nivel){
		case "1":
			return "marker1";
			break;
		case "2":
			return "marker2";
			break;
		case "3":
			return "marker3";
			break;
		case "4":
			return "marker4";
			break;
		case "5":
			return "marker5";
			break;
		case "6":
			return "marker6";
			break;
		case "7":
			return "marker7";
			break;
		case "8":
			return "marker8";
			break;
		case "9":
			return "marker9";
			break;
		case "10":
			return "marker10";
			break;

	}
}

Mapa.prototype.cct_mismo_nivel = function(idcct){
	console.log(idcct);
	$.ajax({
		url: base_url+'mapa/get_mismo_nivel',
		type: 'POST',
		dataType: 'json',
		data: "idcct="+idcct,
		beforeSend: function(xhr) {
	        // obj_loader.show();
	    },
	})
	.done(function(result) {
		// obj_loader.hide();
		var marcadores = result.response;
	    obj_mapa.pinta_en_mapa(marcadores);
	})
	.fail(function(error) {
		console.log("error");
	})
	.always(function(complete) {
		console.log("complete");
	});

}

Mapa.prototype.cct_siguiente_nivel = function(idcct){
	console.log(idcct);
	$.ajax({
		url: base_url+'mapa/get_siguiente_nivel',
		type: 'POST',
		dataType: 'json',
		data: "idcct="+idcct,
		beforeSend: function(xhr) {
	        // obj_loader.show();
	    },
	})
	.done(function(result) {
		// obj_loader.hide();
		var marcadores = result.response;
	    obj_mapa.pinta_en_mapa(marcadores);
	})
	.fail(function(error) {
		console.log("error");
	})
	.always(function(complete) {
		console.log("complete");
	});

}

Mapa.prototype.pinta_en_mapa = function(marcadores){
	if (marcadores != '') {
	document.getElementById('contenedor_mapa_id').scrollIntoView();
	// console.table(marcadores);
	// console.log(marcadores[0][4]);
	var map = new google.maps.Map(document.getElementById('map'), {
	         zoom: 10,
	         center: new google.maps.LatLng(marcadores[0][1],marcadores[0][2]),
	         mapTypeId: google.maps.MapTypeId.ROADMAP
	     });
	      var infowindow = new google.maps.InfoWindow({
	          maxWidth: 330
	      });

	      var oms = new OverlappingMarkerSpiderfier(map); //Spiderfied it here
	      // var iw = new gm.InfoWindow();
	      oms.addListener('click', function(marker, event) {
	        infowindow.setContent(marker.desc);
	        infowindow.open(map, marker);
	      });
	      oms.addListener('spiderfy', function(markers) {
	        infowindow.close();
	      });

	      var marker, i;
	      var iconBase = '../../assets/img/markets/';
	      for (i = 0; i < marcadores.length; i++) {
	      	var iconBase = '../../assets/img/markets/'+obj_mapa.retur_icon(marcadores[i][4])+".png";
	      	// iconBase += obj_mapa.retur_icon(marcadores[i][3]);
	          marker = new google.maps.Marker({
	           position: new google.maps.LatLng(marcadores[i][1], marcadores[i][2]),
	           map: map,
	           icon: iconBase,
	           // animation: google.maps.Animation.DROP
	       });
	          
	           oms.addMarker(marker);  // <-- here attempted to add markers
	          google.maps.event.addListener(marker, 'click', (function(marker, i) {
	           return function() {
	           	cct_mapa = "'"+marcadores[i][3]+"'";
	          cct_turno_mapa = "'"+marcadores[i][3]+"','"+marcadores[i][6]+"'";
	              var contentString = '<div class="card-map">';
                      contentString +='<div class="cardmap-body">';
                      contentString +='<h5 class="card-title fw-800">'+marcadores[i][0]+'</h5>';
	              contentString +='<h6 class="card-subtitle mb-2 fw-800 text-muted">'+marcadores[i][3]+'</h6>';
                      contentString +='<table class="table table-sm">';
                      contentString +='<tbody>';
                      contentString +='<tr>';
                      contentString +='<td colspan="2"><span class="fw800" data-toggle="tooltip" data-placement="right" title="Municipio"><i class="fas fa-globe-americas"></i>: '+marcadores[i][5]+'</span></td>';                   
                      contentString +='</tr>';
                      contentString +='<tr>';
                      contentString +='<td colspan="2"><span class="fw800" data-toggle="tooltip" data-placement="right" title="Localidad"><i class="fa fa-map-marker-alt"></i>: '+marcadores[i][9]+'</span></td>';                   
                      contentString +='</tr>';                      
                      contentString +='<tr>';
                      contentString +='<td><span class="fw800" data-toggle="tooltip" data-placement="right" title="Nivel"><i class="fa fa-chalkboard-teacher"></i>: '+marcadores[i][8]+'</span></td>';
                      contentString +='<td><span class="fw800" data-toggle="tooltip" data-placement="right" title="Sostenimiento"><i class="fa fa-hand-holding-usd"><span data-toggle="tooltip" data-placement="right" title="Municipio"></i>: '+marcadores[i][7]+'</span></td>';                     
                      contentString +='</tr>';
                      contentString +='<tr>';
                      contentString +='<td><span class="fw800" data-toggle="tooltip" data-placement="right" title="Turno"><i class="fa fa-clock"></i>: '+marcadores[i][6]+'</span></td>';
                      contentString +='<td><span class="fw800" data-toggle="tooltip" data-placement="right" title="Zona"><i class="fa fa-crosshairs"></i>: '+marcadores[i][10]+'</span></td>';                     
                      contentString +='</tr>';                      
                      contentString +='</tbody>';
                      contentString +='</table>';
                      contentString +='<p class="text-center">';                      
                      contentString +='<button class="btn btn-primary mr-5" onclick="obj_mapa.cct_mismo_nivel('+cct_mapa+')" data-toggle="tooltip" data-placement="top" title="Busca 5 escuelas del mismo nivel"><i class="far fa-clone"></i></button>'; 
                      contentString +='<button class="btn btn-primary mr-5" onclick="obj_mapa.cct_siguiente_nivel('+cct_mapa+')" data-toggle="tooltip" data-placement="top" title="Busca 5 escuelas del siguiente nivel"><i class="fa fa-share-square"></i></button>';
                      contentString +='<button class="btn btn-primary mr-5" onclick="obj_mapa.get_info('+cct_turno_mapa+')" data-toggle="tooltip" data-placement="top" title="Información de la escuela"><i class="fa fa-info-circle"></i></button>';
                      contentString +='</p>';
                      contentString +='</div>';                      
                      contentString +='</div>';
	              infowindow.setContent(contentString);
	              infowindow.open(map, marker);
	          }
	      })(marker, i));
	           
	     }
	   }else {
	   	console.log('marcadores');
	   	swal({
			title: 'No se encontraron escuelas',
			text:'',
			type: 'info',
		})
	   }
}

Mapa.prototype.get_info = function(id_cct, turno){

	var form = document.createElement("form");
	var element1 = document.createElement("input");
		  element1.type="hidden";
		  element1.name="id_cct";
		  element1.value= id_cct;
    var element2 = document.createElement("input");
		  element2.type="hidden";
		  element2.name="turno";
		  element2.value= turno;

	form.name = "form_info";
	form.id = "form_info";
	form.method = "POST";
	// form.target = "_self";
	form.action = base_url+"info/index";
	form.appendChild(element1);
	form.appendChild(element2);

	document.body.appendChild(form);
	form.submit();
}
