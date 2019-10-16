
$(document).ready(function() {
	
	// google.charts.load('current', {'packages':['corechart'],'language':'es'});
   	obj_prioridad = new Prioridad();
   $("#div_resultados_gral").hide();


});

	$("#nav-tab").click(function (e) {
        var id = e.target.id;
        // console.log(id);
        if(id =="nav-resultados-tab"){
        	$("#nombreescuela_pemc").val("");
        	$("#div_resultados_gral").show();
        	accionesRezagadas(); 
        	// google.charts.load('current', {'packages':['gantt'],'language':'es'}); 
	   		datos_accion();
		   	// datos_laepie();
		   	// datos_objetivopie();
		   	// datos_accionpie();	
   		}else if(id!="nav-resultados-tab"){
   			// console.log(id);
   			$("#div_resultados_gral").hide();
   			$("#div_busxcct_pemc").empty();	  
   		}
	});

$('#salir').click(function(){
	$('#myModal').modal('toggle');
	if ($('.modal-backdrop').is(':visible')) {
	  $('body').removeClass('modal-open');
	  $('.modal-backdrop').remove();
	};
})

$("#btn_mision").click(function(e){
	e.preventDefault()
	var ruta = base_url + 'Rutademejora/modal_mision'
	$.ajax({
		url:ruta,
		data: { },
		beforeSend: function(xhr) {
	      Notification.loading("");
    }
	})
	.done(function(data){
		$("#div_generico").empty();
    $("#div_generico").append(data.strView);

		$('h5').empty();
		$('h5').append(data.titulo);
    $("#myModal").modal("show");
	})
	.fail(function(e) {
    console.error("Error in ()"); console.table(e);
  })
	.always(function() {
    swal.close();
  });
})

$("#img_mision").click(function(e){
	e.preventDefault()
	if($("#tipou_pemc").length){

	}else{
		var ruta = base_url + 'Rutademejora/modal_mision'
		$.ajax({
			url:ruta,
			data: { },
			beforeSend: function(xhr) {
		      Notification.loading("");
	    	}
		})
		.done(function(data){
			$("#div_generico").empty();
	    	$("#div_generico").append(data.strView);
			$('h5').empty();
			$('h5').append(data.titulo);
	    	$("#myModal").modal("show");
		})
		.fail(function(e) {
	    	console.error("Error in ()"); console.table(e);
	  	})
		.always(function() {
	    	swal.close();
	  	});
	}
});

//Prioridad (incompleto)
$("#btn_prioridad").click(function(e){
	e.preventDefault();
	//console.log(obj.id_tprioritario);		
	if(obj.id_tprioritario == undefined || obj.id_tprioritario == ''){
		swal(
        '¡Error!',
        "Selecciona una línea de acción para editar",
        "error"
      );
    return false;
	} else{
		//console.log(obj);
		var ruta = base_url + 'Rutademejora/get_datos_edith_tp'
		$.ajax({
			url:ruta,
			type:'post',
			data: { 
				"id_tprioritario": obj.id_tprioritario,
				"id_prioridad": obj.id_prioridad,
				"id_subprioridad": obj.id_subprioridad,
                "accion": obj.accion,
                "txttp": obj.txttp
			},
			beforeSend: function(xhr) {
			      Notification.loading("");
		    }
		}).done(function(data){
			//console.log( data.data['problematica'].split(','));
			$("#div_generico").empty();
		    $("#div_generico").append(data.strView);
		    // $('.problematica').selectpicker('val', data.data['problematica'].split(','));
		    // $('.problematicaTxt').text( data.data['problematica']);
		    // $('#problematica').val("");
		    // $('#evidencias').val("");
		    // $('#txt_rm_obs_direc').val("");
		    let tipou_pemc="";
			$('h5').empty();
			$('h5').append(data.titulo);
		    $("#myModal").modal("show");
		    if($('#tipou_pemc').length) {
				$("#grabar_prioridad").hide();
				$("#grabar_objetivo").hide();
				$("#btn_eliminar").hide();
				$('.problematica').selectpicker('hide');
				tipou_pemc=$('#tipou_pemc').val();
			}  
        	obj_prioridad.getObjetivos(obj.id_tprioritario);

		}).fail(function(e) {
		    console.error("Error in get_datos_edith_tp()");
		}).always(function() {
		    swal.close();
				// $("#myModal").modal("hide");
		});
	}
});

//Actividades
$("#btn_actividades").click(function(e){
	e.preventDefault()
	var ruta = base_url + 'Rutademejora/modal_actividades'
	$.ajax({
		url:ruta,
		data: { },
		beforeSend: function(xhr) {
	      Notification.loading("");
    }
	})
	.done(function(data){
		$("#div_generico").empty();
    $("#div_generico").append(data.strView);

		$('h5').empty();
		$('h5').append(data.titulo);
    $("#myModal").modal("show");
	})
	.fail(function(e) {
    console.error("Error in ()"); console.table(e);
  })
	.always(function() {
    swal.close();
  });
});



///
Prioridad.prototype.getObjetivos = function(id_tprioritario){
	// var idtemaprioritario = obj.id_tprioritario ;
	 let tipou_pemc="";
		if($('#tipou_pemc').length) {
			$("#grabar_prioridad").hide();
			$("#grabar_objetivo").hide();
			$("#btn_eliminar").hide();
			$('.problematica').selectpicker('hide');
			tipou_pemc=$('#tipou_pemc').val();
		}
	console.log(tipou_pemc);
	if(obj.id_tpriotario != 0){
	//console.log(obj.id_tprioritario);
		$.ajax({
			url: base_url+'Rutademejora/getObjetivos',
			type: 'POST',
			dataType: 'JSON',
			data: {	id_tpriotario: obj.id_tprioritario,
					id_prioridad: obj.id_prioridad,
					id_subprioridad: obj.id_subprioridad,
					tipou_pemc:tipou_pemc,
			},
			beforeSend: function(xhr) {
		        Notification.loading("");
	    	},
		})
		.done(function(result) {
			$("#objetivo_meta").empty();
			$("#objetivo_meta").append(result.table);

			$('#tema_prioritario').val(result.id_tprioritario);
			$('#id_objetivo').val(result.id_objetivo);
			if (result.id_objetivo == 0) {
				$('.problematicaTxt').empty();
				$('#evidencias').empty();
				$('#txt_rm_obs_direc').empty();
			}
			// console.log(result.id_objetivo);
			obj_prioridad.funcionalidadselect();
			// obj_prioridad.btnEditar();
			// btnEditar();
		})
		.fail(function(e) {
			console.error("Error in getObjetivos()");
		})
		.always(function() {
	    swal.close();
		});
	}
}

//grid objetivos
Prioridad.prototype.funcionalidadselect = function(){
	$("#id_tabla_objetivos tr").click(function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		var value = $(this).find('td:first').text();
     	var t_prioritario = $(this).find('td:first').next().text();
		obj.id_objetivo = value;
		obj.id_tprioritario = t_prioritario;
		id_objetivo = 0;
	});
}


	function datos_accion(){
		// console.log("llego a la funcion de datos accion");
		let id_cct_rm=$("#id_cct_rm").val();
		if(id_cct_rm!=""){
			$.ajax({
			    url: base_url+'Rutademejora/avancesxcctxaccion',
			    dataType : 'json',
			    method : 'POST',
			    data : {"id_cct":id_cct_rm},
			    beforeSend: function(xhr){
			      	Notification.loading("");
			    },
			    success: function(data){
			      	swal.close();
			      	if(data.datos.length>0){
			      		$("#chart_div").show();
			      		$('#gantt_p').empty();
			      		$('#gantt_p').append(data.dom);
			      		// pintaGrafica(data.datos,data.fechaMin,data.fechaMax);
			      		// google.charts.setOnLoadCallback(drawChart(data.datos));
			      		    $('#demo').gantt({
						      data: data.acciones,
						      startDate: new Date(data.fechaMin),
						      endDate: new Date(data.fechaMax),
						    });

						let tabla="";
						$("#tabla_avances").empty();
						tabla+="<center>";
						tabla+='<table class="table table-striped table-bordered w-auto">';
			            tabla+='<thead class="thead-dark">';
						tabla+='<tr>';
						tabla+='<th scope="col" ><center>Acción</center></th>';
						tabla+='<th scope="col" ><center>Porcentaje</center></th>';
						tabla+='<th scope="col" ><center>Fecha Inicio</center></th>';
						tabla+='<th scope="col" ><center>Fecha Término</center></th>';
						tabla+='</tr>';
						tabla+='</thead>';
						tabla+='<tbody>';
						let p=0;
						// console.log(data.acciones);
						if(data.datos.length>0){
						    for(let x=0; x <data.datos.length; x++){
						    	let p=0;
						        tabla+='<tr>';
						        tabla+='<td>';
						        tabla+=data.datos[x]['accion'];
						        tabla+='</td>';
						        tabla+='<td>';
						        if(data.datos[x]['porcentaje']!=0 && data.datos[x]['porcentaje']!=null){
						        	p=data.datos[x]['porcentaje'];
						        }

						        tabla+=p+"%";
						        tabla+='</td>';
						        tabla+='<td>';
						        tabla+=data.datos[x]['fechainicio'];
						        tabla+='</td>';
						        tabla+='<td>';
						        tabla+=data.datos[x]['fechafin'];
						        tabla+='</td>';
						        tabla+='</tr>';
						    }
						        	
						}else{
						    $("#mensaje_res").empty();
						    $("#mensaje_res").append('<br><h1 align="center">Esta escuela no cuenta con acciones</h1><br>');
						}
						
						tabla+='</tbody>';
			          	tabla+='</table>';
			          	tabla+='</center>';
			        	$("#tabla_avances").append(tabla);
					}else{
						$("#chart_div").hide();
					}
			        
			    },
			    error: function(error){
			      swal.close();
			      console.log(error);
			    }
			});
		}else{
			alert("Ocurrio un error al cargar los datos de avances de acciones");
		}

	}



    function drawChart(datos) {
      	var data = new google.visualization.DataTable();
      	let alto=200;
      	data.addColumn('string', 'ID Tarea');
      	data.addColumn('string', 'Tarea');
      	data.addColumn('string', 'Recurso');
      	data.addColumn('date', 'Fecha inicio');
      	data.addColumn('date', 'Fecha fin');
      	data.addColumn('number', 'Duracion');
      	data.addColumn('number', 'Porcentaje de avance');
      	data.addColumn('string', 'Dependencias');
      	data.addColumn({type: 'string', role: 'tooltip'});
      	// data.addColumn({type: 'string', role: 'tooltip'});

      	let acciones =[];
      	for(let i=0; i<datos.length; i++){
        	if(datos[i]['porcentaje']!=0 && datos[i]['porcentaje']!=null){
	      		data.addRow([datos[i]['ac'],datos[i]['accion'], datos[i]['ac'],
	         		new Date(datos[i]['a_ini'],datos[i]['m_ini']-1, datos[i]['d_ini']), new Date(datos[i]['a_fin'],datos[i]['m_fin']-1,datos[i]['d_fin']), null,parseInt(datos[i]['porcentaje']), null,'hola']);
        		acciones.push(datos[i]);
        	}else{
        		data.addRow([datos[i]['ac'],datos[i]['accion'], datos[i]['ac'],
	         		new Date(datos[i]['a_ini'],datos[i]['m_ini']-1, datos[i]['d_ini']), new Date(datos[i]['a_fin'],datos[i]['m_fin']-1,datos[i]['d_fin']), null,0, null,'hola']);
        			acciones.push(datos[i]);
        	}
      	}

	    
	    if(datos.length>=4 && datos.length<=6){
	    	alto=400;
	    }else if(datos.length>=7 && datos.length<=14){
	    	alto=800;
	    }else if(datos.length>=15 && datos.length<=21){
	    	alto=1200;
	    }else if(datos.length>=22 && datos.length<=28){
	    	alto=1600;
	    }else if(datos.length>=29 && datos.length<=35){
	    	alto=2000;
	    }
      	let options = {
      		width: 950,
	        height: alto,
	        tooltip: {isHtml: true},
	        legend: 'none',
	        gantt: {
	          	trackHeight: 40,
	          	labelMaxWidth:300,
	        }
      	};

      	var chart = new google.visualization.Gantt(document.getElementById('gantt_p'));

      	chart.draw(data, options);

  //      	document.addEventListener("click", function(){
  // 			addMarker('Kermes'); 
		// });
      	let tabla="";
			$("#tabla_avances").empty();
			tabla+="<center>";
			tabla+='<table class="table table-striped table-bordered w-auto">';
            tabla+='<thead class="thead-dark">';
			tabla+='<tr>';
			tabla+='<th scope="col" ><center>Acción</center></th>';
			tabla+='<th scope="col" ><center>Porcentaje</center></th>';
			tabla+='<th scope="col" ><center>Fecha Inicio</center></th>';
			tabla+='<th scope="col" ><center>Fecha Término</center></th>';
			tabla+='</tr>';
			tabla+='</thead>';
			tabla+='<tbody>';
			let p=0;
			        if(datos.length>0){
			        	for(let x=0; x <datos.length; x++){

			        		tabla+='<tr>';
			        		tabla+='<td>';
			        		tabla+=acciones[x]['accion'];
			        		tabla+='</td>';
			        		tabla+='<td>';
			        		if(datos[x]['porcentaje']!=0 && datos[x]['porcentaje']!=null){
			        			p=datos[x]['porcentaje'];
			        		}
			        		tabla+=p+"%";
			        		tabla+='</td>';
			        		tabla+='<td>';
			        		tabla+=datos[x]['accion_f_inicio'];
			        		tabla+='</td>';
			        		tabla+='<td>';
			        		tabla+=datos[x]['accion_f_termino'];
			        		tabla+='</td>';
			        		tabla+='</tr>';
			        	}
			        	
			        }else{
			        	
			        	$("#mensaje_res").empty();
			        	$("#mensaje_res").append('<br><h1 align="center">Esta escuela no cuenta con acciones</h1><br>');
			        }
			        tabla+='</tbody>';
          			tabla+='</table>';
          			tabla+='</center>';
          			$("#tabla_avances").append(tabla);
    }

   	function datos_accionpie(){
		let id_cct_rm=$("#id_cct_rm").val();
		if(id_cct_rm!=""){
			$.ajax({
			    url: base_url+'Rutademejora/pieAccion',
			    dataType : 'json',
			    method : 'POST',
			    data : {"id_cct":id_cct_rm},
			    beforeSend: function(xhr){
			      	Notification.loading("");
			    },
			    success: function(data){
			      	swal.close();
			        google.charts.setOnLoadCallback(pieAccion(data.datos));
			    },
			    error: function(error){
			      swal.close();
			      console.log(error);
			    }
			});
		}else{
			alert("Ocurrio un error al cargar los datos");
		}

	}

	function datos_objetivopie(){
		let id_cct_rm=$("#id_cct_rm").val();
		if(id_cct_rm!=""){
			$.ajax({
			    url: base_url+'Rutademejora/pieObjetivos',
			    dataType : 'json',
			    method : 'POST',
			    data : {"id_cct":id_cct_rm},
			    beforeSend: function(xhr){
			      	Notification.loading("");
			    },
			    success: function(data){
			      	swal.close();

			        google.charts.setOnLoadCallback(pieObjetivos(data.datos));
			    },
			    error: function(error){
			      swal.close();
			      console.log(error);
			    }
			});
		}else{
			alert("Ocurrio un error al cargar los datos");
		}

	}

	function datos_laepie(){
		let id_cct_rm=$("#id_cct_rm").val();
		if(id_cct_rm!=""){
			$.ajax({
			    url: base_url+'Rutademejora/pieLAE',
			    dataType : 'json',
			    method : 'POST',
			    data : {"id_cct":id_cct_rm},
			    beforeSend: function(xhr){
			      	Notification.loading("");
			    },
			    success: function(data){
			      	swal.close();
			        google.charts.setOnLoadCallback(pieLAE(data.datos));
			    },
			    error: function(error){
			      swal.close();
			      console.log(error);
			    }
			});
		}else{
			alert("Ocurrio un error al cargar los datos");
		}
	}

    function pieAccion(datos) {
    	let c=100-datos[0]['porcentaje'];
    	var data = new google.visualization.DataTable();
            data.addColumn('string', 'Browser');
            data.addColumn('number', 'Percentage');
            data.addRows([
                ['Capturadas',parseInt(datos[0]['porcentaje'])],
         		['No capturadas',parseInt(c)]
            ]);
        let options = {
          title: '',
          colors: ['#F47D4A', '#E1315B']
        };

        $("#div_acc_graf").empty();
        var chart = new google.visualization.PieChart(document.getElementById('div_acc_graf'));

        chart.draw(data, options);
    }

    function pieObjetivos(datos) {
    	let c=100-datos[0]['porc'];
        // var data = google.visualization.arrayToDataTable([
        // 	['Objetivos', 'Avance Objetivos'],
        //   	['Capturadas',datos[0]['porc']],
        //   	['No capturadas',c]
        // ]);
        var data = new google.visualization.DataTable();
            data.addColumn('string', 'Browser');
            data.addColumn('number', 'Percentage');
            data.addRows([
                ['Capturadas',parseInt(datos[0]['porc'])],
         		['No capturadas',parseInt(c)]
            ]);
        let options = {
          title: '',
          colors: ['#FA812A', '#FAAF08']
        };
        $("#div_obj_graf").empty();
        let chart = new google.visualization.PieChart(document.getElementById('div_obj_graf'));

        chart.draw(data, options);
    }

    function pieLAE(datos) {
    	let c=100-datos[0]['porc_p'];
      	var data = new google.visualization.DataTable();
            data.addColumn('string', 'Titulo');
            data.addColumn('number', 'Porcentaje');
            data.addRows([
                ['Capturadas',parseInt(datos[0]['porc_p'])],
         		['No capturadas',parseInt(c)]
            ]);

        let options = {
          title: '',
          colors: ['#2C7873', '#6FB98F']
           };
        $("#div_lae_graf").empty();
        let chart = new google.visualization.PieChart(document.getElementById('div_lae_graf'));

        chart.draw(data, options);
    }

    function accionesRezagadas(){
		let id_cct_rm=$("#id_cct_rm").val();
		if(id_cct_rm!=""){
			$.ajax({
			    url: base_url+'Rutademejora/accionesRezagadas',
			    dataType : 'json',
			    method : 'POST',
			    data : {"id_cct":id_cct_rm},
			    beforeSend: function(xhr){
			      	Notification.loading("");
			    },
			    success: function(data){
			      	swal.close();

			    	let acciones=[];
			    	let acciones1=[];
			    	if(data.datos.length>0){
			    		for(let i=0; i<data.datos.length; i++){
							if (data.datos[i]['dias_restantes_hoy'] >= 0) {
								if (data.datos[i]['dias_restantes'] >= data.datos[i]['dias_restantes_hoy']) {
								    if (data.datos[i]['porcentaje'] == 0) {
								      acciones1.push(data.datos[i]);
								    }
									if (data.datos[i]['porcentaje'] <= 66) {
								      	acciones.push(data.datos[i]);
								      	// console.log("entro en la linea 550");
								    }else{
								      	if (data.datos[i]['porcentaje'] >= 67 && data.datos[i]['porcentaje'] <= 89) {
								      		acciones1.push(data.datos[i]);
									    }else{
									      	if (data.datos[i]['porcentaje'] >= 90 && data.datos[i]['porcentaje'] <= 99) {
									       		acciones1.push(data.datos[i]);
									     	}else{
									      		if (data.datos[i]['porcentaje'] == 100) {
									       			acciones1.push(data.datos[i]);
									     		}
									   		}
									 	}
									}
								}else{
								  	if (data.datos[i]['dias_restantes']>= data.datos[i]['dias_restantes_hoy']) {
									    if (data.datos[i]['porcentaje'] == 0) {
									      	acciones1.push(data.datos[i]);
									    }
									    if (data.datos[i]['porcentaje'] <= 33) {
									     	acciones.push(data.datos[i]);
									     	// console.log("entro en la linea 571");
									   	}else{
										    if (data.datos[i]['porcentaje'] >= 33 && data.datos[i]['porcentaje'] <= 66) {
										      	acciones1.push(data.datos[i]);
										    }else{
										      	if (data.datos[i]['porcentaje'] >= 67 && data.datos[i]['porcentaje'] <= 99) {
										        	acciones1.push(data.datos[i]);
										      	}else{
										        	if (data.datos[i]['porcentaje'] == 100) {
										          		acciones1.push(data.datos[i]);
										        	}
										      	}
										    }
									  	}

									}else{
									  if (data.datos[i]['dias_restantes'] >= data.datos[i]['dias_restantes_hoy']) {
										    if (data.datos[i]['porcentaje'] == 0) {
										      	acciones1.push(data.datos[i]);
										    }
										    if (data.datos[i]['porcentaje'] >= 1 && data.datos[i]['porcentaje'] <= 33) {
										      	acciones1.push(data.datos[i]);
										    }else{
											    if (data.datos[i]['porcentaje'] >= 34 && data.datos[i]['porcentaje'] <= 66) {
											      	acciones1.push(data.datos[i]);
											    }else{
											      	if (data.datos[i]['porcentaje'] >= 67 && data.datos[i]['porcentaje'] <= 99) {
											        	acciones1.push(data.datos[i]);
											      	}else{
											        	if (data.datos[i]['porcentaje'] == 100) {
											          		acciones1.push(data.datos[i]);
											        	}
											      	}
											    }
										  	}
										}else{
									      	acciones1.push(data.datos[i]);
									    } 
									}
								}
							}else{
						    	acciones.push(data.datos[i]);
						    	// console.log("entro en la linea 613");
							}  	
			    		}
			    	}

			    	let tabla="";
			    	$("#div_acc_rez").empty();
			    	if(acciones.length>0){
				    	tabla+="<center>";
				    	tabla+='<table class="table table-striped table-bordered w-auto">';
	            		tabla+='<thead class="thead-dark">';
					    tabla+='<tr>';
						tabla+='<th scope="col" ><center>Acción</center></th>';
						tabla+='<th scope="col" ><center>Porcentaje</center></th>';
						tabla+='<th scope="col" ><center>Fecha Inicio</center></th>';
						tabla+='<th scope="col" ><center>Fecha Término</center></th>';
					    tabla+='</tr>';
				        tabla+='</thead>';
				        tabla+='<tbody>';
				        let porcentaje=0;
				        	for(let x=0; x <acciones.length; x++){
				        		tabla+='<tr>';
				        		tabla+='<td>';
				        		tabla+=acciones[x]['accion'];
				        		tabla+='</td>';
				        		tabla+='<td>';
				        		if(acciones[x]['porcentaje']!="" || acciones[x]['porcentaje']!=null || acciones[x]['porcentaje']!='null'){
				        			porcentaje=acciones[x]['porcentaje'];
				        		}else{
				        			porcentaje=0;
				        		}
				        		tabla+=porcentaje+"%";
				        		tabla+='</td>';
				        		tabla+='<td>';
				        		tabla+=acciones[x]['f_inicio'];
				        		tabla+='</td>';
				        		tabla+='<td>';
				        		tabla+=acciones[x]['f_termino'];
				        		tabla+='</td>';
				        		tabla+='</tr>';
				        	}
				        	
				        
				        tabla+='</tbody>';
	          			tabla+='</table>';
	          			tabla+='</center>';
	          			$("#div_acc_rez").append(tabla);
	          			$("#div_rezagadas").show();
          			}else{
          				// console.log("llego en la linea 633");
          				$("#div_rezagadas").hide();
          				$("#mensaje_res").empty();
          				$("#mensaje_res").append('<br><h1 align="center">Esta escuela no cuenta con datos para proyectar</h1><br>');         				
          			}
			    },
			    error: function(error){
			      swal.close();
			      console.log(error);
			    }
			});
		}else{
			alert("Ocurrio un error al cargar los datos");
		}
	}

            function addMarker(markerRow) {
                var baseline;
                var baselineBounds;
                var chartElements;
                var marker;
                var markerSpan;
                var rowLabel;
                var svg;
                var svgNS;
                var gantt;
                var ganttUnit;
                var ganttWidth;
                var timespan;
                var xCoord;
                var yCoord; 
              // initialize chart elements
              baseline = null; 
              gantt = null; 
              rowLabel = null; 
              svg = null; 
              svgNS = null; 
              var container = document.getElementById('gantt_p');
              chartElements = container.getElementsByTagName('svg'); 
              if (chartElements.length > 0) { 
                svg = chartElements[0]; 
                // console.log(svg);
                svgNS = svg.namespaceURI;
                // console.log(svgNS);
              } 
              chartElements = container.getElementsByTagName('rect');
              // console.log(chartElements); 
              if (chartElements.length > 0) { 
                gantt = chartElements[0]; 
                // console.log(gantt);
              } 
              // chartElements = container.getElementsByTagName('path');
              // console.log(chartElements); 
              // if (chartElements.length > 0) { 
              //   Array.prototype.forEach.call(chartElements, function(path) { 
              //     if ((baseline === null) && (path.getAttribute('fill') !== 'none')) {
              //       baseline = path; 
              //       console.log(baseline);
              //     } }); 
              // } 
              chartElements = container.getElementsByTagName('text');
              // console.log(chartElements); 
              // let elemento;
              if (chartElements.length > 0) { 
                Array.prototype.forEach.call(chartElements, function(label) {
                	console.log(label);
                	// console.log(label.textContent); 
                  	if (label.textContent === 'Duration') {
                  		// rowLabel.text('Duración');
                  		// label.textContent='<text x="445.90625" y="66.203125" style="cursor: default; user-select: none; -webkit-font-smoothing: antialiased; font-family: Roboto; font-size: 14px;" fill="#757575" dx="0px">Duración:</text>';
                  		 // this.texto_referencia[contador_referencia].textContent=(this.valor_referencia[contador_referencia]>=0?"+":"")+this.valor_referencia[contador_referencia];
           
                  		// chartElements.textContent('Duración');
       					// document.getElementsByTagName('text').html('holaaa');
       					$('.text').text('hola');


                	}
                	console.log(label.textContent); 
            	}); 
              } 
              // if ((svg === null) || (gantt === null) || (baseline === null) || (rowLabel === null) || 
              //     (markerDate.getTime() < dateRangeStart.min.getTime()) || (markerDate.getTime() > dateRangeEnd.max.getTime())) {
              //   return; 
              // } 
              // ganttWidth = parseFloat(gantt.getAttribute('width')); 
              // baselineBounds = baseline.getBBox(); 
              // timespan = dateRangeEnd.max.getTime() - dateRangeStart.min.getTime(); 
              // ganttUnit = (ganttWidth - baselineBounds.x) / timespan;
              // markerSpan = markerDate.getTime() - dateRangeStart.min.getTime(); 
              // 
             // marker = document.createElementNS(svgNS, 'polygon');
    			
              // marker.setAttribute('fill', 'transparent'); 
              // marker.setAttribute('stroke', '#ffeb3b'); 
              // marker.setAttribute('stroke-width', '3'); 
              // xCoord = (baselineBounds.x + (ganttUnit * markerSpan) - 4); 
              // yCoord = parseFloat(rowLabel.getAttribute('y'));
              // marker.setAttribute('points', 183.671875 + ',' + (65 - 10) + ' ' + (183.671875 - 5) + ',' + 65 + ' ' + (183.671875 + 5)
              //                     + ',' + 65);
              // marker.setAttribute('text','x="445.90625" y="66.203125" style="cursor: default; user-select: none; -webkit-font-smoothing: antialiased; font-family: Roboto; font-size: 14px;" fill="#757575" dx="0px">Duration:');
              // marker.setAttribute('<text x="445.90625" y="66.203125" style="cursor: default; user-select: none; -webkit-font-smoothing: antialiased; font-family: Roboto; font-size: 14px;" fill="#757575" dx="0px">Duration:</text>'); 
              // svg.insertBefore(marker, rowLabel);

            }
  
