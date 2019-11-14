$('#xZona_tab').click(function() {

    getTablaZona();
});

function getTablaZona() {
    zona = $('#zona_zona option:selected').val();
    sostenimiento = $('#sostenimiento_zona option:selected').val();
    nivel = $('#nivel_educativo_zona option:selected').text();
    nivelval = $('#nivel_educativo_zona option:selected').val();
    if (nivel == undefined) {
        nivel = 'Todos los niveles';
    }
    if (zona == undefined) {
        zona = 0;
    }
    if (sostenimiento == undefined) {
        sostenimiento = 0;
    }

    ruta = base_url + 'Estadistica_pemc/getTablaZona';
    $.ajax({
        url: ruta,
        type: 'POST',
        data: {zona:zona, sostenimiento:sostenimiento, nivel:nivel},
        beforeSend: function(xhr) {
            Notification.loading("");
        },
    })
    .done(function(data) {
        $('#xZona').html(data.str_view);
        $('#zona_zona').removeAttr('disabled');

        $('#zona_zona').val(zona);
        $('#sostenimiento_zona').val(sostenimiento);
        if (nivelval == undefined) {
            $('#nivel_educativo_zona').val(0);
        }else{
          $('#nivel_educativo_zona').val(nivelval);
      }
  })
    .fail(function() {
        console.info('Error');
    })
    .always(function() {

        swal.close();   
    });
}