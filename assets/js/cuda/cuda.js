	  

	google.charts.load("current", {packages:["corechart"]});
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
		// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
		data: {idsubsecretaria: subsecretaria},
	})
		.done(function(data) {
			$('#array').html(data.str_view);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	}

	function getTablas(idusuario) {
		console.log(idusuario);
		$.ajax({
			url: base_url+'Cuda/getEncuestas',
			type: 'POST',
		// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
		data: {idusuario: idusuario},
	})
		.done(function(data) {
			$('#tabla_documentos'+idusuario).html(data.str_view);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	}

	function documento(idaplicar) {
		$.ajax({
			url: base_url+'Cuda/getDocumentoDescarga',
			type: 'POST',
		//dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
		data: {idaplicar: idaplicar},
	})
		.done(function(data) {
			console.log(data.str_view);
			$('#documentoModal').html(data.str_view);
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});

	}

	function detalle(idaplicar) {
		$.ajax({
			url: base_url+'Cuda/getDetalles',
			type: 'POST',
		//dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
		data: {idaplicar: idaplicar},
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
		});
	}

	function contacto(idusuario) {
		console.log(idusuario);
		$.ajax({
			url: base_url+'Cuda/getContacto',
			type: 'POST',
				// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
				data: {idusuario: idusuario},
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
		});

	}

	function estadistica(idusuario, idsubsecretaria) {
		console.log(idusuario + ', ' + idsubsecretaria);
		$.ajax({
			url: base_url+'Cuda/getEstadistica',
			type: 'POST',
			// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
			data: {idusuario: idusuario, idsubsecretaria:idsubsecretaria},
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
		});
		
	}

	
