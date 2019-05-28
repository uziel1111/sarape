$(function() {
    obj_acciones = new VAcciones();
    id_accion_sup = 0;
    obj_acciones.funcionalidadselect();
});

$("#cerrar_modal_acciones_super").click(function(){
  $('#modal_visor_acciones_id').modal('toggle');
});


$("#id_btn_inspeccionar_accion").click(function(){
	if (id_accion_sup === undefined || id_accion_sup == 0) {
	    swal(
	        '¡Error!',
	        "Selecciona una acción",
	        "error"
	      );
	  }
	  else {
	  	$.ajax({
		    url: base_url+'rutademejora/edit_accion_super',
		    type: 'POST',
		    dataType: 'JSON',
		    data: {"id_tprioritario":id_tprioritario_sup, "idaccion":id_accion_sup, "cct": cct_escuela_log},
		    beforeSend: function(xhr) {
		          Notification.loading("");
		      },
		  })
		  .done(function(data) {
		    swal.close();
		    var editado = data.editado;
            $("#slc_rm_ambito").val(editado['id_ambito']);
            $("#slc_rm_ambito").selectpicker("refresh");
            $("#txt_rm_meta").val(editado['accion']);
            $("#txt_rm_obs").val(editado['mat_insumos']);
            $("#slc_rm_presp").val(editado['ids_responsables']);
            $("#txt_rm_sup_personal").val(data.personal);

            var ids = editado['ids_responsables'].split(',');
            for(var i = 0; i < ids.length; i++){
                if(ids[i] == 0){
                    $('#otro_responsable').val(editado['otro_responsable']);
                    $("#div_otro_responsable").show();
                }
            }

            $("#txt_rm_indimed").val(editado['indcrs_medicion']);
             var inicio = editado['accion_f_inicio'].split("-");
             var fin = editado['accion_f_termino'].split("-");
            $("#datepicker1").val(inicio[1]+"/"+inicio[2]+"/"+inicio[0]);
            $("#datepicker2").val(fin[1]+"/"+fin[2]+"/"+fin[0]);
            $('#btn_editando_accion').show();
            $('#btn_agregar_accion').hide();
		  })
		  .fail(function(e) {
		    console.error("Al bajar la informacion"); console.table(e);
		  })
		  .always(function() {
		        swal.close();
		  });
	  }
});

function VAcciones(){
  _this = this;
}

VAcciones.prototype.funcionalidadselect = function(){
    $("#idtabla_accionestp_super tr").click(function(){
       $(this).addClass('selected').siblings().removeClass('selected');
       var value=$(this).find('td:first').text();
       if(value != ""){
       	id_accion_sup = value;
       }else{
       	id_accion_sup = 0;
       }
    });
}