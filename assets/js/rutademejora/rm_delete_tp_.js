$(function() {
    obj_rm_delete_tp = new Rm_delete_tp();
});
$("#btn_rutamejora_eliminareg").click(function(){
  if (obj.id_tprioritario === undefined) {
    swal(
        '¡Error!',
        "Selecciona un tema prioritario a eliminar ",
        "error"
      );
  }
  else {
    swal({
      title: '¿Esta seguro de eliminar el tema prioritario?',
      text: "Una vez eliminado no se podra recuperar",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.value) {
        obj_rm_delete_tp.delete_tp(obj.id_tprioritario);
      }
    })

  }
});





function Rm_delete_tp(){
  _thisrm_delete_tp = this;
}

Rm_delete_tp.prototype.delete_tp = function(id_tprioritario){
  $.ajax({
  url: base_url+'rutademejora/delete_tp',
  type: 'POST',
  dataType: 'JSON',
  data: {id_tprioritario:id_tprioritario},
  beforeSend: function(xhr) {
        Notification.loading("");
    },
  })
  .done(function(result) {
  swal.close();
  if (result.estatus) {
    obj_rm_tp.limpia_campos_tp();
    swal(
        '¡Correcto!',
        "Se eliminó el tema prioritario correctamente",
        'success'
      );
      obj.get_view();
  }
  else {
    swal(
        '¡Error!',
        "Al eliminar el tema prioritario ",
        'error'
      );
  }




  })
  .fail(function(e) {
  console.error("Error in get_datos_edith_tp()"); console.table(e);
  })
  .always(function() {
  })

};
