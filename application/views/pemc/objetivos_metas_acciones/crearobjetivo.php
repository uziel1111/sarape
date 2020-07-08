<div class="container">
	<form class="form-group" name="form_crear_editar_obj" id="form_crear_editar_obj">
		<div class="form-group">
		    <label for="text_objetivo_c">* Objetivo</label>
		    <textarea class="form-control" id="text_objetivo_c" name="text_objetivo_c" rows="3"></textarea>
		 </div>
		 <div class="form-group">
		    <label for="text_meta_c">* Meta</label>
		    <textarea class="form-control" id="text_meta_c" name="text_meta_c" rows="3"></textarea>
		 </div>
		 <div class="form-group">
		    <label for="text_comentariosG_c">Comentarios generales(opcional)</label>
		    <textarea class="form-control" id="text_comentariosG_c" name="text_comentariosG_c" rows="3"></textarea>
		 </div>
		 <div class="row">
		 	<div class="col-xs-12 col-sm-12 col-md-3">
		 		<button class="btn btn-primary" id="btn_guarda_objetivo">Guardar</button>
		 	</div>
	 	 </div>
	</form>
	
</div>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/objetivos/crud.js') ?>"></script>