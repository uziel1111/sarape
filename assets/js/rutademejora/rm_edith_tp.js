$(function() {
    obj_rm_edith_tp = new Rm_edith_tp();
    obj_prioridad = new Prioridad();
});
$("#btn_rutamejora_editar").click(function(){
  if (obj.id_tprioritario === undefined) {
    swal(
        '¡Error!',
        "Selecciona un tema prioritario a editar ",
        "error"
      );
  }
  else {
    obj_rm_edith_tp.get_datos_edith_tp(obj.id_tprioritario);
  }
//
});

$("#btn_actualizar_tp").click(function(){
tmp_id_tprioritario = $("#inp_tmp_id_tprioritario").val();
// console.log(tmp_id_tprioritario);
obj_rm_tp.insert_update_mision_cct();

obj_rm_edith_tp.update_datos_edith_tp(tmp_id_tprioritario);
});



function Rm_edith_tp(){
  _thisrm_edith_tp = this;
}

function Prioridad(){
  _thisrm_tp = this;
}

Rm_edith_tp.prototype.get_datos_edith_tp = function(id_tprioritario){
  $.ajax({
  url: base_url+'rutademejora/get_datos_edith_tp',
  type: 'POST',
  dataType: 'JSON',
  data: {id_tprioritario:id_tprioritario},
  beforeSend: function(xhr) {
        Notification.loading("");
    },
  })
  .done(function(data) {
  swal.close();
  // // console.log(result.datos);
  // obj_rm_edith_tp.set_tags_edith(result.datos);

  // document.getElementById('btn_actualizar_tp').removeAttribute("hidden");
  // document.getElementById('btn_grabar_tp').setAttribute("hidden", true);
  // // document.getElementById('btn_get_reporte').setAttribute("hidden", true);
  // document.getElementById('btn_rutamejora_editar').setAttribute("hidden", true);
  // document.getElementById('btn_rutamejora_eliminareg').setAttribute("hidden", true);
  // document.getElementById('btn_rutamejora_acciones').setAttribute("hidden", true);
  $("#div_generico").empty();
      $("#div_generico").append(data.strView);
      $('h5').empty();
      $('h5').append(data.titulo);
      $("#myModal").modal("show");
      setTimeout(function(){
        obj_prioridad.getObjetivos()
      }, 500)




  })
  .fail(function(e) {
  console.error("Error in get_datos_edith_tp()"); console.table(e);
  })
  .always(function() {
      // swal.close();
  })

};

Rm_edith_tp.prototype.set_tags_edith = function(datos){
// console.log(datos[0]['como_ayudan_pa']);

      // console.log(datos);
      // $(".problematica").val(4);
$("#inp_tmp_id_tprioritario").val(datos[0]['id_tprioritario']);
$("#slc_rm_prioridad").val(datos[0]['id_prioridad']);
$("#slc_rm_prioridad").selectpicker("refresh");
$("#txt_rm_ob1").val(datos[0]['objetivo1']);
$("#txt_rm_met1").val(datos[0]['meta1']);
$("#txt_rm_ob2").val(datos[0]['objetivo2']);
$("#txt_rm_met2").val(datos[0]['meta2']);
$("#txt_rm_problem").val(datos[0]['otro_problematica']);
$("#txt_rm_eviden").val(datos[0]['otro_evidencia']);
$("#slc_pa").selectpicker('val', datos[0]['ids_programapoyo'].split(','));
$("#slc_pa").selectpicker("refresh");
$("#txt_rm_otropa").val(datos[0]['otro_pa']);
$("#txt_rm_programayuda").val(datos[0]['como_ayudan_pa']);
$("#txt_rm_obs_direc").val(datos[0]['obs_direc']);
document.getElementById('dv_obs_super').removeAttribute("hidden");
$("#txt_rm_obs_super").val(datos[0]['obs_supervisor']);
$("#slc_apoyoreq").selectpicker('val', datos[0]['ids_apoyo_req_se'].split(','));
$("#slc_apoyoreq").selectpicker("refresh");
$("#txt_rm_otroapoyreq").val(datos[0]['otro_apoyo_req_se']);
$("#txt_rm_especifiqueapyreq").val(datos[0]['especifique_apoyo_req']);
// alert(live_url);
if (datos[0]['path_evidencia'] !='' && datos[0]['path_evidencia'] !== null) {
  $("#img_evid").prop("src", live_url+datos[0]['path_evidencia']);

  $("#glosaArchivos").html(datos[0]['path_evidencia'].split("/")[3]);
  document.getElementById('btn_clr_img').removeAttribute("hidden");
  $("#edit_img").val(true);
}



};

Rm_edith_tp.prototype.update_datos_edith_tp = function(tmp_id_tprioritario){
// console.log(datos[0]['como_ayudan_pa']);
var validacion = obj_rm_tp.valida_campos_tp();

if (validacion == true) {

  var id_prioridad = $("#slc_rm_prioridad").val();
  var objetivo1 = $("#txt_rm_ob1").val();
  var meta1 = $("#txt_rm_met1").val();
  var objetivo2 = $("#txt_rm_ob2").val();
  var meta2 = $("#txt_rm_met2").val();
  var problematica = $("#txt_rm_problem").val();
  var evidencia = $("#txt_rm_eviden").val();
  var ids_progapoy="";
   $("#slc_pa option:selected").each(function() {
     ids_progapoy += $(this).val() + ",";
   });
   ids_progapoy = ids_progapoy.slice(0,-1);
  var otro_pa = $("#txt_rm_otropa").val();
  var como_prog_ayuda = $("#txt_rm_programayuda").val();
  var obs_direct = $("#txt_rm_obs_direc").val();
  var ids_apoyreq="";
   $("#slc_apoyoreq option:selected").each(function() {
     ids_apoyreq += $(this).val() + ",";
   });
   ids_apoyreq = ids_apoyreq.slice(0,-1);
  var otroapoyreq = $("#txt_rm_otroapoyreq").val();
  var especifiqueapyreq = $("#txt_rm_especifiqueapyreq").val();

  $("#id_id_tprioritario").val(tmp_id_tprioritario);
  $("#id_id_prioridad").val(id_prioridad);
  $("#id_objetivo1").val(objetivo1);
  $("#id_meta1").val(meta1);
  $("#id_objetivo2").val(objetivo2);
  $("#id_meta2").val(meta2);
  $("#id_problematica").val(problematica);
  $("#id_evidencia").val(evidencia);
  $("#id_ids_progapoy").val(ids_progapoy);
  $("#id_otro_pa").val(otro_pa);
  $("#id_como_prog_ayuda").val(como_prog_ayuda);
  $("#id_obs_direct").val(obs_direct);
  $("#id_ids_apoyreq").val(ids_apoyreq);
  $("#id_otroapoyreq").val(otroapoyreq);
  $("#id_especifiqueapyreq").val(especifiqueapyreq);

  var formData = new FormData($(".formulario1")[0]);

  $.ajax({
  url: base_url+'rutademejora/update_tema_prioritario',
  type: 'POST',
  dataType: 'JSON',
  data: formData,
  // {id_tprioritario:tmp_id_tprioritario,id_prioridad:id_prioridad,objetivo1:objetivo1,meta1:meta1,objetivo2:objetivo2,meta2:meta2,problematica:problematica,
  // evidencia:evidencia,ids_progapoy:ids_progapoy,otro_pa:otro_pa,como_prog_ayuda:como_prog_ayuda,obs_direct:obs_direct,
  // ids_apoyreq:ids_apoyreq,otroapoyreq:otroapoyreq,especifiqueapyreq:especifiqueapyreq},
  cache: false,
  contentType: false,
  processData: false,
  beforeSend: function(xhr) {
        Notification.loading("");
    },
})
.done(function(result) {
  swal.close();
  //console.log(result.estatus);
  if (result.estatus) {
    obj_rm_tp.limpia_campos_tp();
    swal(
        '¡Correcto!',
        "Se actualizó el tema prioritario correctamente",
        'success'
      );
      obj.get_view();
      document.getElementById('btn_grabar_tp').removeAttribute("hidden");
      // document.getElementById('btn_get_reporte').removeAttribute("hidden");
      document.getElementById('btn_rutamejora_editar').removeAttribute("hidden");
      document.getElementById('btn_rutamejora_eliminareg').removeAttribute("hidden");
      document.getElementById('btn_rutamejora_acciones').removeAttribute("hidden");
      document.getElementById('btn_actualizar_tp').setAttribute("hidden", true);
      document.getElementById('dv_obs_super').setAttribute("hidden", true);

  }
  else {
    swal(
        '¡Error!',
        "Al actualizar tema prioritario ",
        'error'
      );
  }

})
.fail(function(e) {
  console.error("Error in actualizar tema prioritario()"); console.table(e);
})
.always(function() {
      // swal.close();
})

}

};
