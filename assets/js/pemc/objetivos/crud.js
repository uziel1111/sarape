$(function(){
$("#form_crear_editar_obj").validate({
      onclick:false, onfocusout: false, onkeypress:false, onkeydown:false, onkeyup:false,
      rules: {
         text_objetivo_c: {
           required: true,
         },
         text_meta_c: {
           required: true,
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
         alert("amonos");
      }
    });
});

$("#btn_guarda_objetivo").click(function(e){
 e.preventDefault();
 // alert("funciona");
 $("#form_crear_editar_obj").submit();
});