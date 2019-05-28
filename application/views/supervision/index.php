<section class="main-area">
  <div class="container">
    <div class="card mb-3 card-style-1">
    <div class="card-header card-1-header bg-light">Supervisión escolar</div>
    <div class="card-body">
      <p>La supervisión escolar es un componente de vital importancia, ya que es la instancia sobre la que descansa el reto de lograr que las escuelas cumplan con los objetivos de atender a todos los niños y jóvenes; crear las condiciones para que concluyan al menos la educación media superior; y asegurar que todos ellos adquieran al menos las competencias básicas que establecen los planes y programas.</p>
      <p>Con la finalidad de apoyar el desempeño y fortalecimiento de las y los Supervisores Escolares, se ha creado este espacio en el cual podrán encontrar información sobre los siguientes temas:</p>
      <div class="row">
        <div class="col-md-12 col-lg-12">
        <input type="button" class="btn btn-primary btn-lg btn-block" id="btn_super_trayecto" value="Trayecto formativo para supervisores escolares">
        <input type="button" class="btn btn-primary btn-lg btn-block" id="btn_super_mundo" value='Bibliografía sobre "La supervisión escolar en el mundo"'>
        <input type="button" class="btn btn-primary btn-lg btn-block" id="btn_super_cte" value="Consejos Técnicos Escolares (CTE)">
      </div>
      </div>
    </div>
  </div>
  </div>
</section>
<script type="text/javascript">
$("#btn_super_trayecto").click(function(e){
  e.preventDefault();
  var ruta = base_url+"Supervisor/gettrayectoformativo";
  $.ajax({
    url: ruta,
    method: 'POST',
    data: { 'folder':1, 'file':1 },
    beforeSend: function(xhr) {
      Notification.loading("");
    }
  })
  .done(function( data ) {
    $("#div_generico").empty();
    $("#div_generico").append(data.strView);
    $("#modal_trayectoformativo").modal("show");
  })
  .fail(function(e) {
    console.error("Error in ()"); console.table(e);
  })
  .always(function() {
    swal.close();
  });

});

$("#btn_super_mundo").click(function(e){
  e.preventDefault();
  var ruta = base_url+"Supervisor/getsuperenmundo";
  $.ajax({
    url: ruta,
    method: 'POST',
    data: { 'folder':1, 'file':1 },
    beforeSend: function(xhr) {
      Notification.loading("");
    }
  })
  .done(function( data ) {
    $("#div_generico").empty();
    $("#div_generico").append(data.strView);
    $("#modal_superenmundo").modal("show");
  })
  .fail(function(e) {
    console.error("Error in ()"); console.table(e);
  })
  .always(function() {
    swal.close();
  });

});

$("#btn_super_cte").click(function(e){
  e.preventDefault();
  var ruta = base_url+"Supervisor/getsupercte";
  $.ajax({
    url: ruta,
    method: 'POST',
    data: { 'folder':1, 'file':1 },
    beforeSend: function(xhr) {
      Notification.loading("");
    }
  })
  .done(function( data ) {
    $("#div_generico").empty();
    $("#div_generico").append(data.strView);
    $("#modal_cte").modal("show");
  })
  .fail(function(e) {
    console.error("Error in ()"); console.table(e);
  })
  .always(function() {
    swal.close();
  });

});

</script>
