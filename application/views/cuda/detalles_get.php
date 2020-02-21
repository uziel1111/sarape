<section class="main-area">
<div class="container">
		<div class="row">
			<div class="col">
				<div class="alert alert-light" role="alert">
					<div class="row">
						<div class="col align-self-center">
							<a href="<?=base_url('cuda')?>"><h5 class="text-muted " id="titulo_h5">Catálogo Único de Documentos Autorizados </h5></a>
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
					En la Secretaría de Educación del Estado de Coahuila nos hemos propuesto disminuir de forma sensible la carga administrativa de los docentes de educación básica: se revisaron 176 requerimientos de información de las escuelas de educación básica, de los cuales se acordó eliminar hasta el momento 67 de ellos. A continuación, se publican los requerimientos de información (entre formatos y sistemas automatizados) <strong>Únicos Obligatorios</strong> aplicables para las escuelas en el ciclo escolar 2019-2020.
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
	<div class="card card-index mb-4">
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
				<?php $i = 0;
				foreach ($array_detalles as $key => $value): 
					$i++;
					$complemento = str_replace(",", ", ", $value['complemento']);
					
					 $auxComple = substr($complemento, -2);
					if ($auxComple == ', ') {
						$complemento = rtrim($complemento, ', ');
				
					}
				
					?>
					
					<!-- Modal Detalle -->
					<?php 
				if ($value['idpregunta'] == 7 && (stristr(($value['respuesta']), '.') || stristr(($value['respuesta']), '/'))) { 
					if ( $value['idpregunta'] != 4 && $value['idpregunta'] != 5  && $value['idpregunta'] != 17 && $value['idpregunta'] != 18 && $value['idpregunta'] != 0): ?>
							<div class="row">
							<div class="col-sm">
								<div class="alert alert-success my-1 py-1 fz-18" role="alert">
									
									<?php if ($value['pregunta'] == 'Fecha(s) de entrega') { ?>
										<span class="fw800 text-muted">Meses en que se entregar</span><br> <?= ucfirst($value['respuesta'])?><?= ucfirst($complemento)?>
									<?php } else { ?>
										<span class="fw800 text-muted"><?=$value['pregunta']?></span><br> <?= ucfirst($value['respuesta'])?><?= ucfirst($complemento)?>
									<?php } ?>
				
								</div>		 
							</div>
						</div>
					<?php endif ?>
					<?php if ($value['pregunta'] == '¿Se solicitan anexos?') { 
				
						$responsable = 'No capturado';
				
						switch ($value['responsableDocumento']) {
							case 1:
							$responsable = 'El interesado';
							break;
				
							case 2:
							$responsable = 'El director(a)';
							break;
				
							case 3:
							$responsable = 'El padre de familia';
							break;
				
							case 4:
							$responsable = 'El supervisor';
							break;
				
							case 5:
							$responsable = 'Personal de la secretaría';
							break;
				
						}
						?>
				
						<div class="row">
							<div class="col-sm">
								<div class="alert alert-success my-1 py-1 fz-18" role="alert">
									
				
				
									<span class="fw800 text-muted">Responsable</span></center><br> <?= ucfirst($responsable)?><?= ucfirst($value['otroResponsable'])?>	
				
									
								</div>		 
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<div class="alert alert-success my-1 py-1 fz-18" role="alert">
									
				
				
									<span class="fw800 text-muted">Dirección Encargada</span></center><br><?= ucfirst($value['direccion'])?>	
				
									
								</div>		 
							</div>
						</div>
					<?php } ?>
					<?php } else {
						
					if ( $value['idpregunta'] != 4 && $value['idpregunta'] != 5  && $value['idpregunta'] != 7  && $value['idpregunta'] != 17 && $value['idpregunta'] != 18  && $value['idpregunta'] != 0): ?>
						<div class="row">
							<div class="col-sm">
								<div class="alert alert-success my-1 py-1 fz-18" role="alert">
									
									<?php if ($value['pregunta'] == 'Fecha(s) de entrega') { ?>
										<span class="fw800 text-muted">Meses en que se entrega</span><br> <?= ucfirst($value['respuesta'])?><?= ucfirst($complemento)?>
									<?php } else { ?>
										<span class="fw800 text-muted"><?=$value['pregunta']?></span><br> <?= ucfirst($value['respuesta'])?><?= ucfirst($complemento)?>
									<?php } ?>
				
								</div>		 
							</div>
						</div>
					<?php endif ?>
					<?php if ($value['pregunta'] == '¿Se solicitan anexos?') { 
				
						$responsable = 'No capturado';
				
						switch ($value['responsableDocumento']) {
							case 1:
							$responsable = 'El interesado';
							break;
				
							case 2:
							$responsable = 'El director(a)';
							break;
				
							case 3:
							$responsable = 'El padre de familia';
							break;
				
							case 4:
							$responsable = 'El supervisor';
							break;
				
							case 5:
							$responsable = 'Personal de la secretaría';
							break;
				
						}
						?>
				
						<div class="row">
							<div class="col-sm">
								<div class="alert alert-success my-1 py-1 fz-18" role="alert">
									
				
				
									<span class="fw800 text-muted">Responsable</span></center><br> <?= ucfirst($responsable)?><?= ucfirst($value['otroResponsable'])?>	
				
									
								</div>		 
							</div>
						</div>
						<div class="row">
							<div class="col-sm">
								<div class="alert alert-success my-1 py-1 fz-18" role="alert">
									
				
				
									<span class="fw800 text-muted">Dirección Encargada</span></center><br><?= ucfirst($value['direccion'])?>	
				
									
								</div>		 
							</div>
						</div>
					<?php } ?>
					<?php }?>
					<!-- End Modal -->
				<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>
</section>