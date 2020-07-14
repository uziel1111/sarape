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
			<table class="table table-bordered">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Acción</th>
			      <th scope="col">Recursos</th>
			      <th scope="col">Ámbitos</th>
			      <th scope="col">Responsables</th>
			      <th scope="col">Fecha inicio</th>
			      <th scope="col">Fecha fin</th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr>
			      <th scope="row">1</th>
			      <td>Accion 1</td>
			      <td><textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea></td>
			      <td>
			      	<select class="form-control" id="slc_ambitos_new">
			      	<?php foreach ($ambitos as $ambito): ?>
			      		<option value="<?= $ambito['idambito']?>"><?= $ambito['ambito']?></option>
			      	<?php endforeach ?>
					</select>
			      </td>
			      <td>
					<select class="selectpicker form-control" id="main_responsable" title="SELECCIONA" required>
						<option>Mustard</option>
  						<option>Ketchup</option>
  						<option>Relish</option>
					</select>
					<input type="text" class="form-control" name="">
				  </td>
			      <td><input type="date" name=""></td>
			      <td><input type="date" name=""></td>
			      <td><button class="btn btn-primary ">Guardar</button></td>
			    </tr>
			  </tbody>
			</table>
		</div>
	</div>
</div>
