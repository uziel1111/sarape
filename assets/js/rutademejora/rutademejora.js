$(function() {
  obj_rm = new Rutademejora();
  $("[data-toggle=popover]").each(function(i, obj) {
    $(this).popover({
      html: true,
      trigger:'hover'
    });
  });
});

$('#salir_mision').click(function() {
  console.info('cerraste el modal de la misión_rutademejora.js');
});

$("#slc_pa").change(function(){
  var texto="";
  $("#slc_pa option:selected").each(function() {
    texto += $(this).val() + ",";
  });

  paputilizadas = texto.split(",");
  var i = paputilizadas.indexOf("");
  paputilizadas.splice( i, 1 );
  if( texto.indexOf("0,") > -1){
    document.getElementById('txt_rm_otropa').removeAttribute("hidden");
  }else{
    document.getElementById('txt_rm_otropa').setAttribute("hidden", true);
  }

});

$("#slc_apoyoreq").change(function(){
  var texto="";
  $("#slc_apoyoreq option:selected").each(function() {
    texto += $(this).val() + ",";
  });

  paputilizadas = texto.split(",");
  var i = paputilizadas.indexOf("");
  paputilizadas.splice( i, 1 );

  if( texto.indexOf("0,") > -1){
    document.getElementById('txt_rm_otroapoyreq').removeAttribute("hidden");
  }else{
    document.getElementById('txt_rm_otroapoyreq').setAttribute("hidden", true);
  }
});

$("#nav-avances-tab").click(function(){
  $("#nav-avances").empty();
  let tipou_pemc_avances=0;
  if($("#tipou_pemc2").length){
    tipou_pemc_avances=1;
  }

  $.ajax({
    url: base_url+'Rutademejora/get_avance',
    type: 'POST',
    dataType: 'JSON',
    data: {'x':'x','tipou_pemc_avances':tipou_pemc_avances},
    beforeSend: function(xhr) {
      Notification.loading("");
    },
  }).done(function(result) {
    swal.close();
    $("#nav-avances").html(result.srt_html);
  }).fail(function(e) {
    console.error("Error in get avance()"); console.table(e);
  }).always(function() {
    // swal.close();
  })              
});

$("#btn_get_reporte").click(function(){
  obj_rm.get_reporte(obj.id_tprioritario);
});

$("#btn_rutamejora_obs_super").click(function(){
  if (obj.id_tprioritario === undefined) {
    swal(
        '¡Error!',
        "Favor de seleccionar un tema prioritario",
        "error"
      );
  }else {
    $.ajax({
      url: base_url+'rutademejora/get_obs_super',
      type: 'POST',
      dataType: 'JSON',
      data: {id_tprioritario:obj.id_tprioritario},
      beforeSend: function(xhr) {
            Notification.loading("");
        },
    })
    .done(function(result) {
      swal.close();
      // console.log(result.srt_html);
      $('#exampleModal_obs_super').modal('toggle');
      $("#txt_rm_obs_super1").empty();
      $("#txt_rm_obs_super1").html(result.str_obs_super);
    })
    .fail(function(e) {
      console.error("Error in get obs_sup()"); console.table(e);
    })
    .always(function() {
          // swal.close();
    })
    //llamado a la vista de acciones
  }
});

$("#cerrar_modal_obs_super").click(function(){
  $('#exampleModal_obs_super').modal('toggle');
});


$("#btn_clr_img").click(function(){
  $("#img_evid").prop("src", "");
  $("#glosaArchivos").html("Ningun archivo seleccionado");
  document.getElementById('btn_clr_img').setAttribute("hidden", true);
  $("#edit_img").val(false);
});

function Rutademejora(){
  _thisrm = this;
}
