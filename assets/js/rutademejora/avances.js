$(function() {
    obj_rm_avances_acciones = new Rm_avances_acciones();
});


function Rm_avances_acciones(){
  _thisrm_avances_acciones = this;
}


Rm_avances_acciones.prototype.set_avance = function(cad_str_ids){
  // var val_slc = $("#".concat(cad_str_ids)).val();
  var val_slc = $("#".concat(cad_str_ids)).val();
  // console.log(val_slc);
  var arr_res = cad_str_ids.split("_");
  var var_id_cte = arr_res[0];
  var var_id_cct = arr_res[1];
  var var_id_idtp = arr_res[2];
  var var_id_idacc = arr_res[3];

  $.ajax({
  url: base_url+'rutademejora/set_avance',
  type: 'POST',
  dataType: 'JSON',
  data: { var_id_cct:var_id_cct,
          var_id_idtp:var_id_idtp,
          var_id_idacc:var_id_idacc,
          var_id_cte:var_id_cte,
          val_slc:val_slc
        },
  beforeSend: function(xhr) {
        Notification.loading("");
    },
})
.done(function(result) {
  swal.close();
  // console.log(result.estatus);
  if (result.estatus) {
    swal(
        'Correcto!',
        "Se actualizo tema prioritario correctamente",
        'success'
      );
    var base2 = base_url.split('/index.php');
    var icono = obj_rm_avances_acciones.get_icono(val_slc);
    var ruta = base2[0]+"/assets/img/rm_estatus/"+icono;
    $("#"+var_id_idacc+"icoima").attr("src",ruta);
  }
  else {
    swal(
        'Error!',
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

 };


Rm_avances_acciones.prototype.get_icono = function(porcentaje){
  if(porcentaje == 0){
      return "0.png";
    }else if(porcentaje == 10 || porcentaje == 20 || porcentaje == 30){
      return "1.png";
    }else if(porcentaje == 40 || porcentaje == 50 || porcentaje == 60 || porcentaje == 70){
      return "2.png";
    }else if(porcentaje == 80 || porcentaje == 90){
      return "3.png";
    }else if(porcentaje == 100){
      return "4.png";
  }
};
