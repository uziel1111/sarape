<style type="text/css">
  .selected {
    background-color: #9ccc65;
    color: #FFF;
  }
  .custom-width-modal {
    width: 500%;
  }
</style>
<!-- Multiselect -->
<link rel="stylesheet" href="<?= base_url('assets/multiselect/css/bootstrap-select.min.css') ?>">
<script src="<?= base_url('assets/multiselect/js/bootstrap-select.min.js'); ?>"></script>
<!-- Modal -->
<div class="modal fade" id="modal_visor_acciones_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-style-1">
      <div class="modal-header bgcolor-2">
        <h5 class="modal-title text-white" id="exampleModalLabel">Acciones por prioridad del Sistema Básico de Mejora</h5>
        <button type="button" class="close" id="cerrar_modal_acciones_super" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info" role="alert">
          Escuela: <span class="fw800"><label id="label_escuela"><?= $escuela?></label></span><br>

          Linéa de Acción Estrategica: <span class="fw800"><label id="label_prioridad"><?= $prioridad?></label></span><br>

          Problemática(s): <span class="fw800"><label id="label_problematica"><?= $problematicas?></label></span><br>

          Evidencia(s): <span class="fw800"><label id="label_evidencia"><?= $evidencias?></label></span>
        </div>
        <div class="card mb-3 card-style-1">
          <div class="card-header card-1-header bg-light">ESTRATEGIA GLOBAL DE MEJORA</div>
          <div class="card-body">
            <div class="card-block">
              <div class="form-group form-group-style-1">
                <div class="row">
                      <!-- <div class="col-md-6">
                        <label><label style="color:red;">*</label>Ambitos:</label>
                        <select class="form-control" id="slc_rm_ambito" title="SELECCIONA UN AMBITO" disabled>
                     
                                  <option value="</option>
                          <?php// ?>
                        </select>
                      </div> -->
                    </div>
                    <div class="row mt-15">
                      <div class="col-12">
                        <button id="id_btn_inspeccionar_accion" type="button" title="Ver" class="btn btn-primary"><i class="far fa-eye"></i></button>
                      </div>
                    </div>
                    <div class="row mt-15">
                      <div class="col-12">
                        <div id="contenedor_acciones_id_super">
                          <?= $tacciones?>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-15">
                      <div class="col-md-6">
                        <label><label style="color:red;">*</label>Acción:</label>
                        <textarea id="txt_rm_meta" class="form-control" rows="5" maxlength="150" disabled></textarea>
                      </div>
                      <div class="col-md-6">
                        <label><label style="color:red;">*</label>Materiales e insumos a utilizar:</label>
                        <textarea id="txt_rm_obs" class="form-control" rows="5" maxlength="150" disabled></textarea>
                      </div>

                    </div>
                    <div class="row mt-15">
                      <div class="col-md-4">
                        <label><label style="color:red;">*</label>Responsables (Selecciona uno o más)</label>
                        <textarea id="txt_rm_sup_personal" class="form-control" rows="5" maxlength="150" disabled=""></textarea>
                        <br>
                        <textarea id="txt_rm_otropa" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true" disabled></textarea>
                      </div>
                      <div class="col-md-3">
                        <label><label style="color:red;">*</label>Fecha de inicio</label>
                        <input id="datepicker1" disabled />
                        <script>
                          $('#datepicker1').datepicker({
                            uiLibrary: 'bootstrap4'
                          });
                        </script>
                      </div>

                      <div class="col-md-3">
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
                        <input type="text" name="otro_responsable" id="otro_responsable" class="form-control" disabled>
                      </div>
                    </div>
                    <!-- <div class="row mt-15">
                      <div class="col-md-12">
                        <label><label style="color:red;">*</label>Indicadores de medición:</label>
                        <textarea id="txt_rm_indimed" class="form-control" rows="3" maxlength="150" disabled></textarea>
                      </div>
                    </div> -->
                    <div class="row mt-15">
                      <div class="col-md-12">
                        <label style="color:red;">*</label>Datos obligatorios
                      </div>
                    </div>
                  </div>

                </div>
              </div><!-- card -->

            </div><!-- final despues del card card mb-3 card-style-1-->
          </div><!-- fin del body -->
        </div>
      </div>
    </div> <!-- End Modal -->


    <script src="<?= base_url('assets/js/rutademejora/supervisor/jsacciones.js'); ?>"></script>