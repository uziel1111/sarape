 google.charts.load('current', {'packages':['bar']});
 google.charts.setOnLoadCallback(graficaBarObj_super);
 google.charts.setOnLoadCallback(graficaBarAcc_super);

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

$(document).on("click","#btn-estadisticas",function(){
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
     graficaBarObj_super(data.grafica_super); 
     graficaBarAcc_super(data.grafica_super); 
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
function graficaBarObj_super(objetivos) {
    if (objetivos != undefined){

   
    obj1 = parseInt(objetivos[0]['obj']);
    obj2 = parseInt(objetivos[1]['obj']);
    obj3 = parseInt(objetivos[2]['obj']);
    obj4 = parseInt(objetivos[3]['obj']);
    obj5 = parseInt(objetivos[4]['obj']);
 var data = google.visualization.arrayToDataTable([
        ['Líneas de Acción Estratégicas', 'Objetivos'],
        ['LAE-1', obj1],
        ['LAE-2', obj2],
        ['LAE-3', obj3],
        ['LAE-4', obj4],
        ['LAE-5', obj5],
      ]);

        var options = {
          chart: {
            title: 'Objetivos por LAE',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_super'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
     } 
function graficaBarAcc_super(acciones) {
    if (acciones != undefined){

    acc1 = parseInt(acciones[0]['acc']);
    acc2 = parseInt(acciones[1]['acc']);
    acc3 = parseInt(acciones[2]['acc']);
    acc4 = parseInt(acciones[3]['acc']);
    acc5 = parseInt(acciones[4]['acc']);
 var data = google.visualization.arrayToDataTable([
        ['Líneas de Acción Estratégicas', 'Acciones'],
        ['LAE-1', acc1],
        ['LAE-2', acc2],
        ['LAE-3', acc3],
        ['LAE-4', acc4],
        ['LAE-5', acc5],
      ]);

        var options = {
          chart: {
            title: 'Acciones por LAE',
            subtitle: '',
            height: 250,
            width: 400,
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_acciones_super'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
     } 



   