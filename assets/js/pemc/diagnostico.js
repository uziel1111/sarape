$(function(){
	jQuery.validator.addMethod("noSpace", function(value, element) {
return value.indexOf("  ") < 0 && value != " ";
}, "No se permite exceder el uso de espacios");

$("#fr_diagnostico").validate({
	onclick:false, onfocusout: false, onkeypress:false, onkeydown:false, onkeyup:false,
      rules: {
         in_diag: {
           required: true,
					 noSpace: true
         },
      },
      messages: {
         in_diag: {
          required: "Redacte su diagnóstico por favor",
         },
      },
      submitHandler: function(form) {
         Principal_pemc.guarda_formulario_diagnostico();
      }
    });
});

$("#btn_guardar_diagnostico_pemc").click(function(e){
 e.preventDefault();
 $("#fr_diagnostico").submit();
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
  	},//niveles

		guarda_formulario_diagnostico: () => {
	   var form = document.getElementById("fr_diagnostico");
	   fd = new FormData(form);
		 ruta = base_url+"Pemc/guarda_diagnostico";
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
	     },
	   })
	   .done(function( data ) {
			 swal.close();
			 if (data.estatus==1) {
				 swal(
					 '¡Correcto!',
					 "Se guardo correctamente.",
					 "success"
					 );
			 }
			 else {
				 swal(
	 	      '¡Error!',
	 	      "No se guardo correctamente, favor de intentarlo mas tarde.",
	 	      "error"
	 	      );
			 }
	   })
	   .fail(function(jqXHR, textStatus, errorThrown) {
			 console.error("Error in actualizar tema prioritario()"); console.table(jqXHR);
	   })
	   .always(function() {});
	 },
};
