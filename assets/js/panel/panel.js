$(function() {
    obj_panel = new Panel();
});

$("#btn_mostrar_datos_rec").click(function(){
	obj_panel.get_reactivos();
})

$("#md_close_visor_recursos").click(function(){
	$("#modal_visor_recursos").modal('hide');
  obj_panel.get_reactivos();
})

function Panel(){
  _thismap = this;
}

Panel.prototype.get_reactivos =function(){
	$.ajax({
		url: base_url+'panel/get_reactivos_recursos',
		type: 'POST',
		dataType: 'JSON',
		data: {periodo: $("#slt_periodo_reactivos").val(), campo_dis: $("#slt_campod_reactivos").val() },
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {
		$("#contenedor_tabla").empty();

		var table = "";
		$("#contenedor_tabla").append(result);

	})
	.fail(function(e) {
		console.error("Error in get_Niveles()"); console.table(e);
	})
	.always(function() {
    swal.close();
	});

}


Panel.prototype.get_tabla = function(idreactivo){
	$.ajax({
		url: base_url+'panel/get_tabla_recursosJS',
		type: 'POST',
		dataType: 'JSON',
		data: {id_reactivo: idreactivo},
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {

		$("#div_contenedor_de_tablarec").empty();
		$("#div_contenedor_hidden").empty();
		$("#div_contenedor_de_tablarec").append(result.tabla);
		$("#div_contenedor_hidden").append("<input type='hidden' id='input_id_reactivo' value = "+idreactivo+">");
		$("#div_contenedor_hidden").append("<input type='hidden' id='total_reactivos' value = "+result.totalre+">");
		$("#modal_visor_recursos").modal('show');
	})
	.fail(function(e) {
		console.error("Error in get_Niveles()"); console.table(e);
	})
	.always(function() {
    swal.close();
	});
}

Panel.prototype.show_apoyo = function(path_apoyo){
	var html = "<div style='text-align:left !important;'>";
      html += "<table class='table table-condensed'>";
      html += "<tbody> ";
      html += "    <tr>";
      html += "      <td><center>";
        html += "<img style='width: 100%;' src='http://www.sarape.gob.mx/assets/docs/planea_reactivos/"+path_apoyo+"' class='img-responsive center-block' />";
        html += "      </center></td>";
        html += "    </tr>";
    html += "</tbody>";
      html += "</table>";

      html += "</div>";

    $('#modal_visor_apoyo_react .modal-body #div_cont_apoyo').empty();
    $('#modal_visor_apoyo_react .modal-body #div_cont_apoyo').html(html);


    $("#modal_visor_apoyo_react").modal("show");
}

Panel.prototype.modal_reactivo = function(path_react){

    var html = "<div style='text-align:left !important;'>";
      html += "<table class='table table-condensed'>";
      html += "<tbody> ";
      html += "    <tr>";
      html += "      <td><center>";
        html += "<img style='width: 100%;' src='http://www.sarape.gob.mx/assets/docs/planea_reactivos/"+path_react+"' class='img-responsive center-block' />";
        html += "      </center></td>";
        html += "    </tr>";
    html += "</tbody>";
      html += "</table>";

      html += "</div>";

    $('#modal_visor_reactivos_zom .modal-body #div_listalinks').empty();
    $('#modal_visor_reactivos_zom .modal-body #div_listalinks').html(html);


    $("#modal_visor_reactivos_zom").modal("show");
}

Panel.prototype.show_propuestas = function(id_reactivo){
	$.ajax({
		url: base_url+'panel/get_tabla_propuetas',
		type: 'POST',
		dataType: 'JSON',
		data: {id_reactivo: id_reactivo},
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {

		$("#div_contenedor_de_propuestas").empty();
		$("#div_contenedor_de_propuestas").append(result.respuesta);
		$("#modal_visor_propuestas").modal('show');
	})
	.fail(function(e) {
		console.error("Error in show_propuestas()"); console.table(e);
	})
	.always(function() {
    swal.close();
	})
}

Panel.prototype.ver_propuesta = function(idpropuesta, tipo, ruta){
	if(tipo == 1 || tipo == 2){
		obj_panel.modal_propuestarec(ruta, tipo);
	}else{
		window.open(ruta, '_blank');
	}
}

Panel.prototype.autorizar_propuesta = function(idpropuesta){
	$.ajax({
		url: base_url+'panel/autoriza_propuesta',
		type: 'POST',
		dataType: 'JSON',
		data: {id_propuesta: idpropuesta},
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {

		swal.close();

		if(result.respuesta == 'maximovalor'){
			swal(
		      'Alerta!',
		      "El reactivo ya cuenta con el numero maximo permitido de material",
		      'warning'
		    );
		}
		if(result.respuesta == true){
			swal(
		      'Correcto!',
		      "La propuesta se autorizo correctamente",
		      'success'
		    );
		}
		if(result.respuesta == false){
			swal(
		      'Error!',
		      "Algo salio mal a intentar autorizar la propuesta",
		      'danger'
		    );
		}
		$('#modal_visor_propuestas').modal('toggle');
	})
	.fail(function(e) {
		console.error("Error in autorizar_propuesta()"); console.table(e);
	})
	.always(function() {

	})
}

Panel.prototype.elimina_propuesta = function(idpropuesta){
		swal({
	  title: '¿Esta seguro de eliminar esta propuesta?',
	  text: "Una vez eliminado no se podra tener acceso al recurso",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Eliminar',
	  cancelButtonText: 'Cancelar'
	}).then((result) => {
	  if (result.value) {
	  	$.ajax({
			url: base_url+'panel/delete_propuesta',
			type: 'POST',
			dataType: 'JSON',
			data: {id_propuesta: idpropuesta},
			beforeSend: function(xhr) {
		        Notification.loading("");
		    },
		})
		.done(function(result) {
			swal.close();

			if(result.respuesta == true){
				swal(
			      'Correcto!',
			      "La propuesta se elimino correctamente",
			      'success'
			    );
			}else{
				swal(
			      'Error!',
			      "Algo salio mal intente nuevamente",
			      'danger'
			    );
			}
				$('#modal_visor_propuestas').modal('toggle');
		})
		.fail(function(e) {
			console.error("Error in elimina_propuesta()"); console.table(e);
		})
		.always(function() {
			    // swal.close();
		})
	  }
	})
}

Panel.prototype.modal_propuestarec = function(path_react, tipo){
	var Protocol = location.protocol;
	var URLactual = window.location.host;
	var pathname = window.location.pathname;
  alert(URLactual);
	if(tipo == 1){
		tipo = "<iframe style='width:100%; height:500px;' frameborder='0' src='"+Protocol+"//"+URLactual+"/"+path_react+"'></iframe>";
	}else{
		tipo = "<img style='width: 100%;' src='"+Protocol+"//"+URLactual+"/"+path_react+"' class='img-responsive center-block' />";
	}
// alert(pathname);
    var html = "<div style='text-align:left !important;'>";

        html += tipo;

      html += "</div>";

    $('#modal_visor_apoyo_react .modal-body #div_cont_apoyo').empty();
    $('#modal_visor_apoyo_react .modal-body #div_cont_apoyo').html(html);


    $("#modal_visor_apoyo_react").modal("show");
}
