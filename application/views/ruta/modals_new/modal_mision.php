<div class="form-group form-group-style-1">
	<div class="row">
		<div class="col-12">
			<div class="alert alert-info" role="alert">
				<div class="row">
					<div class="col-12 col-lg">
						<p class="text-justify mb-0">Con el propósito de fortalecer la calidad educativa en Coahuila le proponemos definir la <b>Misión</b> de su escuela.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php $misionT = "En esta sección se hace una descripción breve (de no más de 80 palabras proximadamente) \nque clarifique cuál es la contribución que debe hacer la escuela a la comunidad donde radica, \ndónde se verá su impacto positivo y de qué forma deberá ser vista por quienes interactúan con ella \n(alumnos, padres de familia, autoridades locales, sociedad en general)" ?>
	<div class="row">
		<div class="col-12">
			<label class="mb-1"><span class="badge badge-secondary h4 text-white">Misión</span></label>
			<small class="text-muted">En este ciclo escolar quiero que mi escuela...</small> <em class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="<?= $misionT ?>"></em>
						<textarea id="txt_rm_mision" class="form-control" rows="2" maxlength="150" style="font-size: 20px;"><?= $mision ?></textarea>
						<small id="passwordHelpInline" class="text-muted">Máximo 150 caracteres.</small>

		</div>
	</div>

	<hr class="mt-1 mb-2">
	<div class="row">
		<div class="col-12">
			<button type="button" id="btn_grabar" class="btn btn-success btn-style-1 mr-10" data-dismiss="modal" aria-label="Close">Guardar</button>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/rutademejora/rutademejora_new/btn_grabar_mision.js') ?>"></script>
