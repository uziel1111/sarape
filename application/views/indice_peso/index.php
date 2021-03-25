<div class="container-fluid">
	<div class="row justify-content-center flex-column mb-3 ml-0 mr-0">
		<nav>
			<div class="nav nav-tabs nav-tabs-style-1" id="nav-tab" role="tablist">
				<a class="nav-item nav-link nav-link-style-1 active" id="nav-ruta-tab" data-toggle="tab" href="#nav-ruta" role="tab" aria-controls="nav-ruta" aria-selected="true">Resumen general</a>
				<a class="nav-item nav-link nav-link-style-1" id="nav-indicadores-tab" data-toggle="tab" href="#nav-indicadores" role="tab" aria-controls="nav-indicadores" aria-selected="false">Recomendaciones</a>
				<a class="nav-item nav-link nav-link-style-1" id="nav-ayuda-tab" data-toggle="tab" href="#nav-ayuda" role="tab" aria-controls="nav-ayuda" aria-selected="false">Preguntas frecuentes</a>
			</div>
		</nav>
		<div class="tab-content tab-content-style-1" id="nav-tabContent">
			<div class="tab-pane fade show active" id="nav-ruta" role="tabpanel" aria-labelledby="nav-ruta-tab">
				<?php if (count($arr_indi_peso)>0): ?>
					<div class="row">
						<div class="col-sm-12">
							<h4>Peso general</h4>
							<div class="row">
								<div class="col-sm">
									<div class="imc_box">
										<div class="imc_box_head">
											Peso Predominante
										</div>
										<div class="imc_box_num">
											<?= $arr_indi_peso[0]['predom']?>
										</div>
										<div class="imc_box_label">
											<?php if ($arr_indi_peso[0]['t_bajo']==1): ?> Bajo-peso
											<?php endif; ?>
											<?php if ($arr_indi_peso[0]['t_normal']==1): ?> Normal
											<?php endif; ?>
											<?php if ($arr_indi_peso[0]['t_sobrepeso']==1): ?> Sobrepeso
											<?php endif; ?>
											<?php if ($arr_indi_peso[0]['t_obesidad']==1): ?> Obesidad
											<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="col-sm">
									<ul class="list-group imc_list">
										<li class="list-group-item d-flex justify-content-between align-items-center <?=($arr_indi_peso[0]['t_bajo']==1)?'list-group-item-info':'' ?>">
											Bajo peso
											<span class="badge <?=($arr_indi_peso[0]['t_bajo']==1)?'badge-primary':'badge-secondary' ?> badge-pill">
												<?=$arr_indi_peso[0]['bajo'] ?>%</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center <?=($arr_indi_peso[0]['t_normal']==1)?'list-group-item-info':'' ?>">
											Normal
											<span class="badge <?=($arr_indi_peso[0]['t_normal']==1)?'badge-primary':'badge-secondary' ?> badge-pill">
												<?=$arr_indi_peso[0]['Normal'] ?>%</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center <?=($arr_indi_peso[0]['t_sobrepeso']==1)?'list-group-item-info':'' ?>">
											Sobrepeso
											<span class="badge <?=($arr_indi_peso[0]['t_sobrepeso']==1)?'badge-primary':'badge-secondary' ?> badge-pill">
												<?=$arr_indi_peso[0]['Sobrepeso'] ?>%</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center <?=($arr_indi_peso[0]['t_obesidad']==1)?'list-group-item-info':'' ?>">
											Obesidad
											<span class="badge <?=($arr_indi_peso[0]['t_obesidad']==1)?'badge-primary':'badge-secondary' ?> badge-pill">
												<?=$arr_indi_peso[0]['Obesidad'] ?>%</span>
										</li>
										<li class="list-group-item d-flex justify-content-between align-items-center <?=($arr_indi_peso[0]['Sobrepeso']+$arr_indi_peso[0]['Obesidad']>20)?'list-group-item-danger':'' ?>">
											Obesidad+Sobrepeso
											<span class="badge <?=($arr_indi_peso[0]['Sobrepeso']+$arr_indi_peso[0]['Obesidad']>20)?'badge-danger':'badge-secondary' ?> badge-pill">
												<?=$arr_indi_peso[0]['Sobrepeso']+$arr_indi_peso[0]['Obesidad'] ?>%</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-sm">
							<h4>Gráfica</h4>
							<?php if ($arr_indi_peso[0]['t_bajo']==1): ?>
							<img src="<?= base_url('assets/img/graficaIMCdemo_1.jpg'); ?>" class="img-fluid" alt="Responsive image">
							<?php endif; ?>
							<?php if ($arr_indi_peso[0]['t_normal']==1): ?>
							<img src="<?= base_url('assets/img/graficaIMCdemo_2.jpg'); ?>" class="img-fluid" alt="Responsive image">
							<?php endif; ?>
							<?php if ($arr_indi_peso[0]['t_sobrepeso']==1): ?>
							<img src="<?= base_url('assets/img/graficaIMCdemo_3.jpg'); ?>" class="img-fluid" alt="Responsive image">
							<?php endif; ?>
							<?php if ($arr_indi_peso[0]['t_obesidad']==1): ?>
							<img src="<?= base_url('assets/img/graficaIMCdemo_4.jpg'); ?>" class="img-fluid" alt="Responsive image">
							<?php endif; ?>
						</div>
					</div>
					<div class="row mt-10">
						<div class="col-sm">
							<div class="alert alert-warning" role="alert">
								<?php if ($arr_indi_peso[0]['t_bajo']==1): ?>
								Se recomienda aumentar la densidad calórica de la dieta incorporando o aumentando las grasas vegetales, frutas y productos lácteos; es recomendable ejercicios de fuerza de 2 a 3 veces por semana.
								<?php endif; ?>
								<?php if ($arr_indi_peso[0]['t_normal']==1): ?>
								Se recomienda fomentar la activación física, así como una dieta saludable que incluya el consumo de frutas y verduras en la población infantil y adolescente.
								<?php endif; ?>
								<?php if ($arr_indi_peso[0]['t_sobrepeso']==1): ?>
								Se recomienda incluir programas educativos orientados a la mejora de la dieta, la actividad física y la disminución del sedentarismo, que incluyan a la familia y al personal académico
								<?php endif; ?>
								<?php if ($arr_indi_peso[0]['t_obesidad']==1): ?>
								Se recomienda incluir programas educativos orientados a la mejora de la dieta, la actividad física y la disminución del sedentarismo, que incluyan a la familia y al personal académico
								<?php endif; ?>
								<a href="http://checatemidetemuevete.gob.mx/" target="_blank"></a>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<?php if (count($arr_indi_peso)==0): ?>
					<b>Información no disponible por el momento.</b>
				<?php endif; ?>

			</div>
			<div class="tab-pane fade" id="nav-indicadores" role="tabpanel" aria-labelledby="nav-indicadores-tab">
				<div class="row mt-10">
					<div class="col-sm">
						<div class="alert alert-warning" role="alert">
							<p>Chécate y prevé, acude con tu médico incluso si no tienes ninguna molestia. Es mucho más fácil prevenir que remediar. Localiza tu clínica más cercana. Para mas información visita:
							</p>
							<p class="text-center">

							<a class="btn btn-success btn-style-1" href="http://checatemidetemuevete.gob.mx/" target="_blank"><i class="fas fa-heartbeat"></i> Chécate, Mídete, Muévete</a>
							</p>
						</div>
					</div>
				</div>
				<a href="<?= base_url('assets/img/bmi-and-obesity.jpg'); ?>">
					<img src="<?= base_url('assets/img/bmi-and-obesity.jpg'); ?>" class="img-fluid" alt="Responsive image"/></a>
			</div>


			<div class="tab-pane fade" id="nav-ayuda" role="tabpanel" aria-labelledby="nav-ayuda-tab">
				<div class="card bg-light mb-3">
					<div class="card-header"><span class="badge badge-secondary h5 text-white">1.</span> ¿Qué es el índice de masa corporal?</div>
					<div class="card-body">
						<p class="card-text">El índice de masa corporal (IMC) es un método utilizado para estimar la cantidad de grasa corporal que tiene una persona, y determinar por tanto si el peso está dentro del rango normal, o por el contrario, se tiene sobrepeso o delgadez. Para ello, se pone en relación la estatura y el peso actual del individuo. Esta fórmula matemática fue ideada por el estadístico belga Adolphe Quetelet, por lo que también se conoce como índice de Quetelet o Body Mass Index (BMI).</p>
					</div>
				</div>
				<div class="card bg-light mb-3">
					<div class="card-header"><span class="badge badge-secondary h5 text-white">2.</span> ¿Cómo se calcula?</div>
					<div class="card-body">
						<p class="card-text">El IMC es una fórmula que se calcula dividiendo el peso, expresado siempre en Kg, entre la altura, siempre en metros al cuadrado. Una cosa importante que destaca la nutricionista es que no se pueden aplicar los mismos valores en niños y adolescentes que en adultos. “Para calcular el IMC en niños se utilizan los percentiles. Estos son una media en los que se establece el peso del niño y se le relaciona con sus iguales de edad y sexo, dentro de la misma área; y si está en la media, tiene un peso adecuado; si está por encima, habría un percentil alto, por lo que tendrían obesidad, y si está por debajo, se calificaría como un bajo peso”, indica Escalada. </p>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
