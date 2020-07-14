<div class="card">
  <div class="card-header">
    <a  href="<?= base_url('Pemc/ver_reporte_xidpemc/').$idpemc ?>" target="_blank"><button type="button" class="btn btn-info">Generar reporte</button></a>
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
<div class="card">
  <div class="card-header">
    <h3>Historial de evaluaciones PEMC</h3>
  </div>
  <div class="card-body">
    <div class="container">
      <table class="table table-borderless">
          <thead>
            <tr>
              <th class="text-center">Evaluaciones</th>
              <th class="text-center">Fechas</th>
              <th class="text-center">Reportes PDF</th>
              <th class="text-center">Ciclo escolar</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
            </tr>
          </tbody>
        </table>
    </div>
  </div>
</div>
