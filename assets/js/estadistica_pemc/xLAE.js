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
   sostenimiento = $('#sostenimiento_LAE option:selected').val();
   zona = $('#zona_LAE option:selected').val();

   if (nivel == undefined) {
    nivel = 0;
}

if (region == undefined) {
    region = 0;
}

if (municipio == undefined) {
    municipio = 0;
}

if (sostenimiento == undefined) {
    sostenimiento = 0;
}

if (zona == undefined) {
    zona = 0;
}

ruta = base_url + 'Estadistica_pemc/getEstadisticaLAE';
$.ajax({
    url: ruta,
    type: 'POST',
    data: {nivel:nivel, region:region, municipio:municipio, sostenimiento:sostenimiento, zona:zona},
    beforeSend: function(xhr) {
        Notification.loading("");
    },
})
.done(function(data) {
    swal.close();
    $('#xLAE').html(data.str_view);
    graficaBarObj(data.grafica);
    graficaBarAcc(data.grafica);
    $('#nivel_educativo_LAE').val(nivel);
    $('#region_LAE').val(region);
    $('#municipio_LAE').val(municipio);
    if (region != 0 || municipio != 0) {
        $('#nivel_educativo_LAE').val(nivel);
        $('#municipio_LAE').removeAttr('disabled');
        $('#region_LAE').val(region);
        $('#radiobtn_region').trigger("click");
    }else if (sostenimiento != 0 || zona) {
     $('#radiobtn_zona').trigger("click");
     $('#sostenimiento_LAE').val(sostenimiento);
     $('#zona_LAE').val(zona);
     $('#zona_LAE').removeAttr('disabled');

 }
})
.fail(function() {
    swal.close();
    console.info('Error');
})
.always(function() {
    swal.close();
});

}

function graficaBarObj(objetivos) {
    if (objetivos != undefined && objetivos.length != 0){

        obj1 = parseInt(objetivos[0]['obj']);
        obj2 = parseInt(objetivos[1]['obj']);
        obj3 = parseInt(objetivos[2]['obj']);
        obj4 = parseInt(objetivos[3]['obj']);
        obj5 = parseInt(objetivos[4]['obj']);
        var data = google.visualization.arrayToDataTable([
            ['Líneas de Acción Estratégicas', 'Objetivos capturados'],
            ['LAE-1', obj1],
            ['LAE-2', obj2],
            ['LAE-3', obj3],
            ['LAE-4', obj4],
            ['LAE-5', obj5],
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
}
function graficaBarAcc(acciones) {
    if (acciones != undefined && acciones.length != 0){

        acc1 = parseInt(acciones[0]['acc']);
        acc2 = parseInt(acciones[1]['acc']);
        acc3 = parseInt(acciones[2]['acc']);
        acc4 = parseInt(acciones[3]['acc']);
        acc5 = parseInt(acciones[4]['acc']);
        var data = google.visualization.arrayToDataTable([
            ['Líneas de Acción Estratégicas', 'Acciones capturadas'],
            ['LAE-1', acc1],
            ['LAE-2', acc2],
            ['LAE-3', acc3],
            ['LAE-4', acc4],
            ['LAE-5', acc5],
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
}
