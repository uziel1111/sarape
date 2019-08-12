<link rel="stylesheet" href="<?= base_url('assets/multiselect/css/bootstrap-select.min.css') ?>">

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
					<div class="col-md-2">
						<label style="color:red;">*Datos requeridos</label>
					</div>
					<div class="col-10 float-right">
						<button type="button" class="btn btn-primary btn-style-1 ml-20" id="btn_agregar_accion">Agregar</button>
						<button type="button" class="btn btn-primary btn-style-1 ml-20" id="btn_editando_accion">Editar</button>
					</div>
				</div>
				<div class="row mt-15">
					
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

</div


<script src="<?= base_url('assets/js/rutademejora/rutademejora.js'); ?>"></script>
<script src="<?= base_url('assets/js/rutademejora/acciones.js'); ?>"></script>
