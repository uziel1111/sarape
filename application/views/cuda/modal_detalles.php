<?php $i = 0;
foreach ($array_detalles as $key => $value): 
	$i++;
	?>
	
	<!-- Modal Detalle -->
	<?php if ( $value['idpregunta'] != 4 && $value['idpregunta'] != 5 && $value['idpregunta'] != 6 && $value['idpregunta'] != 7 && $value['idpregunta'] != 17 && $value['idpregunta'] != 18): ?>
		<div class="row">
			<div class="col-sm">
				<div class="alert alert-success my-1 py-1 fz-18" role="alert">
					
					<?php if ($value['pregunta'] == 'Fecha(s) de entrega') { ?>
						<span class="fw800 text-muted">Meses en que se entrega</span><br> <?= ucfirst($value['respuesta'])?><?= $value['complemento']?>
					<?php } else { ?>
						<span class="fw800 text-muted"><?=$value['pregunta']?></span><br> <?= ucfirst($value['respuesta'])?><?= $value['complemento']?>
					<?php } ?>
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
						<br><span class="fw800 text-muted">Responsable</span></center><br> <?= ucfirst($responsable)?><?= ucfirst($value['otroResponsable'])?>	
					<?php  } ?>
				</div>		 
			</div>
		</div>
	<?php endif ?>
	<!-- End Modal -->
<?php endforeach ?>

