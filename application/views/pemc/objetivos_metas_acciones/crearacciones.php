<style type="text/css">
.modal-lg {
    max-width: 95%;
}

</style>

<div class="container-fluid">
	<input type="hidden" name="input_idobjetivo_inaccion" id="<?=$idobjetivo?>">
	<div class="alert alert-primary" role="alert">
	  Objetivo
	  <h3><?= $objetivo->objetivo?></h3>
	  Meta(s):
	  <h3><?= $objetivo->meta?></h3>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12">
			<table class="table table-condensed table-striped">
			  <thead>
			    <tr>
			      <th  class="">#</th>
			      <th  width="20%">Acción</th>
			      <th  width="20%">Recursos</th>
			      <th  width="20%">Ámbitos</th>
			      <th  width="20%">Responsables</th>
			      <th  width="5%">Fecha inicio</th>
			      <th  width="5%">Fecha fin</th>
			      <th ></th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php if (count($acciones)): ?>
		    	<?php foreach ($acciones as $accion): ?>
		    	<tr>
		    	<th scope="row"><?=$accion['orden']?></th>
			    <td><textarea class="form-control" id="txt_accion_<?=$accion['idaccion']?>" rows="3"  maxlength="255"><?=$accion['accion']?></textarea></td>
			    <td><textarea class="form-control" id="txt_recurso_<?=$accion['idaccion']?>" rows="3"  maxlength="255"><?=$accion['recurso']?></textarea></td>
			    <td>
					<select id="select_ambito_<?=$accion['idaccion']?>" class="selectpicker form-control" multiple data-selected-text-format="count > 1" id="slc_ambitos" title="SELECCIONA" onchange="Objetivos.trae_laes(this, 'inp_laes_<?=$accion['accion']?>')">
                     <?php foreach ($ambitos as $ambito): ?>
			      		<option data-lae="<?=$ambito['lae']?>" value="<?= $ambito['idambito']?>" data-subtext="(Línea de Acción Estratégica <?=$ambito['idlae']?>)"><?= $ambito['ambito']?> </option>
			      	<?php endforeach ?>
					</select>

					<script type="text/javascript">
						$('#select_ambito_'+<?=$accion['idaccion']?>).selectpicker('val', [<?=$accion['idambitos']?>]);
					</script>
			    </td>
			    <td>
					<select class="selectpicker form-control" multiple data-selected-text-format="count > 1" id="slc_responsables_<?=$accion['idaccion']?>" >
						<option disabled value="">SELECCIONE</option>
					<?php foreach ($responsables as $responsable): ?>
						<option value="<?=$responsable->rfc?>"><?=$responsable->nombre_completo?></option>
					<?php endforeach ?>
					</select>
					<script type="text/javascript">
						$('#slc_responsables_'+<?=$accion['idaccion']?>).selectpicker('val', [<?=(string)$accion['responsables']?>]);
					</script>
					<br>
					<input type="text" id="txt_otrosresp_<?=$accion['idaccion']?>" class="form-control" name="" value="<?=$accion['otros_responsables']?>"  maxlength="255" placeholder="Otro(s)">
				</td>
			    <td>
            <input type="date" id="txt_finicio_<?=$accion['idaccion']?>" name="" class="form-control" value="<?=$accion['finicio']?>">
            <input type="hidden" id="txt_comentarios_finicio_<?=$accion['idaccion']?>" class="form-control" name="" value="<?=$accion['comentario_finicio']?>"  maxlength="255" placeholder="Comentario(s)">
          </td>
			    <td>
            <input type="date" id="txt_ffin_<?=$accion['idaccion']?>" name="" class="form-control" value="<?=$accion['ffin']?>">
            <input type="hidden" id="txt_comentarios_ffin_<?=$accion['idaccion']?>" class="form-control" name="" value="<?=$accion['comentario_ffin']?>"  maxlength="255" placeholder="Comentario(s)">
          </td>
			    <td>
			    	<button class="btn btn-info" onclick="Objetivos.valida_campos_accion(<?=$accion['idaccion']?>, <?= $idobjetivo ?> )">Guardar</button>
			    	<br>
			    	<button class="btn btn-danger" onclick="Objetivos.elimina_accion(<?=$accion['idaccion']?>, <?= $idobjetivo ?> )">Eliminar</button>
			    </td>
			    </tr>
          <tr style="background-color: #bee5eb; ">
          <td colspan="8"><label><b>Línea(s) de Acción Estratégica: </b><span id="inp_laes_<?=$accion['accion']?>"></span></label></td>
          </tr>
		    	<?php endforeach ?>
		    	<?php endif ?>
		    	<tr>
		    	<th scope="row"><?=count($acciones)+1?></th>
			    <td><textarea class="form-control" id="txt_accion_new" rows="3"   maxlength="255"></textarea></td>
			    <td><textarea class="form-control" id="txt_recurso_new" rows="3"   maxlength="255"></textarea></td>
			    <td>
					<select id="select_ambito_new" class="selectpicker form-control" multiple data-selected-text-format="count > 1" id="slc_ambitos" title="SELECCIONA" onchange="Objetivos.trae_laes(this, 'inp_laes_new_<?=$accion['accion']?>')">
                     <?php foreach ($ambitos as $ambito): ?>
			      		<option data-lae="<?=$ambito['lae']?>" value="<?= $ambito['idambito']?>"  data-subtext="(Línea de Acción Estratégica <?=$ambito['idlae']?>)"><?= $ambito['ambito']?></option>
			      	<?php endforeach ?>
					</select>

			    </td>
			    <td>
					<select class="selectpicker form-control" multiple data-selected-text-format="count > 1" id="slc_responsables_new">
						<option disabled value=""></option>
					<?php foreach ($responsables as $responsable): ?>
						<option value="<?=$responsable->rfc?>"><?=$responsable->nombre_completo?></option>
					<?php endforeach ?>
					</select>
					<br>
					<input type="text" class="form-control" id="txt_otrosresp_new" name="" value=""   maxlength="255" placeholder="Otro(s)">
				</td>
			    <td>
            <input type="date" class="form-control" id="txt_finicio_new" name="" value="">
  					<input type="hidden" id="txt_comentarios_finicio_new" class="form-control" name="" value=""  maxlength="255" placeholder="Comentario(s)">
          </td>
			    <td>
            <input type="date" class="form-control" id="txt_ffin_new" name="" value="">
  					<input type="hidden" id="txt_comentarios_ffin_new" class="form-control" name="" value=""  maxlength="255" placeholder="Comentario(s)">
          </td>
			    <td><button class="btn btn-primary "onclick="Objetivos.valida_campos_accion(0,<?= $idobjetivo ?>)" >Guardar</button></td>
			    </tr>
          <tr style="background-color: #bee5eb; ">
          <td colspan="8"><label><b>Línea(s) de Acción Estratégica: </b><span id="inp_laes_new_<?=$accion['accion']?>"></span></label></td>
          </tr>
			  </tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
$(".selectpicker").selectpicker("refresh");
// $('.selectpicker').selectpicker('val', ['1','2']);
</script>
