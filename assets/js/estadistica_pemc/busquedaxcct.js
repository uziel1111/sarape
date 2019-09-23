$("#busqueda_cct_pemc").click(function(e){
  e.preventDefault();
  let cct=$("#cct_pemc").val();
  let turno=$("#turno_pemc").val();
  // console.log(cct);
  // console.log(turno);
  console.log(validadatos());
  if(validadatos()==false){
    alert("Debe seleccionar un turno y agregar una cct");
  }else{

    if(validacct()==false){
      alert("La CCT es incorrecta");
    }else{
      $.ajax({
        url : base_url+"Estadistica_pemc/busquedaxct",
        dataType : 'json',
        method : 'POST',
        data : {"cct":cct,"turno":turno},
            beforeSend: function(xhr) {
              Notification.loading("");
            },
            success: function(data){
              $("#wait").modal("hide");
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

function validadatos(){
  bandera=false;
  let cct=$("#cct_pemc").val();
  let turno=$("#turno_pemc").val();
  if(cct!=""){
    if(turno!="Seleccione un turno"){
      bandera=true;
    }
  }

  return bandera;
}