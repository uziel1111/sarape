$("#itxt_busquedalista_nombreescuela").keyup(function() {
    $("#itxt_busquedalista_nombreescuela_reporte").val($(this).val());
  });

  $(document).on("click", "#table_escuelas tbody tr", function(e) {
    e.preventDefault();
    if($("#tipou_pemc2").length){
      
      let cct = $(this).data('cve_centro');
      let turno = $(this).data('turno_single');
      var turno_single = $(this).data('turno_single');

      $.ajax({
        url : base_url+"Estadistica_pemc/busquedaxct",
        dataType : 'json',
        method : 'POST',
        data : {"cct":cct,"turno":turno,"turno_single":turno_single},
        beforeSend: function(xhr) {
          Notification.loading("");
        })
        .done(function(data){
          $("#wait").modal("hide");
          $("#filtros_busqueda").collapse('hide');
          $("#div_busxcct_pemc").empty();
          $("#div_busxcct_pemc").append(data.vista);  
        })
        .fail(function(error){
          $("#wait").modal("hide");
          console.log(error);
        })
        .always(function() {
            swal.close();
        });

    }else{

      var cct = $(this).data('cve_centro');
      var turno = $(this).data('turno');
      var turno_single = $(this).data('turno_single');
      var form = document.createElement("form");
      var element1 = document.createElement("input");
      var element2 = document.createElement("input");
      var element3 = document.createElement("input");

      element1.type = "hidden";
      element1.name="id_cct";
      element1.value = cct;

      element2.type = "hidden";
      element2.name="turno";
      element2.value = turno;

      element3.type = "hidden";
      element3.name="turno_single";
      element3.value = turno_single;

      form.name = "form_escuelas_getinfo";
      form.id = "form_escuelas_getinfo";
      form.method = "POST";

      form.action = base_url+"info/index/";

      document.body.appendChild(form);
      form.appendChild(element1);
      form.appendChild(element2);
      form.appendChild(element3);
      form.submit();
    }
});