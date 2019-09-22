// $("#cct_pemc").keyup(function() {
//   if($(this).val().length==8){
//       let obj_re = new Regularexpression();
//       let valid = obj_re.cct(this.value);
//       if(valid){
        
//       }
//   }
//   else if ($(this).val().length>8) {
//     alert('longitud incorrecta');
//     this.value = this.value.substring(0, this.value.length - 1);
//   }
// });


$("#busqueda_cct_pemc").click(function(e){
  e.preventDefault();
  let cct=$("#cct_pemc").val();
  let turno=$("#turno_pemc").val();
  if(cct=="" && turno=="Seleccione Turno"){
    alert("Debe seleccionar un turno y agregar una cct");
  }else{
    console.log(validacct());
    if(validacct()==false){
      alert("La CCT es incorrecta");
    }else{
      $.ajax({
        url : base_url+"Estadistica_pemc/busquedaxct",
        dataType : 'json',
        method : 'POST',
        data : {"cct":cct,"turno":turno},
           beforeSend: function(xhr) {
              $("#wait").modal("show");
            },
           success: function(data){
            $("#wait").modal("hide");
            // console.log(data.vista);
            $("#div_busxcct").empty();
            $("#div_busxcct").append(data.vista);  
          },
        error: function(error){
          $("#wait").modal("hide");
          console.log(error);
        }
      });
    }
  }
});

function validacct(){
  bandera=false;
  if($("#cct_pemc").val().length==8){
      let obj_re = new Regularexpression();
      let valid = obj_re.cct($("#cct_pemc").val());
      if(valid){
        bandera=true;
      }
  }
  else if ($("#cct_pemc").val().length>8) {
    bandera=false;
  }

  return bandera;
}