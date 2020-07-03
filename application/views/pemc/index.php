<div class="container main-container">
<input type="hidden" name="idpemc" id="idpemc" value="<?=$idpemc?>">
  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link tab-item tab-primary three-tab active" id="nv_diagnostico" data-toggle="tab" href="#diagnostico_doc" role="tab" aria-controls="diagnostico_doc" aria-selected="true"><i class="fas fa-file-alt"></i> Diagnóstico</a>
      <a class="nav-item nav-link tab-item tab-secondary three-tab" id="nv_objetivos_metas_acciones" data-toggle="tab" href="#objetivos_metas_acciones_doc" role="tab" aria-controls="objetivos_metas_acciones_doc" aria-selected="false"><i class="fas fa-file-invoice"></i> Objetivos, metas y acciones</a>
      <a class="nav-item nav-link tab-item tab-info three-tab" id="nv_seguimiento" data-toggle="tab" href="#seguimiento_doc" role="tab" aria-controls="seguimiento_doc" aria-selected="false"><i class="fas fa-archive"></i> Seguimiento</a>
      <a class="nav-item nav-link tab-item tab-primary three-tab" id="nv_evaluacion" data-toggle="tab" href="#evaluacion_doc" role="tab" aria-controls="evaluacion_doc" aria-selected="true"><i class="fas fa-file-alt"></i> Evaluación</a>
    </div>
  </nav>

  <div class="tab-content shadow" id="nav-tabContent">
    <div class="tab-pane fade show active" id="diagnostico_doc" role="tabpanel" aria-labelledby="diagnostico_doc_tab">
      <div id="vista_diagnostico"></div>
    </div>
    <div class="tab-pane fade" id="objetivos_metas_acciones_doc" role="tabpanel" aria-labelledby="objetivos_metas_acciones_doc_tab">
      <div id="vista_objetivos_metas_acciones"></div>
    </div>
    <div class="tab-pane fade" id="seguimiento_doc" role="tabpanel" aria-labelledby="seguimiento_doc_tab">
      <div id="vista_seguimiento"></div>
    </div>
    <div class="tab-pane fade" id="evaluacion_doc" role="tabpanel" aria-labelledby="evaluacion_doc_tab">
      <div id="vista_evaluacion"></div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/pemc/principal.js') ?>"></script>
