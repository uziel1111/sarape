<!-- <!DOCTYPE html>
<html lang="es" class="no-js">

<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8"/>

	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Mobile Specific Meta -->
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
	<!-- Favicon-->
	<!-- <link rel="icon" type="image/png" href="http://coahuila.gob.mx/images/favicon-electoral.png"> -->
	<!-- Meta Description -->
	<!-- <meta name="description" content=""> -->
	<!-- Meta Keyword -->
	<!-- <meta name="keywords" content=""> -->
	<!-- meta character set -->
	<!-- <meta charset="UTF-8"> -->
	<!-- Site Title -->
	<!-- <title>Sarape</title> -->
	<!-- Site Title -->
	<!-- <link href="http://fonts.googleapis.com/css?family=Boogaloo" rel="stylesheet"> -->
	<!-- <link href="http://fonts.googleapis.com/css?family=Fira+Sans+Condensed:400,400i,500,500i,800,800i" rel="stylesheet"> -->
	<!-- CSS -->
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
	<!-- <link rel="stylesheet" href="assets/css/linearicons.css"> -->

	<!-- <link rel="stylesheet" href="assets/css/animate.css"> -->
	<!--<link rel="stylesheet" href="assets/css/bootstrap.css">-->
	<!-- <link rel="stylesheet" href="assets/css/main.css"> -->
	<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
	<!-- <link href="assets/bootstrap-411/css/bootstrap.min.css" rel="stylesheet" media="screen">-->
	<!-- <link href="assets/sweetalert2/sweetalert2.min.css" rel="stylesheet" media="screen"> -->
	<!-- <link href="assets/fonts/fontawesome5/css/all.css" rel="stylesheet" media="screen"> -->

	<!-- <link rel="stylesheet" href="assets/css/main.css"> -->

	<!-- CSS -->
	<!--<script src="assets/jquery-3.3.1.min.js"></script>-->

	<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script> -->

	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>-->
	<!--<script src="assets/bootstrap-411/js/bootstrap.min.js"></script>-->
	<!-- <script src="assets/sweetalert2/sweetalert2.min.js"></script> -->

	<!-- <script src="assets/js/messages.js"></script> --> -->

	<!-- Datepicker  -->
	<!-- <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script> -->
	<!-- <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css"/> -->
	<!--<link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />-->

	<!-- Multiselect -->
	<!-- <link rel="stylesheet" href="assets/multiselect/css/bootstrap-select.min.css"> -->
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
	<!--	<script type="text/javascript">
//		$( document ).ready( function () {
//			$( "#myModal" ).modal( 'show' );
//		} );
</script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Mes', 'Preescolar', 'Primaria', 'Secundaria'],
			['Marzo',  1000,      	400,      400],
			['Abril',  1170,      	460,       420],
			['Mayo',  660,      		 1120,      860],
			['Junio',  1030,     		 540,      200]
			]);

		var options = {
			title: 'Demanda por Nivel',
			hAxis: {title: 'Mes',  titleTextStyle: {color: '#333'}},
			vAxis: {minValue: 0}
		};

		var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	}
</script>
<script type="text/javascript">
	google.charts.load("current", {packages:["corechart"]});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Subsecretaría', 'Simplificación'],
			['Admin. y R.H.',     11],
			['E. Básica',      8],
			['Planeación E.',  5]
			]);

		var options = {
			title: 'Simplificación por Subsecretaría',
			pieHole: 0.4,
		};

		var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
		chart.draw(data, options);
	}
</script>	
<!-- </head> -->

<!-- <body> -->
	
	<!-- End Header Area -->
	<!-- Start Main Area -->
	<section class="main-area">
		<div class="container">
			<!-- Searh bar Area -->
			<div class="row">
				<div class="col">
					<div class="alert alert-light" role="alert">
						<div class="row">
							<div class="col align-self-center">
								<h5 class="text-muted">Catálogo Único de Documentos Autorizados</h5>
							</div>
							<div class="col-auto">
								<div class="container h-100">
									<div class="d-flex justify-content-end h-100">
										<div class="searchbar">
											<input class="search_input" type="text" name="" placeholder="Buscar...">
											<a href="#" class="search_icon"><i class="fas fa-search"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Search bar Area -->
			<div class="card-columns">
				<div class="card card-index shadow mb-4">
					<div class="inner">
						<img src="../assets/img/home/box1.jpg" class="card-img-top" alt="...">
					</div>
					<div class="card-body">
						<h5 class="card-title text-danger fz-20"><span class="second-txt">Subsecretaría de Educación Básica</span></h5>
						<p class="card-text text-justify"><button type="button" onclick="getDocumentos(1)" class="btn btn-secondary btn-lg btn-block">Consultar</button>
						</p>
					</div>
				</div>
				<div class="card card-index shadow mb-4">
					<div class="inner">
						<img src="../assets/img/home/box4.jpg" class="card-img-top" alt="...">
					</div>
					<div class="card-body">
						<h5 class="card-title text-danger fz-20"><span class="second-txt">Subsecretaría de Administración y Recursos Humanos</span></h5>
						<p class="card-text text-justify"><button type="button" onclick="getDocumentos(2)" class="btn btn-secondary btn-lg btn-block">Consultar</button>
						</p>
					</div>
				</div>
				<div class="card card-index shadow mb-4">
					<div class="inner">
						<img src="../assets/img/home/box2.jpg" class="card-img-top" alt="...">
					</div>
					<div class="card-body">
						<h5 class="card-title text-danger fz-20"><span class="second-txt">Subsecretaría de Planeación Educativa</span></h5>
						<p class="card-text text-justify"><button type="button" onclick="getDocumentos(3)" class="btn btn-secondary btn-lg btn-block">Consultar</button>
						</p>
					</div>
				</div>
			</div>
			<!--Collapsable items-->
			<div class="card mb-4">
				<div class="card-header">
					<h4 class="mb-0 text-success"><span class="second-txt">Documentos por Direcciones de Área</span></h4>
				</div>
				
				<div class="card-body">
					<div id="array"></div>
					
					<!--Estadisticas items-->
					<div class="card">
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

			<!-- End Main Area -->


			<!-- Start Cta Area -->
			<section class="cta-area">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-8 d-flex no-flex-xs justify-content-center align-items-center">
							<a href="#" class="smooth"><img height="80px" src="assets/img/fuerte-coahuila.png" alt=""></a>
						</div>
					</div>
				</div>
			</section>


			<!-- Scripts  -->

			<script src="<?=base_url('assets/js/cuda/cuda.js')?>"></script>
