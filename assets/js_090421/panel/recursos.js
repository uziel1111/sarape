$(function() {
    obj_recursos = new Recursos();
    $("#div_contenedor_operaciones").hide();
    $("#div_contenedor_operaciones_files").hide();
    obj_recursos.ocultamesaje_link();
    obj_recursos.ocultamesaje_file();
});

$("#md_close_operacion_recursos").click(function(e){
	e.preventDefault();
	$("#modal_operacion_recursos").modal('hide');
})

$("#tipodematerial").change(function(){
		obj_recursos.clean_campos();
	$("#idtipofileform").val($("#tipodematerial").val());
	$("#idreactivofileform").val($("#input_id_reactivo").val());
	$("#idreactivoform").val($("#input_id_reactivo").val());
	var id_reactivo = parseInt($("#input_id_reactivo").val());
	var tipo_contenido = $("#tipodematerial").val();
	switch(tipo_contenido){
		case "1":
		obj_recursos.genera_campo_file(tipo_contenido);
		$(':file').attr("accept", ".pdf");
		break;
		case "2":
		obj_recursos.genera_campo_file(tipo_contenido);
		$(':file').attr("accept", "image/*");
		break;
		case "3":
		obj_recursos.genera_campo_url(tipo_contenido, id_reactivo);
		break;
		case "4":
		obj_recursos.genera_campo_url(tipo_contenido, id_reactivo);
		break;
	}
});

$("#btn_crear_nuevo_recurso").click(function(e){
	e.preventDefault();
	if(parseInt($("#total_reactivos").val()) < 10){
		$("#tipodematerial").val('0')
		obj_recursos.genera_fila();
		$("#div_contenedor_operaciones").hide();
	    $("#div_contenedor_operaciones_files").hide();
	    $(".formulario")[0].reset();
	    $("#total_reactivos").val(parseInt($("#total_reactivos").val())+1);
	}else{
			swal(
		      'Alerta!',
		      "El numero de recursos por reactivo solo es 10",
		      'warning'
		    );
	}
});

$("#btn_guarda_link").click(function(e){
	e.preventDefault();
	obj_recursos.envia_url();
});


function Recursos(){
  _thismap = this;
}

Recursos.prototype.genera_fila = function(){
	$("#modal_operacion_recursos").modal("show");
}

Recursos.prototype.genera_campo_url = function(idtipo, idreactivo){
	$("#div_contenedor_operaciones").show();
	$("#div_contenedor_operaciones_files").hide();
}

Recursos.prototype.genera_campo_file = function(idtipo, idreactivo){
	$("#div_contenedor_operaciones").hide();
	$("#div_contenedor_operaciones_files").show();
}

Recursos.prototype.ocultamesaje_link = function(){
	$("#mensaje_alertattitulo").hide();
    $("#mensaje_alertaurl").hide();
    $("#mensaje_alertaur2").hide();
    $("#mensaje_alertafuente").hide();
}
Recursos.prototype.ocultamesaje_file = function(){
	$("#mensaje_alertatitulo_file").hide();
	$("#mensaje_alertafile").hide();
	$("#mensaje_alertafuente_file").hide();
}
Recursos.prototype.clean_campos = function(){
	$("#inputtitulo").val("");
    $("#inputcampourl").val("");
    $("#inputcampofuente").val("");
}
Recursos.prototype.envia_url =function(){
	obj_recursos.ocultamesaje_link();
  if (!obj_recursos.valida_url($("#inputcampourl").val())) {
    $("#mensaje_alertaur2").show();
  }
  else if($("#inputtitulo").val() ==""){
		$("#mensaje_alertattitulo").show();
	}else if($("#inputcampourl").val() ==""){
    	$("#mensaje_alertaurl").show();
	}else if($("#inputcampofuente").val() ==""){
    	$("#mensaje_alertafuente").show();
	}else{
		$.ajax({
			url: base_url+'panel/envia_url',
			type: 'POST',
			dataType: 'JSON',
			data: {id_reactivo: $("#idreactivoform").val(), url: $("#inputcampourl").val(), titulo: $("#inputtitulo").val(), tipo: $("#tipodematerial").val(), fuenteurlvideo: $("#inputcampofuente").val() },
			beforeSend: function(xhr) {
		        Notification.loading("");
		    },
		})
		.done(function(result) {
			swal.close();
			$("#modal_operacion_recursos").modal('hide');
			swal(
		      'Listo!',
		      result.response,
		      'success'
		    );
			obj_recursos.get_tabla();
		})
		.fail(function(e) {
			swal.close();
			console.error("Error in get_Niveles()"); console.table(e);
		})
		.always(function() {
	    swal.close();
		});
	}

}

Recursos.prototype.elimina_recurso = function(idrecurso){
	swal({
	  title: '¿Esta seguro de eliminar este contenido?',
	  text: "Una vez eliminado no se podra tener acceso al recurso",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Eliminar',
	  cancelButtonText: 'Cancelar'
	}).then((result) => {
	  if (result.value) {
	    $.ajax({
			url: base_url+'panel/delet_recurso',
			type: 'POST',
			dataType: 'JSON',
			data: {id_recurso: idrecurso},
			beforeSend: function(xhr) {
		        Notification.loading("");
		    },
		})
		.done(function(result) {
			swal.close();
			swal(
		      'Eliminado!',
		      'Se elimino correctamente!',
		      'success'
		    )
			obj_recursos.get_tabla();
		})
		.fail(function(e) {
			swal.close();
			console.error("Error in get_Niveles()"); console.table(e);
		})
		.always(function() {
	    swal.close();
		});
	  }
	})
}

Recursos.prototype.get_tabla = function(){
	$.ajax({
		url: base_url+'panel/get_tabla_recursosJS',
		type: 'POST',
		dataType: 'JSON',
		data: {id_reactivo: $("#input_id_reactivo").val()},
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {
		swal.close();
		$("#div_contenedor_de_tablarec").empty();
		$("#div_contenedor_de_tablarec").append(result.tabla);
	})
	.fail(function(e) {
		swal.close();
		console.error("Error in get_Niveles()"); console.table(e);
	})
	.always(function() {
    swal.close();
	});
}

Recursos.prototype.validaExisteArchivo = function(nombre){
	$.ajax({
		url: base_url+'panel/validaExisteArchivo',
		type: 'POST',
		dataType: 'JSON',
		data: {id_reactivo: $("#input_id_reactivo").val(), nombrefile: nombre, tipo: $("#tipodematerial").val()},
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {
		swal.close();
		if(result.respuesta == true){
			$("#validaexixtente").val("true");
			swal(
			  'Alerta',
			  'El archivo que intenta subir ya existe, si continua remplazara al archivo existente.',
			  'warning'
			);
		}else{
			$("#validaexixtente").val("false");
		}
	})
	.fail(function(e) {
		swal.close();
		console.error("Error in get_Niveles()"); 
		console.table(e);
	})
	.always(function() {
    	swal.close();
	});
}

Recursos.prototype.subir_recurso = function(){
    //información del formulario
    var formData = new FormData($(".formulario")[0]);
    var message = "";
    //hacemos la petición ajax
    $.ajax({
        url: base_url+'panel/set_file',
        type: 'POST',
        // Form data
        //datos del formulario
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){
            message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
            showMessage(message)
        },
    })      
    .done(function( data ) {
        swal.close();
        swal(
		    'Listo!',
		    'Su archivo se subio correctamente',
		    'success'
		);
        $("#modal_operacion_recursos").modal('hide');
        obj_recursos.get_tabla();
        $("#idseleccionadofile").val("false");//regresa false la varible que valida si ya se a seleccionado un archivo
        $("#validaexixtente").val("false");//regresa en false la valicacion del archivo exixtente
        
    })
    .fail(function(e) {
        swal.close();
        message = $("<span class='error'>Ha ocurrido un error.</span>");
        showMessage(message);
    })
    .always(function() {
        swal.close();
   	});
}

Recursos.prototype.valida_url = function(url){
  var expression = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/ ;
var regex = new RegExp(expression);
if (url.match(regex)) {

  var expression_adul = /porn|xxx|gay|redtube|porin|lesbian|culo|pinga|verga|pelos|teta|titi|chichi/;
  var regex_a = new RegExp(expression_adul);
  if (url.match(regex_a)) {
    return false;
  }
  else {
    return true;
  }
} else {
  return false;
}
}

$(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    var fileSize = 0;
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
    	$("#idseleccionadofile").val("true");
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
        obj_recursos.validaExisteArchivo(fileName);
    });

    //al enviar el formulario
    $('#btn_subir_pdf_imagen').click(function(e){
    	e.preventDefault();
    	if(fileSize < 5000000){
    		obj_recursos.ocultamesaje_file();
	    	if($("#titulofile").val() == ""){
	    		$("#mensaje_alertatitulo_file").show();
	    	}else if($("#idseleccionadofile").val()== "false"){
	    		$("#mensaje_alertafile").show();
	    	}else if($("#inputcampofuentefile").val() == ""){
	    		$("#mensaje_alertafuente_file").show();
	    	}else if($("#validaexixtente").val() == "true"){
	    		swal({
				  title: '¿Esta seguro de remplazar el archivo?',
				  text: "Puede que algunos recursos no se visualicen correctamente",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Si, reemplazar!',
				  cancelButtonText: 'Cancelar'
				}).then((result) => {
				  if (result.value) {
				  	obj_recursos.subir_recurso();
				  }
				})
	    	}else{
	    		obj_recursos.subir_recurso();
		    }
    	}else{
    		swal(
		      'Su archivo es demaciado grande!',
		      'Solo archivos menores de 5Mb',
		      'warning'
		    );
    	}
    });

//como la utilizamos demasiadas veces, creamos una función para
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}

//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase())
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg':
            return true;
        break;
        default:
            return false;
        break;
    }
}
