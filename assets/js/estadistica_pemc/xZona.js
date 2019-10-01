$('#xZona_tab').click(function() {
    
    getTablaZona();
});

function getTablaZona() {
    ruta = base_url + 'Estadistica_pemc/getTablaZona';
    $.ajax({
        url: ruta,
        type: 'POST',
        data: {},
        beforeSend: function(xhr) {
                Notification.loading("");
            },
    })
    .done(function(data) {
            console.log(data);
        $('#xZona').html(data.str_view);

       
    })
    .fail(function() {
        console.info('Error');
    })
    .always(function() {

        swal.close();   
    });
}