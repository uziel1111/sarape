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
					<div class="card-header bgcolor-1">
						<div class="icon color-6">
							<span class="lnr lnr-chart-bars"></span>
						</div>
						<h3 class="card-title color-6">Estadística e indicadores</h3>
					</div>
					<div class="card-body">
						<!-- List group -->
						<ul class="list-group">
							<li class="list-group-item"><a class="fw800 fz-16" href="<?= base_url('index.php/Indicepeso/index'); ?>"><span class="color-1 mr-5"><i class="material-icons">report</i></span> Índice de peso<span class="h4 text-white badge badge-secondary bgcolor-1">Nuevo</span></a></li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Estadistica/estad_indi_generales'); ?>"><span class="color-1"><i class="material-icons">public</i></span> Por estado, municipio y zona</a></li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Busqueda_xlista/index'); ?>"><span class="color-1"><i class="material-icons">location_city</i></span> Por escuela</a></li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Mapa/busqueda_x_mapa'); ?>"><span class="color-1"><i class="material-icons">my_location</i></span> Localiza tu escuela</a></li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Riesgo/riesgo_x_muni_zona'); ?>"><span class="color-1"><i class="material-icons">report</i></span> Riesgo de abandono</a></li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Planea/index'); ?>"><span class="color-1"><i class="material-icons">insert_chart</i></span> Resultados estatales de PLANEA</a></li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Generico/index'); ?>"><span class="color-1"><i class="material-icons">insert_chart</i></span> nueva seccion</a></li>
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

							<li class="list-group-item"><a class="fw800 fz-16" href="<?= base_url('index.php/Rutademejora/index'); ?>" target="_blank"><span class="color-2 mr-5"><i class="fas fa-star"></i></span> Ruta de Mejora <span class="h4 text-white badge badge-secondary bgcolor-2">Nuevo</span></a>
							</li>
							<!-- <li class="list-group-item"><a class="fw800 fz-16" href="<?= base_url('index.php/Rutademejora/index_new'); ?>" target="_blank"><span class="color-2 mr-5"><i class="fas fa-star"></i></span> Ruta de Mejora <span class="h4 text-white badge badge-secondary bgcolor-2">Nuevo</span></a>
							</li> -->
							<li class="list-group-item"><a onclick="Index.getRevistaEscolar()" href="javascript:void(0)"><span class="color-2 mr-5"><i class="fas fa-star"></i></span><b>Revista InfórmeSE</b> <span class="h4 text-white badge badge-secondary bgcolor-2">Nuevo</span></a>
							</li>

							<li class="list-group-item"><a href="http://servicioprofesionaldocente.sep.gob.mx/" target="_blank"><span class="color-2"><i class="material-icons">chevron_right</i></span> Servicio Profesional Docente</a>
							</li>
							<li class="list-group-item"><a onclick="Index.getReconocimientosEstatales()" href="javascript:void(0)"><span class="color-2"><i class="material-icons">chevron_right</i></span> Reconocimientos estatales</a>
							</li>


							<li class="list-group-item"><a href="https://www.gob.mx/nuevomodeloeducativo/" target="_blank"><span class="color-2"><i class="material-icons">chevron_right</i></span> Nuevo Modelo Educativo</a>
							</li>
							<li class="list-group-item"><a href="<?= base_url('index.php/Supervisor/supervision'); ?>"><span class="color-2"><i class="material-icons">chevron_right</i></span> Supervisión escolar</a>
							</li>

						</ul>
					</div>
				</div>
			</div>
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
							<li class="list-group-item"><a onclick="Index.getguiaparapadres()" href="javascript:void(0)"><span class="color-3"><i class="material-icons">chevron_right</i></span>  Guía para padres de familia</a>
							</li>
							<li class="list-group-item"><a href="http://libros.conaliteg.gob.mx/content/common/consulta-libros-gb/" target="_blank"><span class="color-3"><i class="material-icons">chevron_right</i></span>  Libros de texto gratuito SEP</a>
							</li>
							<li class="list-group-item"><a onclick="Index.getMaterialesUtiles()" href="javascript:void(0)"><span class="color-3"><i class="material-icons">chevron_right</i></span>  Lista de materiales y útiles</a>
							</li>
							<li class="list-group-item"><a href="http://siecec.seducoahuila.gob.mx/expediente_alumno/" target="_blank"><span class="color-3"><i class="material-icons">chevron_right</i></span>  Consulta de calificaciones</a>
							</li>
							<li class="list-group-item"><a href="https://www.seducoahuila.gob.mx/sebuscanvalientes/" target="_blank"><span class="color-3"><i class="material-icons">chevron_right</i></span>  Alto al acoso escolar <i>(bullying)</i></a>
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
					<div class="card-header bgcolor-4">
						<div class="icon color-6">
							<span class="lnr lnr-layers"></span>
						</div>
						<h3 class="card-title color-6">Otros</h3>
					</div>
					<div class="card-body">
						<!-- List group -->
						<ul class="list-group">
							<li class="list-group-item"><a onclick="Index.getmodeloeducativo()" href="javascript:void(0)"><span class="color-4"><i class="material-icons">chevron_right</i></span> Modelo Coahuilense</a>
							</li>
							<li class="list-group-item"><a onclick="Index.getCalendarioEscolar()" href="javascript:void(0)"><span class="color-4"><i class="material-icons">chevron_right</i></span> Calendario escolar</a>
							</li>
							<li class="list-group-item"><a href="http://www.becascoahuila.gob.mx/becas2.html" target="_blank"><span class="color-4"><i class="material-icons">chevron_right</i></span> Becas escolares</a>
							</li>

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
<!-- End Coa Box Txt -->
