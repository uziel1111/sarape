<!-- Modal -->
            <div class="modal fade" id="exampleModalacciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-style-1">
                  <div class="modal-header bgcolor-2">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Acciones por prioridad del Sistema Básico de Mejora</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="alert alert-info" role="alert">
                      Escuela: <span class="fw800">NOMBRE DE LA ESCUELA</span><br>

                      Prioridad: <span class="fw800">Convivencia escolar</span><br>

                      Problemática(s): <span class="fw800">Asistencia de profesores</span><br>

                      Evidencia(s): <span class="fw800">www.sarape.org</span>
                    </div>
                    <div class="card mb-3 card-style-1">
                      <div class="card-header card-1-header bg-light">Estrategia global de mejora</div>
                      <div class="card-body">
                        <div class="card-block">
                          <div class="form-group form-group-style-1">
                            <div class="row">
                              <div class="col-md-6">
                                <label>Ámbito</label>
                                <select class="selectpicker form-control" id="slc_rm_ambito" title="SELECCIONE UNA OPCIÓN">
                                  <?php foreach ($arr_ambitos as $item): ?>
                                          <option value="<?= $item['id_ambito'] ?>"><?= $item['ambito'] ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="row mt-15">
                              <div class="col-md-6">
                                <label>Acción:</label>
                                <textarea id="txt_rm_meta1" class="form-control" rows="5" maxlength="80"></textarea>
                              </div>
                              <div class="col-md-6">
                                <label>Materiales e insumos a utilizar:</label>
                                <textarea id="txt_rm_obs1" class="form-control" rows="5" maxlength="80"></textarea>
                              </div>

                            </div>
                            <div class="row mt-15">

                              <div class="col-md-4">
                                <label>Responsables</label>
                                <select name="ruta_presp1" class="selectpicker form-control" id="slc_rm_presp1" title="SELECCIONE UNA OPCIÓN">
                                  <option value="0">Otro</option>
                                </select>
                              </div>
                              <div class="col-md-4">
                                <label>Fecha de inicio</label>
                                <input id="datepicker1" />
                                <script>
                                $('#datepicker1').datepicker({
                                  uiLibrary: 'bootstrap4'
                                });
                                </script>
                              </div>

                              <div class="col-md-4">
                                <label>Fecha de término</label>
                                <input id="datepicker2" />
                                <script>
                                $('#datepicker2').datepicker({
                                  uiLibrary: 'bootstrap4'
                                });
                                </script>
                              </div>
                            </div>
                            <div class="row mt-15">
                              <div class="col-md-12">
                                <label>Indicadores de medicion:</label>
                                <textarea id="txt_rm_indimed" class="form-control" rows="3" maxlength="80"></textarea>
                              </div>
                            </div>
                            <div class="row mt-15">
                              <div class="col-12">
                                <button type="button" class="btn btn-primary btn-style-1 ml-20">Agregar</button>
                              </div>
                            </div>




                          </div>

                        </div>
                      </div><!-- card -->
                      <div class="row mt-15">
                        <div class="col-12">
                          <button type="button" data-toggle="tooltip" title="Editar" class="btn btn-primary"><i class="fas fa-edit"></i></button>
                          <button type="button" data-toggle="tooltip" title="Eliminar" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>


                        </div>


                      </div>

                      <div class="row mt-15">
                        <div class="col-12">
                          <div class='table-responsive'><table id='' class='table table-condensed table-hover  table-bordered'><thead>
                            <tr class=info>
                              <th id='idrutamtema'><center>Acción</center></th>
                              <th id='orden' style='width:4%'><center>Ámbito</center></th>
                              <th id='tema' style='width:20%'><center>Fecha de inicio</center></th>
                              <th id='problemas' style='width:31%'><center>Fecha de término</center></th>
                              <th id='evidencias' style='width:39%'><center>Responsables</center></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan="5">No hay datos por mostrar</td>
                            </tr>

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <!-- End Modal -->
