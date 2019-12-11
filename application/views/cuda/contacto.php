<?php foreach ($array_usuario as $key => $dato): ?>

	<div >
	<div class="tab-content tab-content-style-1" id="myTabContent">
		<div class="tab-pane fade" id="contacto<?= $dato['idusuario']?>" role="tabpanel" aria-labelledby="contacto-tab"></div>
		<div class="row">
			<div class="col">
				<div class="wrimagecard wrimagecard-topimage">

						<div class="wrimagecard-topimage_header">
							<center><i class="far fa-id-card" data-toggle="tooltip" title="Total de documentos por usuario" style="font-size: 30px"></i>
							</center>
						</div>
						<div class="wrimagecard-topimage_title">
							<center>
								<h4><?= $dato['nombre']. ' ' .$dato['paterno'] .' '. $dato['materno']?></h4>
							</center>
						</div>						


					</div>
				</div>
				<div class="col">
					<p>

						<ul class="fa-ul">
							<li class="text-muted"><span class="fa-li"><i class="far fa-building"></i></span><?= $dato['area_departamento']?></li>
							
							<li><span class="fa-li text-danger"><i class="fas fa-phone"></i></span><?=$dato['ntelefono']?></li>
							<li><span class="fa-li text-danger"><i class="fas fa-envelope"></i></span><a href="#" target="_blank"><?= $dato['email']?></a>
							</li>
						</ul>
					</p>
				</div>
			</div>
		</div>
		<div id="estadistica"></div>
		
	</div>
</div>

<?php endforeach ?>
