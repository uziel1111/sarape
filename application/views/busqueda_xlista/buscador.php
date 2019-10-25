<style media="screen">
  .input_cct{
    font-size: 30px;
    font-weight: bold;
  }
  .label_cct{
    font-size: 30px;
    font-weight: bold;
  }
</style>
<section class="main-area">
<div class="container">
  <div class="card mb-3 card-style-1">
    <div class="card-header card-1-header bg-light">Estadísticas por escuela</div>
    <div class="card-body">

              <?= form_label('Seleccione tipo de búsqueda', 'username') ?>
              <ul class="nav nav-tabs nav-tabs-style-1" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link nav-link-style-1 active" id="xmunicipio-tab" data-toggle="tab" href="#xmunicipio" role="tab" aria-controls="xmunicipio" aria-selected="true">Por municipio, nivel, sostenimiento o nombre</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link nav-link-style-1" id="xcct-tab" data-toggle="tab" href="#xcct" role="tab" aria-controls="xcct" aria-selected="false">Por Clave de Centro de Trabajo</a>
                </li>
              </ul>
              <div class="tab-content tab-content-style-1" id="myTabContent">
                <div class="tab-pane fade show active" id="xmunicipio" role="tabpanel" aria-labelledby="xmunicipio-tab">
                  <?= form_open('estadistica/escuelas', array('method'=>'get', 'class' => 'form', 'id' => 'form_busquedalista')) ?>
                  <div class="row">
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-2">
                      <div class="form-group form-group-style-1">
                        <?= form_label('Municipio', 'slc_busquedalista_municipio') ?>
                        <?= form_dropdown('slc_busquedalista_municipio', $arr_municipios, '', array('id' => 'slc_busquedalista_municipio', 'class'=>'form-control')) ?>
                      </div>
                    </div><!-- col-md-4 -->
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-2">
                      <div class="form-group form-group-style-1">
                        <?= form_label('Nivel', 'slc_busquedalista_nivel') ?>
                        <?= form_dropdown('slc_busquedalista_nivel', $arr_niveles, '', array('id' => 'slc_busquedalista_nivel', 'class'=>'form-control')) ?>
                      </div>
                    </div><!-- col-md-4 -->
                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-2">
                      <div class="form-group form-group-style-1">
                        <?= form_label('Sostenimiento', 'slc_busquedalista_sostenimiento') ?>
                        <?= form_dropdown('slc_busquedalista_sostenimiento', $arr_sostenimientos, '', array('id' => 'slc_busquedalista_sostenimiento', 'class'=>'form-control')) ?>
                      </div>
                    </div><!-- col-md-4 -->
                  </div><!-- row -->

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-style-1">
                          <?= form_label('Nombre de la escuela (opcional)', 'itxt_busquedalista_nombreescuela') ?>
                          <?= form_input('itxt_busquedalista_nombreescuela', '', array('id' => 'itxt_busquedalista_nombreescuela', 'class'=>'form-control' )) ?>
                      </div>
                    </div><!--  col-sm-12 -->
                  </div><!-- row -->

                  <div class="row">
                    <div class="col-0 col-sm-0 col-md-8 col-lg-8 mt-2"></div><!--  col-0 -->
                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= anchor(base_url(), 'Regresar', array('class' => 'btn btn-light btn-block btn-style-1')) ?>
                    </div><!--  col-sm-6 -->

                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= form_submit('mysubmit', 'Buscar', array('id' => '', 'class'=>'btn btn-info btn-block btn-style-1' )); ?>
                    </div><!--  col-sm-6 -->
                  </div><!-- row -->

                  <?= form_hidden('hidden_municipio', 'Todos') ?>
                  <?= form_hidden('hidden_nivel', 'Todos') ?>
                  <?= form_hidden('hidden_sostenimiento', 'Todos') ?>
                  <?= form_close() ?>
                </div><!-- xmunicipio -->

                <div class="tab-pane fade" id="xcct" role="tabpanel" aria-labelledby="xcct-tab">
                  <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 mt-2">
                      <div class="form-group form-group-style-1">
                          <?= form_label('Escriba su CCT', 'itxt_busquedalista_cct') ?>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text label_cct">05</span>
                            </div>
                              <?= form_input('itxt_busquedalista_cct', '', array('id' => 'itxt_busquedalista_cct', 'class'=>'form-control input_cct' )) ?>
                        </div>
                      </div>
                    </div><!--  col-sm-12 -->
                  </div><!-- row -->

                  <div class="row">
                    <div class="col-0 col-sm-0 col-md-8 col-lg-8 mt-2"></div><!--  col-0 -->
                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= anchor(base_url(), 'Regresar', array('class' => 'btn btn-light btn-block btn-style-1')) ?>
                    </div><!--  col-sm-6 -->

                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= form_submit('mysubmit', 'Buscar', array('id' => '', 'class'=>'btn btn-info btn-block btn-style-1' )); ?>
                    </div><!--  col-sm-6 -->
                  </div><!-- row -->
                </div>
              </div>

    </div><!-- card-body -->
  </div><!-- card -->
</div><!-- container -->

</section>

<div id='busquedalista_modal' class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Seleccione una escuela</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?= form_open('Info/index', array('class' => '', 'id' => '')) ?>
        <div class="row">
          <div class="col-12">
            <?= form_dropdown('cct', array(), '', array('id' => 'cct', 'class'=>'form-control')) ?>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12">
            <?= form_submit('mysubmit_cct', 'Ver', array('id' => 'buscador_ccts', 'class'=>'btn btn-info btn-block' )); ?>
          </div>
        </div>
        <?= form_close() ?>

      </div>
    </div>
  </div>
</div><!-- modal -->

<script src="<?= base_url('assets/js/regularexpression.js') ?>"></script>
<script src="<?= base_url('assets/js/busquedaxlista/buscador.js') ?>"></script>
