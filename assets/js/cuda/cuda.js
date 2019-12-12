	$('#nivelEducativoModal').change(function() {
		nivel = $('#nivelEducativoModal option:selected').text();
		mes = 'No';

		$.ajax({
			url: base_url+'Cuda/consultaNivel',
			type: 'POST',
			data: {nivel:nivel, mes:mes},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#seleccionaNivelIndex').modal('hide');
			$('#total_documentos').text('Documentos Autorizados para '+nivel+' / ' + data.total);
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);
			$('#selectEducativo').removeAttr('Hidden');
			$('#selectinput').val(nivel);
			$('#titulo_h5').text('Catálogo Único de Documentos Autorizados por Nivel Educativo');
			nivel = $('#nivelEducativo option[value="'+nivel+'"]').attr('selected', true);
			
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			swal.close();	
		});
	})

	$('#nivelEducativo').change(function() {
		nivel = $('#nivelEducativo option:selected').text();
		mes = $('#mes option:selected').text();

		if (mes == 'Filtrar por mes' || mes == 'Todos los meses') {
			mes = 'No';
		}

		$.ajax({
			url: base_url+'Cuda/consultaNivel',
			type: 'POST',
			data: {nivel:nivel,mes:mes},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#selectinput').val(nivel);
			$('#total_documentos').text('Documentos Autorizados para '+nivel+' / ' + data.total);
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);

		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			swal.close();	
		});
	});

	$('#mes').change(function() {
		nivel = $('#selectinput').val();
		mes = $('#mes option:selected').text();
		if (mes == 'Filtrar por mes' || mes == 'Todos los meses') {
			mes = 'No';
		}

		if (nivel == 'Selecione el Nivel Educativo') {
			nivel = 'No';
		}

		$.ajax({
			url: base_url+'Cuda/consultaNivel',
			type: 'POST',
			data: {nivel:nivel,mes:mes},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#total_documentos').text('Documentos Autorizados para '+nivel+' / ' + data.total);
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			swal.close();	
		});
	});

	function calendario(mes) {
		nivel = $('#nivelEducativo option:selected').text();

		if (mes == 'Filtrar por mes' || mes == 'Todos los meses') {
			mes = 'No';
		}

		$.ajax({
			url: base_url+'Cuda/consultaNivel',
			type: 'POST',
			data: {nivel:nivel,mes:mes},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#selectinput').val(nivel);
			$('#total_documentos').text('Documentos Autorizados para '+nivel+' / ' + data.total);
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);

		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			swal.close();	
		});
	}

	function consultaNivel() {
		$('#consultaSubsecretaria').attr('Hidden','TRUE');
		$('#selectEducativo').removeAttr('Hidden');
		$('#array').empty();
		$('#divDocumentos').attr('Hidden','TRUE');
		$('#titulo_h5').text('Catálogo Único de Documentos Autorizados por Nivel Educativo');
	}

	function consultaSubsecretaria() {
		$('#consultaSubsecretaria').removeAttr('Hidden');
		$('#selectEducativo').attr('Hidden','TRUE');
		$('#array').empty();
		$('#divDocumentos').attr('Hidden','TRUE');
		$('#titulo_h5').text('Catálogo Único de Documentos Autorizados por Subsecretaría');
		$('#total_documentos').text('Documentos Autorizados');
		$('#nivelEducativo').val('Seleccione el Nivel educativo');
		$('#mes').val('Filtrar por mes');
	}
	
	function getDocumentos(subsecretaria) {

		$.ajax({
			url: base_url+'Cuda/getObjetivo',
			type: 'POST',
			data: {idsubsecretaria: subsecretaria},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			swal.close();	
		});

	}

	function getTablas(idusuario) {
		$.ajax({
			url: base_url+'Cuda/getEncuestas',
			type: 'POST',
			data: {idusuario: idusuario},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#tabla_documentos'+idusuario).html(data.str_view);
			swal.close();
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			
		});

	}

	function documento(idaplicar) {
		$.ajax({
			url: base_url+'Cuda/getDocumentoDescarga',
			type: 'POST',
			data: {idaplicar: idaplicar},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();			
			$('#documentoModal').html(data.str_view);
			
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			swal.close();
		});

	}

	function detalle(idaplicar) {
		$.ajax({
			url: base_url+'Cuda/getDetalles',
			type: 'POST',
			data: {idaplicar: idaplicar},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#detallesModal').html(data.str_view);
			$('#verDetalle').modal('show');
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			swal.close();	
		});
	}

	function contacto(idusuario,tipo_busqueda) {
		
		$.ajax({
			url: base_url+'Cuda/getContacto',
			type: 'POST',

			data: {idusuario: idusuario, tipo_busqueda:tipo_busqueda},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			if (tipo_busqueda == 1) {

				$('#contacto'+idusuario).html(data.str_view);
			}else{
				$('#contactoModal').html(data.str_view);
			}
			
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			swal.close();
		});

	}

	function estadistica(idusuario, idsubsecretaria) {
		$.ajax({
			url: base_url+'Cuda/getEstadistica',
			type: 'POST',

			data: {idusuario: idusuario, idsubsecretaria:idsubsecretaria},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#estadisticas'+idusuario).html(data.str_view);
			
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			
			swal.close();
		});
		
	}
	function getFormatoTema(tema, nivel) {

		mes = $('#mes option:selected').text();

		if (mes == 'Todos los meses') {
			mes = 'No';
		}

		if (mes != 'Filtrar por mes') {
			ruta = base_url+'Cuda/getFormatoTemaMes';
			datos =  {tema:tema, nivel:nivel, mes:mes};
		}else{
			ruta = base_url+'Cuda/getFormatoTema';
			datos =  {tema:tema, nivel:nivel};
		}


		$.ajax({
			url: ruta,
			type: 'POST',

			data: datos,
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			swal.close();
			$('#tabla_documentos_tema'+tema).html(data.str_view);
		})
		.fail(function() {
			swal.close();
			console.log("error");
		})
		.always(function() {
			
			swal.close();
		});


	}