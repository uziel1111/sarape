$(function() {
    obj_indiceo = new IndiceO();
});

$("#bt_porcentajeobe").click(function(){
	obj_indiceo.get_escuelas_prom();
})


function IndiceO(){
  _thismap = this;
}



IndiceO.prototype.get_escuelas_prom = function(idreactivo){
	$.ajax({
		url: base_url+'indicepeso/get_escuelas',
		type: 'POST',
		dataType: 'JSON',
		data: {'idmunicipio': $("#slt_municipio_peso").val(), 'idnivel':$("#slt_nivel_peso").val(), 'idperiodo':$("#slt_ciclo_peso").val()},
		beforeSend: function(xhr) {
	        Notification.loading("");
	    },
	})
	.done(function(result) {

		console.log(result.dom_view_indice_peso);
		$("#contenedor_de_vista_g").empty();
		$("#contenedor_de_vista_g").append(result.dom_view_indice_peso);
	})
	.fail(function(e) {
		console.error("Error in get_Niveles()"); console.table(e);
	})
	.always(function() {
    swal.close();
	});
}

