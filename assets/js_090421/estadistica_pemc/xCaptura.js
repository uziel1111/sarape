 google.charts.load('current', {'packages':['corechart']});

 $(document).ready(function() {
 	getEstadistica();

 });

 $('#xgeneral_tab').click(function(e) {
    e.preventDefault();
 	getEstadistica();

 });
 $('#nivel_educativo_grid_general').change(function() {
 	console.log('click');
 	getEstadistica();

 });
 function getEstadistica() {
 	nivel = $('#nivel_educativo_grid_general option:selected').val();
 	if (nivel == undefined) {
 		nivel = 0;
 	}
 	ruta = base_url + 'Estadistica_pemc/getEstadistica';
 	$.ajax({
 		url: ruta,
 		type: 'POST',
 		data: {nivel:nivel},
 	})
 	.done(function(data) {
 		swal.close();
 		$('#xgeneral').html(data.str_view);
 		graficaPie(data.n_porcentajeC,data.n_porcentajeNC);
 		$('#nivel_educativo_grid_general').val(nivel);
 	})
 	.fail(function() {
 		swal.close();
 		console.log("error");
 	})
 	.always(function() {

 		swal.close();
 	});

 }

 function graficaPie(capturado, no_capturado) {


 	var data = google.visualization.arrayToDataTable([
 		['Porcentaje', 'Captura por escuela'],
 		['Capturado',     capturado],
 		['No Capturado',      no_capturado]
 		]);

 	var options = {
 		chart:{
 			title: 'Porcentaje de escuelas que han capturado'
 		},
 		height: 400,
 		width: 700,
      legend: {position: 'labeled'},
 	}
 	var chart = new google.visualization.PieChart($('#piechart')[0]);




 	chart.draw(data, options);
 };