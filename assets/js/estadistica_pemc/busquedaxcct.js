// $("#busqueda_cct_pemc").click(function(e){
//   e.preventDefault();
//   let cct=$("#cct_pemc").val();
//   let turno=$("#turno_pemc").val();

//   if(validadatos()==false){
//     alert("Debe seleccionar un turno y agregar una cct");
//   }else{

//     if(validacct()==false){
//       alert("La CCT es incorrecta");
//     }else{
//       $.ajax({
//         url : base_url+"Estadistica_pemc/busquedaxct",
//         dataType : 'json',
//         method : 'POST',
//         data : {"cct":cct,"turno":turno},
//             beforeSend: function(xhr) {
//               Notification.loading("");
//             },
//             success: function(data){
//               $("#wait").modal("hide");
//               $("#div_busxcct").empty();
//               $("#div_busxcct").append(data.vista);  
//             },
//             error: function(error){
//               $("#wait").modal("hide");
//               console.log(error);
//             }
//       });
//     }
//   }
// });

// function validacct(){
//   bandera=false;
//   if($("#cct_pemc").val().length==8){
//       let obj_re = new Regularexpression();
//       let valid = obj_re.cct($("#cct_pemc").val());
//       if(valid){
//         bandera=true;
//       }
//   }
//   else if ($("#cct_pemc").val().length>8) {
//     bandera=false;
//   }

//   return bandera;
// }

// function validadatos(){
//   bandera=false;
//   let cct=$("#cct_pemc").val();
//   let turno=$("#turno_pemc").val();
//   if(cct!=""){
//     if(turno!="Seleccione un turno"){
//       bandera=true;
//     }
//   }

//   return bandera;
// }

$("#busqueda_cct_pemc").click(function(e){
  e.preventDefault();
  let cve_municipio=$("#id_municipio").val();
  let cve_nivel=$("#id_nivel").val();
  let cve_sostenimiento=$("#id_sostenimiento").val();
  let nombre_escuela=$("#nombreescuela_pemc").val();
  let municipio = $('#municipio_pemc').val();
  let nivel = $('#nivel_pemc').val();
  let sostenimiento = $('#sostenimiento_pemc').val();

  $.ajax({
    url : base_url+"Estadistica_pemc/escuelas_xmunicipio",
    dataType : 'json',
    method : 'POST',
    data : {"cve_municipio":cve_municipio,"cve_nivel":cve_nivel,"cve_sostenimiento":cve_sostenimiento,
            "nombre_escuela":nombre_escuela,"municipio":municipio,"nivel":nivel,"sostenimiento":sostenimiento},
    beforeSend: function(xhr) {
      Notification.loading("");
    },
    success: function(data){
      swal.close();
      $("#div_busxcct").empty();
      $("#div_busxcct").append(data.vista);
      $("#div_busxcct_pemc").empty();  
    },
    error: function(error){
      swal.close();
      console.log(error);
    }
  });
});

// $("#busqueda_cct_pemc").click(function(e){
//   e.preventDefault();
//   $.ajax({
//     url : base_url+"Estadistica_pemc/busquedaxct",
//     dataType : 'json',
//     method : 'POST',
//     data : {"cct":cct,"turno":turno},
//     beforeSend: function(xhr) {
//       Notification.loading("");
//     },
//     success: function(data){
//       $("#wait").modal("hide");
//       $("#div_busxcct").empty();
//       $("#div_busxcct").append(data.vista);  
//     },
//     error: function(error){
//       $("#wait").modal("hide");
//       console.log(error);
//     }
//   });
// });

