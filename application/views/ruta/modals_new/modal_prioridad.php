
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

	.ocultar{
		display: none;
	}
</style>

<div class="form-group form-group-style-1" >
	<div class="row">
		<div class="col-sm-12">
			<form id="t_prioritario" enctype="multipart/form-data">
				<div class="row mt-3">
					<div class="col-lg-6">
						<label><span class="badge badge-secondary h5 text-white">1.</span>Ámbito(s):<span style="color:red">*</span></label><br>
						<!-- <textarea id="problematica" name="problematica" class="form-control" rows="2" maxlength="400"><?= (isset($problematica))?$problematica:"" ?></textarea> -->
						<?php switch ($prioridad) {
							case '1': ?>
							<select class="selectpicker problematica form-control"  title="Seleccione el ámbito" multiple name="problematica" tabindex="-98" >
								<option value="Infraestructura y equipamiento." selected >Infraestructura y equipamiento.</option>
							</select>
							<?php 	break;
							case '2':?>
							<select class="selectpicker problematica form-control"  title="Seleccione el(los) ámbito(s)" multiple name="problematica" tabindex="-98" >
								<option value="Aprovechamiento académico y asistencia de los alumnos.">Aprovechamiento académico y asistencia de los alumnos.</option>
								<option value="Avance de los planes y programas educativos.">Avance de los planes y programas educativos.</option>
							</select>
							<?php 	break;
							case '3':?>
							<select class="selectpicker problematica form-control"  title="Seleccione el ámbito" multiple name="problematica" tabindex="-98" >
								<option value="Formación docente." selected>Formación docente.</option>
							</select>
							<?php 	break;	
							case '4':?>
							<select class="selectpicker problematica form-control"  title="Seleccione el ámbito" multiple name="problematica" tabindex="-98" >
								<option value="Corresponsabilidad (Apoyo al aprendizaje en el hogar)" selected>Corresponsabilidad (Apoyo al aprendizaje en el hogar)</option>
							</select>
							<?php 	break;
							case '5':?>
							<select class="selectpicker problematica form-control"  title="Seleccione la(s) problemática(s) por ámbito(s)" multiple name="problematica" tabindex="-98" >
								<option value="Prácticas docentes y directivas.">Prácticas docentes y directivas.</option>
								<option value="Desempeño de la autoridad escolar.">Desempeño de la autoridad escolar.</option>
								<option value="Carga administrativa.">Carga administrativa.</option>
							</select>
							<?php 	break;
						} ?>
					</div>
					<div class="col-lg-6 mt-3 mt-lg-0">
						<label><span class="badge badge-secondary h5 text-white">2.</span> Problemática<span style="color:red">*</span></label>
						<br>
					<textarea id="problematicaTxt" name="problematica" class="form-control problematicaTxt" rows="2" maxlength="400"><?= (isset($problematica))?$problematica:"" ?></textarea>
				</div>
				</div>
					<!-- <div class="col-lg-6 mt-3 mt-lg-0"> -->
						<div class="row mt-4">
						<div class="col-lg-6">
						<label><span class="badge badge-secondary h5 text-white">3.</span> Evidencia(s)<span style="color:red">*</span></label>
						<br>
						<textarea required id="evidencias" name="evidencia" class="form-control" rows="2" maxlength="400" style="height: 100px !important;"><?= (isset($evidencia))?$evidencia:"" ?></textarea>
					</div>
				

				
					<div class="col-lg-6">
						<label><span class="badge badge-secondary h5 text-white">4.</span> Observaciones del director<span style="color:red">*</span></label>
						<textarea required id="txt_rm_obs_direc" name="comentario_dir" class="form-control" rows="2" style="height: 100px !important;"><?= (isset($director))?$director:"" ?></textarea>
					</div>

					<div class="col-lg-12 mt-2 mt-lg-0">
						<label><span class="badge badge-secondary h5 text-white">5.</span> Observaciones del supervisor</label>
						<br>
						<textarea id="txt_rm_programayuda" class="form-control" rows="2" maxlength="400"  readonly><?= (isset($supervisor))?$supervisor:"" ?></textarea>
					</div>
				</div>

					<div class="row mt-15">
						<div class="col-12">
							<button type="button" id="grabar_prioridad" class="btn btn-primary btn-style-1 mr-10">Guardar</button>
							<span style="color:red">*</span><span>Requisito obligatorio</span>
						</div>
					</div>
			

				<!-- Grid objetivos -->
					<div id="hiddenDiv1" >
						<div class="row mt-4">
							<div class="col-12">
								<label><span class="badge badge-secondary h5 text-white">6.</span> Objetivo(s)<em class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Para la(s) problemática(s) mencionada(s) escribe un objetivo que inicie con uno de los siguientes verbos (aumentar, disminuir, alcanzar o eliminar) seguido por un indicador concreto (por ejemplo: asistencia, aprovechamiento, ... y en algunos casos enfocados a un nivel educativo, a un grado en particular, a una asignatura...), continuando con una meta numérica de mejora del indicador y finalizando con una fecha de cumplimiento máximo (si es para el final del período escolar se puede omitir este elemento dándolo por entendido)"></em></label>
							</div>
						</div>
						

						<div class="col-md-12">
							<div class="row">
								<?php switch ($prioridad) {

									case '2': ?>

									<div class="col-md-6">

										<?php if ($nivel_escolar == 2): ?>

											<select class="form-control slt_objetivo_estatal" tabindex="-98">
												<option selected='selected' value="0">SELECCIONAR UN OBJETIVO ESTATAL</option>
												<option value="Alcanzar el desarrollo de capacidades de los niños y niñas al menos en un 80% a junio del 2020.">Alcanzar el desarrollo de capacidades de los niños y niñas al menos en un 80% a junio del 2020.</option>

											</select>
										<?php endif ?>

										<?php if ($nivel_escolar == 3): ?>

											<select class="form-control slt_objetivo_estatal" tabindex="-98">
												<option selected='selected' value="0">SELECCIONAR UN OBJETIVO ESTATAL</option>
												<option value="Lograr que los alumnos alcancen por lo menos el 80% de los aprendizajes esperados del grado en curso al término del ciclo escolar 2019 - 2020.">Lograr que los alumnos alcancen por lo menos el 80% de los aprendizajes esperados del grado en curso al término del ciclo escolar 2019 - 2020.</option>

											</select>
										<?php endif ?>


										<?php if ($nivel_escolar == 4): ?>

											<select class="form-control slt_objetivo_estatal" tabindex="-98">
												<option selected='selected' value="0">SELECCIONAR UN OBJETIVO ESTATAL</option>
												<option value="Aumentar a 60% el porcentaje de aciertos de alumnos de sexto grado en español y matemáticas en OCI censal.">Aumentar a 60% el porcentaje de aciertos de alumnos de sexto grado en español y matemáticas en OCI censal.</option>
												<option value="Lograr que al menos el 70% de los alumnos de primaria alcance el nivel esperado de los aprendizajes (8, 9 y 10 de calificación en exámenes estandarizados) de acuerdo a las evaluaciones trimestrales.">Lograr que al menos el 70% de los alumnos de primaria alcance el nivel esperado de los aprendizajes (8, 9 y 10 de calificación en exámenes estandarizados) de acuerdo a las evaluaciones trimestrales.</option>

											</select>
										<?php endif ?>

										<?php if ($nivel_escolar == 5): ?>

											<select class="form-control slt_objetivo_estatal" tabindex="-98">
												<option selected='selected' value="0">SELECCIONAR UN OBJETIVO ESTATAL</option>
												<option value="Aumentar los índices de aprendizaje en Español y Matemáticas en un 30% a toda la población educativa del Nivel de Secundaria, a julio de 2020, según prueba estandarizada estatal (gestión - IDDIEE).">Aumentar los índices de aprendizaje en Español y Matemáticas en un 30% a toda la población educativa del Nivel de Secundaria, a julio de 2020, según prueba estandarizada estatal (gestión - IDDIEE).</option>

											</select>
										<?php endif ?>
									</div>
									<div class="col-md-3">
										<button id="" type="button" class="btn_objetivo_estatal btn btn-dark  ocultar" data-toggle="tooltip" data-placement="top" title="Generar oración">Agregar <i class="fas fa-check"></i>
										</button>
									</div>
									<?php break;
									case '4': ?>

									<div class="col-md-6">
										<?php if ($nivel_escolar == 2): ?>

											<select class="form-control slt_objetivo_estatal" tabindex="-98">
												<option selected='selected' value="0">SELECCIONAR UN OBJETIVO ESTATAL</option>
												<option value="Alcanzar el cumplimiento de padres de familia al menos en un 80% en la crianza compartida.">Alcanzar el cumplimiento de padres de familia al menos en un 80% en la crianza compartida.</option>

											</select>
										<?php endif ?>

										<?php if ($nivel_escolar == 3): ?>

											<select class="form-control slt_objetivo_estatal" tabindex="-98">
												<option selected='selected' value="0">SELECCIONAR UN OBJETIVO ESTATAL</option>
												<option value="Lograr la operación del 80% de los CEPS registrados en el ciclo escolar 2019 - 2020.">Lograr la operación del 80% de los CEPS registrados en el ciclo escolar 2019 - 2020.</option>
												<option value="Lograr que el 20% de los padres de familia de cada plantel se involucren en las actividades escolares.">Lograr que el 20% de los padres de familia de cada plantel se involucren en las actividades escolares.</option>
											</select>
										<?php endif ?>


										<?php if ($nivel_escolar == 4): ?>

											<select class="form-control slt_objetivo_estatal" tabindex="-98">
												<option selected='selected' value="0">SELECCIONAR UN OBJETIVO ESTATAL</option>
												<option value="Alcanzar que el 100% de los Padres de Familia de alumnos en riesgo se involucre en actividades de apoyo al aprendizaje trimestralmente durante el ciclo escolar.">Alcanzar que el 100% de los Padres de Familia de alumnos en riesgo se involucre en actividades de apoyo al aprendizaje trimestralmente durante el ciclo escolar.</option>

											</select>
										<?php endif ?>

										<?php if ($nivel_escolar == 5): ?>

											<select class="form-control slt_objetivo_estatal" tabindex="-98">
												<option selected='selected' value="0">SELECCIONAR UN OBJETIVO ESTATAL</option>
												<option value="Aumentar la generación de ambientes de colaboración y corresponsabilidad con los padres de familia en al menos un 80% del total de la población, a julio 2020.">Aumentar la generación de ambientes de colaboración y corresponsabilidad con los padres de familia en al menos un 80% del total de la población, a julio 2020.</option>

											</select>
										<?php endif ?>
									</div>
									<div class="col-md-3">
										<button id="" type="button" class="btn_objetivo_estatal btn btn-dark  ocultar" data-toggle="tooltip" data-placement="top" title="Generar oración">Agregar <i class="fas fa-check"></i>
										</button>
									</div>
									<?php break; } ?>
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
													<span class="badge badge-secondary h5 text-white">3.Métrica</span>
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
										<label class="mb-1 d-block"><span class="badge badge-secondary h5 text-white">5.Ciclo</span><span class="badge badge-success h5 text-white ml-2"><i class="fas fa-angle-double-right"></i> </span></label>
										<select class="form-control" id="slt_ciclo" tabindex="-98">
											<option selected='selected' value="0">SELECCIONAR</option>
											<option>2019-2020</option>
											<option>2020-2021</option>
											<option>2021-2022</option>
										</select>

									</div>


									<div class="col">
										<label class="mb-1"><span class="badge badge-secondary h5 text-white">6.Fecha</span><span class="badge badge-success h5 text-white ml-2"><i class="fas fa-angle-double-right"></i> </span></label>

										<select class="form-control" id="slt_fecha" tabindex="-98">
											<option selected='selected' value="0">SELECCIONAR</option>
											<option>Enero</option>
											<option>Febrero</option>
											<option>Marzo</option>
											<option>Abril</option>
											<option>Mayo</option>
											<option>Junio</option>
											<option>Julio</option>
											<option>Agosto</option>
											<option>Septiembre</option>
											<option>Octubre</option>
											<option>Noviembre</option>
											<option>Diciembre</option>
											<option value="-1">Otro</option>
										</select>

										<!-- <input type="text" id="otra_fecha" class="form-control" style="margin-top: 15px"> -->
										<textarea id="otra_fecha" rows="2" class="form-control" style="margin-top:15px"></textarea>
									</div>

									<!-- Boton generar -->
									<div class="col-auto">
										<button id="writeText" type="button" class="btn btn-dark btn-block" data-toggle="tooltip" data-placement="top" title="Generar oración">Generar<i class="fas fa-i-cursor"></i>
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
					
										<button id="grabar_objetivo" type="button" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Grabar Objetivo"><i id="btn_guardar" class="fas fa-save"></i></button>
					
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
	<script src="<?= base_url('assets/multiselect/js/bootstrap-select.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/btn_prioridad.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/preview_arch.js') ?>"></script>


