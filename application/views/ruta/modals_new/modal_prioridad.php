<style media="screen">
	.btn-file {
		position: relative;
		overflow: hidden;
	}

	.btn-file input[type=file] {
		position: absolute;
		top: 0;
		right: 0;
		min-width: 100%;
		min-height: 100%;
		font-size: 100px;
		text-align: right;
		filter: alpha(opacity=0);
		opacity: 0;
		outline: none;
		cursor: inherit;
		display: block;
	}

	#imagenmuestra{
		width: 120px;
		height: 120px;
	}

	#dv_ver_evidencia{
		margin-left: 50%;
	}

	.cerrar{
		margin-left: 40px;
		margin-top: -10px;
		opacity: 0.2;
		position: absolute;
	}

	#exampleModal_ver_evidencia{
			margin-top: 75%;
	}

	.body_evidencia{
		width: 50%;
	}
</style>

<div class="form-group form-group-style-1" >
	<div class="row">
		<div class="col-sm-12">
			<form id="t_prioritario" enctype="multipart/form-data">
				<div class="row mt-3">
					<div class="col-lg-6">
						<label><span class="badge badge-secondary h5 text-white">1.</span> Problemática(s)</label><br>
						<textarea id="problematica" name="problematica" class="form-control" rows="2" maxlength="400"><?= (isset($problematica))?$problematica:"" ?></textarea>
					</div>

					<div class="col-lg-6 mt-3 mt-lg-0">
						<label><span class="badge badge-secondary h5 text-white">2.</span> Evidencia(s)</label>
						<br>
						<textarea id="evidencias" name="evidencia" class="form-control" rows="2" maxlength="400"><?= (isset($evidencia))?$evidencia:"" ?></textarea>
					</div>
				</div>

				<div class="row mt-4">
					<div class="col-lg-6">
						<label><span class="badge badge-secondary h5 text-white">3.</span> Observaciones del director</label>
						<textarea id="txt_rm_obs_direc" name="comentario_dir" class="form-control" rows="2"><?= (isset($director))?$director:"" ?></textarea>
					</div>

					<div class="col-lg-6 mt-2 mt-lg-0">
						<label><span class="badge badge-secondary h5 text-white">4.</span> Observaciones del supervisor</label>
						<br>
						<textarea id="txt_rm_programayuda" class="form-control" rows="2" maxlength="400"  readonly><?= (isset($supervisor))?$supervisor:"" ?></textarea>
					</div>
				</div>

				<div class="row mt-15">
					<div class="col-12">
						<button type="button" id="grabar_prioridad" class="btn btn-primary btn-style-1 mr-10">Grabar</button>
					</div>
				</div>

				<!-- Grid objetivos -->
				<!-- <div id=""  <?=(isset($idtemaprioritario))?"":"style='display:none'"?> > -->
				<div id="hiddenDiv1" >
					<div class="row mt-4">
						<div class="col-12">
							<label><span class="badge badge-secondary h5 text-white">5.</span> Objetivos y sus metas <em class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Para la prioridad seleccionada escribe un objetivo que inicie con uno de los siguientes verbos (aumentar, disminuir, alcanzar o eliminar) seguido por un indicador concreto (por ejemplo: asistencia, aprovechamiento, ... y en algunos casos enfocados a un nivel educativo, a un grado en particular, a una asignatura...), continuando con una meta numérica de mejora del indicador y finalizando con una fecha de cumplimiento máximo (si es para el final del período escolar se puede omitir este elemento dándolo por entendido)"></em></label>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="alert alert-info" role="alert">
								<div class="row">

									<div class="col">
										<label class="mb-1">
											<span class="badge badge-secondary h5 text-white">1.Verbo </span>
											<span class="badge badge-success h5 text-white ml-2">
												<i class="fas fa-angle-double-right"></i>
											</span>
										</label>

										<select class="form-control" id="slt_verbo" tabindex="-98">
											<option selected='selected' value="0">SELECCIONAR</option>
											<option>LOGRAR</option>
											<option>AUMENTAR</option>
											<option>ELIMINAR</option>
											<option>DISMINUIR</option>
										</select>
									</div>

									<div class="col">
										<label class="mb-1">
											<span class="badge badge-secondary h5 text-white">2.Indicador</span>
											<span class="badge badge-success h5 text-white ml-2">
												<i class="fas fa-angle-double-right"></i>
											</span>
										</label>
										<select class="form-control" id="slt_indicador" tabindex="-98">
											<option selected='selected' value="0">SELECCIONAR</option>
											<?php foreach ($indicadores as $indicador): ?>
												<option value="<?php echo $indicador['id_indicador'] ?>"><?php echo $indicador['indicador'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>

									<div class="col">
										<label class="mb-1">
											<span class="badge badge-secondary h5 text-white">3.Metrica</span>
											<span class="badge badge-success h5 text-white ml-2">
												<i class="fas fa-angle-double-right"></i>
											</span>
										</label>
										<select class="form-control" id="slt_metrica" tabindex="-98">
											<option selected='selected' value="0">SELECCIONAR</option>
											<?php foreach ($metricas as $metrica): ?>
												<option><?php echo $metrica['formula'] ?></option>
											<?php endforeach; ?>
										</select>
									</div>

									<div class="col">
										<label class="mb-1"><span class="badge badge-secondary h5 text-white">4.Meta</span><span class="badge badge-success h5 text-white ml-2"><i class="fas fa-angle-double-right"></i> </span></label>
										<!-- <input type="text" id="slt_meta" class="form-control"> -->
										<textarea id="slt_meta" rows="2" class="form-control" id="slt_meta"></textarea>
										<!-- <select class="form-control" id="slt_meta" tabindex="-98">
											<option selected='selected' value="0">SELECCIONAR</option>
											<option>OPCIÓN 1</option>
											<option>OPCIÓN 2</option>
											<option>OPCIÓN 3</option>
											<option>OPCIÓN 4</option>
										</select> -->
									</div>


									<div class="col">
										<label class="mb-1"><span class="badge badge-secondary h5 text-white">5.Fecha</span><span class="badge badge-success h5 text-white ml-2"><i class="fas fa-angle-double-right"></i> </span></label>

										<select class="form-control" id="slt_fecha" tabindex="-98">
											<option selected='selected' value="0">SELECCIONAR</option>
											<option>Agosto</option>
											<option>Septiembre</option>
											<option>Octubre</option>
											<option>Noviembre</option>
											<option>Diciembre</option>
											<option>Enero</option>
											<option>Febrero</option>
											<option>Marzo</option>
											<option>Abril</option>
											<option>Mayo</option>
											<option>Junio</option>
											<option>Julio</option>
											<option value="-1">Otro</option>
										</select>

										<!-- <input type="text" id="otra_fecha" class="form-control" style="margin-top: 15px"> -->
										<textarea id="otra_fecha" rows="2" class="form-control" style="margin-top:15px"></textarea>
									</div>

									<!-- Boton generar -->
									<div class="col-auto">
										<label class="mb-1 d-block"><span class="badge badge-secondary h5 text-white">6.Generar</span><span class="badge badge-success h5 text-white ml-2"><i class="fas fa-angle-double-down"></i> </span></label>
										<button id="writeText" type="button" class="btn btn-dark btn-block" data-toggle="tooltip" data-placement="top" title="Generar oración">Generar <i class="fas fa-i-cursor"></i>
										</button>
									</div>

								</div> <!-- row -->


								<div class="row mt-3">
									<div class="col">
										<textarea id="CAPoutput" class="form-control" rows="4" style="text-transform: uppercase;" maxlength="400"></textarea>
										<small id="passwordHelpInline" class="text-muted">Máximo 400 caracteres.</small>
										<input type="hidden" id="update_flag" name="" value="0">
									</div>
								</div>
								<div class="row mt-3 float-right">
									<div class="col">
										<label class="mb-1 d-block"><span class="badge badge-secondary h5 text-white">8.Guardar</span><span class="badge badge-success h5 text-white ml-2"><i class="fas fa-angle-double-right"></i> </span></label>
										<button id="grabar_objetivo" type="button" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Grabar Objetivo"><i class="fas fa-check-circle"></i></button>

										<button id="limpiar" type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Limpiar campos"><i class="fas fa-quidditch"></i></button>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- row -->

					<div class="row">
						<div class="col-12">

							<div class="alert alert-info" role="alert">
								<div style="margin-bottom:10px;">

									<button id="btn_editar" type="button" data-toggle="tooltip" title="Editar" class="btn btn-sm btn-success" onclick="btnEditar(id_objetivo)"><i class="fas fa-edit"></i></button>

									<button id="btn_eliminar" type="button" data-toggle="tooltip" title="Eliminar" class="btn btn-sm btn-danger" onclick="btnEliminar(id_objetivo)"><i class='far fa-trash-alt'></i></button>

									<span>Selecciona un objetivo/meta para editar o eliminar</span>

								</div>

								<div class="row" style="margin-top:10px;">

									<div id="objetivo_meta" class="table-responsive" style="display: table;">

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Grid objetivos -->

				<div class="row mt-15">
					<div class="col-12">
						<button type="button" id="salir" class="btn btn-success btn-style-1 mr-10" class="close" data-dismiss="modal">Regresar</button>
					</div>
				</div>

				<?php if (!isset($idtemaprioritario)): ?>
					<input type="hidden" id="id_tema_prioritario" name="id_tema_prioritario" value="0">
				<?php else: ?>
					<input type="hidden" id="id_tema_prioritario" name="id_tema_prioritario" value="<?php echo $idtemaprioritario ?>">
				<?php endif; ?>
			</form>
		</div>
	</div>
</div>

<!--  -->
<div class="modal fade" id="exampleModal_ver_evidencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="overflow-y: scroll;">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content modal-style-1">
			<div class="modal-header bgcolor-2">
				<h5 class="modal-title text-white" id="titulo_ev"> Archivo evidencia</h5>
				<button type="button" class="close" id="cerrar_modal_ver_evidencia" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body body_evidencia">
				<div class="form-group form-group-style-1">

					<div class="row mt-15">
						<div class="col-md-12" id="dv_ver_evidencia"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!--  -->

<input type="hidden" id="nivel" value="  ">
<!-- <input type="hidden" value="" id="idtemap_seleccionado" name="tema_prioritario"> -->
<input type="hidden" value="" id="id_objetivo">


<input type="hidden" id="nivel" value="<?php echo $this->cct[0]['nivel']; ?>">
<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/btn_prioridad.js') ?>"></script>
<!-- <script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/ruta.js') ?>"></script> -->
<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/preview_arch.js') ?>"></script>
