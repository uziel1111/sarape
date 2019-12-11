$("#filtros_busqueda").collapse('show');
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


