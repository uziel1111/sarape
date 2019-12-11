<?php foreach ($array_descarga as $key => $value): 

	$tipo = $value['url_comple'];
	$tipo = substr($tipo, -3);


	?>
	
	<div class="row">
		<div class="col-sm text-right">
			<a class="btn btn-success mb-2" target="blank_" href="http://qual-edu.org/levantamiento_de_requerimientos/<?= $value['url_comple']?>" role="button"><i class="fas fa-file-download"></i> Descargar</a>   
		</div>
	</div>
	<div class="row">
		<div class="col-sm">
			<?php if ($tipo == 'pdf') { ?>
				<iframe src="https://qual-edu.org/levantamiento_de_requerimientos/<?= $value['url_comple']?>" width="100%" height="500" style="border: none;"></iframe>
			<?php } else { ?>
				<img src="https://qual-edu.org/levantamiento_de_requerimientos/<?= $value['url_comple']?>" width="100%" height="100%" style="border: none;" />
			<?php } ?>
		</div>
	</div>	

	<?php endforeach ?>