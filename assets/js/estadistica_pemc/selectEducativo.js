$('#nivel_educativo_grid_general').change(function() {
	Notification.loading("");
	getEstadistica();

});

$('#nivel_educativo_LAE').change(function() {

        $('#region_LAE option:selected').val(0);
        $('#municipio_LAE option:selected').val(0);
	Notification.loading("");
	getEstadisticaLAE();

});

$('#region_LAE').change(function() {
	$('#municipio_LAE option:selected').val(0);
	Notification.loading("");
   $('#sostenimiento_LAE').val(0);
   $('#zona_LAE').val(0);
   getEstadisticaLAE();
  

});

$('#municipio_LAE').change(function() {
	Notification.loading("");
   $('#sostenimiento_LAE option:selected').val();
   $('#zona_LAE option:selected').val();
   getEstadisticaLAE();

});

$('#zona_LAE').change(function() {
	Notification.loading("");
   $('#region_LAE').val(0);
   $('#municipio_LAE').val(0);
   getEstadisticaLAE();

});

$('#sostenimiento_LAE').change(function() {
	Notification.loading("");
   $('#region_LAE').val(0);
   $('#municipio_LAE').val(0);
   getEstadisticaLAE();
});


$('#radiobtn_region').click(function() {
    $('.div_zona').addClass('d-none');
    $('.div_region').removeClass('d-none');

});

$('#radiobtn_zona').click(function() {
    $('.div_region').addClass('d-none');
    $('.div_zona').removeClass('d-none');
});

$('#zona_zona').change(function() {
	Notification.loading("");
   getEstadisticaZona();

});

$('#sostenimiento_zona').change(function() {
	Notification.loading("");
   getEstadisticaZona();
});
