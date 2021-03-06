$(function(){

	jQuery.validator.addMethod("noSpace", function(value, element) {
	return value.indexOf("   ") < 0 && value != " ";
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
         Diagnostico_pemc.guarda_formulario_diagnostico();
      }
    });

	$('#in_diag').trumbowyg({
	   lang: 'es',
	   btns: Utiles.get_botones_trumbowyg(),
	   plugins: {
	     colors: Utiles.get_colores_trumbowyg(),
	   },
	   removeformatPasted: true,
	   autogrow: true
	 });

});

$("#btn_guardar_diagnostico_pemc").click(function(e){
 e.preventDefault();
 $("#fr_diagnostico").submit();
});

var Diagnostico_pemc = {
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
