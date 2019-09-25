 google.charts.load('current', {'packages':['bar']});
 google.charts.setOnLoadCallback(graficaBarObj);
 google.charts.setOnLoadCallback(graficaBarAcc);

$('#xLAE_tab').click(function() {
    getEstadisticaLAE();
});


function getEstadisticaLAE() {
   nivel = $('#nivel_educativo_LAE option:selected').val();
   region = $('#region_LAE option:selected').val();
   municipio = $('#municipio_LAE option:selected').val();
   console.log(region);
   console.log(municipio);
   if (nivel == undefined) {
    nivel = 0;
    }

    if (region == undefined) {
        region = 0;
    }

    if (municipio == undefined) {
        municipio = 0;
    }

    ruta = base_url + 'Estadistica_pemc/getEstadisticaLAE';
    $.ajax({
        url: ruta,
        type: 'POST',
        data: {nivel:nivel, region:region, municipio:municipio},
    })
    .done(function(data) {
    
        $('#xLAE').html(data.str_view);

        graficaBarObj(data.result); 
        graficaBarAcc(data.result); 
        $('#nivel_educativo_LAE').val(nivel);
        $('#region_LAE option:selected').val(region);
        $('#municipio_LAE option:selected').val(municipio);
    })
    .fail(function() {
        console.info('Error');
    })
    .always(function() {

        swal.close();   
    });

}

function graficaBarObj(datos) {
    
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
function graficaBarAcc(datos) {
    
 var data = google.visualization.arrayToDataTable([
        ['Líneas de Acción Estratégicas', 'Acciones capturadas'],
        ['LAE-1', datos.acc1],
        ['LAE-2', datos.acc2],
        ['LAE-3', datos.acc3],
        ['LAE-4', datos.acc4],
        ['LAE-5', datos.acc5]
      ]);

        var options = {
          chart: {
            title: 'Acciones por LAE',
            subtitle: '',
            height: 250,
            width: 400,
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_acciones'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }