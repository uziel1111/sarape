<div class="card">
  <div class="card-header">
    <button type="button" onclick="Evaluacion_pemc.ver_reporte_xidpemc(<?=$idpemc?>)" class="btn btn-info">Generar reporte</button>
  </div>
  <div class="card-body">
    <div class="container">
      <form class="form-group" name="fr_diagnostico" id="fr_evaluacion">
      <label class="my-1 mr-2" for="in_diag">Redacte su evaluación:</label>
       <textarea class="form-control" name="in_diag" id="in_diag" rows="3" required></textarea>
    <button class="btn btn-primary my-1  float-right" id="btn_guardar_evaluacion_pemc">Grabar</button>
    </form>
    </div>
  </div>
</div>
