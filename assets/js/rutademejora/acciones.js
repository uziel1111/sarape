$(function() {
  Rm_acciones_tp.id_accion_select = undefined;
  obj_rm_acciones_tp = new Rm_acciones_tp();
  $("#div_otro_responsable").hide();
    $('#btn_editando_accion').hide();
    sel_encargado = false;
    $('#main_resp_2').attr('hidden', true)

    obj.get_view();

  });

$("#cerrar_modal_acciones").click(function(){
  Rm_acciones_tp.id_accion_select = undefined;
  $('#btn_editando_accion').hide();
  $('#btn_agregar_accion').show();
  obj_rm_acciones_tp.limpia_camposform();
  $('#exampleModalacciones').modal('toggle');
  obj.get_view();
  $('#id_objetivos').removeAttr('disabled');
});

$('#saliract').click(function(){
  obj_rm_acciones_tp.limpia_camposform();
  $('#exampleModalacciones').modal('toggle');
  obj_rm_acciones_tp.get_view();
  $('#id_objetivos').removeAttr('disabled');
  $('#btn_editando_accion').hide();
  $('#btn_agregar_accion').show();
})

$("#btn_rutamejora_acciones").click(function(){
  if (obj.id_tprioritario === undefined) {
    swal(
      '¡Error!',
      "Favor de seleccionar una línea de acción",
      "error"
      );
  }
  else {
    obj_rm_acciones_tp.get_view_acciones(obj.id_tprioritario);
    //llamado a la vista de acciones
  }
});

$("#btn_agregar_accion").click(function(){
  obj_rm_acciones_tp.validaform(1);
});

$("#id_btn_elimina_accion").click(function(){
  if(Rm_acciones_tp.id_accion_select === undefined){
    swal(
      '¡Error!',
      "Favor de seleccionar una acción para eliminar ",
      "error"
      );
  }else{
    swal({
      title: '¿Estás seguro de eliminar esta acción?',
      text: "Una vez eliminado no se podrá recuperar",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.value) {
        obj_rm_acciones_tp.delete_accion(Rm_acciones_tp.id_accion_select, Rm_acciones_tp.id_accion_select1);
      }
    })
  }
});

$("#id_btn_edita_accion").click(function() {
  if(Rm_acciones_tp.id_accion_select == undefined){
    swal(
      '¡Error!',
      "Favor de seleccionar una acción para editar ",
      "error"
      );
  }else{
    obj_rm_acciones_tp.edit_accion(Rm_acciones_tp.id_accion_select, Rm_acciones_tp.id_accion_select1);
  }
});

$("#btn_editando_accion").click(function(){
 if (obj_rm_acciones_tp.validaform(0)) {
    obj_rm_acciones_tp.editar_accion()
} 

});

$("#slc_responsables").change(function(){
  sel_encargado = true;
  var texto="";
  $("#slc_responsables option:selected").each(function() {
    texto += $(this).val() + ",";
  });
  encargados = texto.split(",");
  var i = encargados.indexOf("Otros");
  encargados.splice( i, 1 );
   
   if( texto.indexOf("0,") > -1){
    $("#div_otro_responsable").show();
     
   }else{
    $("#div_otro_responsable").hide();
      
    }
  });

//Responsable principal
$('#main_responsable').change(function(){
  if ( $('#main_responsable').val() == '0' ) {
    $('#main_resp_2').attr('hidden', false)
  } else {
    $('#main_resp_2').attr('hidden', true)
  }
})



function Rm_acciones_tp(){
  _thisrm_delete_tp = this;
  id_accion_select = 0;
}


Rm_acciones_tp.prototype.get_view_acciones = function(id_tprioritario){
  $('#tmp_tprioritario').val(id_tprioritario)
  $.ajax({
   url:base_url+"rutademejora/get_table_acciones",
   method:"POST",
   data:{ "id_tprioritario":id_tprioritario },
   success:function(data){
     var vista = data.tabla;
             if (data.datos['prioridad'] == 'EQUIPAMIENTO E INFRAESTRUCTURA DE ALTA CALIDAD') {
              lae = 'LAE-1 ' + data.datos['prioridad'];
            }
            if (data.datos['prioridad'] == 'ASEGURAR ALTOS ÍNDICES DE APRENDIZAJES A TODA LA POBLACIÓN EDUCATIVA') {
              lae = 'LAE-2 ' + data.datos['prioridad'];
            }
            if (data.datos['prioridad'] == 'CONTAR CON PERSONAL COMPETITIVO A NIVEL INTERNACIONAL') {
              lae = 'LAE-3 ' + data.datos['prioridad'];
            }
            if (data.datos['prioridad'] == 'GENERAR AMBIENTES DE COLABORACIÓN Y CORRESPONSABILIDAD CON LOS PADRES DE FAMILIA') {
              lae = 'LAE-4 ' + data.datos['prioridad'];
            }
            if (data.datos['prioridad'] == 'CONSOLIDAR EL LIDERAZGO DE DIRECTIVOS Y DOCENTES') {
              lae = 'LAE-5 ' + data.datos['prioridad'];
            }
            $('h5').empty();
            $('h5').append(lae);
            $("#label_escuela").text(data.datos['escuela']);
            $("#label_ambito").text(data.datos['ambito']);
            $("#label_prioridad").text(data.datos['prioridad']);
            $("#label_problematica").text(data.datos['problematicas'].toString().replace(/\./g,', '));
            $("#label_evidencia").text(data.datos['evidencias']);
            $("#id_objetivos").empty();
            $("#id_objetivos").append(data.stroption);
            getAccxObj();
             obj_rm_acciones_tp.iniciatabla();
           },
           error: function(error){
             console.log(error);
           }
         });

       $("#exampleModalacciones").modal('show');
     };


     Rm_acciones_tp.prototype.save_accion = function(){
      var accion = $("#txt_rm_meta").val();
      var materiales = $("#txt_rm_obs").val();
      var id_responsable = $("#slc_rm_presp").val();
      var finicio = $("#datepicker1").val();
      var ffin = $("#datepicker2").val();
      var medicion = $("#txt_rm_indimed").val();
      var objetivo =$("#id_objetivos").val();
      var responsable = $('#main_responsable').val();
      $.ajax({
       url:base_url+"rutademejora/save_accion",
       method:"POST",
       data:{"accion":accion, "materiales":materiales, "ids_responsables":encargados,
       "finicio":finicio, "ffin":ffin, "medicion":medicion, 'id_tprioritario': obj.id_tprioritario, 'otroresp': $("#otro_responsable").val(), 'id_objetivo':objetivo, 'responsable':responsable
     },
     success:function(data){
       var vista = data.tabla;
       $("#contenedor_acciones_id").empty();
       $("#contenedor_acciones_id").append(vista);
       obj_rm_acciones_tp.iniciatabla();
       obj_rm_acciones_tp.limpia_camposform();

             $('#id_objetivos').val(objetivo);
             getAccxObj();


           },
           error: function(error){
             console.log(error);
           }
         });
    };

    Rm_acciones_tp.prototype.limpia_camposform = function(){
      $("#txt_rm_meta").val("");
      $("#txt_rm_obs").val("");
      $("#datepicker1").val("");
      $("#datepicker2").val("");
      $("#otro_responsable").val("");
      $("#otro_resp").val("");
      $("#txt_rm_indimed").val("");
  $("#div_otro_responsable").hide();
  $("#slc_rm_ambito").val("");
  $("#slc_rm_ambito").selectpicker("refresh");
  $("#slc_responsables").selectpicker('deselectAll');
  $('#main_responsable').val("");
  $('#main_responsable').selectpicker("refresh");
}

Rm_acciones_tp.prototype.editar_accion = function(){
   var id_ambito = $("#slc_rm_ambito").val();
   var accion = $("#txt_rm_meta").val();
   var materiales = $("#txt_rm_obs").val();
   var id_responsable = $("#slc_rm_presp").val();
   var finicio = $("#datepicker1").val();
   var ffin = $("#datepicker2").val();
   var medicion = $("#txt_rm_indimed").val();
   var id_objetivo = $("#id_objetivos").val();
   var id_accion = $('#idaccion').val();


  $.ajax({
   url:base_url+"rutademejora/save_accion",
   method:"POST",
   data:{
     "id_accion": id_accion, "accion":accion, "materiales":materiales,
     "ids_responsables":encargados, "finicio":finicio, "ffin":ffin, "medicion":medicion,
     'id_tprioritario': obj.id_tprioritario,
     'otroresp': $("#otro_responsable").val(),
     'id_objetivo': id_objetivo,
     'responsable': $('#main_responsable').val(),
     'new_resp': $('#new_resp').val()
   },
   success:function(data){
     var vista = data.tabla;
     $("#contenedor_acciones_id").empty();
     $("#contenedor_acciones_id").append(vista);
             obj_rm_acciones_tp.iniciatabla();
             obj_rm_acciones_tp.limpia_camposform();
             $('#btn_editando_accion').hide();
             $('#btn_agregar_accion').show();
             $('#id_objetivos').val(id_objetivo);

             $('#id_objetivos').attr('disabled', false);
             $('#idaccion').val('');

           },
           error: function(error){
             console.log(error);
           }
         });
};

Rm_acciones_tp.prototype.iniciatabla = function(){
  $("#idtabla_accionestp tr").click(function(){
   $(this).addClass('selected').siblings().removeClass('selected');
   var value=$(this).find('td:first').text();
   var value1=$(this).find('td:nth-child(2)').text();
     Rm_acciones_tp.id_accion_select = value;
     Rm_acciones_tp.id_accion_select1 = value1;
     $('#idaccion').val(value);
   });
}

Rm_acciones_tp.prototype.delete_accion = function(idaccion, idtprioriario){
  id_objetivo = $("#id_objetivos").val();
  $.ajax({
   url:base_url+"rutademejora/delete_accion",
   method:"POST",
   data:{"idaccion":idaccion, 'id_tprioritario': idtprioriario},
   success:function(data){
    if(data.mensaje == 'ok'){
      swal(
        '¡Correcto!',
        "La acción se elimino correctamente",
        "success"
        );
               var vista = data.tabla;
               getAccxObj();
             }else{
              swal(
                '¡Error!',
                "La operación no se pudo completar intente nuevamente",
                "error"
                );
            }
            var vista = data.tabla;
            $("#contenedor_acciones_id").empty();
            $("#contenedor_acciones_id").append(vista);
            obj_rm_acciones_tp.iniciatabla();
          },
          error: function(error){
           console.log(error);
         }
       });
  Rm_acciones_tp.id_accion_select = undefined;
};

Rm_acciones_tp.prototype.edit_accion = function(idaccion, id_tprioritario){
 let id_objetivo = $('#id_objetivos').val();

 $.ajax({
   url:base_url+"rutademejora/edit_accion",
   method:"POST",
   data:{"idaccion":idaccion, 'id_tprioritario': id_tprioritario},
   success:function(data){
    var editado = data.editado;
            $("#txt_rm_meta").val(editado['accion']);
            $("#txt_rm_obs").val(editado['mat_insumos']);
            $("#slc_rm_presp").val(editado['ids_responsables']);
            $("#slc_responsables").selectpicker('val', editado['ids_responsables'].split(','));
            $("#id_objetivos").val(id_objetivo);
            $('#id_objetivos').attr('disabled', true);
             $('#main_responsable').val(editado['main_resp']);
             $("#main_responsable").selectpicker('val', editado['main_resp']);
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
          },
          error: function(error){
           console.log(error);
         }
       });
 Rm_acciones_tp.id_accion_select = undefined;
};

Rm_acciones_tp.prototype.validaform = function(llamado){
 if ($("#id_objetivos").val() > 0) {
  if($("#txt_rm_meta").val() != ""){
    if($("#txt_rm_obs").val() != ""){
      if($("#slc_rm_ambito").val() != ""){
        if(sel_encargado == true){
          if($("#datepicker1").val() != ""){
            if($("#datepicker2").val() != ""){
              if($('#otro_responsable').is(':visible')  && $("#otro_responsable").val() != ""){
                if(date_diff_indays() >= 0){
                  if (llamado != 0) {
                    obj_rm_acciones_tp.save_accion();
                  }else{
                    return true;
                  }
                }else{
                  swal(
                    '¡Error!',
                    "La fecha de termino no puede ser menor a la fecha de inicio",
                    'danger'
                    );
                  return false
                }

              }else{
                if($('#otro_responsable').is(':visible')  && $("#otro_responsable").val() == ""){
                  swal(
                    '¡Error!',
                    "Introduzca nombre del otro responsable",
                    'danger'
                    );
                }else{
                      if(date_diff_indays() >= 0){
                        if (llamado != 0) {
                          obj_rm_acciones_tp.save_accion();
                        }else{
                          return true;
                        }
                      }else{
                        swal(
                          '¡Error!',
                          "La fecha de termino no puede ser menor a la fecha de inicio",
                          'danger'
                          );
                      }
                    return false;
                  }
                }
              }else{
                swal(
                  '¡Error!',
                  "Introduzca fecha de termino",
                  'danger'
                  );
                return false;
              }
            }else{
              swal(
                '¡Error!',
                "Introduzca fecha de inicio",
                'danger'
                );
              return false;
            }
          }else{
            swal(
              '¡Error!',
              "Seleccione un encargado",
              'danger'
              );
            return false;
          }
        }else{
          swal(
            '¡Error!',
            "Seleccione ambito",
            'danger'
            );
          return false;
        }
      }else{
        swal(
          '¡Error!',
          "Introduzca recursos",
          'danger'
          );
        return false;
      }
    }else{
      swal(
        '¡Error!',
        "Introduzca acción ",
        'danger'
        );
      return false;
    }
  }else{
    swal(
      '¡Error!',
      "Seleccione un objetivo",
      'danger'
      );
    return false;
  }

}


var date_diff_indays = function() {
  var date1 = $("#datepicker1").val(); //10/25/2018
  var date2 = $("#datepicker2").val(); //01/01/2019
  dt1 = new Date(date1);
  dt2 = new Date(date2);
  return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
}

//Nuevas funciones grid objetivo
$('#id_objetivos').change(function(){
  getAccxObj();
});
function getAccxObj(){


  let id_objetivo = $('#id_objetivos').val()

  if ( id_objetivo != undefined ) {
    $.ajax({
      url: base_url+"rutademejora/getAccxObj",
      type: 'POST',
      dataType: 'JSON',
      data: { id_objetivo: id_objetivo },
      success:function(data){
        var vista = data.tabla;
        $("#contenedor_acciones_id").empty();
        $("#contenedor_acciones_id").append(vista);
        obj_rm_acciones_tp.iniciatabla();
      },
    })
  }

  $("#exampleModalacciones").modal('show');
}

function getTablaAccxObj(id_objetivo){
  $.ajax({
    url: base_url+"rutademejora/getTablaAccxObj/"+id_objetivo,
    type: 'POST',
    dataType: 'JSON',
    data: { },
    success:function(data){
      var vista = data.tabla;

      $("#contenedor_acciones_id").append(vista);
      $("#contenedor_acciones_id").empty();
      obj_rm_acciones_tp.iniciatabla();
    }
  })
}


//Grid Principal
Rm_acciones_tp.prototype.get_view = function(){
  $.ajax({
    url: base_url+"Rutademejora/bajarutamejora",
    data : "",
    type : 'POST',
    beforeSend: function(xhr) {
      $("#wait").modal("show");
    },
    success: function(data){
      $("#wait").modal("hide");
      var view = data.tabla;
      $("#contenedor_tabla").empty();
      $("#contenedor_tabla").append(view);
      // obj.inicio();
      obj.funcionalidadselect();
      if(data.tamanio == 0){
        $("#btn_get_reporte").hide();
      }else{
        $("#btn_get_reporte").show();
      }
    },
    error: function(error){console.log("Falló:: "+JSON.stringify(error)); }
  });
  obj.id_tprioritario = undefined
}

