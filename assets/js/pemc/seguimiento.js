
var Seguimiento_pemc = {
		guarda_avance: (avance, idaccion) => {
			swal({
				title: '¿Esta seguro de grabar el avance '+avance+'%?',
				text: "Una vez guardado no se puede eliminar",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Eliminar',
				cancelButtonText: 'Cancelar'
			}).then(function(result){
				if (result.value) {
					
				}
				else {

				}
			})
	 },
};
