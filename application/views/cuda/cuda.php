
<style>
	.modal {
		overflow-y: auto;
		width: 100%;
		height: 100%;
		overflow-y: scroll;
		padding-right: 17px;
		/* Increase/decrease this value for cross-browser compatibility */
		box-sizing: content-box;
		/* So the width will be 100% + 17px */
	}
</style>

<script type="text/javascript">
	// google.charts.load('current', {'packages':['corechart']});
 //      google.charts.setOnLoadCallback(drawChart);

 //      function drawChart() {
 //        var data = google.visualization.arrayToDataTable([
 //          ['Periodos', 'Subsecretaría de Educación Básica', 'Subsecretaría de Administración y Recursos Humanos', 'Subsecretaría de Planeación Educativa'],
	// 		['1°',     57,0,0],
	// 		['2°',      62,16,8],
	// 		['3°',  43,2,1]
 //        ]);

 //        var options = {
 //          title: 'Simplificación por Subsecretaría',
 //          hAxis: {title: 'Periodo',  titleTextStyle: {color: '#333'}},
 //          vAxis: {minValue: 0}
 //        };

 //        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
 //        chart.draw(data, options);
 //      }
</script>

<!-- Start Main Area -->
<section class="main-area">
	<div class="container">
		<!-- Searh bar Area -->
		<div class="row">
			<div class="col">
				<div class="alert alert-light" role="alert">
					<div class="row">
						<div class="col align-self-center">
							<h5 class="text-muted " id="titulo_h5">Catálogo Único de Documentos Autorizados </h5>
						</div>

					</div>
				</div>
			</div>
		</div>
	
			<div class="row">
				<div class="col-md-12">

				<div class="card card-index mb-4">
						<div class="card-body text-justify">

							<p>
					En la Secretaría de Educación del Estado de Coahuila nos hemos propuesto disminuir de forma sensible la carga administrativa de los docentes de educación básica: se revisaron 176 requerimientos de información de las escuelas de educación básica, de los cuales se acordó eliminar hasta el momento 66 de ellos. A continuación, se publican los requerimientos de información (entre formatos y sistemas automatizados) <strong>Únicos Obligatorios</strong> aplicables para las escuelas en el ciclo escolar 2019-2020.
					</p>
					
					<p>
					Nota: Algunos requerimientos son aplicables sólo a escuelas beneficiadas por algún programa educativo, o que son de alguna modalidad o sostenimiento específico, según se señala en lo descrito en el detalle de cada requerimiento.	
					</p>
					
					<p>
					¿Alguna duda con referencia al Catálogo Único de Documentos Autorizados? Manda un mensaje a <a style="color:blue;" href="mailto:cuda@seducoahuila.gob.mx">cuda@seducoahuila.gob.mx</a> o en el dato de contacto para cada requerimiento.
					</p>	

						</div>
				</div>



					
				</div>

			</div>
			<div class="row">
			<div class="col-12">
			<div class="card card-index mb-4">
						<div class="card-body text-justify">
						<div class="row">
				<div class="col-md-6">
					<a class="card-text text-justify"><button type="button" onclick="consultaNivel()" class="btn btn-secondary btn-lg btn-block">Consultar por Nivel</button>
						<div class="row" id="selectEducativo" hidden="true" style="background-color: rgba(0,0,0,0.1); margin: 0 4px 0 4px; border-radius: 0 0 20px 20px;">
						<div class="col-lg-6 mt-4">
						<div class="form-group form-group-style-1">	
							<select class="form-control" id="nivelEducativo">
								<option value="Seleccione el Nivel educativo" disabled selected>Nivel Educativo</option>
								<option value="Especial">Especial</option>
								<option value="Inicial">Inicial</option>
								<option value="Preescolar">Preescolar</option>
								<option value="Primaria">Primaria</option>
								<option value="Secundaria">Secundaria</option>
								<option value="Educación para Adultos">Educación para Adultos</option>
								<option value="Extraescolar">Extraescolar</option>
							</select>
						</div>
						</div>	
						<div class="col-lg-6 mt-lg-4 mt-1">
						<div class="form-group form-group-style-1">		
							<select class="form-control" id="mes">
								<option value="Filtrar por mes" disabled selected>Filtrar por mes</option>
								<option value="Enero">Enero</option>
								<option value="Febrero">Febrero</option>
								<option value="Marzo">Marzo</option>
								<option value="Abril">Abril</option>
								<option value="Mayo">Mayo</option>
								<option value="Junio">Junio</option>
								<option value="Julio">Julio</option>
								<option value="Agosto">Agosto</option>
								<option value="Septiembre">Septiembre</option>
								<option value="Octubre">Octubre</option>
								<option value="Noviembre">Noviembre</option>
								<option value="Diciembre">Diciembre</option>
								<option value="Todos los meses">Todos los meses</option>
							</select>
						</div>
						</div>	
					</div>
					<input type="text" hidden="true" id="selectinput">			
				</div>
				<div class="col-md-6">
					<a class="card-text text-justify"><button type="button" onclick="consultaSubsecretaria()" class="btn btn-secondary btn-lg btn-block">Consultar Por Dirección de Área</button>
				</div>	
				</div>
				</div>				
			</div>						
			</div>				
			</div>		
					
					<br><br>

					<!-- Search bar Area -->
					<div class="row" id="consultaSubsecretaria" hidden="true">
						<div class="col-md-4">
							<div class="card card-index shadow mb-4">
								<div class="inner">
									<img src="<?=base_url('/assets/img/home/box1.jpg')?>" alt="...">
								</div>
								<div class="card-body">
									<h5 class="card-title text-danger"><span class="second-txt" style="font-size: 23px">Educación Básica</span></h5>
									<p class="card-text text-justify"><button type="button" onclick="getDocumentos(1)" class="btn btn-secondary btn-lg btn-block">Consultar</button>
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-index shadow mb-4">
								<div class="inner">
									<img src="<?=base_url('/assets/img/home/box4.jpg')?>" class="card-img-top" alt="...">
								</div>
								<div class="card-body">
									<h5 class="card-title text-danger"><span class="second-txt" style="font-size: 23px">Administración y Recursos Humanos</span></h5>
									<p class="card-text text-justify"><button type="button" onclick="getDocumentos(2)" class="btn btn-secondary btn-lg btn-block">Consultar</button>
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card card-index shadow mb-4">
								<div class="inner">
									<img src="<?=base_url('/assets/img/home/box6.jpg')?>" class="card-img-top" alt="...">
								</div>
								<div class="card-body">
									<h5 class="card-title text-danger"><span class="second-txt" style="font-size: 23px">Planeación Educativa</span></h5>
									<p class="card-text text-justify"><button type="button" onclick="getDocumentos(3)" class="btn btn-secondary btn-lg btn-block">Consultar</button>
									</p>
								</div>
							</div>
						</div>
					</div>
					<!--Collapsable items-->
					<div class="card mb-4" id="divDocumentos" hidden="true">
						<div class="card-header">
							<h4 class="mb-0 text-success"><span id="total_documentos" class="second-txt">Documentos Autorizados</span></h4>
						</div>

						<div class="card-body">
							<div id="array"></div>
							<!--Estadisticas items-->
							<div>

							</div>
							<div class="card" style="display: none;">
								<div class="card-header">
									<h4 class="mb-0 text-success"><span class="second-txt">Estadística</span></h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-12 col-md-6 p-0">
											<!-- Identify where the chart should be drawn. -->
											<div id="chart_div" style="width: auto; height: auto;" class="m-0" ></div>
										</div>
										<div class="col-12 col-md-6 p-0">
											<div id="donutchart" style="width: auto; height: auto;" class="m-0"></div>
										</div>
									</div>					



								</div>
							</div>
						</div>

						</div>
					</section>
					<!-- container -->



					<!-- Modal Ver Documento -->
					<div class="modal fade" id="verDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content modal-style-1">
								<div class="modal-header bg-secondary">
									<h5 class="modal-title text-white" id="exampleModalLabel">Vista de documento</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>



								</div>
								<div class="modal-body" id="documentoModal">

								</div>
							</div>
						</div>
					</div>
					<!-- End Modal -->

					<div class="modal fade" id="verDetalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content modal-style-1">
								<div class="modal-header bg-success">
									<h5 class="modal-title text-white" id="exampleModalLabel">Detalle de documento</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>



								</div>
								<div class="modal-body" id="detallesModal">
								</div>
							</div>
						</div>
					</div>

					<!-- mdoal contacto -->
					
					<div class="modal fade" id="verContacto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content modal-style-1">
								<div class="modal-header bg-success">
									<h5 class="modal-title text-white" id="exampleModalLabel">Datos de contacto</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>



								</div>
								<div class="modal-body" id="contactoModal">
								</div>
							</div>
						</div>
					</div>

					<!-- fin modal contacto -->

					<!-- modal index -->
					<div class="modal fade" id="seleccionaNivelIndex" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
							<div class="modal-content modal-style-1">
								<div class="modal-header bg-success">
									<h5 class="modal-title text-white" id="exampleModalLabel">Nivel Educativo</h5>



								</div>
								<div class="modal-body" >
									<div class="row" id="selectEducativoModal"> 
										<div class="col-md-12">
											<select class=" col-md-12 card-header" id="nivelEducativoModal">
												<option value="Seleccione el Nivel educativo" disabled selected>Seleccione el Nivel Educativo</option>
												<option value="Especial">Especial</option>
												<option value="Inicial">Inicial</option>
												<option value="Preescolar">Preescolar</option>
												<option value="Primaria">Primaria</option>
												<option value="Secundaria">Secundaria</option>
											</select>
											<br>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>

					
					<!-- End modal index -->

					<!-- End Main Area -->

					<script src="<?=base_url('assets/js/cuda/cuda.js')?>"></script>
