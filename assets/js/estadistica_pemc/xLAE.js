 google.charts.load('current', {'packages':['bar']});
 google.charts.setOnLoadCallback(graficaBar);

$(document).ready(function() {
    // graficaBar();   
    // getEstadisticaLAE();
});

$('#xLAE_tab').click(function() {
    getEstadisticaLAE();
     // graficaBar();   
});

function getEstadisticaLAE() {
    nivel = 4;
    ruta = base_url + 'Estadistica_pemc/getEstadisticaLAE';
    $.ajax({
        url: ruta,
        type: 'POST',
        data: {nivel:nivel},
    })
    .done(function(data) {

        $('#xLAE').html(data.str_view);
        graficaBar(); 
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
}

function graficaBar() {
 var data = google.visualization.arrayToDataTable([
        ['Líneas de Acción Estratégicas', 'Objetivos capturados'],
        ['LAE-1', 10],
        ['LAE-2', 4 ],
        ['LAE-3', 16],
        ['LAE-4', 12],
        ['LAE-5', 28]
      ]);

        var options = {
          chart: {
            title: 'Objetivos por LAE',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }