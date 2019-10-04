<section class="main-area">
  <div class="container">
    <div class="card mb-3 card-style-1">
    <div class="card-header card-1-header bg-light">Estadísticas Planea</div>
    <div class="card-body">
      <label for="lb_titbusq">Seleccione tipo de búsqueda</label>
        <ul class="nav nav-tabs nav-tabs-style-1" id="tab_busqg" role="tablist">
            <li class="nav-item">
              <a class="nav-link nav-link-style-1 active" id="xest_muni-tab" data-toggle="tab" href="#xest_muni" role="tab" aria-controls="xest_muni" aria-selected="true">Por estado / municipio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-style-1" id="xzona-tab" data-toggle="tab" href="#xzona" role="tab" aria-controls="xzona" aria-selected="false">Por zona escolar</a>
            </li>
        </ul>
        <div class="tab-content tab-content-style-1" id="myTabContent_busqg">
            <div class="tab-pane fade show active" id="xest_muni" role="tabpanel" aria-labelledby="xest_muni-tab">
                      <div class="row">
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                          <div class="form-group form-group-style-1">
                            <?=form_label('Municipio:', 'minicipio', array('class' => 'mr-sm-2'));?>
                            <?=form_dropdown('minicipio', $municipios, 'large', array('class' => 'form-control', 'id' => 'slt_municipio_mapa'));?>
                          </div>
                        </div><!-- col-md-4 -->
                        <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-2">
                          <div class="form-group form-group-style-1">
                            <?=form_label('Nivel:', 'nivel');?>
                            <?=form_dropdown('nivel', $niveles, 'large', array('class' => 'form-control', 'id' => 'slt_nivel_planeaxm'));?>
                          </div>
                        </div><!-- col-md-4 -->
                        <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-2">
                          <div class="form-group form-group-style-1">
                            <?=form_label('Periodo:', 'periodo');?>
                            <?=form_dropdown('periodo', $periodos, 'large', array('class' => 'form-control', 'id' => 'slt_periodo_planeaxm'));?>
                          </div>
                        </div><!-- col-md-4 -->
                        <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                          <div class="form-group form-group-style-1">
                            <?=form_label('Campo disciplinario:', 'campoD');?>
                            <?=form_dropdown('campoD', $camposd, 'large', array('class' => 'form-control', 'id' => 'slt_campod_planeaxm'));?>
                          </div>
                        </div><!-- col-md-4 -->
                      </div><!-- row -->

                      <div class="row">
                        <div class="col-0 col-sm-0 col-md-8 col-lg-8 mt-2"></div><!--  col-0 -->
                        <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                          <?= anchor(base_url(), 'Regresar', array('class' => 'btn btn-light btn-block btn-style-1')) ?>
                        </div><!--  col-sm-6 -->
                        <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                          <?= form_submit('mysubmit', 'Buscar', array('id' => 'btn_busqueda_xestadomun', 'class'=>'btn btn-info btn-block btn-style-1' )); ?>
                        </div><!--  col-sm-6 -->
                      </div><!-- row -->
                  <!-- </form> -->
            </div><!-- xest_muni -->
            <div class="tab-pane fade" id="xzona" role="tabpanel" aria-labelledby="xzona-tab">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                                <div class="row">
                                  <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-2">
                                      <div class="form-group form-group-style-1">
                                        <?=form_label('Nivel:', 'nivel');?>
                                        <?=form_dropdown('nivel', $nivelesz, 'large', array('class' => 'form-control', 'id' => 'slt_nivel_planeaxz'));?>
                                      </div>
                                    </div><!-- col-md-4 -->
                                    <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-2">
                                      <div class="form-group form-group-style-1">
                                        <?=form_label('Sostenimiento:', 'subsostenimiento');?>
                                        <?=form_dropdown('subsostenimiento', $subsostenimientos, 'large', array('class' => 'form-control', 'id' => 'slt_subsostenimiento_planeaxz'));?>
                                      </div>
                                    </div><!-- col-md-4 -->
                                  <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                                    <div class="form-group form-group-style-1">
                                        <?=form_label('Zona:', 'zona', array('class' => 'mr-sm-2'));?>
                                        <?=form_dropdown('zona', array("0" => "SELCCIONE"), 'large', array('class' => 'form-control', 'id' => 'slt_zona_planea'));?>
                                    </div>
                                  </div><!-- col-md-4 -->
                                  <div class="col-12 col-sm-12 col-md-3 col-lg-2 mt-2">
                                      <div class="form-group form-group-style-1">
                                        <?=form_label('Periodo:', 'periodo');?>
                                        <?=form_dropdown('periodo', $periodos, 'large', array('class' => 'form-control', 'id' => 'slt_periodo_planeaxz'));?>
                                      </div>
                                    </div><!-- col-md-4 -->
                                  <div class="col-12 col-sm-12 col-md-3 col-lg-3 mt-2">
                                    <div class="form-group form-group-style-1">
                                      <?=form_label('Campo Disciplinario:', 'campoD');?>
                                      <?=form_dropdown('campoD', $camposd, 'large', array('class' => 'form-control', 'id' => 'slt_campod_planeaxz'));?>
                                    </div>
                                  </div><!-- col-md-4 -->
                                  <input type="hidden" name="slt_tipo"  id="slt_tipo" value="zona">
                                </div><!-- row -->
                              <!-- </form> -->
                        </div>
                    </div><!--  col-sm-12 -->
                </div><!-- row -->
                <div class="row">
                    <div class="col-0 col-sm-0 col-md-8 col-lg-8 mt-2"></div><!--  col-0 -->
                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= anchor(base_url(), 'Regresar', array('class' => 'btn btn-light btn-block btn-style-1')) ?>
                    </div><!--  col-sm-6 -->

                    <div class="col-6 col-sm-6 col-md-2 col-lg-2 mt-2">
                      <?= form_submit('mysubmit', 'Buscar', array('id' => 'btn_busqueda_xregion', 'class'=>'btn btn-info btn-block btn-style-1' )); ?>
                    </div><!--  col-sm-6 -->
                </div><!-- row -->
            </div>
        </div>
        <div class="card mb-3 card-style-1 mt-3">
            <div class="card-header card-1-header bgcolor-2 text-white">Resultados de búsqueda</div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-12">
                        <div id="div_graficas_masivo"></div>
                        <!-- <div id="div_graficas_masivo_matematicas"></div> -->
                    </div>
                </div>
            </div><!-- card-body -->
        </div>
    </div>
  </div><!-- card -->
</div>
</section>
<!-- Modal Reactivos -->
<div class="modal fade" id="modal_visor_reactivos" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-style-1">
            <div class="modal-header bgcolor-2">
                <h5 class="modal-title text-white" id="exampleModalLabel">Consulta por reactivos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="fz-18 fw800" id="modal_reactivos_title"></span>
                <hr>
                <div id="div_reactivos"></div>
            </div>
            </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Apoyos -->
<div class="modal fade" id="modal_visor_apoyos_academ" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="overflow-y: scroll;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-style-1">
            <div class="modal-header bgcolor-4">
                <h5 class="modal-title text-white" id="exampleModalLabel">Apoyos académicos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div_listalinks"></div>
            </div>
            </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Apoyos -->
<div class="modal fade" id="modal_visor_apoyos_reactivos" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="overflow-y: scroll;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-style-1">
            <div class="modal-header bgcolor-4">
                <h5 class="modal-title text-white" id="exampleModalLabel">Texto / imagen complementario del reactivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div_listalinks"></div>
            </div>
            </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Apoyos -->
<div class="modal fade" id="modal_visor_pdfc2" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="overflow-y: scroll;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-style-1">
            <div class="modal-header bgcolor-2">
                <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div_listalinks"></div>
            </div>
            </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Apoyos -->
<div class="modal fade" id="modal_visor_pdfc3" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="overflow-y: scroll;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-style-1">
            <div class="modal-header bgcolor-3">
                <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div_listalinks"></div>
            </div>
            </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal Apoyos -->
<div class="modal fade" id="modal_visor_material_reactivos" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="overflow-y: scroll;">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-style-1">
            <div class="modal-header bgcolor-4">
                <h5 class="modal-title text-white" id="exampleModalLabel"></h5>
                <button type="button" class="close" id="md_close_iframe" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div_listalinks"></div>
            </div>
            </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal react -->
<div class="modal fade" id="modal_visor_reactivos_zom" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-style-1">
            <div class="modal-header bgcolor-4">
                <h5 class="modal-title text-white" id="exampleModalLabel">Reactivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="div_listalinks"></div>
            </div>
            </div>
    </div>
</div>
<!-- End Modal -->
<!-- Modal Apoyos -->
<div class="modal fade" id="modal_operacion_recursos" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" >
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content modal-style-1">
            <div class="modal-header bgcolor-4">
                <h5 class="modal-title text-white" id="exampleModalLabel">Propuestas de material de apoyo</h5>
                <button type="button" class="close" id="md_close_operacion_recursos" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <p>Ayúdanos a mejorar los materiales de apoyo para nuestros alumnos, en este espacio puedes proponer videos, archivos o textos que  en tu experiencia son efectivos.
              </p><p>Muchas gracias.</p>
              <div class="form-group">
            <label for="tipodematerial">Seleccione tipo de contenido a subir</label>
            <select class="form-control" id="tipodematerial">
              <?php foreach ($contenidos as $key => $value): ?>
                    <option value="<?=$key?>"><?=$value?></option>
            <?php endforeach; ?>
            </select>
          </div>
                <div id="div_contenedor_operaciones">
                  <div class="form-group">
              <label for="inputtitulo">Introduzca un título para su contenido: </label>
              <input type="text" class="form-control" id="inputtitulo" placeholder="Titulo">
              <p id="mensaje_alertattitulo" style="color:red;">*El título es requerido</p>
              </div>
            <div class="form-group">
              <label for="inputcampourl">Introduzca url: </label>
              <input type="text" class="form-control" id="inputcampourl" placeholder="https://misitiodeapoyo.com">
              <p id="mensaje_alertaurl" style="color:red;">*El url es requerido</p>
              <p id="mensaje_alertaur2" style="color:red;">*El url no esta permitido</p>
              </div>
              <div class="form-group">
              <label for="inputcampofuente">Introduzca fuente: </label>
              <input type="text" class="form-control" id="inputcampofuente" name="fuenteurlvideo">
              <p id="mensaje_alertafuente" style="color:red;">*La fuente es requerida</p>
              </div>
              <input type="hidden" name="idreactivo" id="idreactivoform_pub">
              <button type="button" class="btn btn-info" onClick = "obj_graficas.envia_url_pub()">Guardar</button>
                </div>
                <div id="div_contenedor_operaciones_files">
                  <!--el enctype debe soportar subida de archivos con multipart/form-data-->
          <form enctype="multipart/form-data" class="formulario">
            <label>Título</label><br />
              <input name="titulo" type="text" id="titulofile" class="form-control"/>
              <p id="mensaje_alertatitulo_file" style="color:red;">*El título es requerido</p>
              <input name="archivo" type="file" id="imagen" accept="application/pdf" />
              <p id="mensaje_alertafile" style="color:red;">*Seleccione un archivo</p>
              <div class="form-group">
              <label for="inputcampofuentefile">Introduzca fuente: </label>
              <input type="text" class="form-control" id="inputcampofuentefile" name="fuentefile">
              <p id="mensaje_alertafuente_file" style="color:red;">*La fuente es requerida</p>
              </div>
              <!--div para visualizar mensajes-->
            <div class="messages"></div><br /><br />
            <!--div para visualizar en el caso de imagen-->
            <div class="showImage"></div>
              <input type="button" value="Subir" class="btn btn-info" id="btn_subir_pdf_imagen_pub" /><br />
              <input type="hidden" name="tipo" id="idtipofileform">
              <input type="hidden" name="idreactivo" id="idreactivofileform_pub">
              <input type="hidden" name="idseleccionadofile" id="idseleccionadofile" value="false">
              <input type="hidden" name="validaexixtente" id="validaexixtente" value="false">
          </form>

                </div>
            </div>
            </div>
    </div>
</div>
<!-- End Modal -->

<script src="<?= base_url('assets/highcharts5.0.3/highcharts.js'); ?>"></script><!--Problemas con esta versión <script src="https://code.highcharts.com/highcharts.js"></script>-->
<script src="<?= base_url('assets/highcharts5.0.3/modules/data.js'); ?>"></script><!--Problemas con esta versión <script src="https://code.highcharts.com/modules/data.js"></script>-->
<script src="<?= base_url('assets/highcharts5.0.3/modules/drilldown.js'); ?>"></script><!--Problemas con esta versión<script src="https://code.highcharts.com/modules/drilldown.js"></script>-->
<script src="<?= base_url('assets/js/planea/graficas.js') ?>"></script>
<script src="<?= base_url('assets/js/planea/planea.js') ?>"></script>
