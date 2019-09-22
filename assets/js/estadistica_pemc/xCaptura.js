 google.charts.load('current', {'packages':['corechart']});
 google.charts.setOnLoadCallback(graficaPie);

$(document).ready(function() {
	getEstadistica();	
});

$('#xgeneral_tab').click(function() {
	getEstadistica();
});

function getEstadistica() {
	nivel = 4;
	ruta = base_url + 'Estadistica_pemc/getEstadistica';
	$.ajax({
		url: ruta,
		type: 'POST',
		data: {nivel:nivel},
	})
	.done(function(data) {

		$('#xgeneral').html(data.str_view);
		graficaPie(data.porcentajeNC,data.porcentajeC);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
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