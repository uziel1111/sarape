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
						<center><span class="fw800">Meses en que se entrega</span></center> <?= $value['respuesta']?><?= $value['complemento']?>
					<?php } else { ?>
						<center><span class="fw800"><?=$value['pregunta']?></span></center><br> <?= $value['respuesta']?><?= $value['complemento']?>
					<?php }
					if ($value['idpregunta'] == 15) { ?>
						
						<center><span class="fw800">Responsable</span></center><br> <?= $value['responsableDocumento']?><?= $value['otroResponsable']?>
						
					<?php } ?>
				</div>		 
			</div>
		</div>
	<?php endif ?>
	<!-- End Modal -->
<?php endforeach ?>

