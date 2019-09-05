	/*google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Subsecretaría', 'Simplificación'],
			['Subsecretaría de Educación Básica',     81],
			['Subsecretaría de Administración y Recursos Humanos',      9],
			['Subsecretaría de Planeación Educativa',  10]
			]);

		var options = {
			title: 'Simplificación por Subsecretaría',
			pieHole: 0.4,
		};

		var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
		chart.draw(data, options);
	}*/
	$(document).ready(function() {
		$('#seleccionaNivelIndex').modal('show');
	});
	

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
			$('#seleccionaNivelIndex').modal('hide');
			$('#total_documentos').text('Documentos Autorizados / ' + data.total);
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);
			$('#selectEducativo').removeAttr('Hidden');
			$('#selectinput').val(nivel);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();	
		});
	})


	$('#nivelEducativo').change(function() {
		nivel = $('#selectinput').val();
		mes = $('#mes option:selected').text();

		if (mes == 'Filtrar por mes') {
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
			$('#total_documentos').text('Documentos Autorizados / ' + data.total);
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();	
		});
	});

	$('#mes').change(function() {
		nivel = $('#selectinput').val();
		mes = $('#mes option:selected').text();

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
			$('#total_documentos').text('Documentos Autorizados / ' + data.total);
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();	
		});
	});

/*	$('#mes').change(function() {
		
		nivel = $('#nivelEducativo option:selected').text();

		$.ajax({
			url: base_url+'Cuda/consultaNivel',
			type: 'POST',
			data: {nivel:nivel,mes:mes},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			$('#total_documentos').text('Documentos Autorizados / ' + data.total);
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();	
		});

	});*/

	function consultaNivel() {
		$('#consultaSubsecretaria').attr('Hidden','TRUE');
		$('#selectEducativo').removeAttr('Hidden');
		$('#array').empty();
		$('#divDocumentos').attr('Hidden','TRUE');
	}

	function consultaSubsecretaria() {
		$('#consultaSubsecretaria').removeAttr('Hidden');
		$('#selectEducativo').attr('Hidden','TRUE');
		$('#array').empty();
		$('#divDocumentos').attr('Hidden','TRUE');
	}
	


	function show( aval ) {
		if ( aval == "1" ) {
			hiddenDiv1.style.display = 'block';
			hiddenDiv2.style.display = 'none';
			Form.fileURL.focus();
		} else if ( aval == "2" ) {
			hiddenDiv1.style.display = 'none';
			hiddenDiv2.style.display = 'block';
			Form.fileURL.focus();
		} else {
			hiddenDiv1.style.display = 'none';
			hiddenDiv2.style.display = 'none';
		}
	}

	function shwTxt() {
		var t1 = document.getElementById( "txt1" );
		var t2 = document.getElementById( "txt2" );
		if ( t1.style.display !== "block" ) {
			t2.style.display = "block";
			t1.style.display = "none";
		} else {
			t1.style.display = "none";
			t2.style.display = "block";
		}
	}

	function chkInput() {
		var checkBox = document.getElementById( "myCheck" );
		var text = document.getElementById( "text" );
		if ( checkBox.checked == true ) {
			text.style.display = "block";
		} else {
			text.style.display = "none";
		}
	}

	function chkInput2() {
		var checkBox2 = document.getElementById( "myCheck2" );
		var text2 = document.getElementById( "text2" );
		if ( checkBox2.checked == true ) {
			text2.style.display = "block";
		} else {
			text2.style.display = "none";
		}
	}

	function writeText() {
		var myCAPtext = document.getElementById( 'CAPoutput' );

		var select_1 = $( "#box1" ).val();
		var select_2 = $( "#box2" ).val();
		var select_3 = $( "#box3" ).val();
		var select_4 = $( "#box4" ).val();
		if ( select_1 == "0" ) {
			select_1 = "(DEFINIR VERBO)";

		}
		if ( select_2 == "0" ) {
			select_2 = "(DEFINIR INDICADOR)";
		}
		if ( select_3 == "0" ) {
			select_3 = "(DEFINIR META)";

		}
		if ( select_4 == "0" ) {
			select_4 = "(DEFINIR FECHA)";
		}
		var CAParray = [ select_1, select_2, select_3, select_4 ]
		var CAPtext = CAParray.join( " " );

		myCAPtext.value = CAPtext;
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
			$('#divDocumentos').removeAttr('Hidden');
			$('#array').html(data.str_view);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();	
		});

	}

	function getTablas(idusuario) {
		// console.log(idusuario);
		$.ajax({
			url: base_url+'Cuda/getEncuestas',
			type: 'POST',
			data: {idusuario: idusuario},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			$('#tabla_documentos'+idusuario).html(data.str_view);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();
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
			
			$('#documentoModal').html(data.str_view);
			
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
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
			$('#detallesModal').html(data.str_view);
			console.log("success");
			$('#verDetalle').modal('show');
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();	
		});
	}

	function contacto(idusuario) {
		console.log(idusuario);
		$.ajax({
			url: base_url+'Cuda/getContacto',
			type: 'POST',

			data: {idusuario: idusuario},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			$('#contacto'+idusuario).html(data.str_view);
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();
		});

	}

	function estadistica(idusuario, idsubsecretaria) {
		// console.log(idusuario + ', ' + idsubsecretaria);
		$.ajax({
			url: base_url+'Cuda/getEstadistica',
			type: 'POST',

			data: {idusuario: idusuario, idsubsecretaria:idsubsecretaria},
			beforeSend: function(xhr) {
				Notification.loading("");
			},
		})
		.done(function(data) {
			$('#estadisticas'+idusuario).html(data.str_view);
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();
		});
		
	}
	function getFormatoTema(tema, nivel) {

		mes = $('#mes option:selected').text();

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
			// console.log(data.str_view);
			$('#tabla_documentos_tema'+tema).html(data.str_view);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
			swal.close();
		});


	}

	
