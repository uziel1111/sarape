<div class="modal fade" id="modal_visor_reactivos" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-style-1">
			<div class="modal-header bgcolor-2">
				<h5 class="modal-title text-white" id="exampleModalLabel">Consulta por reactivos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
			</div>
			<div class="modal-body">
				<span class="fz-18 fw800" id="modal_reactivos_title">Contenido temático: <?php echo $nombre?></span>
				<hr>
					<div id="div_reactivos">
						<div class='container'>
						<?php foreach ($graph_cont_reactivos_xcctxcont as $key => $item) { ?>
							<div class='row'>
		                        <div class='col-2'>
		                        	<h5><span class='h3 badge badge-secondary text-white'><?= $item['n_reactivo'] ?></span></h5>
		                        </div>
		                        <div class='col-10'>
			       					<?php if ($item['path_apoyo']!=null) { ?>
			                        	<center><a style='color:blue;' href='#' onclick=obj_graficas.apoyo_reactivo('<?= $item['path_apoyo'] ?>') >Texto/imagen (apoyo)</a></center>
			                 		<?php  } ?>
		                    	</div>
                      		</div>
	                      	<div class='row'>
		                        <div class='col-12'>
		 							<img style='cursor: zoom-in;' onclick=obj_graficas.modal_reactivo(<?= $item['path_react'] ?>) class='img-fluid' src='http://www.sarape.gob.mx/assets/docs/planea_reactivos/<?= $item['path_react']?>' class='img-responsive center-block' />
		                        </div>
	                      	</div><br>
	                      	 <?php if ($item['id_planea_result']!=null) { ?>
	                      	<div class='container'>
	                  			<h5 align="center">Análisis descriptivo del resultado del reactivo</h5>
	                  			<div class='row'>
	                  				<div class='col-md-7 col-md-7'></div>
					                <div class='col-md-3 col-md-3'>
					                Porcentajes
					                </div>
								</div>
	                  			<div class='row'>
					                <div class='col-md-1 col-sm-12'>
					                  A)
					                </div>
					                <div class='col-md-6 col-sm-12'>
						                <div class="progress"> 
							                <?php if ($item['res_ok']=='A') { ?>
							                <div class="progress-bar  progress-bar-striped bg-success progress-bar-animated" role="progressbar" style='width:<?=$item['porcen_a'] ?>%' aria-valuenow="<?=$item['porcen_a'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="A)" data-content="Porcentaje: <?=$item['porcen_a'] ?>%"></div>
							                  
							                <?php  }else{ ?>
							                <div class="progress-bar bg-primary" role="progressbar" style='width:<?=$item['porcen_a'] ?>%' aria-valuenow="<?=$item['porcen_a'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="A)" data-content="Porcentaje: <?=$item['porcen_a'] ?>%"></div>
							                <?php } ?>
						                </div>
					                </div>
					                <div class='col-md-3 col-sm-12'>
					                  	 <?php echo $item['porcen_a']?>%
					                </div>
					                <div class='col-md-1 col-sm-12 '>
					                <?php if ($item['res_ok']=='A') { ?>
					                	<img  class='img-fluid ' src="<?= base_url('assets/img/ok.jpg'); ?>"  />
					                <?php } ?>
					                </div>
	                  			</div>
	                  			<br>
	                   			<div class='row'>
					                <div class='col-md-1 col-sm-12'>
					                	B)
					                </div>
					                <div class='col-md-6 col-sm-12'>
						                <div class="progress">
							                <?php if ($item['res_ok']=='B') { ?>
							                <div class="progress-bar  progress-bar-striped bg-success progress-bar-animated" role="progressbar" style='width:<?=$item['porcen_b'] ?>%' aria-valuenow="<?=$item['porcen_b'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="B)" data-content="Porcentaje: <?=$item['porcen_b'] ?>%"></div>
							                  
							                <?php  }else{ ?>
							                <div class="progress-bar  bg-secondary" role="progressbar" style='width:<?=$item['porcen_b'] ?>%' aria-valuenow="<?=$item['porcen_b'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="B)" data-content="Porcentaje: <?=$item['porcen_b'] ?>%"></div>
							                   <?php } ?>
						                </div>
					                </div>
					                <div class='col-md-3 col-sm-12'>
					                	 <?php echo $item['porcen_b']?>%
					                </div>
					                <div class='col-md-1 col-sm-12'>
					                <?php if ($item['res_ok']=='B') { ?>
					                	<img  class='img-fluid ' src="<?= base_url('assets/img/ok.jpg'); ?>"  />
					                <?php } ?>
					                </div>
	                  			</div>
	                  			<br>
			                  	<div class='row'>
				                  	<div class='col-md-1 col-sm-12'>
				                  		C)
				                  	</div>
				                  	<div class='col-md-6 col-sm-12'>
					                  	<div class="progress">
						                  	<?php if ($item['res_ok']=='C') { ?>
						                  	<div class="progress-bar  progress-bar-striped bg-success progress-bar-animated" role="progressbar" style='width:<?=$item['porcen_c'] ?>%' aria-valuenow="<?=$item['porcen_c'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="C)" data-content="Porcentaje: <?=$item['porcen_c'] ?>%"></div>
						                  
						                  	<?php  }else{ ?>
						                  	<div class="progress-bar  bg-danger" role="progressbar" style='width:<?=$item['porcen_c'] ?>%' aria-valuenow="<?=$item['porcen_c'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="C)" data-content="Porcentaje: <?=$item['porcen_c'] ?>%">
						                  	</div>
						                  	<?php } ?>
					                  	</div>
				                  	</div>
				                  	<div class='col-md-3 col-sm-12'>
				                  	 <?php echo $item['porcen_c']?>%
				                  	</div>
				                  	<div class='col-md-1 col-sm-12'>
					                <?php if ($item['res_ok']=='C') { ?>
					                	<img  class='img-fluid ' src="<?= base_url('assets/img/ok.jpg'); ?>"  />
					                <?php } ?>
					                </div>
			                  	</div>
	                  			<br>
			                  	<div class="row">
				                  	<div class='col-md-1 col-sm-12'>
				                  		D)
				                  	</div>
				                  	<div class='col-md-6 col-sm-12'>
					                  	<div class="progress">
						                  	<?php if ($item['res_ok']=='D') { ?>
						                  	<div class="progress-bar  progress-bar-striped bg-success progress-bar-animated" role="progressbar" style='width:<?=$item['porcen_d'] ?>%' aria-valuenow="<?=$item['porcen_d'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="D)" data-content="Porcentaje: <?=$item['porcen_d'] ?>%"></div>
						                  
						                  	<?php  }else{ ?>
						                  	<div class="progress-bar  bg-warning" role="progressbar" style='width:<?=$item['porcen_d'] ?>%' aria-valuenow="<?=$item['porcen_d'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="D)" data-content="Porcentaje: <?=$item['porcen_d'] ?>%">
						                  	</div>
						                  	<?php } ?>
					                  	</div>
				                  	</div>
				                  	<div class='col-md-2 col-sm-12'>
				                  		 <?php echo $item['porcen_d']?>%
				                  	</div>
				                  	<div class='col-md-1 col-sm-12'>
					                <?php if ($item['res_ok']=='D') { ?>
					                	<img  class='img-fluid ' src="<?= base_url('assets/img/ok.jpg'); ?>"  />
					                <?php } ?>
					                </div>
			                  	</div>
	                  			<br>
			                  	<div class="row">
				                  	<div class='col-md-1 col-sm-12'>
				                  		Sin contestar
				                  	</div>
				                  	<div class='col-md-6 col-sm-12'>
					                  	<div class="progress">
					                  		<div class="progress-bar bg-fuchsia" role="progressbar" style='width:<?=$item['porcen_sin_res'] ?>%' aria-valuenow="<?=	$item['porcen_sin_res'] ?>" aria-valuemin="0" aria-valuemax="100" data-toggle="popover" title="Sin Contestar" 	data-content="Porcentaje: <?=$item['porcen_sin_res'] ?>%"></div>	
					                  	</div>	
				                  	</div>	
				                  	<div class='col-md-3 col-sm-12'>	
				                  		 <?php echo $item['porcen_sin_res']?>%
				                  	</div>
				                  	<div class='col-md-1 col-sm-12'>	
				                  		
				                  	</div>
			                  	</div>
	                  			<br></br>
	                   			<div class="row">
				                   	<div class='col-md-10 col-sm-12'>
					                   	<table class="table table-bordered table-sm">
										  <thead class="table-primary">
										    <tr>
										      <th scope="col"><center>Total</center></th>
										      <th scope="col"><center>A)</center></th>
										      <th scope="col"><center>B)</center></th>
										      <th scope="col"><center>C)</center></th>
										      <th scope="col"><center>D)</center></th>
										      <th scope="col" width='40'><center>Sin contestar</center></th>
										      <th scope="col"  width='40'><center>Inciso correcto</center></th>
										    </tr>
										  </thead>
										  <tbody>
										    <tr >
										      <td ><center><?php echo $item['n_alum_eval'] ?></center></td>
										      <td ><center><?php echo $item['a'] ?></center></td>
										      <td ><center><?php echo $item['b'] ?></center></td>
										      <td ><center><?php echo $item['c'] ?></center></td>
										      <td ><center><?php echo $item['d'] ?></center></td>
										      <td ><center><?php echo $item['tr_sin_contestar'] ?></center></td>
										      <td ><center><?php echo $item['res_ok'] ?></center></td>
										    </tr>
										  </tbody>
										</table>
				                    </div>
	                  			</div>
                  			</div>
                  			<?php  } ?>
		                    <div class='row'>
		                        <div class='col-md-3 col-sm-12'>
		                        </div>
		                        <div class='col-md-3 col-sm-12'>
		                        </div>
		                        <div class='col-md-3 col-sm-12'>
		                        </div>
		                        <div class='col-md-3 col-sm-12'>
		                        	<center><a style='color:black;' >Numero de propuestas: <b id='n_propcont'><?= $item['n_prop'] ?></b></a></center>
		                        </div>
		                    </div>
	                      	<div class='row'>
		                        <!-- <div class='col-md-3 col-sm-12'>
		                        			                        <center>
		                        			                        <?php if ($periodo!='1') { ?>
		                        			                          <button data-toggle='tooltip' title='Explicación de respuesta correcta' type='button' class='btn btn-style-1 color-6 bgcolor-2 mb-2' onclick=obj_graficas.argumento_reactivo('<?= $item['url_argumento'] ?>')>Argumento</button>
		                        			                 		<?php } ?>
		                        			                        </center>
		                        </div>
		                        <div class='col-md-3 col-sm-12'>
		                        			                        <center>
		                        			                  		<?php if ($periodo!='1') { ?>
		                        			                        	<button type='button' class='btn btn-style-1 color-6 bgcolor-3 mb-2' onclick=obj_graficas.especificacion_reactivo('<?= $item['url_especificacion'] ?>')>Especificación</button>
		                        			                 		<?php } ?>
		                        			                        </center>
		                        </div>
		                        <div class='col-md-3 col-sm-12'>
		                        			                        <center>
		                        			                 			<?php if ($item['n_material']!="0") { ?>
		                        			                          	<button type='button' class='btn btn-style-1 color-6 bgcolor-4 mb-2' onclick=obj_graficas.apoyosacadem('<?= $item['id_reactivo'] ?>')>Apoyos académicos</button>
		                        			               				<?php } ?>
		                        			                        </center>
		                        </div> -->

		                        <div class='col-md-3 col-sm-12'>
			                        <center>
			                 		<?php if ($item['n_prop']<"5") { ?>
			                        	<button id='btn_prop' type='button' class='btn btn-style-1 color-6 bgcolor-1 mb-2' onclick=obj_graficas.propmapoyo(<?= $item['id_reactivo'] ?>)>Proponer material</button>
			                		<?php } ?>
			                        </center>
		                        </div>
	                        </div>
                    	</div>
               			<?php  } ?>
                   <!--  </div><! .col-12 -->	
				<!-- </div>.row --> 
			</div>
		</div>
	</div>
</div>

<script>
$(function() {
	//////////////////
	// Los tooltips //
	/////////////////
	$('[data-toggle="tooltip"]').tooltip();

	$('[data-toggle="popover"]').popover({
		html: true,
		container: 'body',
		trigger:'hover'
	});

});
</script>