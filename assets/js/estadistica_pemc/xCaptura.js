 google.charts.load('current', {'packages':['corechart']});
 google.charts.setOnLoadCallback(graficaPie);

$(document).ready(function() {
	getEstadistica();	

});

$('#xgeneral_tab').click(function() {
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

		$('#xgeneral').html(data.str_view);
		graficaPie(data.porcentajeC,data.porcentajeNC);
		$('#nivel_educativo_grid_general').val(nivel);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
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
          title: 'Porcentaje de escuelas que han capturado'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

