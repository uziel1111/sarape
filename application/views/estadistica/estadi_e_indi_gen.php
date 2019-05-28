        <!-- Start Main Area -->

        <div class="row">
          <div data-toggle="collapse" data-target="#demo" class="card-header card-1-header bg-light">Seleccione tipo de búsqueda:</div>
          <div id="demo" class="collapse show">
      <?= form_label('', 'lb_titbusq') ?>
      <ul class="nav nav-tabs nav-tabs-style-1" id="tab_busqg" role="tablist">
        <li class="nav-item">
          <a class='<?=$tmuni?>' id="xest_muni-tab" data-toggle="tab" href="#xest_muni" role="tab" aria-controls="xest_muni" aria-selected="true">Por Estado / Municipio</a>
        </li>
        <li class="nav-item">
          <a class='<?=$tzona?>' id="xzona-tab" data-toggle="tab" href="#xzona" role="tab" aria-controls="xzona" aria-selected="false">Por zona escolar</a>
        </li>
      </ul>
              <div class="tab-content tab-content-style-1" id="myTabContent_busqg">

                <div class="tab-pane fade show <?=$tmuni?>" id="xest_muni" role="tabpanel" aria-labelledby="xest_muni-tab">
                  <?= form_open('estadistica/xest_muni_x/', array('class' => 'form', 'id' => 'form_xest_muni')) ?>
                  <div class="row">

                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                    <div class="form-group form-group-style-1">
                        <?= form_label('Estado / Municipio', 'slc_xest_muni_estmunicipio') ?>
                        <?= form_dropdown('slc_xest_muni_estmunicipio', $arr_municipios, '', array('id' => 'slc_xest_muni_estmunicipio', 'class'=>'form-control')) ?>
                    </div><!-- col-md-4 -->
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-2">
                    <div class="form-group form-group-style-1">
                        <?= form_label('Nivel', 'slc_xest_muni_nivel') ?>
                        <?= form_dropdown('slc_xest_muni_nivel', $arr_niveles, '', array('id' => 'slc_xest_muni_nivel', 'class'=>'form-control')) ?>
                    </div><!-- col-md-4 -->
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-2">
                        <div class="form-group form-group-style-1">
                        <?= form_label('Sostenimiento', 'slc_xest_muni_sostenimiento') ?>
                        <?= form_dropdown('slc_xest_muni_sostenimiento', $arr_sostenimientos, '', array('id' => 'slc_xest_muni_sostenimiento', 'class'=>'form-control')) ?>
                    </div><!-- col-md-4 -->
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                        <div class="form-group form-group-style-1">
                        <?= form_label('Modalidad', 'slc_xest_muni_modalidad') ?>
                        <?= form_dropdown('slc_xest_muni_modalidad', $arr_modalidad, '', array('id' => 'slc_xest_muni_modalidad', 'class'=>'form-control')) ?>
                    </div><!-- col-md-4 -->
                    </div>
                    <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-2">
                        <div class="form-group form-group-style-1">
                        <?= form_label('Ciclo escolar', 'slc_xest_muni_cicloe') ?>
                        <?= form_dropdown('slc_xest_muni_cicloe', $arr_ciclos, '', array('id' => 'slc_xest_muni_cicloe', 'class'=>'form-control')) ?>
                        </div><!-- col-md-4 -->
                    </div><!-- form-group -->
                  </div><!-- row -->

                  <div class="row">
                    <div class="col-0 col-sm-0 col-md-8 col-lg-8 mt-2"></div><!--  col-0 -->
                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= anchor(base_url(), 'Regresar', array('class' => 'btn btn-light btn-block btn-style-1')) ?>
                    </div><!--  col-sm-6 -->

                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= form_submit('mysubmit', 'Buscar', array('id' => 'btn_buscar_mun_est', 'class'=>'btn btn-info btn-block btn-style-1' )); ?>
                    </div><!--  col-sm-6 -->
                  </div><!-- row -->

                  <?= form_close() ?>
                </div><!-- xest_muni -->


                <div class="tab-pane fade show <?=$tzona?>" id="xzona" role="tabpanel" aria-labelledby="xzona-tab">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group form-group-style-1">
                        <?= form_open('estadistica/xest_zona_x', array('class' => 'form', 'id' => 'form_xest_zona')) ?>
                        <div class="row">
                          <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                            <div class="form-group">
                              <?= form_label('Nivel', 'slc_xest_nivel_zona') ?>
                              <?= form_dropdown('slc_xest_nivel_zona', $arr_nivelesz, '', array('id' => 'slc_xest_nivel_zona', 'class'=>'form-control')) ?>
                            </div>
                          </div><!-- col-md-4 -->
                          <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                            <div class="form-group">
                              <?= form_label('Sostenimiento', 'slc_xest_sostenimiento_zona') ?>
                              <?= form_dropdown('slc_xest_sostenimiento_zona', $arr_subsostenimientos, '', array('id' => 'slc_xest_sostenimiento_zona', 'class'=>'form-control')) ?>
                            </div>
                          </div><!-- col-md-4 -->
                          <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                            <div class="form-group">
                              <?= form_label('Número de zona escolar', 'slc_xest_zona') ?>
                              <?= form_dropdown('slc_xest_zona', $arr_nzonae, '', array('id' => 'slc_xest_zona', 'class'=>'form-control')) ?>
                            </div>
                          </div><!-- col-md-4 -->
                          <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                            <div class="form-group">
                              <?= form_label('Ciclo escolar', 'slc_xest_cicloe_zona') ?>
                              <?= form_dropdown('slc_xest_cicloe_zona', $arr_ciclos, '', array('id' => 'slc_xest_cicloe_zona', 'class'=>'form-control')) ?>
                            </div>
                          </div><!-- col-md-4 -->
                        </div><!-- row -->
                      </div>
                    </div><!--  col-sm-12 -->
                  </div><!-- row -->

                  <div class="row">
                    <div class="col-0 col-sm-0 col-md-8 col-lg-8 mt-2"></div><!--  col-0 -->
                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= anchor(base_url(), 'Regresar', array('class' => 'btn btn-light btn-block btn-style-1')) ?>
                    </div><!--  col-sm-6 -->

                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= form_submit('mysubmit', 'Buscar', array('id' => 'btn_buscar_zona', 'class'=>'btn btn-info btn-block btn-style-1' )); ?>
                    </div><!--  col-sm-6 -->
                  </div><!-- row -->
                  <?= form_close() ?>
                  </div>
                </div>
              </div>


        </div>
        <!-- End Main Area -->





<script src="<?= base_url('assets/js/est_e_ind/est_e_ind_g.js'); ?>"></script>
