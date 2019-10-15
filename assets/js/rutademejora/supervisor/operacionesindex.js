 google.charts.load('current', {'packages':['bar']});
 google.charts.setOnLoadCallback(graficaBarObj);
 google.charts.setOnLoadCallback(graficaBarAcc);

$(function() {
    obj_supervisor = new Supervision();
    id_tprioritario_sup = 0;
    cct_escuela_log = 0;
});


function Supervision(){
  _this = this;

}


/*101019 I*/
$(document).ready(function() {
  cteActual();
});

$("#btn_graficas").click(function() {
  ruta = base_url + 'Rutademejora/graficas_supervisor';

  $.ajax({
    url: ruta,
    type: 'POST',
    dataType: 'json',
    data: {x : 'x'},
    beforeSend: function(xhr) {
      Notification.loading("");
    },
  })
  .done(function(data) {
     swal.close();
    $('#graficas_modal').html(data.str_view);
     $('#modal_visor_graficas_id').modal('show');
     graficaBarObj(data.grafica); 
     graficaBarAcc(data.grafica); 
  })
  .fail(function() {
    console.log("error");
  })
  .always(function() {
 swal.close();
  });
  
});

$('#cerrar_modal_graficas_super').click(function() {
  $('#modal_visor_graficas_id').modal('toggle');
});

$("#btn_seguimiento_modal").click(function(){
    cve = $("#cct_tmp").val();
     tipou_pemc_avances=1;

  $.ajax({
    url: base_url+'Rutademejora/get_avance',
    type: 'POST',
    dataType: 'JSON',
    data: {'x':'x','tipou_pemc_avances':tipou_pemc_avances, 'cve_centro':cve},
    beforeSend: function(xhr) {
      Notification.loading("");
    },
  }).done(function(result) {
    swal.close();
    $("#seguimiento_modal").html(result.srt_html);
    $('#modal_visor_seguimiento_id').modal('show');
  }).fail(function(e) {
    console.error("Error in get avance()"); console.table(e);
  }).always(function() {
    // swal.close();
  })              
});

$('#cerrar_modal_seguimiento_super').click(function() {
  $('#modal_visor_seguimiento_id').modal('toggle');
});

$('#btn_ver_objetivos_super').click(function() {
   cve = $("#cct_tmp").val();
  if (id_tprioritario_sup === undefined || id_tprioritario_sup == 0) {
    swal(
        '¡Error!',
        "Selecciona una línea de acción para editar",
        "error"
      );
    return false;
  } else{
   $.ajax({
      url: base_url+'Rutademejora/getObjetivos',
      type: 'POST',
      dataType: 'JSON',
      data: { cve: cve,
          id_tpriotario:id_tprioritario_sup,
          id_prioridad: 1,
          tipou_pemc:1,
      },
      beforeSend: function(xhr) {
            Notification.loading("");
        },
    })
    .done(function(result) {
      $("#objetivos_modal").empty();
      $("#objetivos_modal").append(result.table);
       $('#modal_visor_objetivos_id').modal('show');
        swal.close();
      // $('#tema_prioritario').val(result.id_tprioritario);
      // $('#id_objetivo').val(result.id_objetivo);
      // if (result.id_objetivo == 0) {
      //   $('.problematicaTxt').empty();
      //   $('#evidencias').empty();
      //   $('#txt_rm_obs_direc').empty();
      // }
      // console.log(result.id_objetivo);
      //obj_prioridad.funcionalidadselect();
      // obj_prioridad.btnEditar();
      // btnEditar();
    })
    .fail(function(e) {
      console.error("Error in getObjetivos()");
    })
    .always(function() {
      swal.close();
    });
   
  }
$('#modal_visor_objetivos_id').modal('show');
// $('#objetivos_modal').
});

$('#cerrar_modal_objetivos_super').click(function() {
  $('#modal_visor_objetivos_id').modal('toggle');
});
/*101019 F*/


$("#cerrar_modal_ver_evidencia_super").click(function(){
  $('#exampleModal_ver_evidencia_super').modal('toggle');
});

$("#slt_cct_excuelasxsuper").change(function(){
  // alert("canallita");
  var cct = $("#slt_cct_excuelasxsuper").val();
  var selected = $("#slt_cct_excuelasxsuper").find('option:selected');
  var turno = selected.data('turno');
  id_tprioritario_sup = 0;
  $("#cct_tmp").val(cct);
  $("#turno_tmp").val(turno);
});

$("#btn_get_rutamejoraxcct").click(function(){
  var cct = $("#slt_cct_excuelasxsuper").val();
  var selected = $("#slt_cct_excuelasxsuper").find('option:selected');
  var turno = selected.data('turno');
  // alert(turno);
  obj_supervisor.get_rutasxcct(cct, turno);
});

$("#btn_cargar_mensaje_super").click(function(){
  if (id_tprioritario_sup === undefined || id_tprioritario_sup == 0) {
    swal(
        '¡Error!',
        "Selecciona una línea de acción estrategica ",
        "error"
      );
  }
  else {
    obj_supervisor.get_comentario_super();
    $('#exampleModalLong').modal('show');
  }
});



$("#btn_guarda_msg_super").click(function(){
  $.ajax({
    url: base_url+'rutademejora/get_mensaje_super',
    type: 'POST',
    dataType: 'JSON',
    data: {"idruta":id_tprioritario_sup, "mensaje":$("#mensajesupervisor").val()},
    beforeSend: function(xhr) {
          Notification.loading("");
      },
  })
  .done(function(data) {
    swal.close();
    swal(
        '¡Mensaje!',
        data.mensaje,
        "success"
      );
    $("#exampleModalLong").modal('hide');
     var cct = $("#slt_cct_excuelasxsuper").val();
  var selected = $("#slt_cct_excuelasxsuper").find('option:selected');
  var turno = selected.data('turno');
  // alert(turno);
  obj_supervisor.get_rutasxcct(cct, turno);
  })
  .fail(function(e) {
    console.error("Al bajar la informacion"); console.table(e);
  })
  .always(function() {
        // swal.close();
  });
});

$("#btn_ver_ruta_super").click(function(){
  if (id_tprioritario_sup === undefined || id_tprioritario_sup == 0) {
    swal(
        '¡Error!',
        "Selecciona una línea de acción estrategica ",
        "error"
      );
  }
  else {
    obj_supervisor.get_vista_acciones();
  }
});


Supervision.prototype.get_rutasxcct = function(cct, turno){
  $.ajax({
    url: base_url+'rutademejora/get_rutas_xcctsuper',
    type: 'POST',
    dataType: 'JSON',
    data: {"cct":cct, "turno":turno},
    beforeSend: function(xhr) {
          Notification.loading("");
      },
  })
  .done(function(data) {
    swal.close();
    cct_escuela_log = data.cct_escuela;
    var view = data.tabla;
    $("#contenedor_tabla_rutas").empty();
    $("#contenedor_tabla_rutas").append(view);
    obj_supervisor.funcionalidadselect();
  })
  .fail(function(e) {
    console.error("Al bajar la informacion"); console.table(e);
  })
  .always(function() {
        // swal.close();
  })

 };


 Supervision.prototype.funcionalidadselect = function(){
    $("#id_tabla_rutas_super tr").click(function(){
       $(this).addClass('selected').siblings().removeClass('selected');
       var value=$(this).find('td:first').text();
       // var value2=$(this).find('td:second').text();
       id_tprioritario_sup = value;
       // alert(obj_supervisor.id_tprioritario_sup);
    });
  }

Supervision.prototype.get_vista_acciones = function(){
  $.ajax({
    url: base_url+'rutademejora/get_vista_acciones',
    type: 'POST',
    dataType: 'JSON',
    data:{"idruta":id_tprioritario_sup, "nombreescuela":$("#slt_cct_excuelasxsuper option:selected").text()},
    beforeSend: function(xhr) {
          Notification.loading("");
      },
  })
  .done(function(data) {
    swal.close();
    var view = data.vista;
    $("#contenedor_vista_acciones").empty();
    $("#contenedor_vista_acciones").append(view);
    $("#modal_visor_acciones_id").modal("show");
  })
  .fail(function(e) {
    console.error("Al bajar la informacion"); console.table(e);
  })
  .always(function() {
        // swal.close();
  })
}

Supervision.prototype.get_comentario_super = function(){
  $.ajax({
    url: base_url+'rutademejora/get_comentario_super',
    type: 'POST',
    dataType: 'JSON',
    data:{"idtemarp":id_tprioritario_sup},
    beforeSend: function(xhr) {
          Notification.loading("");
      },
  })
  .done(function(data) {
    swal.close();
    var comentario = data.mensaje;
    $("#mensajesupervisor").val(comentario);
  })
  .fail(function(e) {
    console.error("Al bajar la informacion"); console.table(e);
  })
  .always(function() {
        // swal.close();
  })
}

/* Funciones de Gráficas I*/
function graficaBarObj(objetivos) {
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

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
     } 
function graficaBarAcc(acciones) {
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

        var chart = new google.charts.Bar(document.getElementById('columnchart_material_acciones'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
     } 
/* Funciones de Gráficas F*/

function cteActual() {
    ruta = base_url + '/Rutademejora/momentoActual';
    $.ajax({
      url: ruta,
      type: 'POST',
      data: {},
    })
    .done(function(data) {
      $('#cteActualSup').html('Consejo Técnico Escolar Actual: '+ data.cte);
    })
    .fail(function(data) {
    })
    .always(function() {
    });
    
  }

Supervision.prototype.ver_archivo_evidencia= function(path_evidencia){
  var Protocol = location.protocol;
  var URLactual = window.location.host;
  var pathname = window.location.pathname;
  $('#dv_ver_evidencia_super').empty();
  $('#dv_ver_evidencia_super').html('<iframe src="'+Protocol+"//"+URLactual+"/pruebas_qualedu/sarape/"+path_evidencia+'" width="100%" height="500" style="border: none;"></iframe>');
  $('#exampleModal_ver_evidencia_super').modal('toggle');
  console.log(Protocol+"//"+URLactual+"/"+path_evidencia);
}
