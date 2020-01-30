<section class="main-area">
	<div class="container">
		<a href="javascript:" id="return-to-top"><span class="color-4"><i class="material-icons">keyboard_arrow_up</i></span></a>
		<div class="card mb-3 card-style-1">
			<div class="card-header card-1-header bg-light">
				<?php if (isset($cve_centro)) { ?>
				Datos generales
				<button class="btn btn-warning btn-style-1 color-6 mb-3" onclick="goBack()">Regresar</button>
				<input hidden type="text" id="in_cct" value="<?=$cve_centro?>">
				<input hidden type="text" id="in_turno" value="<?=$turno?>">
				<input hidden type="text" id="in_nivel" value="<?=$nivel?>">
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col">
						Nombre del centro de trabajo:
						<label class="fw800">
							<?=$nombre_centro?>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col">
						CCT:
						<label class="fw800">
							<?=$cve_centro?>
						</label>
					</div>
					<div class="col">
						Turno:
						<label class="fw800">
							<?=strtoupper($desc_turno)?>
						</label>
					</div>
					<div class="col">
						Nivel:
						<label class="fw800">
							<?=$nivel?>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col">
						Modalidad:
						<label class="fw800">
							<?=$modalidad?>
						</label>
					</div>
					<div class="col">
						Sostenimiento:
						<label class="fw800">
							<?=$sostenimiento?>
						</label>
					</div>
					<div class="col">
						Región:
						<label class="fw800">
							<?=$region?>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col">
						Domicilio:
						<label class="fw800">
							<?=$domicilio?>
						</label>
					</div>
					<div class="col">
						Localidad:
						<label class="fw800">
							<?=$localidad?>
						</label>
					</div>
					<div class="col">
						Municipio:
						<label class="fw800">
							<?=$municipio?>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col">
						Nombre del director:
						<label class="fw800">
							<?=$nombre_director?>
						</label>
					</div>
					<div class="col">
						Estatus de la escuela:
						<label class="fw800">
							<?=$estatus?>
						</label>
					</div>
				</div>
					<div class="row">
						<div class="col-md-12 offset-md-5">
							<a class="btn btn-lg btn-success btn-style-1" target="_blank" style="color:white;" href="http://siecec.seducoahuila.gob.mx/centros/reportes/ficha_tecnica.php?cct=<?=$cve_centro?>">Ficha Técnica</a>
							</div>
					</div>
			</div>
		</div>
		<div class="card mb-3 card-style-1">
			<div class="card-header card-1-header bgcolor-2 text-white">Indicadores del Modelo Educativo de Coahuila</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6 mb-2">
						<div class="alert alert-info h-100" role="alert">
							<h4 class="alert-heading"><i class="fas fa-book"></i> Modelo educativo</h4>
							<hr>
							<p>Conozca datos relevantes de la escuela haciendo clic en cada sección correspondiente a un indicador del modelo educativo del estado: <strong>Asistencia</strong>, <strong>Permanencia</strong> y <strong>Aprendizaje</strong>.</p>
						</div>
					</div>
					<div class="col-md-6 mb-2">
						<div class="alert alert-success h-100" role="alert">
							<h4 class="alert-heading"><i class="fas fa-hand-holding-heart"></i> Salud escolar</h4>
							<hr>
							<p>Asimismo puede consultar un resumen general sobre los indicadores de peso en la escuela haciendo clic en el siguiente botón: </p>
							<p class="text-center mb-0">
								<?php if ($trae_indicpeso > 0): ?>
									<button class="btn btn-lg btn-success btn-style-1" id="btn_indice_peso">Índice de peso</button>
								<?php endif; ?>
								<?php if ($trae_indicpeso == 0): ?>
									<b>Información no disponible por el momento.</b>
								<?php endif; ?>

							</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 text-center">
						<ul class="nav nav-pills nav-apa nav-fill">
							<li class="nav-item">
								<a class="nav-link nav-link-apa bgcolor-1 mt-2" class="btn btn-secondary btn-style-1" id="btn_info_asist" data-toggle="tab"><span class="fz-30"><i class="material-icons">done_all</i></span><br><span class="fz-30">Asistencia</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link nav-link-apa bgcolor-2 mt-2" class="btn btn-secondary btn-style-1" id="btn_info_perma" data-toggle="tab"><span class="fz-30"><i class="material-icons">timeline</i></span><br><span class="fz-30">Permanencia</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link nav-link-apa bgcolor-3 mt-2" class="btn btn-secondary btn-style-1" id="btn_info_aprendiz" data-toggle="tab"><span class="fz-30"><i class="material-icons">school</i></span><br><span class="fz-30">Aprendizaje</span></a>
							</li>
						</ul>
					</div>
					<div hidden id="dv_info_asistencia" class="container mt-3">
						<div id="accordion" class="accordion-style-1 mb-3">
							<div class="card-accordion-style-1 mb-3">
								<div class="accordion-style-1-header" id="estadEsc">
									<a id="est_alumn_escolar_colaps" class="collapsed d-block" data-toggle="collapse" data-target="#est_alum_doc_grup" aria-expanded="true" aria-controls="est_alum_doc_grup">
                   					<i class="fa fa-chevron-down pull-right"></i>
                    				Estadística escolar: alumnos, grupos y docentes
                					</a>
								</div>
								<div id="est_alum_doc_grup" class="collapse" aria-labelledby="estadEsc" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<div id="dv_info_graf_alumn"></div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div id="dv_info_graf_docen"></div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div id="dv_info_graf_grupos"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div hidden class="card-accordion-style-1 mb-3">
								<div class="accordion-style-1-header" id="indiasis">
									<a class="collapsed d-block" data-toggle="collapse" data-target="#indicadores_asisten" aria-expanded="true" aria-controls="indicadores_asisten">
                    				<i class="fa fa-chevron-down pull-right"></i>
                    				Indicadores de Asistencia
                					</a>
								</div>
								<div id="indicadores_asisten" class="collapse" aria-labelledby="indiasis" data-parent="#accordion">
									<div class="card-body">
										<center>
											<p id="lb_ind_asisten"></p>
										</center>
										<div class="row">
											<div class="col-sm-4">
												<div id="dv_info_graf_Cobertura"></div>
												<center>
													<div class='tooltip2' style='cursor:default; font-size:1.5em;'> Cobertura
														<span class='tooltiptext2'>
															<p>Porcentaje de alumnos en edades idóneas o típica para cursar educación básica, media superior y superior, inscritos en el nivel o tipo educativo correspondiente al inicio del ciclo escolar, por cada cien personas de la población en esas edades.
															</p>
														</span>
													</div>
												</center>
											</div>
											<div class="col-sm-4">
												<!-- <div id="dv_info_graf_docen"></div> -->
											</div>
											<div class="col-sm-4">
												<div id="dv_info_graf_Absorcion"></div>
												<center>
													<div class='tooltip2' style='cursor:default; font-size:1.5em;'> Absorción
														<span class='tooltiptext2'>
															<p>Porcentaje de alumnos de nuevo ingreso al primer grado de secundaria, media superior o superior en un determinado ciclo escolar por cada cien egresados del nivel educativo precedente del ciclo escolar previo.</p>
														</span>
													</div>
												</center>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div hidden id="dv_info_permanencia" class="container mt-3">
						<?php
						$arr_bimestres[ '1' ] = '1er Periodo';
						$arr_bimestres[ '2' ] = '2do Periodo';
						$arr_bimestres[ '3' ] = '3er Periodo';


						$arr_ciclos[ '2018-2019' ] = '2018-2019';
						$arr_ciclos[ '2017-2018' ] = '2017-2018';
						?>
						<div id="accordion" class="accordion-style-1">
							<?php if ($nivel=="PRIMARIA" || $nivel=="SECUNDARIA"): ?>
							<div class="card-accordion-style-1 mb-3" class="accordion-style-1">
								<div class="accordion-style-1-header" id="chriesgo">
									<a class="collapsed d-block" data-toggle="collapse" data-target="#riesgo_esc" aria-expanded="true" aria-controls="riesgo_esc">
	                    <i class="fa fa-chevron-down pull-right"></i>
	                    Riesgo de abandono escolar
	                </a>
								</div>
								<div id="riesgo_esc" class="collapse" aria-labelledby="chriesgo" data-parent="#accordion">
									<div class="card-body">
										<div class="row mt-2">
											<div class="col col-md-12 text-secondary fw800">Por combinar inasistencias, bajas calificaciones y/o años sobre la edad ideal del grado.</div>
										</div>
										<div class="row mt-3">
											<div class="col col-md-4">
												<div class="form-group form-group-style-1">
													<?=form_label('Ciclo escolar', 'ciclo');?>
													<?=form_dropdown('ciclo', $arr_ciclos, 'large', array('class' => 'form-control', 'id' => 'slt_ciclo_ries'));?>
												</div>
											</div>
											<div class="col col-md-4">
												<div class="form-group form-group-style-1">
													<?=form_label('Bimestre/Periodo', 'bimestre');?>
													<?=form_dropdown('bimestre',$arr_bimestres , 'large', array('class' => 'form-control', 'id' => 'slt_bimestre_ries'));?>
												</div>
											</div>

											<div class="col col-md-1">
												<?=form_label(' ', ' ');?>
												<button class="btn btn-info btn-style-1" id="btn_buscar_ries_esc">Buscar</button>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div id="dv_riesgo_esc_pie"></div>
												<div class="table-responsive" id="dv_riesgotab_esc_pie"></div>
											</div>
										</div>

										<div class="row" hidden id="dv_barras_muyaltor">
											<div class="col">
												<div id="dv_riesgo_esc_bar"></div>
												<div class="table-responsive" id="dv_riesgtab_esc_bar"></div>
											</div>
										</div>

									</div>
								</div>
							</div>
							<?php endif; ?>
							<div class="card-accordion-style-1 mb-3">
								<div class="accordion-style-1-header" id="indiperma" hidden>
									<a class="collapsed d-block" data-toggle="collapse" data-target="#indicadores_permanen" aria-expanded="true" aria-controls="indicadores_permanen">
	                    <i class="fa fa-chevron-down pull-right"></i>
	                    Indicadores de Permanencia
	                </a>
								</div>
								<div id="indicadores_permanen" class="collapse" aria-labelledby="indiperma" data-parent="#accordion">
									<div class="card-body">
										<center>
											<p id="lb_ind_perma"></p>
										</center>
										<div class="row">
											<div class="col-sm-4">
												<div id="dv_info_graf_Retencion"></div>
												<center>
													<div data-toggle='tooltip' title='Porcentaje de alumnos que permanecen en la escuela entre ciclos escolares consecutivos antes de concluir el nivel educativo de referencia, por cada cien alumnos matriculados al inicio del ciclo escolar.
' style='cursor:default; font-size:1.5em;'> Retención
													</div>
												</center>
											</div>

											<div class="col-sm-4">
												<div id="dv_info_graf_Aprobacion"></div>
												<center>
													<div data-toggle='tooltip' title='Porcentaje de alumnos aprobados de un determinado grado, por cada cien alumnos que están matriculados al final del ciclo escolar.
' style='cursor:default; font-size:1.5em;'> Aprobación
													</div>
												</center>
											</div>
											<div class="col-sm-4">
												<div id="dv_info_graf_Eficiencia_Terminal"></div>
												<center>
													<div data-toggle='tooltip' title='Porcentaje de alumnos que egresan de cierto nivel o tipo educativo en un determinado ciclo escolar por cada cien alumnos de nuevo ingreso, inscritos tantos ciclos escolares atrás como dure el nivel o tipo educativo en cuestión.
' style='cursor:default; font-size:1.5em;'> Eficiencia Terminal
													</div>
												</center>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-accordion-style-1 mb-3">
								<div class="accordion-style-1-header" id="prog_apoyo" hidden>
									<a class="collapsed d-block" data-toggle="collapse" data-target="#prog_apoyo_" aria-expanded="true" aria-controls="indicadores_permanen">
											<i class="fa fa-chevron-down pull-right"></i>
											Programas de apoyo
									</a>
								</div>
								<div id="prog_apoyo_" class="collapse" aria-labelledby="indiperma" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<center>
												<div id="tab_prog_apoyo"></div>
											</center>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div hidden id="dv_info_aprendizaje" class="container mt-3">
						<div id="accordion" class="accordion-style-1">
							<div class="card-accordion-style-1 mb-3" id="dv_lyc_esc" hidden>
								<div class="accordion-style-1-header" id="chplaneaLC">
									<a class="collapsed d-block" data-toggle="collapse" data-target="#planea_cont_lyc" aria-expanded="true" aria-controls="planea_cont_lyc">
                    <i class="fa fa-chevron-down pull-right"></i>
                    PLANEA por contenido temático: Lenguaje y Comunicación
                </a>
								</div>
								<div id="planea_cont_lyc" class="collapse" aria-labelledby="chplaneaLC" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<div class="col-12">
												<div id="dv_info_graf_contlyc"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-accordion-style-1 mb-3" id="dv_mat_esc" hidden>
								<div class="accordion-style-1-header" id="chplaneaMAT">
									<a class="collapsed d-block" data-toggle="collapse" data-target="#planea_cont_mat" aria-expanded="true" aria-controls="planea_cont_mat">
                    <i class="fa fa-chevron-down pull-right"></i>
                    PLANEA por contenido temático: Matemáticas
                </a>
								</div>
								<div id="planea_cont_mat" class="collapse" aria-labelledby="chplaneaMAT" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<div class="col-12">
												<div id="dv_info_graf_contmat"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-accordion-style-1 mb-3" id="dv_lyc_mat_esc_nl" hidden>
								<div class="accordion-style-1-header" id="chplaneaLO">
									<a class="collapsed d-block" data-toggle="collapse" data-target="#planea_n_logro" aria-expanded="true" aria-controls="planea_n_logro">
                    <i class="fa fa-chevron-down pull-right"></i>
                    PLANEA por niveles de logro
                </a>
								</div>
								<div id="planea_n_logro" class="collapse" aria-labelledby="chplaneaLO" data-parent="#accordion">
									<div class="card-body">
										<?php if ($nivel == "PRIMARIA"): ?>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<div style="display:inline-block; width:20px; height:20px; background-color:#ECC462; border: 1px solid black;"></div>
											<p style="display:inline-block; font-size:1.5em; margin-left:10px;">2016</p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<div style="display:inline-block; width:20px; height:20px; background-color:#D5831C; border: 1px solid black;"></div>
											<p style="display:inline-block; font-size:1.5em; margin-left:10px;">2018</p>
										</div>
										<?php endif; ?>
										<?php if ($nivel != "PRIMARIA"): ?>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<div style="display:inline-block; width:20px; height:20px; background-color:#ECC462; border: 1px solid black;"></div>
											<p style="display:inline-block; font-size:1.5em; margin-left:10px;">2016</p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<div style="display:inline-block; width:20px; height:20px; background-color:#D5831C; border: 1px solid black;"></div>
											<p style="display:inline-block; font-size:1.5em; margin-left:10px;">2017</p>
										</div>
											<?php if ($nivel == "SECUNDARIA"): ?>
										<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<div style="display:inline-block; width:20px; height:20px; background-color:#94460C; border: 1px solid black;"></div>
											<p style="display:inline-block; font-size:1.5em; margin-left:10px;">2019</p>
										</div>
										<?php endif; ?>
										<?php endif; ?>
										<div class="row">
											<div class="col">
												<div id="dv_info_graf_nlogrolyc"></div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div id="dv_info_graf_nlogromat"></div>
											</div>
										</div>
										<div class="row">
											<div class="col">
												<div class='table-responsive'>
													<table id='tabla_planea' class='table table-gray table-hover'>
														<thead>
															<tr>
																<th class='text-center' rowspan='2'></th>
																<th class='text-center' colspan='4'>Lenguaje y Comunicación</th>
																<th class='text-center' colspan='4'>Matemáticas</th>
															</tr>
															<tr>
																<th class='text-center'>I
																	<br><span style='font-weight:normal'>Insuficiente</span>
																</th>
																<th class='text-center'>II
																	<br><span style='font-weight:normal'>Elemental</span>
																</th>
																<th class='text-center'>III
																	<br><span style='font-weight:normal'>Bueno</span>
																</th>
																<th class='text-center'>IV
																	<br><span style='font-weight:normal'>Excelente</span>
																</th>
																<th class='text-center'>I
																	<br><span style='font-weight:normal'>Insuficiente</span>
																</th>
																<th class='text-center'>II
																	<br><span style='font-weight:normal'>Elemental</span>
																</th>
																<th class='text-center'>III
																	<br><span style='font-weight:normal'>Bueno</span>
																</th>
																<th class='text-center'>IV
																	<br><span style='font-weight:normal'>Excelente</span>
																</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td colspan='9' style='background-color:silver;'>PLANEA 2016</td>
															</tr>
															<tr>
																<th class='text-center'>Tu escuela</th>
																<?php foreach ($planea16_escuela as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>%</th>
																<?php endforeach; ?>
															</tr>
															<tr>
																<th class='text-center'>Estado de Coahuila</th>
																<?php foreach ($planea16_estado as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>%</th>
																<?php endforeach; ?>
															</tr>
															<tr>
																<th class='text-center'>Nacional</th>
																<?php foreach ($planea16_nacional as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>
																</th>
																<?php endforeach; ?>
															</tr>
															<?php if ($nivel=="PRIMARIA"): ?>

															<tr>
																<td colspan='9' style='background-color:silver;'>PLANEA 2018</td>
															</tr>
															<tr>
																<th class='text-center'>Tu escuela</th>
																<?php foreach ($planea18_escuela as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>%</th>
																<?php endforeach; ?>
															</tr>
															<tr>
																<th class='text-center'>Estado de Coahuila</th>
																<?php foreach ($planea18_estado as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>%</th>
																<?php endforeach; ?>
															</tr>
															<tr>
																<th class='text-center'>Nacional</th>
																<?php foreach ($planea18_nacional as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>
																</th>
																<?php endforeach; ?>
															</tr>

															<?php endif; ?>

															<?php if ($nivel != "PRIMARIA"): ?>
															<tr>
																<td colspan='9' style='background-color:silver;'>PLANEA 2017</td>
															</tr>
															<tr>
																<th class='text-center'>Tu escuela</th>
																<?php foreach ($planea17_escuela as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>%</th>
																<?php endforeach; ?>
															</tr>
															<tr>
																<th class='text-center'>Estado de Coahuila</th>
																<?php foreach ($planea17_estado as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>%</th>
																<?php endforeach; ?>
															</tr>
															<tr>
																<th class='text-center'>Nacional</th>
																<?php foreach ($planea17_nacional as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>
																</th>
																<?php endforeach; ?>
															</tr>
															<?php if ($nivel == "SECUNDARIA"): ?>
															<tr>
																<td colspan='9' style='background-color:silver;'>PLANEA 2019</td>
															</tr>
															<tr>
																<th class='text-center'>Tu escuela</th>
																<?php foreach ($planea19_escuela as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>%</th>
																<?php endforeach; ?>
															</tr>
															<tr>
																<th class='text-center'>Estado de Coahuila</th>
																<?php foreach ($planea19_estado as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>%</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>%</th>
																<?php endforeach; ?>
															</tr>
															<tr>
																<th class='text-center'>Nacional</th>
																<?php foreach ($planea19_nacional as $key => $value): ?>
																<th class='text-center'>
																	<?=$value['lyc_i'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_ii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_iii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['lyc_iv'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_i'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_ii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_iii'] ?>
																</th>
																<th class='text-center'>
																	<?=$value['mat_iv'] ?>
																</th>
																<?php endforeach; ?>
															</tr>
															<?php endif; ?>
															<?php endif; ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-accordion-style-1 mb-3" id="dv_ete_esc" hidden>
								<div class="accordion-style-1-header" id="ch_ete">
									<a class="collapsed d-block" data-toggle="collapse" data-target="#planea_ete" aria-expanded="true" aria-controls="planea_ete">
									 <i class="fa fa-chevron-down pull-right"></i>
									 Eficiencia Terminal Efectiva
							 		</a>
								</div>
								<div id="planea_ete" class="collapse" aria-labelledby="chplaneaLO" data-parent="#accordion">
									<div class="card-body">
										<div class="row">
											<p>De quienes inician el nivel educativo, ¿Qué porcentaje lo termina y además aprende lo esencial?</p>
											<p>A esta pregunta responde el nuevo indicador de Eficiencia Terminal Efectiva (ETE), que toma como base la eficiencia terminal tradicional y le aplica el porcentaje de estudiantes que supera el nivel I en PLANEA.</p>
											<div class='col-sm-4'></div>
											<div class='col-sm-4'>
												<div id='containerRPB03ete'></div>
												<center>
													<div class='tooltip2' style='cursor:default; font-size:1.5em;'> Eficiencia Terminal Efectiva
														<span class='tooltiptext2'>
															<p>Porcentaje de alumnos egresados con aprendizajes suficientes.</p><i>- (SEDU)</i>
														</span>
													</div>
												</center>
											</div>
											<div class='col-sm-4'></div>
										</div>
										<center>
											<p id="lb_ind_efi"></p>
										</center>
										<center>
											<p id="lb_ind_planea"></p>
										</center>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Modal Reactivos -->
					<div class="modal fade" id="modal_ind_peso" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content modal-style-1">
								<div class="modal-header bgcolor-2">
									<h5 class="modal-title text-white" id="exampleModalLabel">Índice de peso 2017-2018</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
								</button>
								</div>
								<div class="modal-body">
									<div id="div_contenedor_indpeso"></div>
								</div>
							</div>
						</div>
					</div>

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

				</div>
			<?php } else { ?>
				<h3>No se encontró información para la CCT: <b style="color:green"><?=$cct_incorrecto?> </b> y el turno: <b style="color:green"><?=$turno_incorrecto?> </b></h3>
			<?php } ?>
			</div>
		</div>
	</div>
</section>

<div id="div_generico_reactivos"></div>

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
					</div><!-- modal_visor_pdfc3 -->


					<!-- Modal Apoyos -->
					<div class="modal fade" id="modal_operacion_recursos" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
						<div class="modal-dialog modal-md" role="document">
							<div class="modal-content modal-style-1">
								<div class="modal-header bgcolor-4">
									<h5 class="modal-title text-white" id="exampleModalLabel">Propuestas de material de apoyo</h5>
									<button type="button" class="close" id="md_close_operacion_recursos" aria-label="Close">
								                    <span aria-hidden="true">&times;</span>
								                </button>
								</div>
								<div class="modal-body">
									<p>Ayúdanos a mejorar los materiales de apoyo para nuestros alumnos, en este espacio puedes proponer videos, archivos o textos que en tu experiencia son efectivos.
									</p>
									<p>Muchas gracias.</p>
									<div class="form-group">
										<label for="tipodematerial">Seleccione tipo de contenido a subir</label>
										<select class="form-control" id="tipodematerial">
											<?php foreach ($contenidos as $key => $value): ?>
											<option value="<?=$key?>">
												<?=$value?>
											</option>
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
										<button type="button" class="btn btn-info" onClick="obj_graficas.envia_url_pub()">Guardar</button>
									</div>
									<div id="div_contenedor_operaciones_files">
										<!--el enctype debe soportar subida de archivos con multipart/form-data-->
										<form enctype="multipart/form-data" class="formulario">
											<label>Título</label><br/>
											<input name="titulo" type="text" id="titulofile" class="form-control"/>
											<p id="mensaje_alertatitulo_file" style="color:red;">*El título es requerido</p>
											<input name="archivo" type="file" id="imagen" accept="application/pdf"/>
											<p id="mensaje_alertafile" style="color:red;">*Seleccione un archivo</p>
											<div class="form-group">
												<label for="inputcampofuentefile">Introduzca fuente: </label>
												<input type="text" class="form-control" id="inputcampofuentefile" name="fuentefile">
												<p id="mensaje_alertafuente_file" style="color:red;">*La fuente es requerida</p>
											</div>
											<!--div para visualizar mensajes-->
											<div class="messages"></div><br/><br/>
											<!--div para visualizar en el caso de imagen-->
											<div class="showImage"></div>
											<input type="button" value="Subir" class="btn btn-info" id="btn_subir_pdf_imagen_pub"/><br/>
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
<script src="<?= base_url('assets/highcharts5.0.3/highcharts.js'); ?>"></script> <!--Problemas con esta versión <script src="https://code.highcharts.com/highcharts.js"></script>-->
<script src="<?= base_url('assets/highcharts5.0.3/modules/data.js'); ?>"></script> <!--Problemas con esta versión <script src="https://code.highcharts.com/modules/data.js"></script>-->
<script src="<?= base_url('assets/highcharts5.0.3/modules/drilldown.js'); ?>"></script> <!--Problemas con esta versión<script src="https://code.highcharts.com/modules/drilldown.js"></script>-->
<script src="<?= base_url('assets/js/info/progressbar.min.js');?>"></script>
<script src="<?= base_url('assets/js/info/graficos_1.js'); ?>"></script>
<script src="<?= base_url('assets/js/info/graficos_riesgo.js'); ?>"></script>
<script src="<?= base_url('assets/js/info/info_funcionalidad.js'); ?>"></script>
