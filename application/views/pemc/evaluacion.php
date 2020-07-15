<div class="card">
  <div class="card-header">
    <a  href="<?= base_url('Pemc/ver_reporte_xidpemc/').$idpemc ?>" target="_blank"><button type="button" class="btn btn-info">Generar reporte</button></a>
  </div>
  <div class="card-body">
    <div class="container">
      <form class="form-group" name="fr_evaluacion" id="fr_evaluacion">
      <label class="my-1 mr-2" for="in_eval">Redacte su evaluación:</label>
       <textarea class="form-control" name="in_eval" id="in_eval" rows="3" required></textarea>
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

              <?php foreach ($evaluacion as $key => $value): ?>
                <tr>
                <td class="text-center"><?=$value['evaluacion'];?></td>
                <td class="text-center"><?=$value['fcreacion'];?></td>
                <td class="text-center"><a  href="<?= base_url($value['url_reporte']) ?>" target="_blank"><button type="button" class="btn btn-info">Ver reporte</button></a></td>
                <td class="text-center"><?=$value['ciclo_escolar'];?></td>
                </tr>
              <?php endforeach; ?>

          </tbody>
        </table>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/evaluacion.js') ?>"></script>
