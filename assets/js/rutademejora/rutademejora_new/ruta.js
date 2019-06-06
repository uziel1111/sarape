$(document).ready(function() {
   obj_prioridad = new Prioridad();
});

$('#salir').click(function(){
	$('#myModal').modal('toggle');
	if ($('.modal-backdrop').is(':visible')) {
	  $('body').removeClass('modal-open');
	  $('.modal-backdrop').remove();
	};
})

$("#btn_mision").click(function(e){
	e.preventDefault()
	var ruta = base_url + 'Rutademejora/modal_mision'
	$.ajax({
		url:ruta,
		data: { },
		beforeSend: function(xhr) {
	      Notification.loading("");
    }
	})
	.done(function(data){
		$("#div_generico").empty();
    $("#div_generico").append(data.strView);

		$('h5').empty();
		$('h5').append(data.titulo);
    $("#myModal").modal("show");
	})
	.fail(function(e) {
    console.error("Error in ()"); console.table(e);
  })
	.always(function() {
    swal.close();
  });
})

//Prioridad (incompleto)
$("#btn_prioridad").click(function(e){
	e.preventDefault();
	console.log(obj.id_tprioritario);		
	if(obj.id_tprioritario == undefined || obj.id_tprioritario == ''){
		swal(
        '¡Error!',
        "Selecciona una línea de acción para editar",
        "error"
      );
    return false;
	} else{
		console.log(obj);
			var ruta = base_url + 'Rutademejora/get_datos_edith_tp'
			$.ajax({
				url:ruta,
				type:'post',
				data: { 
					"id_tprioritario": obj.id_tprioritario,
					"id_prioridad": obj.id_prioridad,
					"id_subprioridad": obj.id_subprioridad,
                	"accion": obj.accion,
                	"txttp": obj.txttp
				},
				beforeSend: function(xhr) {
			      Notification.loading("");
		    }
			})
			.done(function(data){
				$("#div_generico").empty();
		    $("#div_generico").append(data.strView);
				$('h5').empty();
				$('h5').append(data.titulo);
		    $("#myModal").modal("show");
        obj_prioridad.getObjetivos();
			})
			.fail(function(e) {
		    console.error("Error in get_datos_edith_tp()");
		  })
			.always(function() {
		    swal.close();
				// $("#myModal").modal("hide");
		  });
		}
});

//Actividades
$("#btn_actividades").click(function(e){
	e.preventDefault()
	var ruta = base_url + 'Rutademejora/modal_actividades'
	$.ajax({
		url:ruta,
		data: { },
		beforeSend: function(xhr) {
	      Notification.loading("");
    }
	})
	.done(function(data){
		$("#div_generico").empty();
    $("#div_generico").append(data.strView);
		$('h5').empty();
		$('h5').append(data.titulo);
    $("#myModal").modal("show");
	})
	.fail(function(e) {
    console.error("Error in ()"); console.table(e);
  })
	.always(function() {
    swal.close();
  });
});



///
Prioridad.prototype.getObjetivos = function(){
	// var idtemaprioritario = obj.id_tprioritario ;

	if(obj.id_tprioritario != 0){
		$.ajax({
			url: base_url+'Rutademejora/getObjetivos',
			type: 'POST',
			dataType: 'JSON',
			data: {id_tpriotario: obj.id_tprioritario,
						 id_prioridad: obj.id_prioridad,
						 id_subprioridad: obj.id_subprioridad,
					 },
			beforeSend: function(xhr) {
		        Notification.loading("");
	    },
		})
		.done(function(result) {
			$("#objetivo_meta").empty();
			$("#objetivo_meta").append(result.table);

			$('#tema_prioritario').val(result.id_tprioritario);
			$('#id_objetivo').val(result.id_objetivo);
			obj_prioridad.funcionalidadselect()
			// obj_prioridad.btnEditar();
			// btnEditar();
		})
		.fail(function(e) {
			console.error("Error in getObjetivos()");
		})
		.always(function() {
	    swal.close();
		});
	}
}

//grid objetivos
Prioridad.prototype.funcionalidadselect = function(){
	$("#id_tabla_objetivos tr").click(function(){
		 $(this).addClass('selected').siblings().removeClass('selected');
		 var value = $(this).find('td:first').text();
     var t_prioritario = $(this).find('td:first').next().text();

		 obj.id_objetivo = value;
		 obj.id_tprioritario = t_prioritario;
		 // obj.id_subprioridad = val3;

     console.log(obj.id_objetivo);
     // console.log(val2);
     // console.log(val3);

		 id_objetivo = 0;
	});
}
