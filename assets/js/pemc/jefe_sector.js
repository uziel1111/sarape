

$('#slct_supervision').change(function(e) {
  e.preventDefault();
	var cct_super=$('#slct_supervision option:selected').val();
    var cct = cct_super.split('_')[0];
    var turno =cct_super.split('_')[1];
    $.ajax({
    	type:"POST",
    	url:base_url+"Pemc/obtener_seccion_escxsuper",
    	data:{cct:cct,turno:turno},
    	beforeSend: function(xhr) {
					Notification.loading("");
				}
    })
    .done(function(data){
     $("#vista_escuelas").empty();
	 $("#vista_escuelas").append(data.str_vista_escuelaxsuper);
    })
    .fail(function(e) {
	    console.error("Error in ()"); console.table(e);
    })
    .always(function() {
	swal.close();
    });

});

$(document).on("click","#btn-estadisticas_xjefsector",function(e){
  e.preventDefault();
  $.ajax({
    url: base_url+"Pemc/estadisticas_jefesector",
    type: 'POST',
    data: {},
    beforeSend: function(xhr) {
      Notification.loading("");
    },
  })
  .done(function(data) {
     swal.close();
    $('#contenido-estadisticas_xjefsector').html(data.str_view_jefsector);
    $('#modal_estadisticas_xjefsector').modal('show');
      setTimeout(function(){
        graficaPie(parseInt(data.esc_que_capt), parseInt(data.esc_que_n_capt));
        graficaBarObj_jefsector(data.grafica_jefsector);
        graficaBarAcc_jefsector(data.grafica_jefsector);
     }, 1000);
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
 swal.close();
  });

});
$(document).on("click","#btn-cerrar_estadisticas_xjefsector",function(){
  $('#modal_estadisticas_xjefsector').modal('toggle');

});