<div class="container main-container">
<input type="hidden" name="idpemc" id="idpemc" value="<?=$idpemc?>">
<input type="hidden" name="cct" id="cct" value="<?=$cct?>">
<input type="hidden" name="turno" id="turno" value="<?=$id_turno?>">
<input type="hidden" name="t_usuario" id="t_usuario" value="<?=$tipo_usuario?>">

  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link tab-item tab-primary three-tab active" id="nv_diagnostico<?=$idpemc?><?=$id_turno?>" data-toggle="tab" href="#diagnostico_doc<?=$idpemc?><?=$id_turno?>" role="tab" aria-controls="diagnostico_doc<?=$idpemc?><?=$id_turno?>" aria-selected="true" onclick="Principal_pemc.obtiene_vista_diagnostico('<?=$idpemc?>','<?=$id_turno?>')"><i class="fas fa-file-alt"></i> Diagnóstico</a>
      <a class="nav-item nav-link tab-item tab-secondary three-tab" id="nv_objetivos_metas_acciones<?=$idpemc?><?=$id_turno?>" data-toggle="tab" href="#objetivos_metas_acciones_doc<?=$idpemc?><?=$id_turno?>" role="tab" aria-controls="objetivos_metas_acciones_doc<?=$idpemc?><?=$id_turno?>" aria-selected="false" onclick="Principal_pemc.obtiene_vista_obetivos('<?=$idpemc?>','<?=$id_turno?>')"><i class="fas fa-file-invoice"></i> Objetivos, metas y acciones</a>
      <a class="nav-item nav-link tab-item tab-info three-tab" id="nv_seguimiento<?=$idpemc?><?=$id_turno?>" data-toggle="tab" href="#seguimiento_doc<?=$idpemc?><?=$id_turno?>" role="tab" aria-controls="seguimiento_doc<?=$idpemc?><?=$id_turno?>" aria-selected="false" onclick="Principal_pemc.obtiene_vista_seguimiento('<?=$idpemc?>','<?=$id_turno?>')"><i class="fas fa-archive"></i> Seguimiento</a>
      <a class="nav-item nav-link tab-item tab-primary three-tab" id="nv_evaluacion<?=$idpemc?><?=$id_turno?>" data-toggle="tab" href="#evaluacion_doc<?=$idpemc?><?=$id_turno?>" role="tab" aria-controls="evaluacion_doc<?=$idpemc?><?=$id_turno?>" aria-selected="true" onclick="Principal_pemc.obtiene_vista_evaluacion('<?=$idpemc?>','<?=$cct?>','<?=$id_turno?>')"><i class="fas fa-file-alt"></i> Evaluación</a>
    </div>
  </nav>

  <div class="tab-content shadow" id="nav-tabContent">
    <div class="tab-pane fade show active" id="diagnostico_doc<?=$idpemc?><?=$id_turno?>" role="tabpanel" aria-labelledby="diagnostico_doc<?=$idpemc?><?=$id_turno?>_tab">
      <div id="vista_diagnostico<?=$idpemc?><?=$id_turno?>"></div>
    </div>
    <div class="tab-pane fade" id="objetivos_metas_acciones_doc<?=$idpemc?><?=$id_turno?>" role="tabpanel" aria-labelledby="objetivos_metas_acciones_doc<?=$idpemc?><?=$id_turno?>_tab">
      <div id="vista_objetivos_metas_acciones<?=$idpemc?><?=$id_turno?>">
      </div>
    </div>
    <div class="tab-pane fade" id="seguimiento_doc<?=$idpemc?><?=$id_turno?>" role="tabpanel" aria-labelledby="seguimiento_doc<?=$idpemc?><?=$id_turno?>_tab">
      <div id="vista_seguimiento<?=$idpemc?><?=$id_turno?>"></div>
    </div>
    <div class="tab-pane fade" id="evaluacion_doc<?=$idpemc?><?=$id_turno?>" role="tabpanel" aria-labelledby="evaluacion_doc<?=$idpemc?><?=$id_turno?>_tab">
      <div id="vista_evaluacion<?=$idpemc?><?=$id_turno?>"></div>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?= base_url('assets/js/pemc/principal.js') ?>"></script>
