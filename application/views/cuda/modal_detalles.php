<?php foreach ($array_detalles as $key => $value): ?>
	
	<!-- Modal Detalle -->
	
	<?php //if ( $value['respuesta'] != null): ?>
		<div class="row">
			<div class="col-sm">
				<div class="alert alert-success my-1 py-1 fz-18" role="alert">
					<?=$value['pregunta'] ?><span class="fw800"> <?= $value['respuesta']?><?= $value['complemento']?></span>
				</div>		 
			</div>
		</div>
	<?php //endif ?>
	<!-- End Modal -->
	<?php endforeach ?>