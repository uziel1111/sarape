$('#nivel_educativo_grid_general').change(function() {
	Notification.loading("");
	getEstadistica();

});

$('#nivel_educativo_LAE').change(function() {
	Notification.loading("");
	getEstadisticaLAE();

});

$('#region_LAE').change(function() {
	Notification.loading("");
   getEstadisticaLAE();
});

$('#municipio_LAE').change(function() {
	Notification.loading("");
   getEstadisticaLAE();
});
