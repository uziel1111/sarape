<section  class="main-area">
<div class="container">
  <a href="javascript:" id="return-to-top"><span class="color-4"><i class="material-icons">keyboard_arrow_up</i></span></a>
    <div class="card mb-3 card-style-1">
  <div class="pb-1 pt-1 card-body">
    <div><?=$buscador;?> </div>
    <div id="title_bsq_est" class="card-header card-1-header bg-light"></div>
  <!-- <div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
      <center>
        <button type="button" class="btn btn-warning btn-style-1 color-6 flex-center" name="button"><?= anchor('Estadistica/estad_indi_generales', 'Regrese a la búsqueda', 'class="link-class"') ?></button>
      </center>
    </div>
  </div> -->
  <div class="dv_filtro">
  <div class="row">

    <div id="dv_flot_est" class="pt-5 col-12 col-sm-12 col-lg-12">
      <p><center>
        <?php if ($tipo_busqueda=="municipal"): ?>
          <div id="filtros_est_gen"><p style="background:#ffff00">Municipio: <?= $municipio?>, Nivel: <?= $nivel?>, Sostenimiento: <?= $sostenimiento?>, Modalidad: <?= $modalidad?>, Ciclo escolar: <?= $ciclo?>.<p>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 mt-2">
              <?= form_open('Report/est_generales_xmuni') ?>
              <?= form_hidden('id_municipio', $id_municipio) ?>
              <?= form_hidden('id_nivel', $id_nivel) ?>
              <?= form_hidden('id_sostenimiento', $id_sostenimiento) ?>
              <?= form_hidden('id_modalidad', $id_modalidad) ?>
              <?= form_hidden('id_ciclo', $id_ciclo) ?>
              <?php
              $data = array(
                  'id' => 'btn_genera_excel_est_g_xmuni',
                  'value' => 'true',
                  'type' => 'submit',
                  'class'=>'btn btn-primary btn-style-1 btn-block',
                  'content' => '<i class="fas fa-file-excel"></i>',
                  'data-toggle' => "tooltip",
                  'data-placement' => "top",
                  'title' => 'Exportar los resultados'
              );
              echo form_button($data);
              ?>
              <?= form_close() ?>
            </div><!-- col-md-1 -->
          </div>
              </center></p>
            </div>
          </div>
          </div>

          </div>
        </div>

        <div class="dv_tablas_estmuni">
          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Alumnos</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_alumnos?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Personal docente</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_pdocentes?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Infraestructura</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_infraestructura?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Indicadores de asistencia</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_in_asis?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Indicadores de permanencia</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_in_perm?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Indicadores de aprendizaje</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_planea?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Rezago educativo</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_rezag_inegi?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Analfabetismo</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_analf_inegi?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->
        <?php endif; ?>
        <?php if ($tipo_busqueda=="zona"): ?>
          <div id="filtros_est_gen"><p style="background:#ffff00">Nivel: <?= $nivel_z?>, Sostenimiento: <?= $sostenimiento_z?>, Zona escolar: <?= $zona_z?>, Ciclo escolar: <?= $ciclo_z?>.</p>
            <div class="col-12 col-sm-12 col-md-1 col-lg-1 mt-2">
              <?= form_open('Report/est_generales_xzona') ?>
              <?= form_hidden('id_nivel_z', $id_nivel_z) ?>
              <?= form_hidden('id_sostenimiento_z', $id_sostenimiento_z) ?>
              <?= form_hidden('id_zona_z', $id_zona_z) ?>
              <?= form_hidden('id_ciclo_z', $id_ciclo_z) ?>
              <?php
              $data = array(
                  'id' => 'btn_genera_excel_est_g_xzona',
                  'value' => 'true',
                  'type' => 'submit',
                  'class'=>'btn btn-primary btn-style-1 btn-block',
                  'content' => '<i class="fas fa-file-excel"></i>',
                  'data-toggle' => "tooltip",
                  'data-placement' => "top",
                  'title' => 'Exportar los resultados'
              );

              echo form_button($data);
              ?>
              <?= form_close() ?>
            </div><!-- col-md-1 -->
          </div>
          </div>
              </center></p>
            </div>
          </div>

          </div>
        </div>

        <div class="dv_tablas_estzona">
          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Alumnos</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_alumnos?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Personal docente</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_pdocentes?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->

          <div class="card mb-3 card-style-1">
            <div class="card-header card-1-header bgcolor-2 text-white">Infraestructura</div>
            <div class="card-body">
              <div class="table-responsive"><?= $srt_tab_infraestructura?>  </div>
            </div><!-- card-body -->
          </div><!-- card -->
        </div>
        <?php endif; ?>



</div><!-- container -->

</section>

<script>
$(function () {
  $(window).scroll(function() {
  var scroll = $(window).scrollTop();
  var position=300;
// alert("111111");
  if (scroll > position) {
      $( "#dv_flot_est" ).addClass("dv_flotante");
  } else {
      $( "#dv_flot_est" ).removeClass("dv_flotante");
  }

});

  $(".hide-ini").css("display","none");

  $('tr.parent').css("cursor","pointer").attr("title","Click para expander/contraer").click(function()
    {
      if($(this).siblings('.child-'+this.id).is(":visible"))
      {
        $(this).find('img').css("transform", "rotate(360deg)");
          $(this).siblings('.child-'+this.id).fadeOut('500');
          $(this).siblings('.child-'+this.id).siblings('.class-hide-'+this.id).fadeOut('500');
      }
      else
      {
        $(this).find('img').css("transform", "rotate(270deg)");
            $(this).siblings('.child-'+this.id).fadeIn('500');
      }
    });

    $('tr.child-parent').css("cursor","pointer").attr("title","Click para expander/contraer").click(function()
    {

          if($(this).siblings('.nieto-'+this.id).is(":visible"))
              {
                $(this).find('img').css("transform", "rotate(360deg)");
                    $(this).siblings('.nieto-'+this.id).fadeOut('500');
                    $(this).siblings('.nieto-'+this.id).siblings('.class-hide-'+this.id).fadeOut('500');
              }
              else
              {
                $(this).find('img').css("transform", "rotate(270deg)");
                    $(this).siblings('.nieto-'+this.id).fadeIn('500');
              }
    });

    $('tr.child-nieto').css("cursor","pointer").attr("title","Click para expander/contraer").click(function()
    {
        if($(this).siblings('.bisnieto-'+this.id).is(":visible"))
        {
          $(this).find('img').css("transform", "rotate(360deg)");
              $(this).siblings('.bisnieto-'+this.id).fadeOut('500');
        }
        else
        {
          $(this).find('img').css("transform", "rotate(270deg)");
              $(this).siblings('.bisnieto-'+this.id).fadeIn('500');
        }
    });
});

</script>
