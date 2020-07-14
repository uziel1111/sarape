
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

  agreg_acciones: () =>{
  	$.ajax({
		url:base_url+"Objetivos/get_view_acciones",
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
  }
}
