<!-- Start Main Boxes Area -->
<section class="title-bg section-full">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8 mt-0">

			</div>
		</div>
		<div class="row">
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
				<div class="card main-boxes">
					<div class="card-header bgcolor-3">
						<div class="icon color-6">
							<span class="lnr lnr-bubble"></span>
						</div>
						<h3 class="card-title color-6">Familia y estudiantes</h3>
					</div>
					<div class="card-body">
						<!-- List group -->
						<ul class="list-group">
							<li class="list-group-item"><a class="fw800 fz-16" onclick="Index.getAprendeencasa()" href="javascript:void(0)"><span class="color-3"><i class="fas fa-star"></i></span> Aprende en Casa <span class="h4 text-white badge badge-secondary bgcolor-3">Nuevo</span>
									<a style="color:grey; padding-left: 10%;" onclick="Index.getAprendeencasa()" href="javascript:void(0)"><span class="h6 text-white badge badge-secondary bgcolor-3"><i class="fas fa-user"></i></span> <b>Programación T.V.</b>
									</a>
							</li>
							<!-- <li class="list-group-item"><a class="fw800 fz-16" href="https://sarape-conectados.mx/Alumno/login" target="_blank"><span class="color-3"><i class="fas fa-star"></i></span> Conectados para aprender
									<a style="color:grey; padding-left: 10%;" href="https://sarape-conectados.mx/Alumno/login" target="_blank"><span class="h6 text-white badge badge-secondary bgcolor-3"><i class="fas fa-user"></i></span> <b>Ingreso para Estudiantes</b>
									</a>
							</li> -->
							<li class="list-group-item" id="conecados_aprender"><a class="fw800 fz-16" href=""><span class="color-3"><i class="fas fa-star"></i></span> Conectados para aprender
									<a style="color:grey; padding-left: 10%;"></a>
							</li>
							<li class="list-group-item"><a class="fw800 fz-16" href="https://www.seducoahuila.gob.mx/educacionencasa/" target="_blank"><span class="color-3"><i class="fas fa-star"></i></span> Educación en casa <span class="h4 text-white badge badge-secondary bgcolor-3">Nuevo</span>
									<a style="color:grey; padding-left: 10%;" href="https://www.seducoahuila.gob.mx/educacionencasa/" target="_blank"><b>Protégete del Coronavirus</b>
									</a>
							</li>
							<!-- <li class="list-group-item"><a onclick="Index.getguiaparapadres()" href="javascript:void(0)"><span class="color-3"><i class="material-icons">chevron_right</i></span> Guía para padres de familia</a> -->
							</li>
							<!-- <li class="list-group-item"><a href="http://libros.conaliteg.gob.mx/content/common/consulta-libros-gb/" target="_blank"><span class="color-3"><i class="material-icons">chevron_right</i></span> Libros de texto gratuito SEP</a>
							</li> -->
							<!-- <li class="list-group-item"><a onclick="Index.getMaterialesUtiles()" href="javascript:void(0)"><span class="color-3"><i class="material-icons">chevron_right</i></span>  Lista de materiales y útiles</a>
							</li> -->
							<li class="list-group-item"><a href="http://siecec.seducoahuila.gob.mx/expediente_alumno/" target="_blank"><span class="color-3"><i class="material-icons">chevron_right</i></span> Consulta de calificaciones</a>
							</li>
							<!-- <li class="list-group-item"><a href="https://www.seducoahuila.gob.mx/sebuscanvalientes/" target="_blank"><span class="color-3"><i class="fas fa-star"></i></span> Alto al acoso escolar <i>(bullying)</i></a> -->
							</li>
							<li class="list-group-item">
								<a href="https://proyectoeducativo.org" target="_blank" style=" font-size:13px"><span class="color-3"><i class="fas fa-star"></i></span>Recursos de apoyo para el aprendizaje</a>
							</li>
							<!-- <li class="list-group-item"><a href="http://www.escuelatransparente.gob.mx/transparencia/juegos.php" target="_blank"><span class="color-3"><i class="material-icons">face</i></span> Juegos y aplicaciones educativas</a></li> -->
							<!-- <li class="list-group-item"><a href="http://www.escuelatransparente.gob.mx/transparencia/correo.php" target="_blank"><span class="color-3"><i class="material-icons">face</i></span> Ingresa a tu correo electronico</a></li> -->
							<!-- <li class="list-group-item"><a href="http://www.escuelatransparente.gob.mx/transparencia/concursos.php" target="_blank"><span class="color-3"><i class="material-icons">face</i></span> Cursos y convocatorias</a></li> -->
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
				<div class="card main-boxes">
					<div class="card-header bgcolor-1">
						<div class="icon color-6">
							<span class="lnr lnr-chart-bars"></span>
						</div>
						<h3 class="card-title color-6">Estadística e indicadores</h3>
					</div>
					<div class="card-body">
						<!-- List group -->
						<ul class="list-group">
							<li class="list-group-item"><a class="fw800 fz-16" href="<?= base_url('index.php/aprovechamiento_escolar/'); ?>"><span class="color-1 mr-5"><i class="fas fa-star"></i></span>
									<font SIZE=3> Aprovechamiento <a style="color:grey; padding-left: 10%;" href="<?= base_url('index.php/aprovechamiento_escolar/'); ?>"><b>escolar</b> </font> <span class="h4 text-white badge badge-secondary bgcolor-1">Nuevo</span>
								</a>
							</li>
							<li class="list-group-item"><a class="" href="<?= base_url('index.php/Indicepeso/index'); ?>"><span class="color-1 mr-5"><i class="material-icons">report</i></span> Índice de peso</a></li>
							<!-- index.php/Estadistica/estad_indi_generales -->
							<!-- index.php/Server_ocupado/index -->
							<li class="list-group-item"><a href="<?= base_url('index.php/Estadistica/estad_indi_generales'); ?>"><span class="color-1"><i class="material-icons">public</i></span> Por estado, municipio y zona</a></li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Busqueda_xlista/index'); ?>"><span class="color-1"><i class="material-icons">location_city</i></span> Por escuela</a></li>
							<!-- <li class="list-group-item"><a href="<?= base_url('index.php/Mapa/busqueda_x_mapa'); ?>"><span class="color-1"><i class="material-icons">my_location</i></span> Localiza tu escuela</a></li> -->
							<!-- <li class="list-group-item"><a href="<?= base_url('index.php/Riesgo/riesgo_x_muni_zona'); ?>"><span class="color-1"><i class="material-icons">report</i></span> Riesgo de abandono</a></li> -->
							<li class="list-group-item"><a class="fw800 fz-16" href="<?= base_url('index.php/Planea/index'); ?>" target="_blank"><span class="color-1"><i class="material-icons">insert_chart</i></span> Resultados estatales de
									<a style="color:grey; padding-left: 10%;" href="<?= base_url('index.php/Planea/index'); ?>" target="_blank"><b>PLANEA</b> <span class="h4 text-white badge badge-secondary bgcolor-1">Nuevo</span></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
				<div class="card main-boxes">
					<div class="card-header bgcolor-2">
						<div class="icon color-6">
							<span class="lnr lnr-briefcase"></span>
						</div>
						<h3 class="card-title color-6">Docentes</h3>
					</div>
					<div class="card-body">
						<!-- List group -->
						<ul class="list-group">
							<li class="list-group-item"><a class="fw800 fz-16" href="<?= base_url('index.php/Indicadores_certe/'); ?>"><span class="color-2 mr-5"><i class="fas fa-star"></i></span>
									<font SIZE=3> Indicadores CERTE </font> <span class="h4 text-white badge badge-secondary bgcolor-2">Nuevo</span>
								</a>
							</li>
							<li class="list-group-item"><a class="fw800 fz-16" href="<?= base_url('index.php/cuda');  ?>" target="_blank"><span class="color-2"><i class="fas fa-star"></i></span> Catálogo Único de Documentos
									<a style="color:grey; padding-left: 10%;" href="<?= base_url('index.php/cuda'); ?>" target="_blank"><b>Autorizados (CUDA)</b> <span class="h4 text-white badge badge-secondary bgcolor-2">Nuevo</span></a></li>
							<li class="list-group-item"><a class="" href="<?= base_url('index.php/Pemc/index'); ?>"><span class="color-2"><i class="material-icons">chevron_right</i></span>
									<font SIZE=3> Programa Escolar de Mejora <a style="color:grey; padding-left: 10%;" href="<?= base_url('index.php/Rutademejora/index'); ?>" target="_blank">Continua </font>
								</a>
							</li>
							<li class="list-group-item"><a onclick="Index.getRevistaEscolar()" href="javascript:void(0)"><span class="color-2 mr-5"><i class="material-icons">chevron_right</i></span>Revista InfórmeSE</a>
							</li>
							<li class="list-group-item"><a onclick="Index.getReconocimientosEstatales()" href="javascript:void(0)"><span class="color-2"><i class="material-icons">chevron_right</i></span> Reconocimientos estatales</a>
							</li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Supervisor/supervision'); ?>"><span class="color-2"><i class="material-icons">chevron_right</i></span> Supervisión escolar</a>
							</li>

						</ul>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
				<div class="card main-boxes">
					<div class="card-header bgcolor-4">
						<div class="icon color-6">
							<span class="lnr lnr-layers"></span>
						</div>
						<h3 class="card-title color-6">Otros</h3>
					</div>
					<div class="card-body">
						<!-- List group -->
						<ul class="list-group">
							<!-- <li class="list-group-item"><a href="http://inscripciones.org" target="_blank"><span class="color-4"><i class="fas fa-star"></i></span> <b>Pre-inscripciones 2020-2021</b></a> -->
							<!-- </li> -->
							<li class="list-group-item"><a class="" href="<?= base_url('index.php/Talis/index'); ?>"><span class="color-4 mr-5"><i class="material-icons">chevron_right</i></span> TALIS </a></li>
							<li class="list-group-item"><a class="" href="https://www.saludcoahuila.gob.mx/COVID19/index.php" target="_blank"><span class="color-4 mr-5"><i class="material-icons">chevron_right</i></span> Secretaría de Salud Coahuila
									<a style="color:grey; padding-left: 14%;" href="https://www.saludcoahuila.gob.mx/COVID19/index.php" target="_blank">(COVID-19)</a></a></li>
							</li>
							<li class="list-group-item"><a class="" href="https://coronavirus.gob.mx/" target="_blank"><span class="color-4 mr-5"><i class="material-icons">chevron_right</i></span> Secretaría de Salud Federal
									<a style="color:grey; padding-left: 14%;" href="https://coronavirus.gob.mx/" target="_blank">(COVID-19)</a></a></li>
							</li>
							<li class="list-group-item"><a class="" href="https://www.who.int/es/emergencies/diseases/novel-coronavirus-2019/advice-for-public" target="_blank"><span class="color-4 mr-5"><i class="material-icons">chevron_right</i></span> Organización Mundial de la
									<a style="color:grey; padding-left: 14%;" href="https://www.who.int/es/emergencies/diseases/novel-coronavirus-2019/advice-for-public" target="_blank">salud (COVID-19)</a></a></li>
							<li class="list-group-item"><a class="" href="https://espanol.cdc.gov/coronavirus/2019-ncov/index.html" target="_blank"><span class="color-4 mr-5"><i class="material-icons">chevron_right</i></span> Centro para el Control y
									<a style="color:grey; padding-left: 14%;" href="https://espanol.cdc.gov/coronavirus/2019-ncov/index.html" target="_blank">la Prevención de</a>
									<a style="color:grey; padding-left: 14%;" href="https://espanol.cdc.gov/coronavirus/2019-ncov/index.html" target="_blank">Enfermedades (COVID-19)</a></a></li>
							</li>
							<!-- <li class="list-group-item"><a onclick="Index.getmodeloeducativo()" href="javascript:void(0)"><span class="color-4"><i class="material-icons">chevron_right</i></span> Modelo Coahuilense</a>
							</li> -->
							<!-- <li class="list-group-item"><a onclick="Index.getCalendarioEscolar()" href="javascript:void(0)"><span class="color-4"><i class="material-icons">chevron_right</i></span> Calendario escolar</a>
							</li>
							<li class="list-group-item"><a href="http://www.becascoahuila.gob.mx/becas2.html" target="_blank"><span class="color-4"><i class="material-icons">chevron_right</i></span> Becas escolares</a>
							</li> -->

							<li class="list-group-item"><a href="http://bibliotecadigitalcoahuila.gob.mx/" target="_blank"><span class="color-4"><i class="material-icons">chevron_right</i></span> Biblioteca Digital Coahuila</a>
							</li>

							<!-- <li class="list-group-item"><a href="http://www.escuelatransparente.gob.mx/transparencia/2017-2018/ESCUELAS_ALTA_DEMANDA.pdf" target="_blank"><span class="color-4"><i class="material-icons">face</i></span> Escuelas de alta demanda</a></li> -->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Main Boxes Area -->
<!-- Start Coa Box Txt -->
<section class="section-full coaboxt-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="coaboxt-content">
					<h2 class="h1 text-white text-uppercase mb-20">Fortaleciendo a <br>la escuela coahuilense</h2>
					<p class="text-white mb-30">Dotando al Sistema Educativo del Estado de acceso a la información en los contenidos de los programas educativos y en el proceso de enseñanza-aprendizaje.</p>
					<a onclick="Index.getmsjsarape()" href="javascript:void(0)" class="primary-btn border-color-1 btn-color-1 text-white d-inline-flex align-items-center">Leer más<span class="lnr lnr-arrow-right"></span></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- modal COVID19-->
<div id='modalCOVID19' class="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bgcolor-3">
				<h5 class="modal-title  color-6">Información Importante</h5>
				<button type="button" class="close  color-6" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-lg-6">
						<div class="info-box shadow">
							<div class="modal-eclase">
								<div class="eclase-info">
									<p>La Secretaría de Educación del Estado de Coahuila pone a disposición de estudiantes y docentes de Secundaria, Media Superior y Normales una herramienta de apoyo para la educación a distancia.</p>
									<div class="row mb-3">
										<div class="col-12">
											<div class="card card-level shadow mb-15">
												<div class="card-header">
													<span>Secundaria</span>
												</div>
												<div class="card-body">
													<div class="row">
														<div class="col-sm-6"><a href="https://ebas.sarape-conectados.mx/" target="_blank" class="primary-btn btn-block border-color-2 btn-color-2 align-items-center"><small>Estudiantes</small></a></div>
														<div class="col-sm-6"><a href="https://ebas.sarape-conectados.mx/escolar" target="_blank" class="primary-btn btn-block border-color-3 btn-color-3 align-items-center"><small>Docentes</small></a></div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12">
											<div class="card card-level shadow mb-15">
												<div class="card-header">
													<span>Media Superior</span>
												</div>
												<div class="card-body">
													<div class="row">
														<div class="col-sm-6"><a href="https://sarape-conectados.mx/" target="_blank" class="primary-btn btn-block border-color-2 btn-color-2 align-items-center"><small>Estudiantes</small></a></div>
														<div class="col-sm-6"><a href="https://sarape-conectados.mx/escolar" target="_blank" class="primary-btn btn-block border-color-3 btn-color-3 align-items-center"><small>Docentes</small></a></div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12">
											<div class="card card-level shadow">
												<div class="card-header">
													<span>Normales</span>
												</div>
												<div class="card-body">
													<div class="row">
														<div class="col-12 text-center">
															<h3 class="text-center">Próximamente</h3>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-lg-6">
						<div class="info-box h-100 shadow">
							<div class="modal-educasa h-100">
								<div class="educasa-info">
									<div class="row">
										<div class="col-12">
											<img class="logo2" src="<?= base_url('assets/img/home/educasa/logo-educacion-en casa coahuila2.png'); ?>" alt="">
											<img src="<?= base_url('assets/img/home/educasa/2.png'); ?>" alt="">
										</div>
									</div>
									<div class="row mb-3 bg-main-img">
										<div class="col-12">
											<div class="row">
												<div class="col-12">
													<h4>Recursos didácticos para alumnos, docentes y padres de familia</h4>
												</div>
											</div>
											<div class="row">
												<div class="col-6">
													<a href="https://www.seducoahuila.gob.mx/educacionencasa/inicial.html" target="_blank"><img class="img-fluid" src="<?= base_url('assets/img/home/educasa/iniccial.png'); ?>" alt=""></a>
												</div>
												<div class="col-6">
													<a href="https://www.seducoahuila.gob.mx/educacionencasa/preescolar.html" target="_blank"><img class="img-fluid" src="<?= base_url('assets/img/home/educasa/pree.png'); ?>" alt=""></a>
												</div>
												<div class="col-6">
													<a href="https://www.seducoahuila.gob.mx/educacionencasa/primara.html" target="_blank"><img class="img-fluid" src="<?= base_url('assets/img/home/educasa/prim.png'); ?>" alt=""></a>
												</div>
												<div class="col-6">
													<a href="https://www.seducoahuila.gob.mx/educacionencasa/secundaria.html" target="_blank"><img class="img-fluid" src="<?= base_url('assets/img/home/educasa/sec.png'); ?>" alt=""></a>
												</div>
												<div class="col-6">
													<a href="https://www.seducoahuila.gob.mx/educacionencasa/especial.html" target="_blank"><img class="img-fluid" src="<?= base_url('assets/img/home/educasa/especial-cam.png'); ?>" alt=""></a>
												</div>
												<div class="col-6">
													<a href="https://www.seducoahuila.gob.mx/educacionencasa/fisica.html" target="_blank"><img class="img-fluid" src="<?= base_url('assets/img/home/educasa/fisica.png'); ?>" alt=""></a>
												</div>
												<div class="col-6">
													<a href="https://www.seducoahuila.gob.mx/educacionencasa/ingles.html" target="_blank"><img class="img-fluid" src="<?= base_url('assets/img/home/educasa/ingles.png'); ?>" alt=""></a>
												</div>
												<div class="col-6">
													<a href="https://www.seducoahuila.gob.mx/educacionencasa/extra-escolar.html" target="_blank"><img class="img-fluid" src="<?= base_url('assets/img/home/educasa/extraescolar.png'); ?>" alt=""></a>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<a href="https://www.seducoahuila.gob.mx/educacionencasa/" target="_blank" class="primary-btn btn-block border-color-2 btn-color-2 align-items-center"><small>Visitar sitio</small></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- modal -->

<!-- End Coa Box Txt -->
