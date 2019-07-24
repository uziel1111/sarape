			<!-- acá va el foreach -->
			<?php foreach ($array_datos as $key => $dato){ ?>
				<div class="accordion accordion-style-1" id="accordionExample">
					<div class="card mb-3">
						<div class="card-header collapsed" id="headingOne" data-toggle="collapse" data-target="#collapse<?= $dato['idusuario']?>" aria-expanded="false" aria-controls="collapse<?= $dato['idusuario']?>" style="cursor: pointer;" onclick="getTablas(<?= $dato['idusuario']?>)">
							<i class="fas fa-clipboard-list mr-2"></i> <span class="second-txt"><?= $dato['area_departamento']?></span>
						</div>

						<div id="collapse<?= $dato['idusuario']?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
							<div class="card-body p-0">

								<ul class="nav nav-tabs nav-justified nav-tabs-style-1" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="encuestas-tab" data-toggle="tab" href="#encuestas<?= $dato['idusuario']?>" role="tab" aria-controls="home" aria-selected="true"><i class="far fa-star text-warning"></i> Documentos</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="estadisitcas-tab" data-toggle="tab" onclick="estadistica(<?= $dato['idusuario']?>, <?= $dato['idsubsecretaria']?>)" href="#estadisticas<?= $dato['idusuario']?>" role="tab" aria-controls="profile" aria-selected="false">Estadística</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="contacto-tab" data-toggle="tab" onclick="contacto(<?= $dato['idusuario']?>)" href="#contacto<?= $dato['idusuario']?>" role="tab" aria-controls="contact" aria-selected="false">Contacto</a>
									</li>
								</ul>
								<div class="tab-content tab-content-style-1" id="myTabContent">
									<div class="tab-pane fade show active" id="encuestas<?= $dato['idusuario']?>" role="tabpanel" aria-labelledby="encuestas-tab">
										<div class="row">
											<div class="col">
												<table class="table table-striped table-hover">
													<thead>
														<tr>
															<th scope="col">#</th>
															<th scope="col">Nombre del documento</th>
															<!-- <th scope="col">Fecha de creación</th> -->
															<th scope="col">Ver</th>
														</tr>
													</thead>
													<tbody id="tabla_documentos<?= $dato['idusuario']?>">

													</tbody>
												</table>
											</div>

										</div>
										<!-- <div class="row">
											<div class="col">
												<a href="#" class="btn btn-success btn-block" role="button" aria-pressed="true">Ver todos</a>
											</div>
										</div> -->
									</div>
									<div class="tab-pane fade" id="estadisticas<?= $dato['idusuario']?>" role="tabpanel" aria-labelledby="estadisticas-tab"></div>
									<!-- <div id="contacto"></div> -->
									<div class="tab-pane fade" id="contacto<?= $dato['idusuario']?>" role="tabpanel" aria-labelledby="contacto-tab"></div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<!-- acá termina el foreach -->