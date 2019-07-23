
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
	google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Subsecretaría', 'Simplificación'],
			['Subsecretaría de Educación Básica',     81],
			['Subsecretaría de Administración y Recursos Humanos',      9],
			['Subsecretaría de Planeación Educativa',  10]
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

<!-- Start Main Area -->
<section class="main-area">
	<div class="container">
		<!-- Searh bar Area -->
		<div class="row">
			<div class="col">
				<div class="alert alert-light" role="alert">
					<div class="row">
						<div class="col align-self-center">
							<h5 class="text-muted ">Catálogo Único de Documentos Autorizados</h5>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- Search bar Area -->
		<div class="card-columns">
			<div class="card card-index shadow mb-4">
				<div class="inner">
					<img src="<?=base_url('/assets/img/home/box1.jpg')?>" class="card-img-top" alt="...">
				</div>
				<div class="card-body">
					<h5 class="card-title text-danger fz-20"><span class="second-txt">Subsecretaría de Educación Básica</span></h5>
					<p class="card-text text-justify"><button type="button" onclick="getDocumentos(1)" class="btn btn-secondary btn-lg btn-block">Consultar</button>
					</p>
				</div>
			</div>
			<div class="card card-index shadow mb-4">
				<div class="inner">
					<img src="<?=base_url('/assets/img/home/box4.jpg')?>" class="card-img-top" alt="...">
				</div>
				<div class="card-body">
					<h5 class="card-title text-danger fz-20"><span class="second-txt">Subsecretaría de Administración y Recursos Humanos</span></h5>
					<p class="card-text text-justify"><button type="button" onclick="getDocumentos(2)" class="btn btn-secondary btn-lg btn-block">Consultar</button>
					</p>
				</div>
			</div>
			<div class="card card-index shadow mb-4">
				<div class="inner">
					<img src="<?=base_url('/assets/img/home/box2.jpg')?>" class="card-img-top" alt="...">
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
				<div>

				</div>
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

		<script src="<?=base_url('assets/js/cuda/cuda.js')?>"></script>
