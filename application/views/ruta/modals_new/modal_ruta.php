<div class="form-group form-group-style-1">
	<div class="row" style="margin-top:15px;">
		<div class="col-12">
			<div class="alert alert-info" role="alert">
				<div class="row">
					<div class="col-12 col-lg">
						<h4 class="text-justify mb-0"><b>La Meta Grande y Audaz</b>: "Posicionar la educación de Coahuila en los primeros lugares de los indicadores de calidad educativa de la OCDE, para el año 2040".</h4>
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
			<textarea id="txt_rm_mision2" class="form-control" rows="2" readonly style="font-size: 20px;"><?= $mision ?></textarea>
		</div>
	</div>

	<hr class="mt-1 mb-2">
	<div class="row">
		<div class="col-12">
			<button type="button" class="btn btn-success btn-style-1 mr-10" data-dismiss="modal" aria-label="Close">Continuar</button>
		</div>
	</div>
</div>
