
if (typeof google !== 'undefined') {
  google.charts.load('current', {'packages':['bar']});

  google.charts.setOnLoadCallback(graficaBarObj_jefsector);
  google.charts.setOnLoadCallback(graficaBarAcc_jefsector);
  google.charts.setOnLoadCallback(graficaBarObj_super);
  google.charts.setOnLoadCallback(graficaBarAcc_super);
  // google.charts.setOnLoadCallback(graficaPiesuper);
  // google.charts.setOnLoadCallback(graficaPie);
  
  google.charts.load('current', {'packages':['corechart']});
}

 
$(".btn-coll_escuela").click(function (e) {
    e.preventDefault();
    cct_escuela=$(this).data('escuela').cct;
    turno_escuela=$(this).data('escuela').turno;
    idpemc=$(this).data('escuela').idpemc;
    $("#idpemc_click").val(idpemc);
    $("#turno_click").val(turno_escuela);
    $(".icon-escuela_"+cct_escuela+turno_escuela).toggleClass('fas fa-chevron-up').toggleClass('fas fa-chevron-down');
    $.ajax({
    	type:"POST",
    	url:base_url+"Pemc/obtiene_seccion_escuela",
    	data:{cct_escuela:cct_escuela,turno_escuela:turno_escuela,idpemc:idpemc},
    	beforeSend: function(xhr) {
					Notification.loading("");
				}
    })
    .done(function(data){
     $("#vista_escuela"+cct_escuela+turno_escuela).empty();
	   $("#vista_escuela"+cct_escuela+turno_escuela).append(data.str_vista_escuela);
    })
    .fail(function(e) {
	    console.error("Error in ()"); console.table(e);
    })
    .always(function() {
	swal.close();
    });
});

$(document).on("click","#btn-estadisticas",function(e){
  e.preventDefault();
  $.ajax({
    url: base_url+"Pemc/estadisticas_supervisor",
    type: 'POST',
    data: {},
    beforeSend: function(xhr) {
      Notification.loading("");
    },
  })
  .done(function(data) {
     swal.close();
    $('#contenido-estadisticas').html(data.str_view_super);
     $('#modal_estadisticas').modal('show');
     setTimeout(function(){
      graficaPiesuper(parseInt(data.esc_que_capt), parseInt(data.esc_que_n_capt));
     graficaBarObj_super(data.grafica_super);
     graficaBarAcc_super(data.grafica_super);
      }, 1000);
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
 swal.close();
  });

});

$(document).on("click","#btn-cerrar_estadisticas",function(){
  $('#modal_estadisticas').modal('toggle');

});


   
