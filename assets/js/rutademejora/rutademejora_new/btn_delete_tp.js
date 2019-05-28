$(document).ready(function () {
	obj = new Tabla();
  obj.get_view();
});

$('#btn_rutamejora_eliminareg').click(function(){
	if (obj.id_tprioritario === undefined){
		swal(
      '¡Error!',
      "Selecciona un tema prioritario a eliminar ",
      "error"
    );
	} else {
		console.log(obj.id_tprioritario);
		swal({
      title: '¿Esta seguro de eliminar el tema prioritario?',
      text: "Una vez eliminado no se podra recuperar",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar'
    }).then(function(result){
				if (result.value) {
					eliminarTP(obj.id_tprioritario)
				}
		})
	}
})


function eliminarTP(id_tprioritario){
	$.ajax({
		url: base_url+'rutademejora/eliminarTP',
	  type: 'POST',
	  dataType: 'JSON',
	  data: { id_tprioritario:id_tprioritario },
	  beforeSend: function(xhr) {
        Notification.loading("");
    },
	})
	.done(function(result) {
	  if (result) {
	    swal(
	        '¡Correcto!',
	        "Se eliminó el tema prioritario correctamente",
	        'success'
	      );
	      obj.get_view();
	  }
	  else {
	    swal(
	        '¡Error!',
	        "Al eliminar el tema prioritario ",
	        'error'
	      );
	  }
  })
	.fail(function(e) {
  	console.error("Error in eliminarTP()");
  })
  .always(function() {
      swal.close();
  })
}
