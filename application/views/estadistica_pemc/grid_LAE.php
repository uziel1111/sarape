 <div class="row">
    <div class="col-md-12">
      <select id="nivel_educativo_grid_general_LAE" class="form-control">
        <option value="0">Todos los niveles</option>
        <option value="1">Especial</option>
        <option value="2">Inicial</option>
        <option value="3">Preescolar</option>
        <option value="4">Primaria</option>
        <option value="5">Secundaria</option>
      </select>
    </div>
    <div class="col-sm-12">
         <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
     </div>
    <div class="col-sm-12">
      <br>
        <table class="table">
          <thead class="thead-dark">
        <tr>
          <th scope="col">TOTAL</th>
          <th scope="col">LAE 1</th>
          <th scope="col">LAE 2</th>
          <th scope="col">LAE 3</th>
           <th scope="col">LAE 4</th>
          <th scope="col">LAE 5</th>
        </tr>
          </thead>
          <tbody>
           <tr>
            <td><?=$result['total']?></td>
             <td><?=$result['obj1']?></td>
             <td><?=$result['obj2']?></td>
             <td><?=$result['obj3']?></td>
             <td><?=$result['obj4']?></td>
             <td><?=$result['obj5']?></td>
           </tr>
        </tbody>
        </table>
    </div>
     
 </div>

 <script src="<?= base_url('assets/js/estadistica_pemc/selectEducativo.js') ?>"></script>
