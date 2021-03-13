 google.charts.load('current', {'packages':['bar']});
 google.charts.setOnLoadCallback(graficaBarObj_jefsector);
 google.charts.setOnLoadCallback(graficaBarAcc_jefsector);

$('#slct_supervision').change(function() {
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

$(document).on("click","#btn-estadisticas_xjefsector",function(){
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
     graficaBarObj_jefsector(data.grafica_jefsector); 
     graficaBarAcc_jefsector(data.grafica_jefsector); 
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

function graficaBarObj_jefsector(objetivos) {
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

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_xjefesector'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
     } 
function graficaBarAcc_jefsector(acciones) {
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

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_acciones_xjefesector'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
     } 



