<style type="text/css">
  td {border: 1px #DDD solid; padding: 5px; cursor: pointer;}

.selected {
    background-color: #9ccc65;
    color: #FFF;
}
.popover-body {
    padding: .5rem .75rem;
    color: #212529;
}
.popover{
    max-width:600px;
}
</style>

<section class="main-area">
  <div class="container">


    <div class="row justify-content-center flex-column mb-3">
      <nav>
        <div class="nav nav-tabs nav-tabs-style-1" id="nav-tab" role="tablist">
          <a class="nav-item nav-link nav-link-style-1 active" id="nav-ruta-tab" data-toggle="tab" href="#nav-ruta" role="tab" aria-controls="nav-ruta" aria-selected="true">Captura de la Ruta de Mejora</a>
          <a class="nav-item nav-link nav-link-style-1" id="nav-avances-tab" data-toggle="tab" href="#nav-avances" role="tab" aria-controls="nav-avances" aria-selected="false">Avances por acciones</a>
          <a class="nav-item nav-link nav-link-style-1" id="nav-indicadores-tab" data-toggle="tab" href="#nav-indicadores" role="tab" aria-controls="nav-indicadores" aria-selected="false">Indicadores sugeridos</a>
          <a class="nav-item nav-link nav-link-style-1" id="nav-instrucc-tab" data-toggle="tab" href="#nav-instrucc" role="tab" aria-controls="nav-instrucc" aria-selected="false">Instructivo</a>
        </div>
      </nav>
      <div class="tab-content tab-content-style-1" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-ruta" role="tabpanel" aria-labelledby="nav-ruta-tab">
          <div class="form-group form-group-style-1">
            <div class="row">
              <div class="col-6">
                <label><span class="badge badge-secondary h5 text-white">1.</span> En este ciclo escolar quiero que mi escuela (Misión): <em class="fas fa-question-circle" data-toggle="popover" data-placement="top" data-content="En esta sección se hace una descripción
                  breve (de no más de 80 palabras Aproximadaménte) que clarifique cual es
                  la contribución que debe hacer la escuela a la comunidad donde radica,
                  donde se verá su impacto positivo y de que forma deberá ser vista por
                  quienes interactúan con ella (alumnos, padres de familia, autoridades
                  locales y sociedad en general)"></em></label>
                  <textarea id="txt_rm_identidad" class="form-control fz-20" rows="2" maxlength="150"><?= $mision ?></textarea>
                </div>
                <div class="col-md-6">
                  <label><span class="badge badge-secondary h5 text-white">2.</span> Prioridad del sistema básico de mejora</label><label style="color:red;">*</label><br>
                  <select class="selectpicker form-control" title="SELECCIONA UNA OPCIÓN" id="slc_rm_prioridad">
                    <!-- <option value="">SELECCIONE UNA OPCIÓN</option> -->
                    <?php foreach ($arr_prioridades as $item): ?>
                            <option value="<?= $item['id_prioridad'] ?>"><?= $item['prioridad'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row mt-15">
                <div class="col-12">
                  <label><span class="badge badge-secondary h5 text-white">3.</span> Objetivos y sus metas <em class="fas fa-question-circle" data-toggle="popover" data-placement="top" data-content="Para la prioridad seleccionada escribe un objetivo que
                    inicie con uno de los siguientes verbos (aumentar, disminuir, alcanzar o
                    eliminar) seguido por un indicador concreto (por ejemplo: asistencia,
                    aprovechamiento, y en algunos casos enfocados a un nivel educativo,
                    a un grado en particular, a una asignatura), continuando con una meta
                    numérica de mejora del indicador y finalizando con una fecha de
                    cumplimiento máximo (si es para el final del período escolar se puede
                    omitir este elemento dándolo por entendido)"></em></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Objetivo 1<label style="color:red;">*</label></span>
                      </div>
                      <textarea class="form-control" aria-label="With textarea" maxlength="150" id="txt_rm_ob1"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Objetivo 2</span>
                      </div>
                      <textarea class="form-control" aria-label="With textarea" maxlength="150"id="txt_rm_ob2"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-6">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Meta 1<label style="color:red;">*</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
                      </div>
                      <textarea class="form-control" aria-label="With textarea" maxlength="150" id="txt_rm_met1"></textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Meta 2&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</span>
                      </div>
                      <textarea class="form-control" aria-label="With textarea" maxlength="150" id="txt_rm_met2"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row mt-15">
                  <div class="col-md-6">
                    <label><span class="badge badge-secondary h5 text-white">4.</span> Problemática por prioridad</label><label style="color:red;">*</label>
                    <textarea id="txt_rm_problem" class="form-control" rows="2" maxlength="150"></textarea>
                    <!-- <select class="selectpicker form-control" id="slc_problem">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      <?php foreach ($arr_problematicas as $item): ?>
                              <option value="<?= $item['id_problematica'] ?>"><?= $item['problematica'] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <br>
                    <textarea id="txt_rm_otroproblematica" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true"></textarea> -->
                  </div>
                  <div class="col-md-6">
                    <label><span class="badge badge-secondary h5 text-white">5.</span> Evidencias de las problematicas</label><label style="color:red;">*</label>
                    <textarea id="txt_rm_eviden" class="form-control" rows="2" maxlength="150"></textarea>
                    <!-- <select class="selectpicker form-control"multiple data-selected-text-format="count > 3" id="slc_evidencias">
                      <option value="">SELECCIONE UNA OPCIÓN</option>
                      <?php foreach ($arr_evidencias as $item): ?>
                              <option value="<?= $item['id_evidencia'] ?>"><?= $item['evidencia'] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <br>
                    <textarea id="txt_rm_otroevidencia" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true"></textarea> -->
                  </div>

                </div>
                <div class="row mt-15">
                  <div class="col-md-6">
                    <label><span class="badge badge-secondary h5 text-white">6.</span> Programas educativos de apoyo</label>
                    <select class="selectpicker form-control" multiple data-selected-text-format="count > 3" id="slc_pa" title="SELECCIONA UNA OPCIÓN">

                      <?php foreach ($arr_progsapoyo as $item): ?>
                              <option value="<?= $item['id_programa_apoyo'] ?>"><?= $item['descripcion'] ?></option>
                      <?php endforeach; ?>
                      <option value="0">OTRO</option>
                    </select>
                    <br>
                    <textarea id="txt_rm_otropa" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true"></textarea>
                  </div>
                  <div class="col-md-6">
                    <label><span class="badge badge-secondary h5 text-white">7.</span> ¿Cómo ayudan los programas de apoyo?</label>
                    <br>
                    <textarea id="txt_rm_programayuda" class="form-control" rows="2" maxlength="150"></textarea>
                  </div>

                </div>
                <div class="row mt-15">
                  <div class="col-md-6">
                    <label><span class="badge badge-secondary h5 text-white">8.</span> Observaciones del director</label>
                    <textarea id="txt_rm_obs_direc" class="form-control" rows="2" maxlength="150"></textarea>
                  </div>
                  <div class="col-6">
                    <input type="text" name="" id="inp_tmp_id_tprioritario" value="" hidden>
                    <label><span class="badge badge-secondary h5 text-white">9.</span> Subir evidencia (imagen o pdf) </label>
                    <label class="" style="color:red;">*Disponible a partir del Consejo Técnico Escolar 2.</label><br>
                    <br>
                    <form enctype="multipart/form-data" id="from_aux" class="formulario1">
                    <div class="form-group">

                      <input type="hidden" name="id_id_tprioritario" id="id_id_tprioritario">
                      <input type="hidden" name="id_prioridad" id="id_id_prioridad">
                      <input type="hidden" name="objetivo1" id="id_objetivo1">
                      <input type="hidden" name="meta1" id="id_meta1">
                      <input type="hidden" name="objetivo2" id="id_objetivo2">
                      <input type="hidden" name="meta2" id="id_meta2">
                      <input type="hidden" name="problematica" id="id_problematica">
                      <input type="hidden" name="evidencia" id="id_evidencia">
                      <input type="hidden" name="ids_progapoy" id="id_ids_progapoy">
                      <input type="hidden" name="otro_pa" id="id_otro_pa">
                      <input type="hidden" name="como_prog_ayuda" id="id_como_prog_ayuda">
                      <input type="hidden" name="obs_direct" id="id_obs_direct">
                      <input type="hidden" name="ids_apoyreq" id="id_ids_apoyreq">
                      <input type="hidden" name="otroapoyreq" id="id_otroapoyreq">
                      <input type="hidden" name="especifiqueapyreq" id="id_especifiqueapyreq">

                      <input type="hidden" name="edit_img" id="edit_img" value="false">

                      <!-- <input name="archivo" type="file" id="imagen" accept="image.*/pdf" /> -->
                      <!-- disabled="true" -->
                        <button type="button"
                                onclick="obj_rm_tp.abrir('imagen')">Escoga un archivo</button>
                        <input type="file"
                               id="imagen" name="archivo"
                               onchange="obj_rm_tp.contar(this, 'glosaArchivos')" style="display: none" accept="application/pdf, image/*" >
                        <span id="glosaArchivos">Ningun archivo seleccionado</span>

                        <br>
                        <div class="col-8">
                          <button id="btn_clr_img" type="button" class="close" aria-label="Close" hidden><span aria-hidden="true">&times;</span></button>
                          <img id="img_evid"  alt="" class="img-fluid" alt="Responsive image"/>
                        </div>

        					    <!-- <p id="mensaje_alertafile" style="color:red;">*Seleccione un archivo</p> -->
                    </div>
                    </form>
                    <!-- <label><span class="badge badge-secondary h5 text-white">9.</span> ¿Qué apoyo requerimos por parte de la SE para lograr estos objetivos?</label>
                    <br>
                    <select class="selectpicker form-control" multiple data-selected-text-format="count > 3" id="slc_apoyoreq" title="SELECCIONE UNA OPCIÓN">
                      <?php foreach ($arr_apoyosreq as $item): ?>
                              <option value="<?= $item['id_apoyo_req_se'] ?>"><?= $item['apoyo_req_se'] ?></option>
                      <?php endforeach; ?>
                    </select>

                    <br>
                    <textarea id="txt_rm_otroapoyreq" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true" maxlength="80"></textarea>
                    <br>
                    <textarea id="txt_rm_especifiqueapyreq" class="form-control" rows="2" maxlength="80"></textarea> -->
                  </div>
                </div>
                <div class="row mt-15">
                  <div class="col-md-6" id="dv_obs_super" hidden="true">
                    <label> Observaciones del supervisor</label>
                    <textarea id="txt_rm_obs_super" class="form-control" rows="2" maxlength="150" disabled></textarea>
                  </div>
                </div>

                <div class="row mt-15">
                  <div class="col-12">
                    <p id="mensaje_alertafile" style="color:red;">*Elementos requeridos</p>
                  </div>
                </div>
                <div class="row mt-15">
                  <div class="col-1">
                    <button type="button" class="btn btn-primary btn-style-1 mr-1" id="btn_grabar_tp">Grabar</button>
                  </div>
                  <div class="col-1">
                    <button type="button" class="btn btn-primary btn-style-1 mr-1" id="btn_actualizar_tp" hidden>Actualizar</button>
                  </div>
                </div>

              </div>
              <div class="container">
                <div class="card mb-3 card-style-1">
                  <div class="card-header card-1-header bg-light">Detalle</div>
                  <div class="card-body">
                    <div class="card-block">
                      <div class="row mt-15">
                        <div class="col-12">
                          <a class="btn btn-primary" id="btn_get_reporte" title="Generar reporte" target="_blank" href="<?= base_url('index.php/Reporte/get_reporte') ?>"><i class="fas fa-print" ></i></a>
                          <button id="btn_rutamejora_editar" type="button" title="Editar" class="btn btn-primary"><i class="fas fa-edit"></i></button>
                          <button id="btn_rutamejora_eliminareg" type="button" title="Eliminar" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>
                          <button id="btn_rutamejora_acciones" type="button" data-toggle="modal" data-target="#exampleModal" title="Crear actividades" class="btn btn-primary"><i class="fas fa-tasks"></i></button>
                          <button id="btn_rutamejora_obs_super" type="button" data-toggle="modal" data-target="#exampleModal" title="Mostrar observacion del supervisor" class="btn btn-primary"><i class="far fa-eye"></i></button>

                        </div>


                      </div>

                      <div class="row mt-15">
                        <div class="col-12">
                          <!-- aqui ira el html de la tabla             -->
                          <div id="contenedor_tabla"></div>
                        </div>
                            </div>
                            <div class="row">
                              <div class="col-12">
                                <label class="" style="font-size:15pt;font-weight: bold;">*Selecciona una prioridad e inserta sus acciones.</label><br>
                                <label class="" style="">*Puedes modificar el orden de los temas prioritarios arrastando el registro a la posición deseada.</label>
                              </div>
                            </div>


                          </div>

                        </div>
                      </div><!-- card -->
                    </div><!-- container -->
                  </div>
                  <div class="tab-pane fade" id="nav-avances" role="tabpanel" aria-labelledby="nav-avances-tab">
                    <!-- <?= $tab_avances?> -->
                  </div>
                  <div class="tab-pane fade" id="nav-indicadores" role="tabpanel" aria-labelledby="nav-indicadores-tab">
                    <?= $tab_indicadores?>
                  </div>
                  <div class="tab-pane fade" id="nav-instrucc" role="tabpanel" aria-labelledby="nav-instrucc-tab">
                    <?= $tab_instructivo?>
                  </div>

                </div>

              </div>
            </div><!-- container -->
        </section>
        <!-- Modal -->
            <div class="modal fade" id="exampleModal_ver_evidencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-style-1">
                  <div class="modal-header bgcolor-2">
                    <h5 class="modal-title text-white" id="exampleModalLabel"> Archivo evidencia</h5>
                    <button type="button" class="close" id="cerrar_modal_ver_evidencia" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                          <div class="form-group form-group-style-1">
                            <div class="row mt-15">
                              <div class="col-md-12" id="dv_ver_evidencia">
                              </div>
                            </div>
                          </div>
              </div>
            </div>
          </div>
          </div>
        <!-- Modal -->
            <div class="modal fade" id="exampleModal_obs_super" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-style-1">
                  <div class="modal-header bgcolor-2">
                    <h5 class="modal-title text-white" id="exampleModalLabel"> Observaciones del supervisor</h5>
                    <button type="button" class="close" id="cerrar_modal_obs_super" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                          <div class="form-group form-group-style-1">
                            <div class="row mt-15">
                              <div class="col-md-12" id="dv_obs_super1">
                                <textarea id="txt_rm_obs_super1" class="form-control" rows="2" maxlength="150" disabled></textarea>
                              </div>
                            </div>
                          </div>
              </div>
            </div>
          </div>
          </div>

        <!-- Modal -->
            <div class="modal fade" id="exampleModalacciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-style-1">
                  <div class="modal-header bgcolor-2">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Acciones por prioridad del Sistema Básico de Mejora</h5>
                    <button type="button" class="close" id="cerrar_modal_acciones" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                      Escuela: <span class="fw800"><label id="label_escuela"></label></span><br>

                      Prioridad: <span class="fw800"><label id="label_prioridad"></label></span><br>

                      Problemática(s): <span class="fw800"><label id="label_problematica"></label></span><br>

                      Evidencia(s): <span class="fw800"><label id="label_evidencia"></label></span>
                    </div>
                    <div class="card mb-3 card-style-1">
                      <div class="card-header card-1-header bg-light">ESTRATEGIA GLOBAL DE MEJORA</div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="form-group form-group-style-1">
                            <div class="row">
                              <div class="col-md-6">
                                <label><label style="color:red;">*</label>Ambitos:</label>
                                <select class="selectpicker form-control" id="slc_rm_ambito" title="SELECCIONA UN AMBITO">
                                  <?php foreach ($arr_ambitos as $item): ?>
                                          <option value="<?= $item['id_ambito'] ?>"><?= $item['ambito'] ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="row mt-15">
                              <div class="col-md-6">
                                <label><label style="color:red;">*</label>Acción:</label>
                                <textarea id="txt_rm_meta" class="form-control" rows="5" maxlength="150"></textarea>
                              </div>
                              <div class="col-md-6">
                                <label><label style="color:red;">*</label>Materiales e insumos a utilizar:</label>
                                <textarea id="txt_rm_obs" class="form-control" rows="5" maxlength="150"></textarea>
                              </div>

                            </div>
                            <div class="row mt-15">
                              <div class="col-md-4">
                                <label><label style="color:red;">*</label>Responsables (Selecciona uno o más)</label>
                                <select class="selectpicker form-control" multiple data-selected-text-format="count > 3" id="slc_responsables" title="SELECCIONA">
                                <?= $responsables?>
                                </select>
                                <br>
                                <textarea id="txt_rm_otropa" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true"></textarea>
                              </div>
                              <div class="col-md-4">
                                <label><label style="color:red;">*</label>Fecha de inicio</label>
                                <input id="datepicker1" disabled />
                                <script>
                                $('#datepicker1').datepicker({
                                  uiLibrary: 'bootstrap4'
                                });
                                </script>
                              </div>

                              <div class="col-md-4">
                                <label><label style="color:red;">*</label>Fecha de término</label>
                                <input id="datepicker2" disabled/>
                                <script>
                                $('#datepicker2').datepicker({
                                  uiLibrary: 'bootstrap4'
                                });
                                </script>
                              </div>
                            </div>
                            <div class="row mt-15">
                              <div class="col-md-6" id="div_otro_responsable">
                                <label>Otro responsable:</label>
                                <input type="text" name="otro_responsable" id="otro_responsable" class="form-control">
                              </div>
                            </div>
                            <div class="row mt-15">
                              <div class="col-md-12">
                                <label><label style="color:red;">*</label>Indicadores de medición:</label>
                                <textarea id="txt_rm_indimed" class="form-control" rows="3" maxlength="150"></textarea>
                              </div>
                            </div>
                            <div class="row mt-15">
                              <div class="col-md-12">
                                <label style="color:red;">*Datos requeridos</label>
                              </div>
                            </div>
                            <div class="row mt-15">
                              <div class="col-12">
                                <button type="button" class="btn btn-primary btn-style-1 ml-20" id="btn_agregar_accion">Agregar</button>
                                <button type="button" class="btn btn-primary btn-style-1 ml-20" id="btn_editando_accion">Editar</button>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div><!-- card -->
                      <div class="row mt-15">
                        <div class="col-12">
                          <button id="id_btn_edita_accion" type="button" title="Editar" class="btn btn-primary"><i class="fas fa-edit"></i></button>
                          <button id="id_btn_elimina_accion" type="button" title="Eliminar" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>
                        </div>
                      </div>
                      <div class="row mt-15">
                        <div class="col-12">
                          <div id="contenedor_acciones_id" style="display:table;"></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <!-- End Modal -->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script> -->



        <!-- <script src="<?= base_url('assets/multiselect/js/bootstrap-select.js'); ?>"></script>
        <script src="<?= base_url('assets/jquery.validate.js'); ?>"></script>
        <script src="<?= base_url('assets/js/jquery.sticky.js'); ?>"></script>
        <script src="<?= base_url('assets/js/main.js'); ?>"></script> -->

        <script src="<?= base_url('assets/js/rutademejora/rm_table_operation.js'); ?>"></script>
        <script src="<?= base_url('assets/js/rutademejora/drag.js'); ?>"></script>
        <script src="<?= base_url('assets/js/rutademejora/rutademejora.js'); ?>"></script>
        <script src="<?= base_url('assets/js/rutademejora/rm_tp.js'); ?>"></script>
        <script src="<?= base_url('assets/js/rutademejora/rm_edith_tp.js'); ?>"></script>
        <script src="<?= base_url('assets/js/rutademejora/rm_delete_tp.js'); ?>"></script>
        <script src="<?= base_url('assets/js/rutademejora/acciones.js'); ?>"></script>
        <script src="<?= base_url('assets/js/rutademejora/avances.js'); ?>"></script>
