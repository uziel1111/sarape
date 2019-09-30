
google.charts.load('current', {'packages':['gantt']});
google.charts.load('current', {'packages':['corechart']});

$(document).ready(function() {
   obj_prioridad = new Prioridad();
   // datos =[];

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
        	obj_prioridad.getObjetivos(obj.id_tprioritario,tipou_pemc);

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
Prioridad.prototype.getObjetivos = function(tipou_pemc){
	// var idtemaprioritario = obj.id_tprioritario ;
	
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
			console.log(result.id_objetivo);
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
			        // drawChart(data.datos);
			        // datos=data.datos;
			        google.charts.setOnLoadCallback(drawChart(data.datos));
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
    	// console.log(datos);
      	var data = new google.visualization.DataTable();
      	// data.addColumn('string', 'Task ID');
      	data.addColumn('string', 'Task Name');
      	data.addColumn('string', 'Resource');
      	data.addColumn('date', 'Start Date');
      	data.addColumn('date', 'End Date');
      	data.addColumn('number', 'Duration');
      	data.addColumn('number', 'Percent Complete');
      	data.addColumn('string', 'Dependencies');
      	// data.addRow();
      	for(let i=0; i<datos.length; i++){
      		// data.addRow([datos[i]['accion'], datos[i]['accion'],
        //  		new Date(2014, 2, 22), new Date(2014, 5, 20), null,60, null]);
        	// console.log(datos[i]['cte1']);
        	if(datos[i]['cte1']!=0 && datos[i]['cte1']!=null){
        		
	      		data.addRow([datos[i]['accion'], datos[i]['accion'],
	         		new Date(datos[i]['a_ini'],datos[i]['m_ini'], datos[i]['d_ini']), new Date(datos[i]['a_fin'],datos[i]['m_fin'],datos[i]['d_fin']), null,parseInt(datos[i]['cte1']), null]);
        	}else{
        		data.addRow([datos[i]['accion'], datos[i]['accion'],
	         		new Date(datos[i]['a_ini'],datos[i]['m_ini'], datos[i]['d_ini']), new Date(datos[i]['a_fin'],datos[i]['m_fin'],datos[i]['d_fin']), null,0, null]);
        	}
      		// data.addRow(['Hermione', new Date(1999,0,1)]);
      	}
      	var colors = [];
	    var colorMap = {
	        write: '#e63b6f',
	        complete: '#19c362'
	    }
	    
	    for (var i = 0; i < data.getNumberOfRows(); i++) {
	        colors.push(colorMap[data.getValue(i, 2)]);
	    }

      	var options = {
      		width: 1000,
	        height: 400,
	        // title: 'Avances de acciones por escuela',
	        // hAxis: { textStyle: { color: 'red' }, 
	        // titleTextStyle: { color: 'red' } }, 
	        // vAxis: { textStyle: { color: 'red' }, 
	        // titleTextStyle: { color: 'red' } }, 
	        // legend: { textStyle: { color: 'red' }},
      		// colors: ['red','green'],
	        gantt: {
	          	trackHeight: 40,
	          	percentEnabled: true,
	          	labelMaxWidth:400,
	          	// criticalPathEnabled: true,
            // 	criticalPathStyle: {
            //   	stroke: '#e64a19',
            //   	strokeWidth: 5 },
	   //        	labelStyle: {
	   //        		fontFamily:'Arial',
				//   	fontSize: 12,
				//   	textAling:'right'
				  
				// }
				labelStyle: {
				  fontName: 'Roboto',
				  fontSize: 12,
				  color: 'red',
				  textAlign:'right'
				},
				customChartStyle:{
	        	textAlign:'right !important'
	        	}

	        },
	        backgroundColor: 'black',

	        // cssClassNames: {'tableCell':
	        // }
	        // colors: colors
	        // customClass:{
	        // 	textAlign:'left'
	        // } 
      	};

		// var options = {
		// 	width: 1000,
		//     height: 600,
		//     gantt: {
		//     	labelMaxWidth:400,
		//       	criticalPathEnabled: false, // Critical path arrows will be the same as other arrows.
		//       	arrow: {
		// 	        angle: 50,
		// 	        width: 1,
		// 	        color: 'white',
		// 	        radius: 2
		//       	},
		//       	labelStyle: {
		// 	        fontName: 'Arial',
		// 	        fontSize: 10,
		// 	        color: 'black',
		// 	        textAlign:'right'
		//       	},
		//       	barCornerRadius: 2,
		//       	backgroundColor: {
		// 	    	fill: 'transparent',
		// 	    },
		//       	innerGridHorizLine: {
		//         	stroke: '#ddd',
		//         	strokeWidth: 0,
		//       	},
		//       	innerGridTrack: {
		//         	fill: 'transparent'
		//       	},
		//       	innerGridDarkTrack: {
		//         	fill: 'transparent'
		//       	},
		//       	percentEnabled:	true, 
		//       	shadowEnabled: true,	
		//       	shadowColor: 'white',
		//       	shadowOffset: 2
		      	
		//     }
		// };

      	var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
      	chart.draw(data, options);
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
			        // drawChart(data.datos);
			        // datos=data.datos;
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
			      	console.log(data.datos);
			        // drawChart(data.datos);
			        // datos=data.datos;
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
			        // drawChart(data.datos);
			        // datos=data.datos;
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
        var options = {
          title: '',
          colors: ['#F47D4A', '#E1315B']
        };

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
        var options = {
          title: '',
          colors: ['#FA812A', '#FAAF08']
        };

        var chart = new google.visualization.PieChart(document.getElementById('div_obj_graf'));

        chart.draw(data, options);
    }

    function pieLAE(datos) {
    	let c=100-datos[0]['porc_p'];
       //  var data = google.visualization.arrayToDataTable([
       //  	['LAE', 'Avance LAE'],
       //  	['LAE Capturadas',p],
       //  	['LAE No capturadas',c]
        	
      	// ]);
      	var data = new google.visualization.DataTable();
            data.addColumn('string', 'Browser');
            data.addColumn('number', 'Percentage');
            data.addRows([
                ['Capturadas',parseInt(datos[0]['porc_p'])],
         		['No capturadas',parseInt(c)]
            ]);

        var options = {
          title: '',
          colors: ['#2C7873', '#6FB98F']
           };

        var chart = new google.visualization.PieChart(document.getElementById('div_lae_graf'));

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
			    	// console.log(data.datos);
			    	let acciones=[];
			    	if(data.datos.length>0){
			    		for(let i=0; i<data.datos.length; i++){
							if (data.datos[i]['dias_restantes_hoy'] >= 0) {
							    if (data.datos[i]['dias_restantes'] >= data.datos[i]['dias_restantes_hoy']) {
								    if (data.datos[i]['porcentaje'] <= 66) {
								    	acciones.push(data.datos[i]);
								    }
								}else{
								  	if ((data.datos[i]['dias_restantes'] * 2 )>= data.datos[i]['dias_restantes_hoy']) {  
									    if (data.datos[i]['porcentaje'] <= 33) {
									     	acciones.push(data.datos[i]);
									   	}
									}
								}
							}else{
							    acciones.push(data.datos[i]);
							}	
			    		}
			    	}

			    	// console.log(acciones);
			    	let tabla="";
			    	tabla+="<center>";
			    	tabla+='<table class="table table-striped table-bordered w-auto">';
            		tabla+='<thead class="thead-dark">';
				    tabla+='<tr>';
					tabla+='<th scope="col" ><center>Acción</center></th>';
					tabla+='<th scope="col" ><center>Fecha Inicio</center></th>';
					tabla+='<th scope="col" ><center>Fecha Término</center></th>';
				    tabla+='</tr>';
			        tabla+='</thead>';
			        tabla+='<tbody>';
			        if(acciones.length>0){
			        	for(let x=0; x <acciones.length; x++){
			        		tabla+='<tr>';
			        		tabla+='<td>';
			        		tabla+=acciones[x]['accion'];
			        		tabla+='</td>';
			        		tabla+='<td>';
			        		tabla+=acciones[x]['f_inicio'];
			        		tabla+='</td>';
			        		tabla+='<td>';
			        		tabla+=acciones[x]['f_termino'];
			        		tabla+='</td>';
			        		tabla+='</tr>';
			        	}
			        	
			        }
			        tabla+='</tbody>';
          			tabla+='</table>';
          			tabla+='</center>';
          			$("#div_acc_rez").append(tabla);
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

	$("#nav-tab").click(function (e) {
        var id = e.target.id;
        if(id =="nav-resultados-tab"){
	   		datos_accion();
		   	datos_laepie();
		   	datos_objetivopie();
		   	datos_accionpie();
		   	accionesRezagadas();
   		}
    });