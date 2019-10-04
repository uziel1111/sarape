<div class="container">
	<div class="tab-pane fade active show" id="nav-avances" role="tabpanel" aria-labelledby="nav-avances-tab">
<div class="alert alert-success" role="alert">
  <div class="row font-weight-bold text-muted">
    <div class="col">
     <img src="<?= base_url('assets/img/rm_estatus/0.png') ?>" class="img-fluid" alt="Responsive image" width="35px"> No iniciado
    </div>
    <div class="col">
      <img src="<?= base_url('assets/img/rm_estatus/1.png') ?>" class="img-fluid" alt="Responsive image" width="35px"> Recién iniciado
    </div>
    <div class="col">
      <img src="<?= base_url('assets/img/rm_estatus/2.png') ?>" class="img-fluid" alt="Responsive image" width="35px"> Avance medio
    </div>
    <div class="col">
      <img src="<?= base_url('assets/img/rm_estatus/3.png') ?>" class="img-fluid" alt="Responsive image" width="35px"> Por terminar
    </div>
    <div class="col">
      <img src="<?= base_url('assets/img/rm_estatus/4.png') ?>" class="img-fluid" alt="Responsive image" width="35px"> Terminado 
    </div>
  </div>
    <p style="red">Nota: El avance no se suma, es el porcentaje real.</p>
</div>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Prioridad</th>
      <th scope="col">Actividades</th>

      <th scope="col">CTE 1</th>
      <th scope="col">CTE 2</th>
      <th scope="col">CTE 3</th>
      <th scope="col">CTE 4</th>
      <th scope="col">CTE 5</th>
      <th scope="col">CTE 6</th>
      <th scope="col">CTE 7</th>
      <th scope="col">CTE 8</th>
      <th scope="col">Estatus</th>
    </tr>
  </thead>
  <tbody>
              <tr>
          <td>NORMALIDAD MÍNIMA ESCOLAR</td>                  <td>Dar a conocer actividades y resultados</td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;1_4237_751_9878&quot;)" id="1_4237_751_9878">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;2_4237_751_9878&quot;)" id="2_4237_751_9878">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;3_4237_751_9878&quot;)" id="3_4237_751_9878">
              <option value="0">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60" selected="">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;4_4237_751_9878&quot;)" id="4_4237_751_9878">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;5_4237_751_9878&quot;)" id="5_4237_751_9878">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;6_4237_751_9878&quot;)" id="6_4237_751_9878">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;7_4237_751_9878&quot;)" id="7_4237_751_9878">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;8_4237_751_9878&quot;)" id="8_4237_751_9878">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>


        <td><img src="<?= base_url('assets/img/rm_estatus/1.png') ?>" class="img-fluid" alt="Responsive image"></td>
		                </tr>
              <tr>
                      <td></td>
                            <td>Tendedero literario (exposición de productos)
Cuadro de honor matemático
</td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;1_4237_751_9876&quot;)" id="1_4237_751_9876">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;2_4237_751_9876&quot;)" id="2_4237_751_9876">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;3_4237_751_9876&quot;)" id="3_4237_751_9876">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;4_4237_751_9876&quot;)" id="4_4237_751_9876">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;5_4237_751_9876&quot;)" id="5_4237_751_9876">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select onchange="obj_rm_avances_acciones.set_avance(&quot;6_4237_751_9876&quot;)" id="6_4237_751_9876">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;7_4237_751_9876&quot;)" id="7_4237_751_9876">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;8_4237_751_9876&quot;)" id="8_4237_751_9876">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>



        <td>
					<img src="<?= base_url('assets/img/rm_estatus/0.png') ?>" class="img-fluid" alt="Responsive image">
				</td>
		                </tr>
              <tr>
                      <td></td>
                            <td>Compartir materiales de aplicación entre grados</td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;1_4237_751_9875&quot;)" id="1_4237_751_9875">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;2_4237_751_9875&quot;)" id="2_4237_751_9875">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))?'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;3_4237_751_9875&quot;)" id="3_4237_751_9875">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;4_4237_751_9875&quot;)" id="4_4237_751_9875">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;5_4237_751_9875&quot;)" id="5_4237_751_9875">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select onchange="obj_rm_avances_acciones.set_avance(&quot;6_4237_751_9875&quot;)" id="6_4237_751_9875">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;7_4237_751_9875&quot;)" id="7_4237_751_9875">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;8_4237_751_9875&quot;)" id="8_4237_751_9875">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

        <td><img src="<?= base_url('assets/img/rm_estatus/2.png') ?>" class="img-fluid" alt="Responsive image"></td>
		                </tr>
              <tr>
                      <td></td>
                            <td>Elegir un texto literario de distinto genero y aplicar actividades acordes
Resolución de problemas de manera aleatoria
</td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;1_4237_751_9874&quot;)" id="1_4237_751_9874">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;2_4237_751_9874&quot;)" id="2_4237_751_9874">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;3_4237_751_9874&quot;)" id="3_4237_751_9874">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;4_4237_751_9874&quot;)" id="4_4237_751_9874">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;5_4237_751_9874&quot;)" id="5_4237_751_9874">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select onchange="obj_rm_avances_acciones.set_avance(&quot;6_4237_751_9874&quot;)" id="6_4237_751_9874">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;7_4237_751_9874&quot;)" id="7_4237_751_9874">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;8_4237_751_9874&quot;)" id="8_4237_751_9874">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>



        <td><img src="<?= base_url('assets/img/rm_estatus/4.png') ?>" class="img-fluid" alt="Responsive image"></td>
		                </tr>
              <tr>
                      <td></td>
                            <td>SSSSSSSSSSSSSSSS</td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;1_4237_751_1435&quot;)" id="1_4237_751_1435">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;2_4237_751_1435&quot;)" id="2_4237_751_1435">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;3_4237_751_1435&quot;)" id="3_4237_751_1435">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;4_4237_751_1435&quot;)" id="4_4237_751_1435">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;5_4237_751_1435&quot;)" id="5_4237_751_1435">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select onchange="obj_rm_avances_acciones.set_avance(&quot;6_4237_751_1435&quot;)" id="6_4237_751_1435">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;7_4237_751_1435&quot;)" id="7_4237_751_1435">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;8_4237_751_1435&quot;)" id="8_4237_751_1435">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>



        <td><img src="<?= base_url('assets/img/rm_estatus/3.png') ?>" class="img-fluid" alt="Responsive image"></td>
		                </tr>
              <tr>
          <td>MEJORA DE LOS APRENDIZAJES CON ÉNFASIS EN LECTURA, ESCRITURA Y MATEMÁTICAS</td>                  <td>QQQ</td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;1_4237_4203_10897&quot;)" id="1_4237_4203_10897">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;2_4237_4203_10897&quot;)" id="2_4237_4203_10897">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;3_4237_4203_10897&quot;)" id="3_4237_4203_10897">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;4_4237_4203_10897&quot;)" id="4_4237_4203_10897">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;5_4237_4203_10897&quot;)" id="5_4237_4203_10897">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select onchange="obj_rm_avances_acciones.set_avance(&quot;6_4237_4203_10897&quot;)" id="6_4237_4203_10897">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;7_4237_4203_10897&quot;)" id="7_4237_4203_10897">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;8_4237_4203_10897&quot;)" id="8_4237_4203_10897">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>



        <td><img src="<?= base_url('assets/img/rm_estatus/1.png') ?>" class="img-fluid" alt="Responsive image"></td>
		                </tr>
              <tr>
          <td>CONVIVENCIA ESCOLAR SANA Y PACÍFICA</td>                  <td>ssssss</td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;1_4237_5038_14028&quot;)" id="1_4237_5038_14028">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;2_4237_5038_14028&quot;)" id="2_4237_5038_14028">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;3_4237_5038_14028&quot;)" id="3_4237_5038_14028">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;4_4237_5038_14028&quot;)" id="4_4237_5038_14028">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;5_4237_5038_14028&quot;)" id="5_4237_5038_14028">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select onchange="obj_rm_avances_acciones.set_avance(&quot;6_4237_5038_14028&quot;)" id="6_4237_5038_14028">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;7_4237_5038_14028&quot;)" id="7_4237_5038_14028">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>

                  <td>
            <select <?=(isset($tipou_pemc_avances))? 'disabled':'' ?> onchange="obj_rm_avances_acciones.set_avance(&quot;8_4237_5038_14028&quot;)" id="8_4237_5038_14028">
              <option value="0" selected="">0%</option>
              <option value="10">10%</option>
              <option value="20">20%</option>
              <option value="30">30%</option>
              <option value="40">40%</option>
              <option value="50">50%</option>
              <option value="60">60%</option>
              <option value="70">70%</option>
              <option value="80">80%</option>
              <option value="90">90%</option>
              <option value="100">100%</option>
            </select>
          </td>



        <td><img src="<?= base_url('assets/img/rm_estatus/2.png') ?>" class="img-fluid" alt="Responsive image"></td>
		                </tr>
        </tbody>
</table>
					</div>



</div>
