// Funcion para el preview de las evidencias
function readURL(id_objetivo,input) {
    if (input.files && input.files[0]) {
      // alert('Archivo guardado')
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview'+id_objetivo).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function readURL_Fin(id_objetivo,input) {
    if (input.files && input.files[0]) {
      // alert('Archivo guardado')
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview_fin'+id_objetivo).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
// FIn Funcion para el preview de las evidencias

//Funciones para eliminar evidencias
function eliminaEvidencia(id_objetivo, elemento){
  // alert(id_objetivo)
  swal({
    title: '¿Esta seguro de eliminar la evidencia?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  })
  .then((result)=>{
    if (result.value) {
      $.ajax({
        url: base_url+'Rutademejora/eliminaEvObjIn/'+id_objetivo,
        type: 'POST',
        dataType: 'JSON',
        data: { id_objetivo: id_objetivo },
        beforeSend: function(xhr) {
               Notification.loading("");
        },
      })
      .done(function(result) {
       //Recargamos el grid
       setTimeout(function(){
         swal(
           '¡Correcto!',
           "La evidencia se eliminó correctamente",
           'success'
         );
       }, 1000)
       $('#preview'+id_objetivo).attr('src', '#');
      })
      .fail(function(e) {
       console.error("Error in eliminaEvidencia()");
      })
      .always(function() {
       swal.close();
      });
    }
  })

  // $('#preview'+id_objetivo).attr('src', '#');
}

function eliminaEvidenciaFin(id_objetivo, elemento){
  // alert(id_objetivo)
  swal({
    title: '¿Esta seguro de eliminar la evidencia?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  })
  .then((result) =>{
    $.ajax({
      url: base_url+'Rutademejora/eliminaEvObjFin/'+id_objetivo,
     	type: 'POST',
   	  dataType: 'JSON',
   	  data: { id_objetivo: id_objetivo },
   	  beforeSend: function(xhr) {
     				 Notification.loading("");
      },
    })
    .done(function(result) {
   	 //Recargamos el grid
   	 setTimeout(function(){
   		 swal(
   			 '¡Correcto!',
   			 "La evidencia se eliminó correctamente",
   			 'success'
   		 );
       $('#preview_fin'+id_objetivo).attr('src', '#');
   	 }, 1000)

    })
    .fail(function(e) {
   	 console.error("Error in eliminaEvidenciaFin()");
    })
    .always(function() {
   	 swal.close();
    });

    // $('#preview_fin'+id_objetivo).attr('src', '#');
  })
}

//Funciones para eliminar evidencias

//Funciones para guardar evidencias inicio

function cargarEvidencia(id_objetivo, id_tprioritario, elemento){
 console.log("metódo de adjuntar imagen del modal objetivos");
 console.log(elemento);
 readURL(id_objetivo,elemento);
 let formData = new FormData($('#form_evidencia_'+id_objetivo)[0])

 $.ajax({
	 url: base_url+'Rutademejora/cargarEvidencia/'+id_objetivo+'/'+id_tprioritario,
	 type: 'POST',
	 dataType: 'JSON',
	 cache: false,
	 contentType: false,
	 processData: false,
	 data: formData,
	 beforeSend: function(xhr) {
				 Notification.loading("");
	 },
 })
 .done(function(result) {
	 //Recargamos el grid
	 setTimeout(function(){
		 swal(
			 '¡Correcto!',
			 "La evidencia se cargó correctamente",
			 'success'
		 );
	 }, 1000)
 })
 .fail(function(e) {
	 console.error("Error in cargarEvidencia()");
 })
 .always(function() {
	 swal.close();
 });

}

//FIN
function cargarEvidenciaFin(id_objetivo, id_tprioritario, elemento){
 // console.log(elemento);
 readURL_Fin(id_objetivo,elemento);
 let formData = new FormData($('#form_evidencia_fin_'+id_objetivo)[0])

 $.ajax({
	 url: base_url+'Rutademejora/cargarEvidenciaFin/'+id_objetivo+'/'+id_tprioritario,
	 type: 'POST',
	 dataType: 'JSON',
	 cache: false,
	 contentType: false,
	 processData: false,
	 data: formData,
	 beforeSend: function(xhr) {
				 Notification.loading("");
	 },
 })
 .done(function(result) {
	 //Recargamos el grid
	 setTimeout(function(){
		 swal(
			 '¡Correcto!',
			 "La evidencia se cargó correctamente",
			 'success'
		 );
	 }, 1000)
 })
 .fail(function(e) {
	 console.error("Error in cargarEvidenciaFin()");
 })
 .always(function() {
	 swal.close();
 });

}


//Modal preview



function imgPreview(id_objetivo){
  let src = $('#preview'+id_objetivo).attr('src')
  $('#titulo_ev').empty()
  $('#titulo_ev').text('Vista previa')
  $('#dv_ver_evidencia').empty()
  $('#dv_ver_evidencia').html('<img src="'+src+'" width="100%" height="250" style="border: none;"/>')
  $('#exampleModal_ver_evidencia').modal('toggle');
}

function imgPreviewFin(id_objetivo){
  let src = $('#preview_fin'+id_objetivo).attr('src')
  $('#dv_ver_evidencia').empty()
  $('#dv_ver_evidencia').html('<img src="'+src+'" width="100%" height="250" style="border: none;"/>')
  $('#exampleModal_ver_evidencia').modal('toggle');
}

function subirImagen() {
  console.log('subiendo imagen desde funcion');
}

$("#cerrar_modal_ver_evidencia").click(function(){
  $('#exampleModal_ver_evidencia').modal('toggle');
});

//
// function modal_cerrar(){
//   $('.modal_cerrar').modal('hide');
// }
//
//
// function imgPreviewFin(id_objetivo){
//   let src = $('#preview'+id_objetivo).attr('src')
//   $('#imagen_pre').attr('src', '');
//   $('#preview_img').modal('show');
//   $('#imagen_pre').attr('src', src);
//
// }
