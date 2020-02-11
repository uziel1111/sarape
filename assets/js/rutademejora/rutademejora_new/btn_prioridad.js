$(document).ready(function(){
	obj.id_objetivo = undefined;
	obj_prioridad = new Prioridad();
	$('#otra_fecha').attr('hidden', true)
	$('[data-toggle="tooltip"]').tooltip({
		trigger : 'hover'
	});


	$('.problematica').selectpicker("refresh");
});
//Eventos
$('#opt_prioridad_especial').change(function(){
	let tipou_pemc="";
	if($('#tipou_pemc').length) {
		tipou_pemc=$('#tipou_pemc').val();
	}  
	if ( $('#opt_prioridad_especial').val() != 0 ) {
		obj_prioridad.llenaIndicador();
		obj_prioridad.getObjetivos($("#opt_prioridad").val(),$("#opt_prioridad_especial").val(),tipou_pemc);
		$('#opt_prioridad_especial').attr('disabled', true)
	}
})

//SELECT PROBLEMATICA
$('.problematica').change(function() {
	valor = $('.problematica option:selected').text();
	if (valor.match(/Otros.*/)) {
		$('#problematicaTxt').attr('disabled',false);

	}else{
		$('#problematicaTxt').attr('disabled',true);
	}
});

$('#slt_fecha').change(function(){
	if ( $('#slt_fecha').val() == '-1' ) {
		$('#otra_fecha').attr('hidden', false)
	} else {
		$('#otra_fecha').attr('hidden', true)
	}
})


$('#slt_indicador').change(function(){
	if ($('#slt_indicador').val() != 0 ) {
		obj_prioridad.llenaMetrica()
	}
})

$('#limpiar').click(function(e){
	e.preventDefault();
	$('#slt_verbo').val('0');
	$('#slt_indicador').val('0');
	$('#slt_metrica').val('0');
	$('#slt_meta').val('');
	$('#slt_ciclo').val('0');
	$('#slt_fecha').val('0');
	$('#CAPoutput').val('');
	$('#otra_fecha').attr('hidden', true);
})

$('#userFile').change(function(){
	if(this.files[0].size > 5242880){
		swal(
			'¡Error!',
			"El archivo no debe de superar los 5MB",
			'error'
			);
	} else {
		var name = this.files[0].name;
		var ext = (this.files[0].name).split('.').pop();

		switch (ext) {
			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'pdf':
			case 'JPG':
			case 'JPEG':
			case 'PNG':
			case 'PDF':
			break;

			default:
			swal(
				'¡Error!',
				"El archivo no tiene la extensión adecuada",
				'error'
				);
				this.value = ''; // reset del valor
				this.files[0].name = '';
			}
			$('#file_name').empty();
			$('#file_name').html(name);
		}
	})

$('#salir').click(function(e){
	e.preventDefault();
	$('#myModal').modal('toggle');
	if ($('.modal-backdrop').is(':visible')) {
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
	};
	obj.get_view();
})

$('#close').click(function(e){
	e.preventDefault();
	$('.modal-backdrop').remove();
	obj.get_view();
})

$('#delete_file').click(function(e){
	e.preventDefault();
	$('#elimina_recurso').val('true')

})

function publicar(id) {
	
	estado = $('#aPublicar_'+id).data('estado');

	if (estado == 0) {	

		estado_publicacion = 1;

	}else{

		estado_publicacion = 0;

	}
	$.ajax({
		url:base_url+'Rutademejora/publicar',
		type: 'POST',
		data: {estado_publicacion:estado_publicacion, id_publicacion:id},
		beforeSend: function(xhr) {
			Notification.loading("");
		},})
	.done(function(data){
		swal.close();
		if (data.estado == 1) {	
			$('#aPublicar_'+id).data('estado', 1);
			$('#publicar_'+id).removeClass('fa-user-secret');
			$('#publicar_'+id).addClass('fa-globe-americas');
			
			
		}else{
			$('#aPublicar_'+id).data('estado', 0)
			$('#publicar_'+id).removeClass('fa-globe-americas');
			$('#publicar_'+id).addClass('fa-user-secret');
			
			
		}

		swal(
			'¡Nota!',
			"Actualmente esta función no está disponible",
			'warning'
			);	
		
	})
	.fail(function(e) {
		console.error("Error in publicar()");
		swal.close();
	})
	.always(function() {

	});

	
}

function Prioridad(){
	_thismap = this;
}

//Funciones
Prioridad.prototype.llenaIndicador = function(){
	$.ajax({
		url: base_url+'Rutademejora/llenaIndicador',
		type: 'POST',
		dataType: 'JSON',
		data: { nivel:$("#nivel").val(),
		id_prioridad: $("#opt_prioridad").val(),
		id_subprioridad: $("#opt_prioridad_especial").val()},
		beforeSend: function(xhr) {
			Notification.loading("");
		},
	})
	.done(function(result) {
		swal.close();
		$("#slt_indicador").empty();
		$("#slt_indicador").append(result.stroption);
	})
	.fail(function(e) {
		swal.close();
		console.error("Error in llenaIndicador()");
	})
	.always(function() {
		swal.close();
	});
}

Prioridad.prototype.llenaMetrica = function(){
	$.ajax({
		url: base_url+'Rutademejora/getMetrica',
		type: 'POST',
		dataType: 'JSON',
		data: {id_indicador: $("#slt_indicador").val()},
		beforeSend: function(xhr) {

			Notification.loading("");
		},
	})
	.done(function(result) {
		swal.close();
		$("#slt_metrica").empty();
		$("#slt_metrica").append(result.stroption);
	})
	.fail(function(e) {
		swal.close();
		console.error("Error in llenaMetrica()");
	})
	.always(function() {
		swal.close();
	});
}

//Aqui disparamos todas las funciones del modal
function show(select_id){
	
	let opt = $('#opt_prioridad').val();
	
	let tipou_pemc="";
	if($('#tipou_pemc').length) {
		tipou_pemc=$('#tipou_pemc').val();
	} 
	if (opt == 1) {
		obj_prioridad.llenaIndicador();
		$('#opt_prioridad').attr('disabled', true)

		setTimeout(function(){
			alert('Cargando objetivos')
		}, 1000)
	} else {
		$('#opt_prioridad').attr('disabled', true)
		$('#normalidad').attr('hidden', true);
		obj_prioridad.llenaIndicador();
		obj_prioridad.getObjetivos(opt,0,tipou_pemc);
	}

	hiddenDiv1.style.display='block';
}

$('.slt_objetivo_estatal').change(function() {
	$('.btn_objetivo_estatal').removeClass('ocultar');
	if ($('.slt_objetivo_estatal option:selected').val() == '0') {
		$('.btn_objetivo_estatal').addClass('ocultar');
	}
})

$('.btn_objetivo_estatal').click(function(e) {
	e.preventDefault();
	$('#CAPoutput').val($('.slt_objetivo_estatal option:selected').text());
});

$('#writeText').click(function(e){
	e.preventDefault();
	let verbo = $('#slt_verbo').val();
	let indicador = $('#slt_indicador').val();
	let metrica = $('#slt_metrica').val();
	let meta = $('#slt_meta').val();
	let fecha = $('#slt_fecha option:selected').val();
	let otra_fecha = $('#otra_fecha').val();

	if (verbo == '0' && indicador == '0' && metrica == '0' && meta == '' && fecha  == '0') {
		swal(
			'¡Error!',
			"Por favor seleccione al menos una opción",
			'error'
			);
	} else {
		metrica_txt = $('#slt_metrica option:selected').text();
		let contenido = $('#slt_verbo option:selected').text() + ' ' + $('#slt_indicador option:selected').text() + ' en un '  + meta + ' ' + metrica_txt.substring(0,1) + ' en el ciclo: '+ $('#slt_ciclo option:selected').text() + ' '  + $('#slt_fecha option:selected').text() + ' ' + otra_fecha

		$('#CAPoutput').val(contenido);
	}
})


//Grabar prioridad
$('#grabar_prioridad').click(function(e){
	e.preventDefault();
	id_tprioritario = $('#id_tema_prioritario').val();
	problematica = $('#problematicaTxt').val();
	var selected=[];
	$('.problematica :selected').each(function(){
		selected[$(this).data('id')]=$(this).data('id');
	});

	$.ajax({
		url: base_url+'Rutademejora/grabarTema',
		type: 'POST',
		dataType: 'JSON',
		data:{ id_tprioritario: id_tprioritario,
			problematica: problematica,
			evidencias: $('#evidencias').val().trim(),
			txt_rm_obs_direc: $('#txt_rm_obs_direc').val().trim(),
			ambito: selected
		},
		beforeSend: function(xhr) {
			Notification.loading("");
		}
	})
	.done(function(result) {

		valor = $('.problematica option:selected').text();
		$('.problematicaTxt').val(problematica.toString().replace(/\./g,', '));
		obj.get_view();
		for (var i = result.encabezado.length - 1; i >= 0; i--) {

			$(".problematica option[value="+result.encabezado[i]['problematica']+"]").prop("selected",true);
		}

	})
	.fail(function(e) {
		console.error("Error in grabarTema()");
	})
	.always(function() {
		swal.close();
	});
})
//Grabar prioridad


//Grabar objetivo
$('#grabar_objetivo').click(function(e){
	e.preventDefault();
	let idtemap = $('#id_tema_prioritario').val();

	let flag = $('#update_flag').val();
	let contenido = $('#CAPoutput').val();
	let tipou_pemc="";
	if($('#tipou_pemc').length) {
		tipou_pemc=$('#tipou_pemc').val();
	} 

	if (contenido == '') {
		swal(
			'¡Error!',
			"Por favor ingrese un objetivo",
			'error'
			);
	}else if (contenido.length > 400) {
		swal(
			'¡Error!',
			"No puede ingresar mas de 400 caracteres",
			'error'
			);
		return false
	}
	else {

		if (flag == 0) {
			if ($('#CAPoutput').val().trim() == '') {
				swal(
					'¡Error!',
					'El objetivo no puede capturarse en blanco',
					"error"
					);
			}
			else{
				$.ajax({
					url: base_url+'Rutademejora/agregarObjetivo',
					type: 'POST',
					dataType: 'JSON',
					data: {
						id_tprioritario : idtemap,
						id_subprioridad : obj.id_subprioridad,
						id_prioridad: obj.id_prioridad,
						objetivo: $('#CAPoutput').val().trim(),
					},
					beforeSend: function(xhr) {
						Notification.loading("");
					},
					success: function(data){


						obj_prioridad.getObjetivos($("#opt_prioridad").val(),$("#opt_prioridad_especial").val(),tipou_pemc);
					}
				})
				.done(function(result) {
					setTimeout(function () {
						swal(
							'¡Correcto!',
							"El objetivo se insertó correctamente",
							'success'
							);
						
						obj_prioridad.getObjetivos($("#opt_prioridad").val(),$("#opt_prioridad_especial").val(),tipou_pemc);
					}, 1000);


					$("#opt_prioridad").attr('disabled', true);
					$("#opt_prioridad_especial").attr('disabled', true);
					$('#otra_fecha').attr('hidden', true);
					$('#slt_meta').val('');
				})
				.fail(function(e) {
					swal.close();
					console.error("Error in grabar_objetivo()");
				})
				.always(function() {
					swal.close();
				});
			}
		} else {
			$.ajax({
				url: base_url+'Rutademejora/actualizarObjetivo',
				type: 'POST',
				dataType: 'JSON',
				data: { id_objetivo: flag,
					objetivo: $('#CAPoutput').val().trim()
				},
				beforeSend: function(xhr) {
					Notification.loading("");
				},
				success: function(data){
					setTimeout(function () {
						swal(
							'¡Correcto!',
							"El objetivo se actualizó correctamente",
							'success'
							);
					}, 1000);
					obj_prioridad.getObjetivos($("#opt_prioridad").val(),$("#opt_prioridad_especial").val(),tipou_pemc);
				}
			})
			.done(function(result) {
				obj_prioridad.getObjetivos($("#opt_prioridad").val(),$("#opt_prioridad_especial").val(),tipou_pemc);
				$('#update_flag').val('')

				$("#opt_prioridad").attr('disabled', true);
				$("#opt_prioridad_especial").attr('disabled', true);
			})
			.fail(function(e) {
				console.error("Error in agregar_objetivo()");
			})
			.always(function() {
				swal.close();
			});

		}
		$("#CAPoutput").val("");
		$('#btn_guardar').removeClass('fa-edit');
		$('#btn_guardar').addClass('fa-save');
		$('#btn_eliminar').removeClass('d-none');
	}
})
//Grabar objetivo


// Grid
function btnEditar(){
	if (obj.id_objetivo == undefined) {
		swal(
			'¡Error!',
			"Selecciona una tema prioritario a editar ",
			"error"
			);
		return false
	}else {
		$('#btn_eliminar').addClass("d-none");
		$('#btn_guardar').removeClass("fa-save");
		$('#btn_guardar').addClass("fa-edit")
		$.ajax({
			url: base_url+'Rutademejora/btnEditar',
			type: 'POST',
			dataType: 'JSON',
			data: { id_objetivo: obj.id_objetivo },
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(result) {
			$("#CAPoutput").empty();
			$("#CAPoutput").val(result.datos['objetivo']);
			$('#update_flag').val(result.idobj);
		})
		.fail(function(e) {
			console.error("Error in btnEditar()");
		})
		.always(function() {
			swal.close();
		});
	}
	obj.id_objetivo = undefined;

}

function btnEliminar(){
	
	objetivo = obj.id_objetivo;
	if (obj.id_objetivo == undefined) {
		swal(
			'¡Error!',
			"Selecciona un objetivo para eliminar ",
			"error"
			);

	}else {
		$('#CAPoutput').val('');
		swal({
			title: '¿Esta seguro de eliminar el objetivo?',
			text: "Se borrarán las actividades vinculadas al mismo, una vez eliminado no se podra recuperar",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Eliminar',
			cancelButtonText: 'Cancelar'
		})
		.then((result) => {
			if (result.value) {

				$.ajax({
					url: base_url+'Rutademejora/btnEliminar',
					type: 'POST',
					dataType: 'JSON',
					data: { id_objetivo: objetivo },
					beforeSend: function(xhr) {
						Notification.loading("");
					},
					success: function(data){
						obj_prioridad.getObjetivos();
					}
				}) //Ajax
				.done(function(result) {
					setTimeout(function(){
						swal(
							'¡Correcto!',
							"El objetivo se eliminó correctamente",
							'success'
							);
					}, 1000)
				})
				.fail(function(e) {
					console.error("Error in btnEliminar()");
				})
				.always(function() {
					swal.close();
				});
			}else{
				obj_prioridad.getObjetivos();
			}
		})
	}
	obj.id_objetivo = undefined;
}

Prioridad.prototype.getObjetivos = function(){
	var idtemaprioritario = obj.id_tprioritario ;
	let idtemap = $('#id_tema_prioritario').val();
	idtprio = $('#id_tema_prioritario').val();

	let tipou_pemc="";
	if($('#tipou_pemc').length) {
		tipou_pemc=$('#tipou_pemc').val();
	} 
	if(obj.id_tprioritario != 0){
		$.ajax({
			url: base_url+'Rutademejora/getObjetivos',
			type: 'POST',
			dataType: 'JSON',
			data: {id_tpriotario: idtemap,
				id_prioridad: obj.id_prioridad,tipou_pemc:tipou_pemc
			},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(result) {
			for (var i = result.encabezado.length - 1; i >= 0; i--) {

				$(".problematica option[value="+result.encabezado[i]['problematica']+"]").prop("selected",true);
			}

			$("#objetivo_meta").empty();
			$("#objetivo_meta").append(result.table);
			$('#id_objetivo').val(result.id_objetivo);
			obj_prioridad.funcionalidadselect()
			
			if (result.id_objetivo == 0) {
				$('.problematicaTxt').empty();
				$('#evidencias').empty();
				$('#txt_rm_obs_direc').empty();
			}
		})
		.fail(function(e) {
			console.error("Error in getObjetivos()");
		})
		.always(function() {
			swal.close();
		});
	}
}


Prioridad.prototype.funcionalidadselect = function(){
	$("#id_tabla_objetivos tr").click(function(){
		var value = $(this).find('td:first').text();
		var t_prioritario = $(this).find('td:first').next().text();
		if (value != '') {
			$(this).addClass('selected').siblings().removeClass('selected');
			obj.id_objetivo = value;
			obj.id_tprioritario = t_prioritario;
			id_objetivo = 0;
		}
	});
}
