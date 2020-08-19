
// $(function() {
//     $("#txt_otrosresp_new").hide();
// });

$("#close_obj_generico").click(function(){
	$("#modal_generico_obj").modal('hide');
	Principal_pemc.obtiene_vista_obetivos();
});
$("#btn_crear_obj").click(function(){
	// if($("#txt_numero_objetivos_creados").val() < 3){
		Objetivos.get_view_creareditar_obj();
	// }else{
	// 	swal(
	// 		'Alerta!',
	// 		"Solo se pueden crear 3 objetivos",
	// 		"warning"
	// 		);
	// }

});


// function get_seleccionados(){
// 	console.log($("#slc_responsables_new").val());
// }

$("#btn_edita_obj").click(function(){
	if(Objetivos.idseleccionado != null){
		Objetivos.get_view_creareditar_obj(Objetivos.idseleccionado);
	}else{
		swal(
			'Alerta!',
			"Seleccione un objetivo para editar",
			"warning"
			);
	}
});

$("#btn_elimina_obj").click(function(){
	if(Objetivos.idseleccionado != null){
		swal({
	      title: '¿Está seguro de eliminar este objetivo?',
	      text: "Se eliminará las metas, comentarios, evidencias, seguimientos y evaluaciones asignadas a el mismo, una vez eliminado no se podrá recuperar",
	      type: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Eliminar',
	      cancelButtonText: 'Cancelar'
	    }).then((result) => {
	      if (result.value) {
	        Objetivos.delete_objetivo(Objetivos.idseleccionado);
	      }
	    })
	}else{
		swal(
			'Alerta!',
			"Seleccione un objetivo para eliminar",
			"warning"
			);
	}
});

$("#id_tabla_objetivos_pemc tr").click(function(){
       var value = $(this).find('td:first').text();
       var val2 = $(this).find('td:first').next().text();
       var val3 = $(this).find('td:first').next().next().text();
       var val4 = $(this).find('td:first').next().next().next().next().text();
       var textotp = $(this).find('td:first').next().next().next().text();
     if (value != '') {
           $(this).addClass('selected').siblings().removeClass('selected');
           Objetivos.idseleccionado = value;
      }
});


var Objetivos = {
	idseleccionado : null,
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

	get_view_creareditar_obj: (idobjetivo = 0) => {
    $.ajax({
    	type: 'POST',
		url:base_url+"Objetivos/get_view_obj",
		data:{
			'idobjetivo': idobjetivo
		},
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
			'comentarios_finicio': $("#txt_comentarios_finicio_"+idaccion).val(),
			'ffin': $("#txt_ffin_"+idaccion).val(),
			'comentarios_ffin': $("#txt_comentarios_ffin_"+idaccion).val()
		},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		swal.close();
		if(data.estatus){
			swal({
	      title: 'Se guardó correctamente.',
	      text: "¿Requiere seguir actualizando acciones?",
	      type: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Si',
	      cancelButtonText: 'No',
				allowOutsideClick: false
	    }).then((result) => {
	      if (result.value) {
	        // $("#modal_generico_obj").modal('hide');
					Objetivos.agreg_acciones(idobjetivo);
	      }
				else {
					$("#modal_generico_obj").modal('hide');
					Principal_pemc.obtiene_vista_obetivos();
				}
	    });
			// Principal_pemc.obtiene_vista_obetivos();
		}else{
			swal(
			'¡Error!',
			"Fallo la actualización",
			"error"
			);
		}
		// $("#modal_generico_obj").modal('hide');
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
			'comentarios_finicio': $("#txt_comentarios_finicio_new").val(),
			'ffin': $("#txt_ffin_new").val(),
			'comentarios_ffin': $("#txt_comentarios_ffin_new").val()
		},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		swal.close();
		if(data.estatus){
			swal({
	      title: 'Se guardó correctamente.',
	      text: "¿Requiere seguir actualizando acciones?",
	      type: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Si',
	      cancelButtonText: 'No',
				allowOutsideClick: false
	    }).then((result) => {
	      if (result.value) {
	        // $("#modal_generico_obj").modal('hide');
					Objetivos.agreg_acciones(idobjetivo);
	      }
				else {
					$("#modal_generico_obj").modal('hide');
					Principal_pemc.obtiene_vista_obetivos();
				}
	    });

		}else{
			swal(
			'¡Error!',
			"Fallo al insertar",
			"error"
			);
		}
		// $("#modal_generico_obj").modal('hide');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		// swal.close();
	});
  },

  valida_campos_accion: (idaccion = 0, idobjetivo = 0) => {
  	if(idaccion != 0){
  		if($("#txt_accion_"+idaccion).val().trim() == ''){
  			swal('¡Error!',"Inserte acción valida, verifique espacios","error");
  		}else{
  			if($("#txt_recurso_"+idaccion).val().trim() == ''){
  			swal('¡Error!',"Inserte recurso valido, verifique espacios","error");
	  		}else{
	  			if($("#select_ambito_"+idaccion).val() == ''){
	  			swal('¡Error!',"Seleccione ámbito","error");
		  		}else{
		  			if($("#slc_responsables_"+idaccion).val() == ''){
		  			swal('¡Error!',"Seleccione responsable","error");
			  		}else{
			  			if($("#txt_otrosresp_"+idaccion).is(":visible") && $("#txt_otrosresp_"+idaccion).val() == ''){
			  				swal('¡Error!',"Introduzca otro(s) responsable(s)","error");
			  			}else{
			  				if($("#txt_finicio_"+idaccion).val() == ''){
				  			swal('¡Error!',"Seleccione fecha de inicio","error");
					  		}else{
					  			if($("#txt_ffin_"+idaccion).val() == ''){
					  			swal('¡Error!',"Seleccione fecha de fin","error");
						  		}else{
						  			if(Objetivos.valida_fecha($("#txt_finicio_"+idaccion).val(), $("#txt_ffin_"+idaccion).val())){
						  			swal('¡Error!',"La fecha de inicio no puede ser mayo a la de fin","error");
							  		}else{
							  			Objetivos.agreg_editarA(idaccion, idobjetivo);
							  		}
						  		}
					  		}
			  			}
			  		}
		  		}
	  		}
  		}
  	}else{
  		if($("#txt_accion_new").val().trim() == ''){
  			swal('¡Error!',"Inserte acción valida, verifique espacios","error");
  		}else{
  			if($("#txt_recurso_new").val().trim() == ''){
  			swal('¡Error!',"Inserte recurso valido, verifique espacios","error");
	  		}else{
	  			if($("#select_ambito_new").val() == ''){
	  			swal('¡Error!',"Seleccione ámbito","error");
		  		}else{
		  			if($("#slc_responsables_new").val() == ''){
		  			swal('¡Error!',"Seleccione responsable","error");
			  		}else{
			  			if($("#txt_otrosresp_new").is(":visible") && $("#txt_otrosresp_new").val() == ''){
			  				swal('¡Error!',"Introduzca otro(s) responsable(s)","error");
			  			}else{
			  				if($("#txt_finicio_new").val() == ''){
				  			swal('¡Error!',"Seleccione fecha de inicio","error");
					  		}else{
					  			if($("#txt_ffin_new").val() == ''){
					  			swal('¡Error!',"Seleccione fecha de fin","error");
						  		}else{
						  			if(Objetivos.valida_fecha($("#txt_finicio_new").val(), $("#txt_ffin_new").val())){
						  			swal('¡Error!',"La fecha de inicio no puede ser mayo a la de fin","error");
							  		}else{
							  			Objetivos.guardar_naccion(idobjetivo);
							  		}
						  		}
					  		}
			  			}
			  		}
		  		}
	  		}
  		}
  	}
  },

  elimina_accion: (idaccion, idobjetivo) =>{
  	swal({
      title: '¿Está seguro de eliminar esta acción?',
      text: "Una vez eliminada no se podrá recuperar",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar',
			allowOutsideClick: false
    }).then((result) => {
      if (result.value) {
        Objetivos.delete_accion(idaccion, idobjetivo);
      }
    })
  },

  delete_accion: (idaccion, idobjetivo) =>{
  	$.ajax({
  		type: 'POST',
		url:base_url+"Objetivos/delete_accion",
		data:{
			'idobjetivo': idobjetivo,
			'idaccion': idaccion,
		},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		swal.close();
		if(data.estatus){
			swal({
	      title: 'Se elimino correctamente.',
	      text: "¿Requiere seguir actualizando acciones?",
	      type: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Si',
	      cancelButtonText: 'No',
				allowOutsideClick: false
	    }).then((result) => {
	      if (result.value) {
	        // $("#modal_generico_obj").modal('hide');
					Objetivos.agreg_acciones(idobjetivo);
	      }
				else {
					$("#modal_generico_obj").modal('hide');
					Principal_pemc.obtiene_vista_obetivos();
				}
	    });

			// swal(
			// '¡Correcto!',
			// "La accion se elimino correctamente",
			// "success"
			// );
			// Principal_pemc.obtiene_vista_obetivos();
		}else{
			swal(
			'¡Error!',
			"Fallo al insertar",
			"error"
			);
		}
		// $("#modal_generico_obj").modal('hide');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		// swal.close();
	});
  },

  valida_fecha: (inicio, fin) =>{
  	let finicio = new Date(inicio);
  	let ffin = new Date(fin);
    if( finicio <= ffin){
        return false;
    }else{
        return true;
    }
  },

  carga_archivos:(archivo, tipo, idobjetivo) =>{
  	var idvisor = "";
  	switch(tipo) {
	  case 1:
	    idvisor = "img_preview_ini"+idobjetivo;
	    break;
	  case 2:
	    idvisor = "img_preview_fin"+idobjetivo;
	    break;
	}


  	var formData = new FormData();
    var files = $(archivo)[0].files[0];
		if(files.type.match('image/jp.*') || files.type.match('application/pdf') || files.type.match('image/gif')) {
			if(files.size<=2*1024*1024) {
				if (archivo.files && archivo.files[0]) {
			        var reader = new FileReader();
			        reader.onload = function (e) {
			        image = document.getElementById(idvisor);
		    			image.src = reader.result;
		    			// idvisor.innerHTML = '';
		    			// idvisor.append(image);
			        }
			        reader.readAsDataURL(archivo.files[0]);
						}
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
						Principal_pemc.obtiene_vista_obetivos();
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
			else {
				swal(
 			 '¡Error!',
 			 "Solo se permiten archivos de máximo 2MB",
 			 "error"
 			 );
			}
	   }
		 else {
			 swal(
			 '¡Error!',
			 "Solo se permiten archivos de tipo jpeg, gif y pdf",
			 "error"
			 );
		 }

  },

  elimina_imagen: (idobjetivo, tipo) =>{
  	swal({
	      title: '¿Está seguro de eliminar esta imagen?',
	      text: "Una vez eliminada no se podrá recuperar",
	      type: 'warning',
	      showCancelButton: true,
	      confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      confirmButtonText: 'Eliminar',
	      cancelButtonText: 'Cancelar',
				allowOutsideClick: false
	    }).then((result) => {
	      if (result.value) {
	        Objetivos.delete_imagen(idobjetivo, tipo);
	      }
	    })
  },

  delete_imagen: (idobjetivo, tipo) => {
  	$.ajax({
  		type: 'POST',
		url:base_url+"Objetivos/delete_imagen",
		data:{
			'idobjetivo': idobjetivo, 'tipo_img': tipo
		},
		beforeSend: function(xhr) {
			Notification.loading("Eliminando, espere porfavor...");
		}
	})
	.done(function(data){
		if(data.estatus){
			Principal_pemc.obtiene_vista_obetivos();
		}else{
			swal(
			'¡Error!',
			"Fallo al eliminar",
			"error"
			);
		}
		// $("#modal_generico_obj").modal('hide');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		// swal.close();
	});
  },

  delete_objetivo: (idobjetivo) => {
  	$.ajax({
  		type: 'POST',
		url:base_url+"Objetivos/delete_objetivo",
		data:{
			'idobjetivo': idobjetivo,
		},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		if(data.estatus){
			Principal_pemc.obtiene_vista_obetivos();
		}else{
			swal(
			'¡Error!',
			"Fallo al eliminar",
			"error"
			);
		}
		// $("#modal_generico_obj").modal('hide');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		// swal.close();
	});
  },
  bigImg: (idobjetivo, tipo_evidencia) =>{
  	$.ajax({
  		type: 'POST',
		url:base_url+"Objetivos/get_evidencia",
		data:{
			'idobjetivo': idobjetivo, 'tipo_evidencia': tipo_evidencia
		},
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		$("#contenedor_obj_evidencia").empty();
		$("#contenedor_obj_evidencia").append(data.str_view);
		$("#modal_generico_archivos").modal('show');
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		swal.close();
	});
  },

  get_seleccionados: (elemento, idinput)=>{
  	var seleccionados = $(elemento).val();
  	var pos = seleccionados.indexOf("0");
  	if(pos != -1){
  		$("#"+idinput).show();
  	}else{
  		$("#"+idinput).hide();
  	}
  }
}
