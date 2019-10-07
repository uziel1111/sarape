<section class="main-area">
<div class="container">

  <div class="card mb-3 card-style-1">
    <div class="card-header card-1-header bg-light">Estadísticas por escuela</div>
    <div class="card-body">
  <?php if(isset($tipou_pemc)){?>
    <input type="text" name="tipou_pemc2" id="tipou_pemc2" hidden> 
  <?php }else{?>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <center>
          <?= anchor('estadistica', 'Regrese a la búsqueda', 'class="btn btn-warning btn-style-1 color-6 mb-3"') ?> <br>
          Conozca los datos de matrícula, maestros y desempeño de cada escuela haciendo clic en su CCT
        </center>
      </div>
    </div>
  <?php }?>

  <div class="row">
    <div class="col-12 col-sm-12 mt-3">
      <?php
        $mensaje = '';
      ?>
      <center><?= $total_escuelas ?> escuelas encontradas del municipio: <?= $municipio ?>, nivel: <?= $nivel ?> y sotenimiento: <?= $sostenimiento ?></center>
    </div><!-- col-md-5 -->
  </div>

  <?php
  if(isset($tipou_pemc)){

  }else{ ?>
  <div class="alert alert-primary flex-center mt-3" role="alert">
  <div class="row flex-center">
    <div class="col-9 col-sm-9 col-md-10 col-lg-10 mt-2">
      <div class="form-group form-group-style-1">
          <?= form_open('estadistica/escuelas') ?>
          <?= form_hidden('slc_busquedalista_municipio', $cve_municipio) ?>
          <?= form_hidden('slc_busquedalista_nivel', $cve_nivel) ?>
          <?= form_hidden('slc_busquedalista_sostenimiento', $cve_sostenimiento) ?>

          <?= form_hidden('hidden_municipio', $municipio) ?>
          <?= form_hidden('hidden_nivel', $nivel) ?>
          <?= form_hidden('hidden_sostenimiento', $sostenimiento) ?>
          <?= form_input('itxt_busquedalista_nombreescuela', $nombre_escuela, array('id' => 'itxt_busquedalista_nombreescuela', 'class'=>'form-control',
                                                                                    'placeholder'=>'Use este campo para buscar una escuela dentro de la tabla de resultados, ingrese parte del nombre de la escuela' )) ?>

        </div>
        </div>
        <div class="col-3 col-sm-3 col-md-1 col-lg-1 mt-2">
          <?php
          $data = array(
              'name' => '',
              'id' => '',
              'value' => 'true',
              'type' => 'submit',
              'class'=>'btn btn-info btn-style-1 btn-block',
              'content' => '<i class="fa fa-search"></i>',
              'data-toggle' => "tooltip",
              'data-placement' => "top",
              'title' => ''
          );
          echo form_button($data);
          ?>
          <?= form_close() ?>

        </div><!-- col-md-1 -->
        <?php }?>

        <div class="col-12 col-sm-12 col-md-1 col-lg-1 mt-2">
          <?= form_open('Report/por_escuela') ?>
          <?= form_hidden('slc_busquedalista_municipio_reporte', $cve_municipio) ?>
          <?= form_hidden('slc_busquedalista_nivel_reporte', $cve_nivel) ?>
          <?= form_hidden('slc_busquedalista_sostenimiento_reporte', $cve_sostenimiento) ?>
          <?= form_hidden('itxt_busquedalista_nombreescuela_reporte', $nombre_escuela, array('id' => 'itxt_busquedalista_nombreescuela_reporte')) ?>
          <?php
            if(isset($tipou_pemc)){

            }else{
              $data = array(
                'name' => 'btn_busquedaxlista_xlsx',
                'id' => 'btn_busquedaxlista_xlsx',
                'value' => 'true',
                'type' => 'submit',
                'class'=>'btn btn-primary btn-style-1 btn-block',
                'content' => '<i class="fas fa-file-excel"></i>',
                'data-toggle' => "tooltip",
                'data-placement' => "top",
                'title' => 'Exportar los resultados'
              );
              echo form_button($data);
            }
          ?>
          <?= form_close() ?>
        </div><!-- col-md-1 -->
      </div><!-- row -->
  </div><!-- row -->
<div class="row mt-3">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
      <div id="table_escuelas">
      <div class="table-responsive">
      <table class="table table-style-1 table-striped table-hover">
        <thead class="bg-info">
          <tr>
            <th scope="col">CCT</th>
            <th scope="col">Turno</th>
            <th scope="col">Nombre</th>
            <th scope="col">Nivel</th>
            <th scope="col">Municipio</th>
            <th scope="col">Localidad</th>
            <th scope="col">Domicilio</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($arr_escuelas as $escuela) { ?>
            <tr data-idescuela="<?= $escuela['id_cct'] ?>" data-cve_centro="<?= $escuela['cve_centro'] ?>" data-turno_single="<?= $escuela['turno_single'] ?>">
              <td>
                <?= $escuela['cve_centro'] ?>
              </td>
              <td ><?= $escuela['turno_single'] ?></td>
              <td><?= $escuela['nombre_centro'] ?></td>
              <td><?= $escuela['nivel'] ?></td>
              <td><?= $escuela['municipio'] ?></td>
              <td><?= $escuela['localidad'] ?></td>
              <td><?= $escuela['domicilio'] ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div><!-- table-responsive -->
    </div>
  </div><!-- col-12 -->
  </div><!-- row -->
</div>
</div>
</div><!-- container-fluid -->
</section>

<script src="<?= base_url('assets/js/busquedaxlista/escuelas.js') ?>"></script>


<script type="text/javascript">
  $("#itxt_busquedalista_nombreescuela").keyup(function() {
    $("#itxt_busquedalista_nombreescuela_reporte").val($(this).val());
  });

  $(document).on("click", "#table_escuelas tbody tr", function(e) {
    if($("#tipou_pemc2").length){
      $("#div_busxcct").collapse('hide');
      $("#div_busxcct_pemc").collapse('hide');
      
      let idescuela = $(this).data('idescuela');
      let cct = $(this).data('cve_centro');
      let turno = $(this).data('turno_single');
      // console.log(idescuela);
      // console.log(cct);
      // console.log(turno);
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
          $("#div_busxcct_pemc").empty();
          $("#div_busxcct_pemc").append(data.vista);  
        },
        error: function(error){
          $("#wait").modal("hide");
          console.log(error);
        }
      });

    }else{

      var idescuela = $(this).data('idescuela');
      var form = document.createElement("form");
      var element1 = document.createElement("input");

      element1.type = "hidden";
      element1.name="id_cct";
      element1.value = idescuela;
      form.name = "form_escuelas_getinfo";
      form.id = "form_escuelas_getinfo";
      form.method = "POST";
      // form.target = "_self";
      form.action = base_url+"info/index/";

      document.body.appendChild(form);
      form.appendChild(element1);
      form.submit();
    }
});
</script>
