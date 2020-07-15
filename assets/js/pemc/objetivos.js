
$("#btn_crear_obj").click(function(){
	Objetivos.get_view_creareditar_obj();
});



var Objetivos = {
	get_objetivos_x_idpemc: () => {
	    $.ajax({
			url:base_url+"Objetivos/get_objetivos_x_idpemc",
			data:{},
			beforeSend: function(xhr) {
				Notification.loading("Cargando vista");
			}
		})
		.done(function(data){
			
			$("#contenedor_tabla_objetivos").empty();
			$("#contenedor_tabla_objetivos").append(data.contenido_tabla);
		})
		.fail(function(e) {
			console.error("Error in ()"); console.table(e);
		})
		.always(function() {
			swal.close();
		});
	},

	get_view_creareditar_obj: () => {
    $.ajax({
		url:base_url+"Objetivos/get_view_obj",
		data:{},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		$("#contenedor_obj_gen").empty();
		$("#contenedor_obj_gen").append(data.str_view);
		$("#modal_generico_obj").modal('show');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		swal.close();
	});
  },

  agreg_acciones: (idobjetivo) =>{
  	$.ajax({
  		type: 'POST',
		url:base_url+"Objetivos/get_view_acciones",
		data:{'idobjetivo':idobjetivo},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		$("#contenedor_obj_gen").empty();
		$("#contenedor_obj_gen").append(data.str_view);
		$("#modal_generico_obj").modal('show');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		swal.close();
	});
  },

  agreg_editarA: (idaccion, idobjetivo) =>{
  	$.ajax({
  		type: 'POST',
		url:base_url+"Objetivos/update_acciones",
		data:{
			'idobjetivo': idobjetivo,
			'idaccion':idaccion,
			'accion': $("#txt_accion_"+idaccion).val(),
			'recurso': $("#txt_recurso_"+idaccion).val(),
			'ambitos': $("#select_ambito_"+idaccion).val(),
			'responsables': $("#slc_responsables_"+idaccion).val(),
			'otro_responsable': $("#txt_otrosresp_"+idaccion).val(),
			'finicio': $("#txt_finicio_"+idaccion).val(),
			'ffin': $("#txt_ffin_"+idaccion).val()
		},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		if(data.estatus){
			swal(
			'¡Bien!',
			"La accion se actualizó correctamente",
			"success"
			);
		}else{
			swal(
			'¡Error!',
			"Fallo la actualización",
			"error"
			);
		}
		$("#modal_generico_obj").modal('hide');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		// swal.close();
	});
  },

  guardar_naccion: (idobjetivo) =>{
  	$.ajax({
  		type: 'POST',
		url:base_url+"Objetivos/insert_acciones",
		data:{
			'idobjetivo': idobjetivo,
			'accion': $("#txt_accion_new").val(),
			'recurso': $("#txt_recurso_new").val(),
			'ambitos': $("#select_ambito_new").val(),
			'responsables': $("#slc_responsables_new").val(),
			'otro_responsable': $("#txt_otrosresp_new").val(),
			'finicio': $("#txt_finicio_new").val(),
			'ffin': $("#txt_ffin_new").val()
		},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		if(data.estatus){
			swal(
			'¡Bien!',
			"La accion se inserto correctamente",
			"success"
			);
		}else{
			swal(
			'¡Error!',
			"Fallo al insertar",
			"error"
			);
		}
		$("#modal_generico_obj").modal('hide');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		// swal.close();
	});
  },

  carga_archivos:(archivo, tipo, idobjetivo) =>{
  	var formData = new FormData();
    var files = $(archivo)[0].files[0];
    formData.append('file',files);
    formData.append('tipo_evidencia',tipo);
    formData.append('idobjetivo',idobjetivo);
  	$.ajax({
  		type: 'POST',
		url:base_url+"Objetivos/insert_evidencias",
        data: formData,
        contentType: false,
        processData: false,
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		if(data.estatus){
			swal(
			'¡Bien!',
			"La evidencia se inserto correctamente",
			"success"
			);
		}else{
			swal(
			'¡Error!',
			"Fallo al insertar",
			"error"
			);
		}
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		// swal.close();
	});
  }
}
