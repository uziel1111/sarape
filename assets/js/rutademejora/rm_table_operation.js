$(document).ready(function () {
   obj = new Tabla();
   obj.get_view();
   obj.recomendacion();
   // obj.inicio()
});


function Tabla(){
   _this = this;
   id_tprioritario = 0;
}


 // Tabla.prototype.inicio = function(){
 //      drag = null;
 //      drag = new Drag();
 //      $("#id_tbody_demo").css( 'cursor', 'pointer' );
 //      $("#id_tbody_demo").sortable({
 //        start: function( event, ui ) {
 //          var vector = drag.all_rows('id_tabla_rutas');
 //          drag.remove_empty(vector)
 //        },
 //         stop: function( event, ui ) {
 //            var vector2 = drag.all_rows('id_tabla_rutas');
 //            drag.sort(vector2, 1);
 //            obj.update_order(vector2);
 //         }
 //      });
 //  };

  Tabla.prototype.get_view = function(){
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

  // Tabla.prototype.update_order = function(datos){
  //  $.ajax({
  //          url:base_url+"rutademejora/update_order",
  //          method:"POST",
  //          data:{"orden":datos},
  //          success:function(data){
  //            var tabla = data.tabla;
  //            $("#contenedor_tabla").empty();
  //            $("#contenedor_tabla").append(tabla);
  //            // obj.inicio();
  //            obj.funcionalidadselect();
  //          },
  //          error: function(error){
  //            console.log(error);
  //          }
  //      });
  // };

  Tabla.prototype.funcionalidadselect = function(){
    $("#id_tabla_rutas tr").click(function(){
       $(this).addClass('selected').siblings().removeClass('selected');
       var value = $(this).find('td:first').text();
       var val2 = $(this).find('td:first').next().text();
       var val3 = $(this).find('td:first').next().next().text();
       var val4 = $(this).find('td:first').next().next().next().next().text();
       var textotp = $(this).find('td:first').next().next().next().text();

       obj.id_tprioritario = value;
       obj.id_prioridad = val2;
       obj.id_subprioridad = val3;
       obj.accion = val4;
       obj.txttp = textotp;

       id_tprioritario = 0;
    });
  }

  Tabla.prototype.recomendacion = function(){
  var ruta = base_url + 'Rutademejora/modal_recomendacion'
  $.ajax({
    url:ruta,
    data: { },
    // beforeSend: function(xhr) {
    //     Notification.loading("");
    // }
  })
  .done(function(data){
    $("#div_generico").empty();
    $("#div_generico").append(data.strView);
    $('h5').empty();
    $('h5').append(data.titulo);

    $("#myModal").modal("show");

  })
  .fail(function(e) {
    console.error("Error in ()"); console.table(e);
  })
  .always(function() {
    swal.close();
  });
}

  $('#img_objetivo').click(function() {

    swal(
        "Seleccione una línea de acción",
        "Es necesario seleccionar una línea de acción",
        "info"
      );
       
       location.reload();

  })

   $('#img_actividad').click(function() {

    swal(
        "Seleccione una línea de acción",
        "Es necesario seleccionar una línea de acción",
        "info"
      );
       
       location.reload();

  })

    $('#img_avances').click(function() {
      $('#nav-avances').addClass('active');
      $('#nav-avances').addClass('show');
      $('#nav-ayuda').removeClass('active');
      $('#nav-ayuda').removeClass('show'); 
      $('#nav-ruta').removeClass('active');
      $('#nav-ruta').removeClass('show'); 
      $('#nav-ayuda').attr('aria-selected',false); 
      $('#nav-avances').attr('aria-selected',true); 

  })
