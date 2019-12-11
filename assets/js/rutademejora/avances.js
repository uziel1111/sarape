function obsercaciones_modal(id) {
 $('#myModal'+id).show();
 $('.div_observaciones'+id).removeClass('d-none');
}

function btn_observar(id) {
  var resultados = $("#txt_obs_resultados_"+id).val();
  var obstaculos = $("#txt_obs_obstaculos_"+id).val();
  var ventajas = $("#txt_obs_ventajas_"+id).val();
  var ajustes = $("#txt_obs_ajustes_"+id).val();
  var accion = $("#slc_observaciones"+id+" option:selected").val();

  $.ajax({
    url: base_url+'rutademejora/set_observacion',
    type: 'POST',
    data: {'idaccion':accion, 'resultados': resultados, 'obstaculos':obstaculos, 'ventajas':ventajas, 'ajustes': ajustes},
    success: function(data) {
      $('#myModal'+id).hide();
    }
  })
  
  $('.div_observaciones'+id).addClass('d-none');
}

$(function() {
  obj_rm_avances_acciones = new Rm_avances_acciones();
});


function Rm_avances_acciones(){
  _thisrm_avances_acciones = this;
}


Rm_avances_acciones.prototype.set_avance = function(cad_str_ids){
  var val_slc = $("#".concat(cad_str_ids)).val();
  var arr_res = cad_str_ids.split("_");
  var var_id_cte = arr_res[0];
  var var_id_cct = arr_res[1];
  var var_id_idtp = arr_res[2];
  var var_id_idacc = arr_res[3];
  var dias_restantes = arr_res[4];
  var dias_restantes_hoy = arr_res[5];
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
  if (result.estatus) {
    swal(
      '¡Correcto!',
      "Se actualizó tema prioritario correctamente",
      'success'
      );
    var base2 = base_url.split('/index.php');
    var icono = obj_rm_avances_acciones.get_icono(val_slc, dias_restantes, dias_restantes_hoy,var_id_idacc);
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
    })

};


Rm_avances_acciones.prototype.get_icono = function(porcentaje, dias_restantes, dias_restantes_hoy,var_id_idacc){

  if (dias_restantes_hoy >= 0) {
    if (dias_restantes >= dias_restantes_hoy) {
      $('#spanRestante'+var_id_idacc+'').addClass('text-warning');
      $('#spanRestante'+var_id_idacc+'').text('Quedan: '+ (dias_restantes_hoy/24) +' días restantes');
      if (porcentaje == 0) {
        return "G0.png";
      }
      if (porcentaje <= 66) {
        return "R1.png";
      }else{
        if (porcentaje >= 67 && porcentaje <= 89) {
          return "Y2.png";  
        }else{
          if (porcentaje >= 90 && porcentaje <= 99) {
            return "G3.png";
          }else{
            if (porcentaje == 100) {
              return "G4.png";
            }
          }
        }
      }
    }else{
      if ((dias_restantes * 2 )>= dias_restantes_hoy) {
        $('#spanRestante'+var_id_idacc+'').addClass('text-warning');
        $('#spanRestante'+var_id_idacc+'').text('Quedan: '+ (dias_restantes_hoy/24) +' días restantes');
        if (porcentaje == 0) {
          return "G0.png";
        }
        if (porcentaje <= 33) {
          return "R1.png";
        }else{
          if (porcentaje >= 33 && porcentaje <= 66) {
            return "Y2.png";
          }else{
            if (porcentaje >= 67 && porcentaje <= 99) {
              return "G3.png";
            }else{
              if (porcentaje == 100) {
                return "G4.png";
              }
            }
          }
        }
      }else{
        if ((dias_restantes * 3 )>= dias_restantes_hoy) {
          $('#spanRestante'+var_id_idacc+'').addClass('text-success');
          $('#spanRestante'+var_id_idacc+'').text('Quedan: '+ (dias_restantes_hoy/24) +' días restantes');
          if (porcentaje == 0) {
            return "G0.png";
          }
          if (porcentaje >= 1 && porcentaje <= 33) {
            return 'Y1.png';
          }else{
            if (porcentaje >= 34 && porcentaje <= 66) {
              return 'Y2.png';
            }else{
              if (porcentaje >= 67 && porcentaje <= 99) {
                return 'G3.png';
              }else{
                if (porcentaje == 100) {
                  return 'G4.png';
                }
              }
            }
          }
        }else{
             $('#spanRestante'+var_id_idacc+'').addClass('text-info');
            $('#spanRestante'+var_id_idacc+'').text('Quedan: '+ (dias_restantes_hoy/24) +' días restantes');
           
              return 'G0.png';
        } 
      }
    }
  }else{
    $('#spanRestante'+var_id_idacc+'').addClass('text-info');
    $('#spanRestante'+var_id_idacc+'').text('Quedan: '+ (dias_restantes_hoy/24) +' días restantes');
    return 'R0.png';
  }  
};
