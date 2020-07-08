<div class="container">
	<!-- <form class="form-group" name="form_objetivos_metas_acciones" id="form_objetivos_metas_acciones"> -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-1">
		      <button class="btn btn-primary" id="btn_crear_obj">Crear</button>
		    </div><!-- .col-xs-12 col-sm-12 col-md-2 -->
		    <div class="col-xs-12 col-sm-12 col-md-1">
		      <button class="btn btn-md btn-warning" id="btn_elimina_obj">Eliminar</button>
		    </div><!-- .col-xs-12 col-sm-12 col-md-2 -->
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
		      <table class="table table-bordered">
				  <thead>
				  	<tr>
				  	  <th scope="col" rowspan="2">#</th>
				  	  <th scope="col" rowspan="2">Objetivos</th>
				      <th scope="col" rowspan="2">Fecha de creación</th>
				      <th scope="col" rowspan="2">Acciones</th>
				      <th scope="col" colspan="2"><center>Evidencias</center></th>
				  	</tr>
				    <tr>
				      <th scope="col" >Antes</th>
				      <th scope="col" >Despues</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <th scope="row">1</th>
				      <td>Mark</td>
				      <td>Otto</td>
				      <td>@mdo</td>
				      <td>@mdo</td>
				      <td>@mdo</td>
				    </tr>
				  </tbody>
				</table>
		    </div><!-- .col-xs-12 col-sm-12 col-md-2 -->
		</div>
	<!-- </form> -->
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modal_generico_obj" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	<div class="modal-header">
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
<script type="text/javascript" src="<?= base_url('assets/js/pemc/objetivos.js') ?>"></script>
