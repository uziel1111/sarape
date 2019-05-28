<style type="text/css">
	.margintop35{
	  margin-top: 25px;
	}

</style>
<div class="container">
	<br><br><br><br><br><br><br>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="form-group form-group-style-1">
          <?=form_label('Municipio', 'minicipio', array('class' => 'mr-sm-2'));?>
          <?=form_dropdown('minicipio', $arr_municipios, 'large', array('class' => 'form-control', 'id' => 'slt_municipio_peso'));?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="form-group form-group-style-1">
          <?=form_label('Nivel', 'nivel');?>
          <?=form_dropdown('nivel', $arr_niveles, 'large', array('class' => 'form-control', 'id' => 'slt_nivel_peso'));?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-3">
            <div class="form-group form-group-style-1">
          <?=form_label('Ciclo', 'ciclo');?>
          <?=form_dropdown('ciclo', $arr_ciclos, 'large', array('class' => 'form-control', 'id' => 'slt_ciclo_peso'));?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-lg-3 margintop35">
        	<button class="btn btn-primary" id="bt_porcentajeobe">Buscar</button>
        </div>
	</div>
	

	<div id="contenedor_de_vista_g"></div>

	
</div>

<script src="<?= base_url('assets/js/indiceobesidad/indiceo.js') ?>"></script>
