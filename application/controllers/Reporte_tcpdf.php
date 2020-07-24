<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_tcpdf extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('Utilerias');
		$this->load->library('My_tcpdf');
		$this->load->model('Pemc_model');

	}// __construct()

	  function reporte_detalle($idpemc){
			$datos_sesion = Utilerias::get_cct_sesion($this);
			$cve_centro = $datos_sesion['cve_centro'];
			$turno = $datos_sesion['id_turno_single'];
			$str_cct = "CCT: {$datos_sesion['cve_centro']}";
			$str_nombre = $datos_sesion['nombre_centro'];
			$cte = $this->Pemc_model->get_cte();
			$str_cte = "Consejo técnico escolar: {$cte}";
			$fecha = date("Y-m-d");
			$arr_aux = explode("-",$fecha);
			$anio_i = $arr_aux[0];
			$mes_i = $arr_aux[1];
			$dia_i = $arr_aux[2];
			$fecha = " Fecha: ".$dia_i."/".$mes_i."/".$anio_i;
			$ciclo =  $this->Pemc_model->trae_ciclo_actual();
			$diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
			$pdf = new My_tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('JL');
			$pdf->SetTitle('Diagnostico');
			$pdf->SetSubject('');
			$pdf->SetKeywords('');
			$pdf->SetTextColor(65, 65, 67);
			$pdf->AddPage('L', 'Legal');
			$pdf->SetFont('montserratb', '', 17);
			$pdf->Cell(0, 60, 'Programa Escolar de Mejora Continua (PEMC)', 0, 1, 'C');
			$cte = $this->Pemc_model->get_cte();
			$pdf->CreateTextBox('Consejo técnico escolar: '.$cte, 95, 13, 10, 70, 14, 'B', 'L');
			$pdf->SetAutoPageBreak(TRUE, 0);
			$pdf->SetAutoPageBreak(FALSE, 0);
			$pdf->Image($file='assets/img/logoreporte.png', $x=7, $y=12, $w=65, $h=12, $type='', $link='', $align='', $resize=true, $dpi=100, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
			$pdf->SetTextColor(65, 65, 67);
			$pdf->CreateTextBox('CCT: ', 220, 8, 180, 10, 9, 'B', 'L');
			$pdf->CreateTextBox('Escuela: ', 220, 13, 180, 10, 9, 'B', 'L');
			$pdf->SetFont('montserrat', '', 17);
			$pdf->CreateTextBox($cve_centro, 229, 8, 180, 10, 9, '', 'L');
			$long_nombre=strlen($str_nombre);
			$pdf->MultiCell(0, 12, $str_nombre, 0, 'L', 0, 0, 255, 16, true);
			if ($long_nombre>=43){
				$y=$pdf->GetY()+6;
			}
			else {
				$y=$pdf->GetY()+3;
			}
			$pdf->SetFont('montserratb', '', 17);
			$pdf->CreateTextBox('Ciclo:', 220,$y,180, 10, 9, 'B', 'L');
			$pdf->SetFont('montserrat', '', 17);
			$pdf->CreateTextBox($ciclo, 229,$y,180, 10, 9, '', 'L');
			$pdf->CreateTextBox('Diagnóstico: ', 0, 18, 10, 70, 14, 'B', 'L');
			$y2=$pdf->GetY()+6;
			$pdf->SetFont('montserratb', '', 17);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('arialb', '', 8);
			$str_html= $diagnostico;
			$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=60, $str_html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

			$pdf->Output('diagnostico.pdf', 'I');
	}// reporte_acceso_dia()


	function reporte_pemc($idpemc, $url_save=null){
		$datos_sesion = Utilerias::get_cct_sesion($this);
		$cve_centro = $datos_sesion['cve_centro'];
		$turno = $datos_sesion['id_turno_single'];
		$str_cct = "CCT: {$datos_sesion['cve_centro']}";
		$str_nombre = $datos_sesion['nombre_centro'];
		$cte = $this->Pemc_model->get_cte();
		$str_cte = "Consejo técnico escolar: {$cte}";
		$fecha = date("Y-m-d");
		$arr_aux = explode("-",$fecha);
		$anio_i = $arr_aux[0];
		$mes_i = $arr_aux[1];
		$dia_i = $arr_aux[2];
		$fecha = " Fecha: ".$dia_i."/".$mes_i."/".$anio_i;
		$ciclo =  $this->Pemc_model->trae_ciclo_actual();
		$diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
		$pdf = new My_tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('JL');
		$pdf->SetTitle('Diagnostico');
		$pdf->SetSubject('');
		$pdf->SetKeywords('');
		$pdf->SetTextColor(65, 65, 67);
		$pdf->AddPage('L', 'Legal');
		$pdf->SetFont('montserratb', '', 17);
		$pdf->Cell(0, 60, 'Programa Escolar de Mejora Continua (PEMC)', 0, 1, 'C');
		$cte = $this->Pemc_model->get_cte();
		$pdf->CreateTextBox('Consejo técnico escolar: '.$cte, 95, 13, 10, 70, 14, 'B', 'L');
		$pdf->SetAutoPageBreak(TRUE, 0);
		$pdf->SetAutoPageBreak(FALSE, 0);
		$pdf->Image($file='assets/img/logoreporte.png', $x=7, $y=12, $w=65, $h=12, $type='', $link='', $align='', $resize=true, $dpi=100, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
		$pdf->SetTextColor(65, 65, 67);
		$pdf->CreateTextBox('CCT: ', 220, 8, 180, 10, 9, 'B', 'L');
		$pdf->CreateTextBox('Escuela: ', 220, 13, 180, 10, 9, 'B', 'L');
		$pdf->SetFont('montserrat', '', 17);
		$pdf->CreateTextBox($cve_centro, 229, 8, 180, 10, 9, '', 'L');
		$long_nombre=strlen($str_nombre);
		$pdf->MultiCell(0, 12, $str_nombre, 0, 'L', 0, 0, 255, 16, true);
		if ($long_nombre>=43){
			$y=$pdf->GetY()+6;
		}
		else {
			$y=$pdf->GetY()+3;
		}
		$pdf->SetFont('montserratb', '', 17);
		$pdf->CreateTextBox('Ciclo:', 220,$y,180, 10, 9, 'B', 'L');
		$pdf->SetFont('montserrat', '', 17);
		$pdf->CreateTextBox($ciclo, 229,$y,180, 10, 9, '', 'L');
		$y2=$pdf->GetY()+6;

		if ($url_save==null) {
			$pdf->Output();
		}
		else {
			$pdf->AddPage('L','Legal');
			$diagnostico = $this->Pemc_model->obtener_diagnostico_xidpemc($datos_sesion['idpemc']);
			$pdf->SetFont('montserratb', '', 17);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('arialb', '', 8);
			$str_html= $diagnostico;
			$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=60, $str_html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);


			$evaluacion = $this->Pemc_model->obtener_evaluacion_xidpemc($datos_sesion['idpemc']);
			$pdf->SetFont('montserratb', '', 17);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('arialb', '', 8);
			$str_html= $evaluacion;
			$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=60, $str_html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

			$pdf->Output($url_save,'F');
		}
}// reporte_acceso_dia()

	private function reporte_alumnos_multiple($pdf, $array_datos,$contador,$array_datos_escuela){
		$pdf->SetTextColor(65, 65, 67);
		$pdf->AddPage('P', 'A4');
		$pdf->SetFont('montserratb', '', 17);
		$pdf->Cell(0, 70, 'Último acceso', 0, 1, 'C');

		$pdf->SetAutoPageBreak(TRUE, 0);


		$pdf->Image('assets/'.SKIN.'/img/template/encabezado.png', 0,0,211, 16, '', '', '', false, 300, '', false, false, 0);


		$pdf->SetAutoPageBreak(FALSE, 0);

		if (strlen(trim($this->usuario_sesion->logo)) > 0) {

			$img_base64_encoded = $this->usuario_sesion->logo;
		$imageContent = file_get_contents($img_base64_encoded);
		$path = tempnam(sys_get_temp_dir(), 'prefix');
		file_put_contents ($path, $imageContent);

				$pdf->Image($file=$path, $x=7, $y=10, $w=0, $h=20, $type='', $link='', $align='', $resize=true, $dpi=150, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);

		} else {
				$pdf->Image($file='assets/'.SKIN.'/img/template/logo-main.png', $x=7, $y=10, $w=70, $h=20, $type='', $link='', $align='', $resize=true, $dpi=150, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
		}

		$pdf->SetTextColor(65, 65, 67);
  		$pdf->CreateTextBox('CCT: ', 70, 8, 180, 10, 9, 'B', 'L');
		$pdf->CreateTextBox('Escuela: ', 70, 13, 180, 10, 9, 'B', 'L');

		$pdf->SetFont('montserrat', '', 17);
		$pdf->CreateTextBox($array_datos_escuela['clave'], 79, 8, 180, 10, 9, '', 'L');
		// $pdf->CreateTextBox($array_datos_escuela['nombre'], 84, 13, 2, 10, 9, '', 'L');
		// $pdf->MultiCell(79, 8,$array_datos_escuela['nombre'] , 1, 'J', 1, 0, '', '', true, 0, false, true, 40, 'T');
		// echo strlen($array_datos_escuela['nombre']); // 7
		//43
		// $array_datos_escuela['nombre']='AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
		// echo strlen($array_datos_escuela['nombre']); // 7
		$long_nombre=strlen($array_datos_escuela['nombre']);

		$pdf->MultiCell(0, 12, $array_datos_escuela['nombre'], 0, 'L', 0, 0, 105, 16, true);
		if ($long_nombre>=43){
			$y=$pdf->GetY()+6;
			// echo 'if';
		}
		else {
			$y=$pdf->GetY()+3;
			// echo 'else';
		}


		$pdf->SetFont('montserratb', '', 17);

		// $y=$pdf->GetY()+4;
		$pdf->CreateTextBox('Grupo:                   Fecha:', 70,$y,180, 10, 9, 'B', 'L');
		$pdf->SetFont('montserrat', '', 17);
		// $pdf->CreateTextBox($array_datos_escuela['turno'], 81,$y,180, 10, 9, '', 'L');
		$pdf->CreateTextBox($array_datos[0]['grupo'], 82,$y,180, 10, 9, '', 'L');
		$pdf->CreateTextBox($array_datos_escuela['fecha'], 109,$y,180, 10, 9, '', 'L');
		$y2=$pdf->GetY()+6;
		$pdf->SetFont('montserratb', '', 17);

$pdf->SetTextColor(0,0,0);

  	$pdf->SetFont('arialb', '', 10);
  	$str_html='
  	<style>
  	table td{
  		border: 1px solid #E6E7E9;
  		padding: 2px !important;
  	}

  	</style>
  	<table style="padding: 7px; border-left: 40px solid #E6E7E9; border-right: 40px solid #E6E7E9; border-top: 40px solid #E6E7E9; border-bottom: 40px solid #E6E7E9;">

  <tr style="background-color:#414143">
	<td style="text-align:center" width="6%" height="28px"><font color="white"><b>No.</b></font></td>
  <td style="text-align:center" width="36%" height="28px"><font color="white"><b>Apellido 1 / Apellido 2 / Nombre(s)</b></font></td>
  <td style="text-align:center" width="8%" height="28px"><font color="white"><b>Género</b></font></td>
	<td style="text-align:center" width="25%" height="28px"><font color="white"><b>Último login</b></font></td>
	<td style="text-align:center" width="14%" height="28px"><font color="white"><b>Días sin acceso</b></font></td>
	<td style="text-align:center" width="11%" height="30px"><font color="white"><b>Teléfono</b></font></td>
  </tr>'
	;

  	// $contador = 1;
  	// echo "<pre>"; print_r($array_datos); die();
  	foreach ($array_datos as $key => $alumno) {
			$pdf->SetFont('arial', '', 8);

  		$nombre=$alumno['nombre'];
			$no_dias=$alumno['no_dias'];
			$sexo=$alumno['sexo'];
			// $genero = ($sexo == 'M') ? "MUJER" : "HOMBRE";
			$telefono=$alumno['telefono'];
  		$fecha=$alumno['ultlogin'];

if($contador % 2 == 0){
$color="#F7F9F9";
}
else {
	$color="#FFFFFF";
}
  		$str_html .= <<<EOD
  		<tr bgcolor="$color">
			<td style="text-align:center" height="18px">&nbsp;$contador</td>
  		<td height="18px">&nbsp;$nombre</td>
  		<td style="text-align:center" height="18px">$sexo</td>
			<td style="text-align:center" height="18px">&nbsp;$fecha</td>
			<td style="text-align:center" height="18px">$no_dias</td>
			<td style="text-align:center" height="18px">$telefono</td>
  </tr>
EOD;

 $contador++;
  	}

  	$str_html .= '</table>';

  $html= <<<EOT
  $str_html
EOT;

  		$pdf->writeHTMLCell($w=0,$h=55,$x=10,$y=57, $html, $border=0, $ln=1, $fill=0, $reseth=true, $aligh='L', $autopadding=true);

			return array(
				'pdf' => $pdf,
				'contador' => $contador,
			);
  }// reporte_alumnos_multiple()
}
