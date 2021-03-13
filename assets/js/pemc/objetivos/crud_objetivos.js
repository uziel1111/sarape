   var idpemc = $("#idpemc").val();
   var turno = $("#turno").val();
$(function(){
	jQuery.validator.addMethod("noSpace", function(value, element) {
		return value.indexOf("  ") < 0 && value != " ";
	}, "No se permite exceder el uso de espacios");

$("#form_crear_editar_obj").validate({
      onclick:false, onfocusout: false, onkeypress:false, onkeydown:false, onkeyup:false,
      rules: {
         text_objetivo_c: {
           required: true,
           noSpace: true
         },
         text_meta_c: {
           required: true,
           noSpace: true
         },
         text_comentariosG_c:{
         	noSpace: true
         }
      },
      messages: {
         text_objetivo_c: {
          required: "El objetivo es requerido",
         },
         text_meta_c: {
           required: "La meta es requerida",
         }
      },
      submitHandler: function(form) {
         Crud_objetivos.save_conf_objetivo(idpemc,turno);
      }
    });
});

$("#btn_guarda_objetivo").click(function(e){
 e.preventDefault();
 // alert("funciona");
 $("#form_crear_editar_obj").submit();
});

var Crud_objetivos = {
	save_conf_objetivo: (idpemc,turno) => {
	var form = $("#form_crear_editar_obj").serialize();
    // var fd = new FormData(form);
    $.ajax({
    	type: 'POST',
		url:base_url+"Objetivos/save_conf_objetivo",
		data:form,
		beforeSend: function(xhr) {
			Notification.loading("Cargando vista");
		}
	})
	.done(function(data){
		if (data.estatus == 'true' || data.estatus == true) {
			Principal_pemc.obtiene_vista_obetivos(idpemc,turno);
			$("#modal_generico_obj").modal('hide');
		}
	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		swal.close();
	});
  }
}