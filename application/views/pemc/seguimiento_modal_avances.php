<?php foreach ($arr_datos_accion as $key => $value): ?>
  <div class="card">
  <div class="card-header">
    <div class="row" style="background-color: #FFCC80; ">
      <div class="card-header">
        <b>Objetivo:</b> <?=$value['objetivo'];?>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row" style="background-color: #bee5eb; ">
      <div class="col-12">
        <b>Meta(s):</b> <?=$value['meta'];?>
      </div>
    </div>
    <div class="row" style="background-color: #bee5eb; ">
      <div class="col-12">
        <b>Comentarios generales:</b> <?=$value['comentario_general'];?>
      </div>
    </div>
    <div class="row" style="background-color: #c3e6cb; ">
      <div class="col-12">
        <b>Ambitos:</b> <?=$value['ambitos'];?>
      </div>
    </div>
    <div class="row">
      <table class="table table-borderless">
          <thead>
            <tr>
              <th class="text-center">Fechas</th>
              <th class="text-center">Porcentaje de avance</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($arr_avances as $key => $value): ?>
            <tr>
              <td class="text-center"><?= $value['fcreacion'];?></td>
              <td class="text-center"><?= $value['avance'];?>%</td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    </div>
  </div>
</div>
  <?php endforeach; ?>
