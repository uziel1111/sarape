<section class="main-area">
	<div class="container">
	  	<div class="card mb-3 card-style-1">
	    	<div class="card-header card-1-header bg-light"></div>
	    	<div class="card-body">
	            <ul class="nav nav-tabs nav-tabs-style-1" id="myTab" role="tablist">
	                <li class="nav-item">
	                  	<a class="nav-link nav-link-style-1 active" id="xgeneral_tab" data-toggle="tab" href="#xgeneral" role="tab" aria-controls="xgeneral" aria-selected="true">Por Captura</a>
	                </li>
	                <li class="nav-item">
	                  	<a class="nav-link nav-link-style-1" id="xLAE_tab" data-toggle="tab" href="#xLAE" role="tab" aria-controls="xLAE" aria-selected="false">Por LAE</a>
	                </li>
	                 <li class="nav-item">
	                  	<a class="nav-link nav-link-style-1" id="xZona_tab" data-toggle="tab" href="#xLAE" role="tab" aria-controls="xZona" aria-selected="false">Por Zona</a>
	                </li>
	                <li class="nav-item">
	                  	<a class="nav-link nav-link-style-1" id="xcct_turno_tab" data-toggle="tab" href="#xcct_turno" role="tab" aria-controls="xcct_turno" aria-selected="false">Por Municipio, Nivel, Sostenimiento, Nombre</a>
	                </li>
	            </ul>
	            <div class="tab-content tab-content-style-1" id="myTabContent">
	                <div class="tab-pane fade show active" id="xgeneral" role="tabpanel" aria-labelledby="xgeneral_tab">
	                </div>
	                <div class="tab-pane fade" id="xLAE" role="tabpanel" aria-labelledby="xLAE_tab">
	                </div>
	                <div class="tab-pane fade" id="xZona" role="tabpanel" aria-labelledby="xZona_tab">
	                </div>
	                <div class="tab-pane fade" id="xcct_turno" role="tabpanel" aria-labelledby="xcct_turno">
		                <div class="tab-content tab-content-style-1" id="myTabContent">
			                <div class="tab-pane fade show active" id="xmunicipio" role="tabpanel" aria-labelledby="xmunicipio-tab">
			                  	<?= form_open() ?>
			                  	<div class="row">
				                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-2">
				                      	<div class="form-group form-group-style-1">
				                        	<?= form_label('Municipio', 'municipio_pemc') ?>
				                        	<?= form_dropdown('id_municipio', $arr_municipios, '', array('id' => 'id_municipio', 'class'=>'form-control')) ?>
				                      	</div>
				                    </div><!-- col-md-4 -->
				                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-2">
				                      	<div class="form-group form-group-style-1">
				                        	<?= form_label('Nivel', 'nivel_pemc') ?>
				                        	<?= form_dropdown('id_nivel', $arr_niveles, '', array('id' => 'id_nivel', 'class'=>'form-control')) ?>
				                      	</div>
				                    </div><!-- col-md-4 -->
				                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-2">
				                      	<div class="form-group form-group-style-1">
				                        	<?= form_label('Sostenimiento', 'sostenimiento_pemc') ?>
				                        	<?= form_dropdown('id_sostenimiento', $arr_sostenimientos, '', array('id' => 'id_sostenimiento', 'class'=>'form-control')) ?>
				                      	</div>
				                    </div><!-- col-md-4 -->
			                  	</div><!-- row -->

			                  	<div class="row">
			                    	<div class="col-sm-12">
			                      		<div class="form-group form-group-style-1">
			                          		<?= form_label('Nombre de la escuela (opcional)', 'nombreescuela_pemc') ?>
			                          		<?= form_input('nombreescuela_pemc', '', array('id' => 'nombreescuela_pemc', 'class'=>'form-control' )) ?>
			                      		</div>
			                    	</div><!--  col-sm-12 -->
			                  	</div><!-- row -->
			                  	<div class="row col-md-12">
			                  		<div class="col-sm-8 col-md-8 col-lg-8 mt-8">
			                  		</div>
						            <div class="col-sm-4 col-md-4 col-lg-4 mt-4">
						                <?= form_submit('mysubmit', 'Buscar', array('id' => 'busqueda_cct_pemc', 'class'=>'btn btn-info btn-block btn-style-1' )); ?>
				                	</div><!-- row -->
			                	</div>


			                  	<?= form_hidden('municipio_pemc', 'Todos') ?>
			                  	<?= form_hidden('nivel_pemc', 'Todos') ?>
			                  	<?= form_hidden('sostenimiento_pemc', 'Todos') ?>
			                  	<?= form_close() ?>
			                  	<br>
			                  	<div id="div_busxcct"></div>
			                  	<br>
			                  	<div id="div_busxcct_pemc"></div>
			                </div>
	                	</div>
	            	</div>
	    		</div>
	  		</div>
		</div>
	</div>
</section>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="<?= base_url('assets/js/estadistica_pemc/busquedaxcct.js') ?>"></script>
<script src="<?= base_url('assets/js/estadistica_pemc/xCaptura.js') ?>"></script>
<script src="<?= base_url('assets/js/estadistica_pemc/xLAE.js') ?>"></script>
<script src="<?= base_url('assets/js/regularexpression.js') ?>"></script>

