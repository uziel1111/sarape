$('#xLAE_tab').click(function() {
    
    getTablaZona();
});

function getTablaZona() {
    ruta = base_url + 'Estadistica_pemc/getTablaZona';
    $.ajax({
        url: ruta,
        type: 'POST',
        data: {nivel:nivel, region:region, municipio:municipio},
        beforeSend: function(xhr) {
                Notification.loading("");
            },
    })
    .done(function(data) {
    
        $('#xZona').html(data.str_view);

       
    })
    .fail(function() {
        console.info('Error');
    })
    .always(function() {

        swal.close();   
    });
}