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

	<!-- Start Main Area -->
	<section class="main-area">
		<div class="container">
      <div class="alert alert-success text-center" role="alert" style="margin-bottom: 30px;">
        <h3>Planeación y despliegue estrategico</h3>
      </div>
			<div class="row justify-content-center flex-column mb-3">
				<nav>
					<div class="nav nav-tabs nav-tabs-style-1" id="nav-tab" role="tablist">
						<a class="nav-item nav-link nav-link-style-1 active" id="nav-ruta-tab" data-toggle="tab" href="#nav-ruta" role="tab" aria-controls="nav-ruta" aria-selected="true">Planeación estrategica</a>
						<a class="nav-item nav-link nav-link-style-1" id="nav-avances-tab" data-toggle="tab" href="#nav-avances" role="tab" aria-controls="nav-avances" aria-selected="false">Avances por actividades</a>
						<a class="nav-item nav-link nav-link-style-1" id="nav-ayuda-tab" data-toggle="tab" href="#nav-ayuda" role="tab" aria-controls="nav-ayuda" aria-selected="false">Ayuda</a>
					</div>
				</nav>
				<div class="tab-content tab-content-style-1" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-ruta" role="tabpanel" aria-labelledby="nav-ruta-tab">
						<div class="row">

							<div class="col">
								<span data-toggle="modal" data-target="#mision">
								<button type="button" id="btn_mision" data-toggle="tooltip" title="Misión" class="btn btn-lg btn-primary"><i class="fas fa-flag" ></i></button>
								</span>

								<span data-toggle="modal" data-target="#prioridad">
								<button type="" id="btn_prioridad" data-toggle="tooltip" title="Agregar a planeación estrategica" class="btn btn-lg btn-primary" data-target="#myModal" data-dismiss="modal"><i class="fas fa-plus-square" ></i></button>
								</span>

								<span data-toggle="modal" data-target="#actividades">
								<button type="button" id="btn_rutamejora_acciones" title="Crear actividades" data-toggle="tooltip" title="Crear actividades" class="btn btn-lg btn-primary" ><i class="fas fa-tasks"></i></button>
								</span>
								<a class="btn btn-lg btn-primary" id="btn_get_reporte_1" title="Generar reporte" target="_blank" href="<?= base_url('index.php/Reporte/get_reporte') ?>"><i class="fas fa-print" ></i></a>
							</div>

						</div>
						<div class="row mt-15">

              <div class="col-12">
								<div id="contenedor_tabla" style="display: table;"></div>

              </div>
						</div>
					</div> <!-- Ruta mejora -->

					<div class="tab-pane fade" id="nav-avances" role="tabpanel" aria-labelledby="nav-avances-tab">
						<?= $vista_avance ?>
					</div> <!-- Avances -->

					<div class="tab-pane fade" id="nav-ayuda" role="tabpanel" aria-labelledby="nav-ayuda-tab">
						<?= $vista_ayuda ?>
					</div> <!-- Ayuda -->

				</div> <!-- tab-content -->
			</div> <!-- row -->
		</div> <!-- container -->

</section>

<!-- modal -->
<div id="myModal" class="modal fade" role="dialog" aria-labelledby="prioridad_modal" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-style-1" style="width: 112% !important; margin-left:-25px !important; align:center !important;">
			<div class="modal-header bg-dark">
				<h5 class="modal-title text-white" id="prioridad_modal"><i class="far fa-lightbulb"></i> </h5>
				<button type="button" class="close" id="close" data-target="#myModal" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body" >
				<div id="div_generico">

				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="exampleModalacciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-style-1">
			<div class="modal-header bgcolor-2">
				<h5 class="modal-title text-white" id="exampleModalLabel">Actividades por prioridad del Sistema Básico de Mejora</h5>
				<button type="button" class="close" id="cerrar_modal_acciones" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="alert alert-info" role="alert">
					Escuela: <span class="fw800"><label id="label_escuela"></label></span><br>

					Linea de acción: <span class="fw800"><label id="label_prioridad"></label></span><br>

					Problemática(s): <span class="fw800"><label id="label_problematica"></label></span><br>

					Evidencia(s): <span class="fw800"><label id="label_evidencia"></label></span>
				</div>
				<div class="card mb-3 card-style-1">
					<div class="card-header card-1-header bg-light">Actividades</div>
					<div class="card-body">
						<div class="card-block">
							<div class="form-group form-group-style-1">

                <div class="row mt-15">
                  <div class="col-md-12">
                    <label><label style="color:red;">*</label>Seleccione un objetivo/meta:</label>
										<select class="form-control" id="id_objetivos">
                        <option value="0">SELECCIONE</option>
                    </select>

									</div>
                </div>

								<div class="row mt-15">
									<div class="col-md-6">
										<label><label style="color:red;">*</label>Actividad:</label>
										<textarea id="txt_rm_meta" class="form-control" rows="5" maxlength="150"></textarea>
									</div>
									<div class="col-md-6">
										<label><label style="color:red;">*</label>Recursos:</label>
										<textarea id="txt_rm_obs" class="form-control" rows="5" maxlength="150"></textarea>
									</div>

								</div>

                <div class="row mt-15">
                  <div class="col-md-12">
                    <label><label style="color:red;">*</label>Responsable</label>
                    <select class="selectpicker form-control" id="main_responsable" title="SELECCIONA">
                    <?= $responsables?>
                    </select>
                    <br>
                    <textarea id="new_resp" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true"></textarea>
                  </div>
                </div>
                <div class="row mt-15">
									<div class="col-md-12" id="main_resp_2">
										<label>Otro responsable:</label>
										<input type="text" name="otro_resp" id="otro_resp" class="form-control" placeholder="Escribe el nombre del responsable">
									</div>
								</div>

								<div class="row mt-15">

									<div class="col-md-12">
										<label><label style="color:red;">*</label>Profesores que apoyan</label>
										<select class="selectpicker form-control" multiple data-selected-text-format="count > 3" id="slc_responsables" title="SELECCIONA">
										<?= $responsables?>
										</select>
										<br>
										<textarea id="txt_rm_otropa" class="form-control" rows="1" placeholder="Escriba que otro" hidden="true"></textarea>
									</div>

								</div>
								<div class="row mt-15">
									<div class="col-md-12" id="div_otro_responsable">
										<label>Otro responsable:</label>
										<input type="text" name="otro_responsable" id="otro_responsable" class="form-control">
									</div>
								</div>

								<div class="row mt-15">
									<div class="col-md-6">
										<label><label style="color:red;">*</label>Fecha de inicio</label>
										<input id="datepicker1" disabled />
										<script>
										$('#datepicker1').datepicker({
											uiLibrary: 'bootstrap4'
										});
										</script>
									</div>

									<div class="col-md-6">
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
									<!-- <div class="col-md-12">
										<label><label style="color:red;">*</label>Indicadores de medición:</label>
										<textarea id="txt_rm_indimed" class="form-control" rows="3" maxlength="150"></textarea>
									</div>
								</div> -->
								<div class="row mt-15">
									<div class="col-md-12">
										<label style="color:red;">*Datos requeridos</label>
									</div>
								</div>
								<div class="row mt-15">
									<div class="col-12">
										<button type="button" class="btn btn-primary btn-style-1 ml-20" id="btn_agregar_accion">Agregar actividad</button>
										<button type="button" class="btn btn-primary btn-style-1 ml-20" id="btn_editando_accion">Editar</button>
                    <button type="button" id="saliract" class="btn btn-success btn-style-1 mr-10">Regresar</button>
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
							<div id="contenedor_acciones_id"></div>
				</div>
			</div>
      <!-- <input type="text" name="" value="" id="tmp_tprioritario">      -->
		</div>
	</div>
</div>
</div>
</div>
</div>
<!-- fin modal -->


<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/btn_delete_tp.js') ?>"></script>


<script src="<?= base_url('assets/js/rutademejora/rm_table_operation.js'); ?>"></script>
<!-- <script src="<?= base_url('assets/js/rutademejora/drag.js'); ?>"></script> -->
<script src="<?= base_url('assets/js/rutademejora/rutademejora.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/rm_tp.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/rm_edith_tp.js'); ?>"></script>
<!-- <script src="<?= base_url('assets/js/rutademejora/rm_delete_tp.js'); ?>"></script> -->
<script src="<?= base_url('assets/js/rutademejora/acciones.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/avances.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/ruta.js') ?>"></script>
