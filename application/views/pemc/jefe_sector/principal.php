<div class="container" style="padding: 40px 40px;">
<div class="card">
  <div class="card-header" style="padding: 1.2rem 1.2rem;">
  </div>
  <div class="card-body">
  	<div class="col-lg-12 row">
		<div class="col-md-6 form-group form-group-style-1 "  style="margin-left: 13px">
			<label for="slct_supervision">Seleccione la supervisión</label>
			 <select id="slct_supervision" class="form-control">
			 	 <option value="0">Seleccione...</option>
			 	<?php foreach ($supervisiones as $supervision) :?>
				 <option value="<?= $supervision->cct.'_'.$supervision->turno?>"><?= $supervision->nombre.' / '.$supervision->cct?></option>
                <?php endforeach; ?>
			</select>
		</div>
    <div class="col-md-3">
    </div>
		<div class="col-md-2" style="margin-top:30px;margin-left: 10px;">
   		<button type="button" id="btn-estadisticas_xjefsector"class="btn btn-a2"><i class="fas fa-chart-bar"></i>&nbsp;Estadísticas por Sector</button>
        </div>
   </div>
   <div id="vista_escuelas">

   </div>
</div>
</div>
</div>
<!-- Modal Estadísticas Jefe de Sector-->
<div class="modal fade" id="modal_estadisticas_xjefsector" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-style-1">
      <div class="modal-header bgcolor-2">
        <h5 class="modal-title text-white" id="exampleModalLabel">Objetivos y Acciones</h5>
        <button type="button" class="close" id="btn-cerrar_estadisticas_xjefsector" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="contenido-estadisticas_xjefsector"></div>
      </div>
    </div>
  </div>
</div> <!-- Fin modal estadisticas-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/jefe_sector.js') ?>"></script>
