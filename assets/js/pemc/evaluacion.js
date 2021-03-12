$(function(){
	jQuery.validator.addMethod("noSpace", function(value, element) {
return value.indexOf("   ") < 0 && value != " ";
}, "No se permite exceder el uso de espacios");

$("#fr_evaluacion").validate({
	onclick:false, onfocusout: false, onkeypress:false, onkeydown:false, onkeyup:false,
      rules: {
         in_eval: {
           required: true,
		   noSpace: true
         },
      },
      messages: {
         in_eval: {
          required: "Redacte su evaluación por favor",
         },
      },
      submitHandler: function(form) {
         Evaluacion_pemc.evaluacio_pemc();
      }
});

$('.in_eval').trumbowyg({
   lang: 'es',
   btns: Utiles.get_botones_trumbowyg(),
   plugins: {
    colors: Utiles.get_colores_trumbowyg(),
   },
   removeformatPasted: true,
   autogrow: true
 });

$('.in_obser').trumbowyg({
   lang: 'es',
   btns: Utiles.get_botones_trumbowyg(),
   plugins: {
     colors: Utiles.get_colores_trumbowyg(),
   },
   removeformatPasted: true,
   autogrow: true
 });
});

$("#btn_guardar_evaluacion_pemc").click(function(e){
 e.preventDefault();
 // swal({
	//  title: '¿Esta seguro de grabar su evaluación?',
	//  text: "Una vez grabado no se puede eliminar",
	//  type: 'warning',
	//  showCancelButton: true,
	//  confirmButtonColor: '#3085d6',
	//  cancelButtonColor: '#d33',
	//  confirmButtonText: 'Grabar',
	//  cancelButtonText: 'Cancelar'
 // }).then(function(result){
	//  if (result.value) {
		 $("#fr_evaluacion").submit();
	 // }
	 // else {
	 //
	 // }
 // })

});
$("#btn_guardar_cierre_pemc").click(function(e){
 e.preventDefault();
 swal({
	 title: '¿Está seguro de hacer el corte de cierre de su PEMC?',
	 text: "Una vez hecho no se puede modificar",
	 type: 'warning',
	 showCancelButton: true,
	 confirmButtonColor: '#3085d6',
	 cancelButtonColor: '#d33',
	 confirmButtonText: 'Grabar',
	 cancelButtonText: 'Cancelar'
 }).then(function(result){
	 if (result.value) {
		 Evaluacion_pemc.guarda_cierre();
	 }
	 else {

	 }
 });

});

var Observacion_pemc = {
        observacion_supervalidate:(idpemc,turno) => {
       $("#fr_observacion_"+idpemc+turno).validate({
	       onclick:false, onfocusout: false, onkeypress:false, onkeydown:false, onkeyup:false,
             rules: {
                in_obser: {
                  required: true,
			      noSpace: true
                },
             },
             messages: {
                in_obser: {
                 required: "Redacte su observación o comentario por favor",
                },
             },
             submitHandler: function(form) {
                Observacion_pemc.observacion_supervisor(idpemc,turno);
             }
           });
        },
        observacion_supervisor: (idpemc,turno) => {
	    var form = document.getElementById("fr_observacion_"+idpemc+turno);
	    formulario = new FormData(form);
	   $.ajax({
	     url: base_url+"Pemc/guarda_observacion_supervisor",
	     method:"POST",
	     data: formulario,
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
			 }else {
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
	 },
};

var Evaluacion_pemc = {
		evaluacio_pemc: () => {
	    var form = document.getElementById("fr_evaluacion");
	    fd = new FormData(form);
		ruta = base_url+"Pemc/guarda_evaluacion";
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
	 },
	 guarda_cierre: () => {
		ruta = base_url+"Pemc/guarda_cierre";
		$.ajax({
			url: ruta,
			method:"POST",
			data: {x:''} ,
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
					Principal_pemc.obtiene_vista_evaluacion($("#idpemc").val());
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
	},
};
