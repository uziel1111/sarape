<div class="container" style="padding: 40px 40px;">
    <div class="card">
      <div class="card-header" style="padding: 1.2rem 1.2rem;">
       <h5>Escuelas</h5>
      <input type="hidden"id="idpemc_click" name="idpemc_click" value="">
      <input type="hidden"id="turno_click" name="turno_click" value="">
      </div>
      <div class="card-body">
        <?php if (isset($escuelas)): ?>
      	<div class="col-lg-12">
      		<button type="button" id="btn-estadisticas"class="btn btn-a2"><i class="fas fa-chart-bar"></i>&nbsp;Estadísticas por zona</button><br><br>
          <table class="table table-hover" style="border:1px solid #dee2e6">
              <thead class="bgcolor-2 color-6">
                <tr>
                  <th scope="col"></th>
                  <th scope="col">Nombre</th>
                  <th scope="col">CCT</th>
                  <th scope="col">Turno</th>
                  <th scope="col"># Objetivos</th>
                  <th scope="col"># Acciones</th>
                </tr>
              </thead>
              <tbody>
                <div id="accordion" class="accordion">
                  <div class="card">
  	               <?php foreach ($escuelas as  $escuela): ?>
  	               <tr>
                        <td id="heading<?= $escuela->b_cct.$escuela->b_turno?>">
                        <button id=""data-escuela='{"cct":"<?= $escuela->b_cct?>","turno":"<?= $escuela->b_turno?>","idpemc":"<?= $escuela->idpemc?>"}'class="btn collapsed btn-coll_escuela" data-toggle="collapse" data-target="#<?= $escuela->b_cct.$escuela->b_turno?>" aria-expanded="false" aria-controls="<?= $escuela->b_cct.$escuela->b_turno?>">
                        <i class="color-2 icon-escuela_<?= $escuela->b_cct.$escuela->b_turno?> fas fa-chevron-down"></i>
                        </button>
                        </td>                       
                        <td><?= $escuela->b_nombre ?></td> 
                        <td><?= $escuela->b_cct ?></td>
                        <td><?= $escuela->b_desc_turno ?></td>
                        <td><?= $escuela->objetivos ?></td>
                        <td><?= $escuela->acciones ?></td>                  
                    </tr>
                    <tr>
                        <td id="<?= $escuela->b_cct.$escuela->b_turno?>" class="collapse" aria-labelledby="heading<?= $escuela->b_cct.$escuela->b_turno?>" data-parent="#accordion"colspan="6">
                         <?php if ($escuela->idpemc!="SINPEMC"): ?>
                            <div id="vista_escuela<?=$escuela->b_cct.$escuela->b_turno?>"></div>
                         <?php endif; ?>
                         <?php if ($escuela->idpemc=="SINPEMC"): ?>
                            <div class="alert alert-info">Escuela sin actividad de PEMC</div> 
                         <?php endif; ?>
                        </td>
                    <tr>
                 <?php endforeach; ?>
                 </div>
                </div> 

              </tbody>
            </table> 
           </div>
           <?php endif ?>
           <?php if (!isset($escuelas)): ?>
            <?= $status_super ?>
             <?php endif ?>
      	</div>
      </div>
    </div>   
<!-- Modal Estadísticas Supervisor-->
<div class="modal fade" id="modal_estadisticas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-style-1">
      <div class="modal-header bgcolor-2">
        <h5 class="modal-title text-white" id="exampleModalLabel">Objetivos y Acciones</h5>
        <button type="button" class="close" id="btn-cerrar_estadisticas" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="contenido-estadisticas"></div>
      </div>
    </div>
  </div>
</div> <!-- Fin modal estadisticas-->
<script>
  function getScript2(src)
  {
    if($('script[src="'+src+'"]').length>0){
        return true;
    }else{
        return false;
    }
  }
  $(document).ready(function(){
    if (!getScript2("<?= base_url('assets/js/pemc/graf_chars.js') ?>")) {
      var script1 = document.createElement("script");  // create a script DOM node
      script1.src = "https://www.gstatic.com/charts/loader.js";  // set its src to the provided URL
      document.head.appendChild(script1);
      var script2 = document.createElement("script");  // create a script DOM node
      script2.src = "<?= base_url('assets/js/pemc/graf_chars.js') ?>";  // set its src to the provided URL
      document.head.appendChild(script2);
    }
});
</script>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/supervisor.js') ?>"></script>
