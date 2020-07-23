<style type="text/css">
.modal-mediano{
	max-width: 60%;
	max-height: 60%;
}
.selected {
    background-color: #9ccc65;
    color: #FFF;
  }
  .preview {
    border: 0px solid #ddd;
    padding: 5px;
    border-radius: 2px;
    background: #fff;
    max-width: 80px;
    /*max-height: 80px;*/
}

.preview img {
    width: 100%;
    /*height: 100%;*/
    display: block;
}

.custom-file-input:lang(en)~.custom-file-label::after {
    content: "Seleccione";
}
</style>
<div class="container">
	<!-- <form class="form-group" name="form_objetivos_metas_acciones" id="form_objetivos_metas_acciones"> -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-1">
				<?php if (count($objetivos) < 3): ?>
					<button class="btn btn-primary" id="btn_crear_obj">Crear</button>
				<?php endif ?>
		    </div><!-- .col-xs-12 col-sm-12 col-md-2 -->
		    <div class="col-xs-12 col-sm-12 col-md-1">
		      <button class="btn btn-primary" id="btn_edita_obj">Editar</button>
		    </div><!-- .col-xs-12 col-sm-12 col-md-2 -->
		    <div class="col-xs-12 col-sm-12 col-md-1">
		      <button class="btn btn-md btn-warning" id="btn_elimina_obj">Eliminar</button>
		    </div><!-- .col-xs-12 col-sm-12 col-md-2 -->
        <div class="col-xs-12 col-sm-12 col-md-1 text-light text-right ">
		      <a tabindex="0" class="btn btn-lg btn-dark" role="button" data-toggle="popover" data-trigger="focus" title="Objetivos y metas:" data-content="Objetivos (máximo 3): son los que especifican lo que se pretende alcanzar y para qué lograrlo. Deben ser alcanzables y comunicables; son la guía de las acciones a realizar. Es recomendable establecer uno o dos objetivos que planteen lo que se pretende lograr al término de la vigencia del PEMC.
         Metas: es la definición específica del punto de llegada. Se expresan en términos de tiempo y resultados concretos que implican establecer un indicador que permita evaluar lo alcanzado. Cada objetivo tiene su meta. Acciones: Son las que hacen realidad el cumplimiento de los objetivos y las metas. Se recomienda plantear al menos dos acciones por ámbito."><i class="fa fa-info-circle"></i></a>
		    </div><!-- .col-xs-12 col-sm-12 col-md-2 -->
		</div>
		<br>
		<input type="hidden" id="txt_numero_objetivos_creados" value="<?= count($objetivos)?>">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
		      <table class="table table-bordered" id="id_tabla_objetivos_pemc">
				  <thead>
				  	<tr>
				  	  <th hidden></th>
				  	  <th scope="col" rowspan="2">#</th>
				  	  <th scope="col" rowspan="2" width="20%">Objetivos</th>
				      <th scope="col" rowspan="2" width="20%">Fecha de creación</th>
				      <th scope="col" rowspan="2">Acciones</th>
							<th scope="col" rowspan="2">Agregar acciones</th>
				      <th scope="col" colspan="2"><center>Evidencias</center></th>
				  	</tr>
				    <tr>
				      <th scope="col" ><center>Antes</center></th>
				      <th scope="col" ><center>Después</center></th>
				    </tr>
				  </thead>
				  <tbody id="contenedor_tabla_objetivos">
				  <?php foreach ($objetivos as $objetivo): ?>
				  	<tr>
				  	<td hidden><?= $objetivo['idobjetivo'] ?></td>
				  	<td scope='row'><?= $objetivo['orden'] ?></td>
				     <td><?= $objetivo['objetivo']?></td>
				     <td><?= $objetivo['fcreacion']?></td>
				     <td class="text-center"><?= $objetivo['num_acciones']?></td>
						 <td><button class='btn btn-primary btn-block' onclick='Objetivos.agreg_acciones(<?= $objetivo['idobjetivo']?>)'><i class="fa fa-upload" aria-hidden="true"></i></button></td>
				     <td>
				     	<center>
				     	<div class="preview">
				     		<div class="row">
					     		<div class="col">
					     			<img onmousedown="Objetivos.bigImg(<?= $objetivo['idobjetivo']?>, 1)" src="<?=($objetivo['url_evidencia_antes'] != '')? base_url($objetivo['url_evidencia_antes']):'' ?>" id="img_preview_ini<?= $objetivo['idobjetivo'] ?>">
					     		</div>
					     		<div class="col">
					     			<?php if ($objetivo['url_evidencia_antes'] != ''): ?>
					     				<button class="btn btn-danger btn-sm" onclick="Objetivos.elimina_imagen(<?= $objetivo['idobjetivo']?>, 1)">X</button>
					     			<?php endif ?>
					     		</div>
				     		</div>
					     </div>
					     </center>
					     <div class="row">
					     	<div class="col-1"></div>
	      					<div class="custom-file col-7">
							    <input type="file" class="custom-file-input" name='file_evidencia_antes' id='file_evidencia_antes' onchange='Objetivos.carga_archivos(this, 1, <?= $objetivo['idobjetivo']?>)'>
							    <label class="custom-file-label" for="customFile"></label>
							</div>
					     </div>

      				</td>
				     <td>
				     	<center>
				     	<div class="preview">
				     		<div class="row">
						       <div class="col">
					     			<img onmousedown="Objetivos.bigImg(<?= $objetivo['idobjetivo']?>, 2)" src="<?=($objetivo['url_evidencia_despues'] != '')? base_url($objetivo['url_evidencia_despues']):'' ?>" id="img_preview_fin<?= $objetivo['idobjetivo'] ?>">
					     		</div>
					     		<div class="col">
					     			<?php if ($objetivo['url_evidencia_despues'] != ''): ?>
					     				<button class="btn btn-danger btn-sm" onclick="Objetivos.elimina_imagen(<?= $objetivo['idobjetivo']?>, 2)">X</button>
					     			<?php endif ?>
					     		</div>
				     		</div>
					     </div>
					     </center>
					     <div class="row">
					     	<div class="col-1"></div>
					     	<div class="custom-file col-7">
							    <input type="file" class="custom-file-input" name='file_evidencia_despues' id='file_evidencia_despues' onchange='Objetivos.carga_archivos(this, 2, <?= $objetivo['idobjetivo']?>)'>
							    <label class="custom-file-label" for="customFile"></label>
							</div>
					     </div>
				     </td>
				    </tr>
				  <?php endforeach ?>
				  </tbody>
				</table>
		    </div><!-- .col-xs-12 col-sm-12 col-md-2 -->

		</div>
	<!-- </form> -->
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modal_generico_obj" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
    	<div class="modal-header bgcolor-2">
	        <h5 class="modal-title">Objetivo</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    </div>
	    <div class="modal-body">
	        <div id="contenedor_obj_gen"></div>
	     </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_generico_archivos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-mediano modal-dialog-centered">
    <div class="modal-content">
    	<div class="modal-header bgcolor-2">
	        <h5 class="modal-title">Evidencia</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    </div>
	    <div class="modal-body">
	        <div id="contenedor_obj_evidencia" width="100%" height="100%">

	        </div>
	     </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
  $('[data-toggle="popover"]').popover();
});
</script>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/objetivos.js') ?>"></script>
