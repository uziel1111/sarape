<style type="text/css">
	.modal-lg { 
    max-width: 95%; 
} 
</style>

<div class="container-fluid">
	<div class="alert alert-primary" role="alert">
	  Objetivo
	  <h3>Objetivo</h3>
	  Meta
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<table class="table table-condensed table-striped">
			  <thead>
			    <tr>
			      <th  class="">#</th>
			      <th  class="">Acción</th>
			      <th  width="20%">Recursos</th>
			      <th  width="20%">Ámbitos</th>
			      <th  width="20%">Responsables</th>
			      <th  class="">Fecha inicio</th>
			      <th  class="">Fecha fin</th>
			      <th ></th>
			    </tr>
			  </thead>
			  <tbody>
		    	<?php foreach ($acciones as $accion): ?>
		    	<tr>
		    	<th scope="row"><?=$accion['orden']?></th>
			    <td><?=$accion['accion']?></td>
			    <td><textarea class="form-control" id="exampleFormControlTextarea1" rows="3"><?=$accion['recurso']?></textarea></td>
			    <td>
					<select id="select_ambito_<?=$accion['orden']?>" class="selectpicker form-control" multiple data-selected-text-format="count > 1" id="slc_ambitos" title="SELECCIONA">
                     <?php foreach ($ambitos as $ambito): ?>
			      		<option value="<?= $ambito['idambito']?>"><?= $ambito['ambito']?></option>
			      	<?php endforeach ?>
					</select>
					<script type="text/javascript">
						$('#select_ambito_'+<?=$accion['orden']?>).selectpicker('val', [<?=$accion['idambitos']?>]);
					</script>
			    </td>
			    <td>
					<select class="selectpicker form-control" multiple data-selected-text-format="count > 1" id="slc_responsables" title="SELECCIONA">
					<?php foreach ($responsables as $responsable): ?>
						<option value="<?=$responsable->rfc?>"><?=$responsable->nombre_completo?></option>
					<?php endforeach ?>
					</select>
					<br>
					<input type="text" class="form-control" name="" value="<?=$accion['otros_responsables']?>">
				</td>
			    <td><input type="date" name="" value="<?=$accion['finicio']?>"></td>
			    <td><input type="date" name="" value="<?=$accion['ffin']?>"></td>
			    <td><button class="btn btn-primary ">Guardar</button></td>
			    </tr>
		    	<?php endforeach ?>
			  </tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
$(".selectpicker").selectpicker("refresh");
// $('.selectpicker').selectpicker('val', ['1','2']);
</script>