
$(document).ready(function() {
	Principal_pemc.obtiene_vista_diagnostico($("#idpemc").val());
});

$("#nv_diagnostico").click(function (e) {
	e.preventDefault();
 Principal_pemc.obtiene_vista_diagnostico($("#idpemc").val());
});

$("#nv_objetivos_metas_acciones").click(function (e) {
	e.preventDefault();
 Principal_pemc.obtiene_vista_obetivos();
});

var Principal_pemc = {
  	obtiene_vista_diagnostico: (idpemc) => {
    	ruta = base_url + "Pemc/obtiene_vista_diagnostico";
			$.ajax({
				url:ruta,
				data: {idpemc:idpemc},
				beforeSend: function(xhr) {
					Notification.loading("");
				}
			})
			.done(function(data){
				$("#vista_diagnostico").empty();
				$("#vista_diagnostico").append(data.str_vista);
			})
			.fail(function(e) {
				console.error("Error in ()"); console.table(e);
			})
			.always(function() {
				swal.close();
			});
  	},//obtiene_vista_diagnostico

  	obtiene_vista_obetivos: () => {
  		ruta = base_url + "Pemc/obtiene_vista_objetivosymetas";
			$.ajax({
				url:ruta,
				data:{},
				beforeSend: function(xhr) {
					Notification.loading("");
				}
			})
			.done(function(data){
				$("#vista_diagnostico").empty();
				$("#vista_diagnostico").append(data.str_vista);
			})
			.fail(function(e) {
				console.error("Error in ()"); console.table(e);
			})
			.always(function() {
				swal.close();
			});
  	},//obtiene_vista_obetivos
};
