
var Seguimiento_pemc = {
		guarda_avance: (elemento, avance, idaccion, val_ant, ageOutputId) => {
			swal({
				title: '¿Esta seguro de guardar el avance '+avance+'%?',
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
					"Se guardo correctamente.",
					"success"
					);
			 }
			 else {
				 swal(
				 '¡Error!',
				 "No se guardo correctamente, favor de intentarlo más tarde.",
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
};
