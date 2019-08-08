<?php foreach ($array_usuario as $key => $dato): ?>

	<div >

	<!-- <ul class="nav nav-tabs nav-justified nav-tabs-style-1" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="encuestas-tab" data-toggle="tab" href="#encuestas<?= $dato['idusuario']?>" role="tab" aria-controls="home" aria-selected="true"><i class="far fa-star text-warning"></i> Documentos</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="estadisitcas-tab" data-toggle="tab" href="#estadisitcas<?= $dato['idusuario']?>" role="tab" aria-controls="profile" aria-selected="false">Estadística</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="contacto-tab" data-toggle="tab" onclick="contacto(<?= $dato['idusuario']?>)" href="#contacto<?= $dato['idusuario']?>" role="tab" aria-controls="contact" aria-selected="false">Contacto</a>
		</li>
	</ul> -->
	<div class="tab-content tab-content-style-1" id="myTabContent">
		<div class="tab-pane fade" id="contacto<?= $dato['idusuario']?>" role="tabpanel" aria-labelledby="contacto-tab"></div>
		<div class="row">
			<div class="col">
				<div class="wrimagecard wrimagecard-topimage">

						<!-- <div class="wrimagecard-topimage_header">
							<center><i class="fas fa-user-tie"></i>
							</center>
						</div> -->
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
							<!-- <li><span class="fa-li text-danger"><i class="fas fa-map-marker-alt"></i></span>Coordinación General de Educación Normal y Actualización Docente</li> -->
							<li><span class="fa-li text-danger"><i class="fas fa-phone"></i></span><?=$dato['ntelefono']?></li>
							<li><span class="fa-li text-danger"><i class="fas fa-envelope"></i></span><a href="#" target="_blank"><?= $dato['email']?></a>
							</li>
						</ul>
					</p>
				</div>
			</div>
		</div>
		<div id="estadistica"></div>
		<!-- <div id="contacto"></div> -->
		
	</div>
</div>

<?php endforeach ?>
