$(function(){
	var arr_idobjetivo = $("#idsobj").val().split(',');

	jQuery.validator.addMethod("noSpace", function(value) {
	return value.indexOf("   ") < 0 && value != " ";
	}, "No se permite exceder el uso de espacios");
	

	arr_idobjetivo.forEach(function(idibjetivo) {
		in_obs_seg = "in_obs_seg"+idibjetivo;
	
		$("#btn_guardar_obs_seg_"+idibjetivo).click(function(e){
			e.preventDefault();
			$("#fr_obs_seg"+idibjetivo).submit();
		   });
		   var rules = new Object();
		   var messages = new Object();
		   rules[in_obs_seg] = { required: true , noSpace: true};
		   messages[in_obs_seg] = { required: 'Redacte sus observaciones para el seguimiento por favor' };

		$("#fr_obs_seg"+idibjetivo).validate({
			onclick:false, onfocusout: false, onkeypress:false, onkeydown:false, onkeyup:false,
			  rules: rules,
			  messages: messages,
			  submitHandler: function(form) {
				Seguimiento_pemc.grabar_obs_seg(idibjetivo);
			  }
			});

		$('.in_obs_seg'+idibjetivo).trumbowyg({
			defaultLinkTarget: '_blank',
			minimalLinks: true,
			lang: 'es',
			btns: Utiles.get_botones_trumbowyg(),
			plugins: {
				colors: Utiles.get_colores_trumbowyg(),
			},
			removeformatPasted: true,
			autogrow: true,
			tagsToRemove: ['script', 'link']
			});

	  });
});

var Seguimiento_pemc = {
		guarda_avance: (elemento, avance, idaccion, val_ant, ageOutputId) => {
			swal({
				title: '¿Está seguro de guardar el avance '+avance+'%?',
				text: "Una vez guardado no se puede eliminar",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Guardar',
				cancelButtonText: 'Cancelar'
			}).then(function(result){
				if (result.value) {
					Seguimiento_pemc.ir_a_guardar_avance(elemento, val_ant, idaccion, avance, ageOutputId);
				}
				else {
					$(ageOutputId).text(val_ant);
					$(elemento).val(val_ant);
				}
			})
	 },
	 ir_a_guardar_avance: (elemento, val_ant, idaccion, avance, ageOutputId) => {
		 ruta = base_url + "Pemc/ir_a_guardar_avance";
		 $.ajax({
			 url:ruta,
			 type:'post',
			 data: {idaccion:idaccion,avance:avance},
			 beforeSend: function(xhr) {
				 Notification.loading("");
			 }
		 })
		 .done(function(data){
			 swal.close();
			 if (data.estatus) {
				 swal(
					'¡Correcto!',
					"Se guardó correctamente.",
					"success"
					);
			 }
			 else {
				 swal(
				 '¡Error!',
				 "No se guardó correctamente, favor de intentarlo más tarde.",
				 "error"
				 );
				 $(ageOutputId).text(val_ant);
				 $(elemento).val(val_ant);
			 }
		 })
		 .fail(function(e) {
			 console.error("Error in ()"); console.table(e);
		 })
		 .always(function() {

		 });
	 },//ir_a_guardar_avance

	 ver_avance: (idaccion) => {
		 ruta = base_url + "Pemc/ver_avance";
		 $.ajax({
			 url:ruta,
			 type:'post',
			 data: {idaccion:idaccion},
			 beforeSend: function(xhr) {
				 Notification.loading("");
			 }
		 })
		 .done(function(data){
			 swal.close();
			 console.log(data.arr_avances);
				$("#contenedor_modal_avance").empty();
 				$("#contenedor_modal_avance").append(data.str_avances);
 				$("#modal_generico_avance").modal('show');
		 })
		 .fail(function(e) {
			 console.error("Error in ()"); console.table(e);
		 })
		 .always(function() {

		 });
	 },//ir_a_guardar_avance

	 btn_obs_seg: (idobjetivo) => {
		event.preventDefault();
		$("#fr_obs_seg"+idobjetivo).submit();
	 },//btn_obs_seg

	 grabar_obs_seg: (idobjetivo) => {
		//  alert(idobjetivo);
		 var form = document.getElementById("fr_obs_seg"+idobjetivo);
	    fd = new FormData(form);
		fd.append('idobjetivo', idobjetivo);

		ruta = base_url+"Pemc/guarda_obs_seg";
	   $.ajax({
	     url: ruta,
	     method:"POST",
	     data: fd,
	     contentType: false,
	     cache: false,
	     processData:false,
	     dataType: "json",
	     beforeSend: function(xhr) {
	         Notification.loading("");
	     }
	   })
	   .done(function( data ) {
			 swal.close();
			 if (data.estatus==1) {
				 swal(
					 '¡Correcto!',
					 "Se guardó correctamente.",
					 "success"
					 );
					 // Principal_pemc.obtiene_vista_evaluacion($("#idpemc").val());
			 }
			 else {
				 swal(
	 	      '¡Error!',
	 	      "No se guardó correctamente, favor de intentarlo más tarde.",
	 	      "error"
	 	      );
			 }
	   })
	   .fail(function(jqXHR, textStatus, errorThrown) {
			 console.error("Error in guardar()"); console.table(jqXHR);
	   })
	   .always(function() {});
	 },//grabar_obs_seg
};
