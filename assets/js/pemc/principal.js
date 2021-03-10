
$(document).ready(function(){
var tipo_usuario=$("#t_usuario").val();
    if(tipo_usuario!="escuela"){
     var idpemc = $("#idpemc_click").val();
    }else{
     var idpemc = $("#idpemc").val();
    }
	Principal_pemc.obtiene_vista_diagnostico(idpemc);
});
/*$("#nv_diagnostico").click(function (e) {
	e.preventDefault();
 Principal_pemc.obtiene_vista_diagnostico(idpemc);
});

$("#nv_objetivos_metas_acciones").click(function (e) {
	e.preventDefault();
 Principal_pemc.obtiene_vista_obetivos(idpemc);
});

$("#nv_seguimiento").click(function (e) {
	e.preventDefault();
 Principal_pemc.obtiene_vista_seguimiento(idpemc);
});

$("#nv_evaluacion").click(function (e) {
	e.preventDefault();
 Principal_pemc.obtiene_vista_evaluacion(idpemc,$("#cct").val(),$("#turno").val());
});*/

var Principal_pemc = {
  	obtiene_vista_diagnostico: (idpemc) => {
    	ruta = base_url + "Pemc/obtiene_vista_diagnostico";
			$.ajax({
				url:ruta,
				type:'post',
				data: {idpemc:idpemc},
				beforeSend: function(xhr) {
					Notification.loading("");
				}
			})
			.done(function(data){
				$("#vista_diagnostico"+idpemc).empty();
				$("#vista_diagnostico"+idpemc).append(data.str_vista);
			})
			.fail(function(e) {
				console.error("Error in ()"); console.table(e);
			})
			.always(function() {
				swal.close();
			});
  	},//obtiene_vista_diagnostico

  	obtiene_vista_obetivos: (idpemc) => {
  		ruta = base_url + "Pemc/obtiene_vista_objetivosymetas";
		$.ajax({
			url:ruta,
			type:'post',
			data:{idpemc:idpemc},
			beforeSend: function(xhr) {
				Notification.loading("");
			}
		})
		.done(function(data){
			$("#vista_objetivos_metas_acciones"+idpemc).empty();
			$("#vista_objetivos_metas_acciones"+idpemc).append(data.str_vista);
		})
		.fail(function(e) {
			console.error("Error in ()"); console.table(e);
		})
		.always(function() {
			swal.close();
		});
	},
	obtiene_vista_seguimiento: (idpemc) => {
	ruta = base_url + "Pemc/obtiene_vista_seguimiento";
		$.ajax({
			url:ruta,
			type:'post',
			data: {idpemc:idpemc},
			beforeSend: function(xhr) {
				Notification.loading("");
			}
		})
		.done(function(data){
			$("#vista_seguimiento"+idpemc).empty();
			$("#vista_seguimiento"+idpemc).append(data.str_vista);
		})
		.fail(function(e) {
			console.error("Error in ()"); console.table(e);
		})
		.always(function() {
			swal.close();
		});
	},

	// get_objetivos_x_idpemc: () => {
	//     $.ajax({
	// 		url:base_url+"Objetivos/get_objetivos_x_idpemc_tabla",
	// 		data:{},
	// 		beforeSend: function(xhr) {
	// 			Notification.loading("Cargando vista");
	// 		}
	// 	})
	// 	.done(function(data){
	// 		$("#contenedor_tabla_objetivos").empty();
	// 		$("#contenedor_tabla_objetivos").append(data.contenido_tabla);
	// 	})
	// 	.fail(function(e) {
	// 		console.error("Error in ()"); console.table(e);
	// 	})
	// 	.always(function() {
	// 		swal.close();
	// 	});
	// },

	// obtiene_vista_seguimiento: (idpemc) => {
	// ruta = base_url + "Pemc/obtiene_vista_seguimiento";
	//     $.ajax({
			// url:ruta,
			// type:'post',
			// data: {idpemc:idpemc},
			// beforeSend: function(xhr) {
				// Notification.loading("");
			// }
		// })
		// .done(function(data){
			// $("#vista_seguimiento"+idpemc).empty();
			// $("#vista_seguimiento"+idpemc).append(data.str_vista);
		// })
		// .fail(function(e) {
			// console.error("Error in ()"); console.table(e);
		// })
		// .always(function() {
			// swal.close();
		// });
	// },
			obtiene_vista_evaluacion: (idpemc,cct,turno) => {			
	    	ruta = base_url + "Pemc/obtiene_vista_evaluacion";
				$.ajax({
					url:ruta,
					type:'post',
					data: {idpemc:idpemc,cct:cct,turno:turno},
					beforeSend: function(xhr) {
						Notification.loading("");
					}
				})
				.done(function(data){
					$("#vista_evaluacion"+idpemc).empty();
					$("#vista_evaluacion"+idpemc).append(data.str_vista);
					
				})
				.fail(function(e) {
					console.error("Error in ()"); console.table(e);
				})
				.always(function() {
					swal.close();
				});
			}
};
