 <div class="container">
   <div class="row">
        <div class="col-md-4 form-group form-group-style-1">
          <label for="nivel_educativo_LAE">Seleccione un nivel educativo</label>
            <select id="nivel_educativo_LAE" class="form-control">
              <option value="0">Todos los niveles</option>
              <option value="1">Especial</option>
              <option value="2">Inicial</option>
              <option value="3">Preescolar</option>
              <option value="4">Primaria</option>
              <option value="5">Secundaria</option>
            </select></label>
        </div>
         <div class="col-md-4 form-group form-group-style-1">
           <label for="region_LAE">Seleccione una región</label>
            <select id="region_LAE" class="form-control">
              <option value="0">Todas las regiones</option>
              <option value="1">Sur</option>
              <option value="2">Centro - Desertica</option>
              <option value="3">Carbonifera</option>
              <option value="4">Norte</option>
              <option value="5">Laguna</option>
                   </select></label>
         </div>
         <div class="col-md-4 form-group form-group-style-1">
           <label for="municipio_LAE">Seleccione un municipio</label>
            <select id="municipio_LAE" class="form-control">
            	<option value="0">Todos los municipios</option>
              <?php foreach ($municipio as $key => $value) { ?>
              	<option value="<?= $value['id_municipio'] ?>"><?= $value['municipio'] ?></option>
              <?php } ?>
                   </select></label>
         </div>
       </div>
     </div>

      <div class="d-flex justify-content-center float-none">
      <p>
        <b>LAE-1 </b>EQUIPAMIENTO E INFRAESTRUCTURA DE ALTA CALIDAD <br>
        <b>LAE-2 </b>ASEGURAR ALTOS ÍNDICES DE APRENDIZAJES A TODA LA POBLACIÓN EDUCATIVA <br>
        <b>LAE-3 </b>CONTAR CON PERSONAL COMPETITIVO A NIVEL INTERNACIONAL <br>
        <b>LAE-4 </b>GENERAR AMBIENTES DE COLABORACIÓN Y CORRESPONSABILIDAD CON LOS PADRES DE FAMILIA <br>
        <b>LAE-5 </b>CONSOLIDAR EL LIDERAZGO DE DIRECTIVOS Y DOCENTES <br>
      </p>
      </div>
    
     <div>
       <br>
             <div id="columnchart_material" class="float-left" style="height: 350px;"></div>
             <div id="columnchart_material_acciones"  class="float-right" style="height: 350px;"></div>
        <br>
     </div>
     
      <div class="col-md-12 table-responsive" >
        <br>
        <table class="table table-striped table-bordered w-auto">
            <thead class="thead-dark">
          <tr>
            <th scope="col" width="250px">Región</th>
            <th scope="col">Municipio</th>
            <th scope="col" colspan="2"><center>LAE 1</center></th>
            <th scope="col" colspan="2"><center>LAE 2</center></th>
            <th scope="col" colspan="2"><center>LAE 3</center></th>
            <th scope="col" colspan="2"><center>LAE 4</center></th>
            <th scope="col" colspan="2"><center>LAE 5</center></th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th>Objetivos</th>
            <th>Acciones</th>
            <th>Objetivos</th>
            <th>Acciones</th>
            <th>Objetivos</th>
            <th>Acciones</th>
            <th>Objetivos</th>
            <th>Acciones</th>
            <th>Objetivos</th>
            <th>Acciones</th>
          </tr>
            </thead>
            <tbody>
              <?=$tabla?>
          </tbody>
          </table>
      </div>
       
   </div>
 </div>

 <script src="<?= base_url('assets/js/estadistica_pemc/selectEducativo.js') ?>"></script>
