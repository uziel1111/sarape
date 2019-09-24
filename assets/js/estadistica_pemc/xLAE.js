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
   nivel = $('#nivel_educativo_LAE option:selected').val();
   region = $('#region_LAE option:selected').val();
  if (nivel == undefined) {
        nivel = 0;
    }

    if (region == undefined) {
        region = 0;
    }
    ruta = base_url + 'Estadistica_pemc/getEstadisticaLAE';
    $.ajax({
        url: ruta,
        type: 'POST',
        data: {nivel:nivel, region:region},
    })
    .done(function(data) {

        $('#xLAE').html(data.str_view);
        console.log(data.result);
        //graficaBar(data.result); 
        $('#nivel_educativo_LAE').val(nivel);
         $('#region_LAE option:selected').val(region);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
        swal.close();   
    });
    
}

function graficaBar(datos) {
    console.log(datos);
 var data = google.visualization.arrayToDataTable([
        ['Líneas de Acción Estratégicas', 'Objetivos capturados'],
        ['LAE-1', datos.obj1],
        ['LAE-2', datos.obj2],
        ['LAE-3', datos.obj3],
        ['LAE-4', datos.obj4],
        ['LAE-5', datos.obj5]
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