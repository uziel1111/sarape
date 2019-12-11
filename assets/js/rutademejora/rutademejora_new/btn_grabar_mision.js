$('#btn_grabar').click(function(e){
	e.preventDefault()

	var mision = $('#txt_rm_mision').val();
	var id_cct = $('#id_cct').val()
	let ruta = base_url + 'Rutademejora/insert_update_misioncct/'

	$.ajax({
		url:ruta,
		type:'post',
		data: { 'misioncct': mision },
		beforeSend: function(xhr) {
				Notification.loading("");
		}
	})
	.done(function( data ) {
		setTimeout(function(){
			Swal.fire(
			  '¡Correcto!',
			  'La misión se actualizó correctamente',
			  'success'
			)
		}, 300);

	})
	.fail(function(e) {
		console.error("Error in ()"); console.table(e);
	})
	.always(function() {
		swal.close();
	});
})
