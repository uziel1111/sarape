<?php foreach ($array_descarga as $key => $value): ?>
	
	<div class="row">
		<div class="col-sm text-right">
			<a class="btn btn-success mb-2" href="http://qual-edu.org/levantamiento_de_requerimientos<?= $value['url_comple']?>" role="button"><i class="fas fa-file-download"></i> Descargar</a>   
		</div>
	</div>
	<div class="row">
		<div class="col-sm">
			 <iframe src="https://docs.google.com/viewer?url=http://qual-edu.org/levantamiento_de_requerimientos/<?= $value['url_comple']?>&embedded=true" width="100%" height="500" style="border: none;"></iframe>
		</div>
	</div>	

<?php endforeach ?>