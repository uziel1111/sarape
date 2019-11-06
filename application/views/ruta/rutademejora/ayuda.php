<style>
	.vt {
		/* cambia estos dos valores para definir el tamaño de tu círculo */
		height: 250px;
		width: 250px;
		/* los siguientes valores son independientes del tamaño del círculo */
		background-repeat: no-repeat;
		background-position: 50%;
		border-radius: 50%;
		background-size: 100% auto;
	}
	.li {
		position: relative;
		display: inline-block;
		width: 23%;
		margin: 1%;
		text-align: left;
		font-size: 12px;
	}

	li .link i {
		z-index: 4;
		opacity: 0;
		position: absolute;
		left: 50%;
		bottom: 0%;
		margin: 0px 0px -24px -24px;
		width: 48px;
		height: 48px;
		background: url(https://i.imgur.com/FZaEYsL.png) no-repeat center center;
		border-radius: 50%;
		box-shadow: 0px 0px 40px rgba(0, 0, 0, 1);
		transition: all 0.20s ease-out;
	}

	li .link img {
		width: 100%;
		transition: all 0.20s ease-out;
		margin-top: -2%;
		margin-bottom: -15%;
	}

	li:hover .link i {
		opacity: .8;
		bottom: 50%;
	}

	li:hover .link img {
		transform: rotate(0deg) xscale(1.03);
	}
</style>
<div class="tab-pane fade active show" id="nav-ayuda" role="tabpanel" aria-labelledby="nav-ayuda-tab">
	<div class="card bg-light mb-3 center">
		<p>
			<img src="<?= base_url('assets/img/mapa/mision.png')?>" width="200" height="200" alt="">
			<img src="<?= base_url('assets/img/mapa/objetivos.png')?>" width="200" height="200" alt="">
			<img src="<?= base_url('assets/img/mapa/actividades.png')?>" width="200" height="200" alt="">
			<img src="<?= base_url('assets/img/mapa/avances.png')?>" width="200" height="200" alt="">
			<img src="<?= base_url('assets/img/mapa/fin.png')?>" width="100" height="200" alt="">
			<br>
			<u><a style="padding-left: 7em; cursor: hand; cursor: pointer; color: blue;" id="img_mision">Ir a misión</a></u>
			<a style="padding-left: 7em; cursor: hand; cursor: pointer;" >Ir a objetivos</a>
			<a style="padding-left: 7em; cursor: hand; cursor: pointer;" >Ir a acciones</a>
			<u><a style="padding-left: 7em; cursor: hand; cursor: pointer; color: blue;" id="img_avances">Ir a avances</a></p></u>
			<br>
			
			

			<div class="row">	
				<li class="li">
					<a class="link" data-toggle="modal" data-target="#T1_SARAPE">
						<i></i>
						<img src="<?= base_url('assets/vid/T1.png')?>" class="vt" alt=""></a>
					</a>
				</li>
				<li class="li">
					<a class="link" data-toggle="modal" data-target="#T2_SARAPE">
						<i></i>
						<img src="<?= base_url('assets/vid/T2.png')?>" class="vt" alt=""></a>
					</a>
				</li>
				<li class="li">
					<a class="link" data-toggle="modal" data-target="#T3_SARAPE">
						<i></i>
						<img src="<?= base_url('assets/vid/T3.png')?>" class="vt" alt=""></a>
					</a>
				</li>
				<li class="li">
					<a class="link" data-toggle="modal" data-target="#T4_SARAPE">
						<i></i>
						<img src="<?= base_url('assets/vid/T4.png')?>" class="vt" alt=""></a>
					</a>
				</li>
				<br>	<br>	
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="T1_SARAPE" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document" style="height: 1200px !important;">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Tutorial 1</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12" id="VT1">
							<iframe width="100%" height="415" src="https://www.youtube.com/embed/S5HT3mqxs3w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="T2_SARAPE" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document" style="height: 1200px !important;">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Tutorial 2</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12" id="VT2">
							<iframe width="100%" height="415"  src="https://www.youtube.com/embed/d3yfq2hiuiI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="T3_SARAPE" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document" style="height: 1200px !important;">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Tutorial 3</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12" id="VT3">
							<iframe width="100%" height="415"  src="https://www.youtube.com/embed/xYSsgzHoCpA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="T4_SARAPE" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document" style="height: 1200px !important;">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Tutorial 4</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12" id="VT4">
							<iframe width="100%" height="415"  src="https://www.youtube.com/embed/ysTVJgO31MM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$('.close').click(function(event) {
			$('#VT1').empty();
			$('#VT1').html('<iframe width="100%" height="415" src="https://www.youtube.com/embed/S5HT3mqxs3w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
			$('#VT2').empty();
			$('#VT2').html('<iframe width="100%" height="415"  src="https://www.youtube.com/embed/d3yfq2hiuiI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
			$('#VT3').empty();
			$('#VT3').html('<iframe width="100%" height="415"  src="https://www.youtube.com/embed/xYSsgzHoCpA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
			$('#VT4').empty();
			$('#VT4').html('<iframe width="100%" height="415"  src="https://www.youtube.com/embed/ysTVJgO31MM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
		});
	</script>
	<script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
	<link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
