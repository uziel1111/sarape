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
	                  	<a class="nav-link nav-link-style-1" id="xcct_turno_tab" data-toggle="tab" href="#xcct_turno" role="tab" aria-controls="xcct_turno" aria-selected="false">Por CCT</a>
	                </li>
	            </ul>
	            <div class="tab-content tab-content-style-1" id="myTabContent">
	                <div class="tab-pane fade show active" id="xgeneral" role="tabpanel" aria-labelledby="xgeneral_tab">
	                </div>
	                <div class="tab-pane fade" id="xLAE" role="tabpanel" aria-labelledby="xLAE_tab">
	                </div>
	                <div class="tab-pane fade" id="xcct_turno" role="tabpanel" aria-labelledby="xcct_turno">
	                	<div class="row">
		                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 mt-2">
		                      	<div class="form-group form-group-style-1">
		                          	<?= form_label('Escriba su CCT', 'cct_pem') ?>
		                          	<div class="input-group mb-3">
		                            <div class="input-group-prepend">
		                                <span class="input-group-text label_cct">05</span>
		                            </div>
		                              	<?= form_input('cct_pemc', '', array('id' => 'cct_pemc', 'class'=>'form-control input_cct' )) ?>
		                        	</div>
		                      	</div>
		                    </div><!--  col-sm-12 -->

		                    <div class="col-12 col-sm-6 col-md-3 col-lg-3 mt-2">
		                      	<div class="form-group form-group-style-1">
		                          	<?= form_label('Turno', 'turno_pemc') ?>
		                          	<div class="input-group mb-3">
										<select class="form-control" id="turno_pemc">
											<option value="Seleccione un turno" selected>Seleccione Turno</option>
											<option value="1">Matutino</option>
											<option value="2">Vespertino</option>
											<option value="3">Preescolar</option>
											<option value="4">Discontinuo</option>
											<option value="5">Continuo</option>
											<option value="6">Complementario</option>
										</select>
									</div>
								</div>
							</div>

							<div class="col-12 col-sm-6 col-md-3 col-lg-3 mt-2">
		                      	<div class="form-group form-group-style-1">
		                          	<?= form_label('', '') ?>
		                          	<div class="input-group mb-3">
		                          		 <?= form_submit('mysubmit', 'Buscar', array('id' => 'busqueda_cct_pemc', 'class'=>'btn btn-info btn-block btn-style-1' )); ?>
		                          	</div>
		                        </div>
		                    </div>

                  		</div><!-- row -->
                  		<div id="div_busxcct">

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

