<?php $i = 0; foreach ($formato as $key => $encuestas) { $i++; ?>
        <tr>
            <th scope='row' width="15px"><?=$i?></th>
            <td width="390px"><?=strtoupper($encuestas[1]['respuesta'])?></td>
            <td width="145px"><?= $encuestas[0]['sostenimiento']?></td>
            <td width="130px">
                <span data-toggle='modal' data-target='#verDocumento'>
                    <button type='button' data-toggle='tooltip' title='Ver documento' onclick='documento(<?=$encuestas[0]['idaplicar']?>)' class='btn btn-sm btn-secondary'><i class='fas fa-file-alt mx-1'></i></button>
                </span>


                <span data-toggle='modal' data-target='#verDetalle'>
                    <button type='button' data-toggle='tooltip' title='Ver detalle' onclick='detalle(<?=$encuestas[0]['idaplicar']?>)' class='btn btn-sm btn-success'><i class='fas far fa-eye'></i></button>
                </span>

                 <span data-toggle='modal' data-target='#verContacto'>
                    <button type='button' data-toggle='tooltip' title='Ver conctacto' onclick='contacto(<?=$encuestas[0]['idusuario']?>, 2)' class='btn btn-sm btn-info'><i class='far fa-id-card'></i></button>
                </span>


            </td>
        </tr>
<?php } ?>