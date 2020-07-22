<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_pemcv1_masivo extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->library('Utilerias');
		$this->load->model('Reportepdf_model');
		$this->load->model('Escuela_model');
		$this->load->model('Rutamejora_model');
		$this->load->library('PDF_MC_Table');
		date_default_timezone_set('America/Mexico_City');
	}// __construct()


	public function Reporte_PEMC(){

			$ccts = $this->Reportepdf_model->get_esc_masivas();
			// echo "<pre>";print_r($ccts);die();
			foreach ($ccts as $key => $cct) {
				echo "<pre>";print_r($cct."__".$key);
				$cve_centro = $cct['cct'];
				$turno = $cct['turno'];
				$str_cct = "CCT: {$cct['cct']}";
				$str_nombre = "ESCUELA: {$cct['nombre']}";

				$fecha = date("Y-m-d");
				$arr_aux = explode("-",$fecha);

				$anio_i = $arr_aux[0];
				$mes_i = $arr_aux[1];
				$dia_i = $arr_aux[2];
				$fecha = " Fecha: ".$dia_i."/".$mes_i."/".$anio_i;
				$ciclo =$this->Reportepdf_model->get_ciclo();
				$ciclo = "CICLO:".$ciclo[0]->ciclo.$fecha;
				$pdf = new PDF_MC_Table($str_cct, $str_nombre, $ciclo);
				//incializamos variables de header
				$pdf->SetvarHeader($str_cct, $str_nombre, $ciclo);
				$pdf->AliasNbPages();
				$pdf->AddPage('L','Legal');

				$rutas = $this->Reportepdf_model->get_rutasxcct($cve_centro,$turno);
				$aux_ruta = '';
				$loque_imprime= '' ;

				foreach ($rutas as $ruta) {
					if ($aux_ruta == $ruta['tema']) {
						$ruta['tema']= '' ;
						$id_tprioritario_cap= $ruta['id_tprioritario'];
					}
					else {
					}
					$aux_ruta = $ruta['tema'];
					$id_tprioritario = $ruta['id_objetivo'];
					$id_tprioritario_cap= $ruta['id_tprioritario'];
					//DATOS
					if ($id_tprioritario!='') {

						$cap = $this->Rutamejora_model->get_problematica_ambito($id_tprioritario_cap);
								$ambitoA = '';
								$problematicaA = '';
								foreach ($cap as $key => $value) {
									if ($value['tipo'] == 1) {
										$problematicaA .= $value['descripcion'];
									}else{
										$ambitoA .= $value['descripcion'];
									}
								}

								$this->pinta_ruta($pdf, $ruta, $pdf->GetY()+5, $id_tprioritario,$cct['cct'], $problematicaA, $ambitoA, 'E');
					}



				}
				$path_eval = "pemcv1_masivos/".$cct['cct']."_".$cct['turno'].".pdf";
				$pdf->Output($path_eval,'F');
			}
			// echo "<pre>";print_r($cct);die();

			// $pdf->Output();
	}// get_reporte()


	public function pinta_ruta($pdf, $ruta, $y, $id_tprioritario,$cvecct,$problematicaA, $ambitoA,$tipo){
		// if(Utilerias::haySesionAbiertacct($this)){
				$orden = '';
				// "Orden: {$ruta['orden']}"
				$tema = ($ruta['tema']=='')? '':"Línea de acción: {$ruta['tema']}";
				$pdf->Ln(2);
				$pdf->SetFont('Arial','B',11);
				$pdf->SetWidths(array(50,200)); // ancho de primer columna, segunda, tercera
				$pdf->SetFillColor(255,255,255);
				$pdf->SetAligns(array("L","C"));
				$pdf->SetLineW(array(0,0));
				$pdf->SetTextColor(0,0);
					$pdf->Row2(array(
						utf8_decode($orden),
						utf8_decode($tema)
					));
				$obj1 = "Objetivo: {$ruta['objetivo']}";


				$pdf->Ln(5);
				$pdf->SetFont('Arial','B',9);
				$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
				$pdf->SetFillColor(255);
				$pdf->SetAligns(array("L"));
				// $pdf->SetColors(array(TRUE));
				$pdf->SetLineW(array(0.2));
				$pdf->SetTextColor(0,0,0);
					$pdf->Row1(array(
						utf8_decode($obj1)
					));

				$ambito = "Ámbito(s): {$ambitoA}";
				$pdf->Ln(2);
				$pdf->SetFont('Arial','B',9);
				$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
				$pdf->SetFillColor(255);
				$pdf->SetAligns(array("L"));
				// $pdf->SetColors(array(TRUE));
				$pdf->SetLineW(array(0.2));
				$pdf->SetTextColor(0,0,0);
					$pdf->Row1(array(
						utf8_decode($ambito)
					));

				$problematica = "Problemática(s): {$problematicaA}";
				$pdf->Ln(2);
				$pdf->SetFont('Arial','B',9);
				$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
				$pdf->SetFillColor(255);
				$pdf->SetAligns(array("L"));
				// $pdf->SetColors(array(TRUE));
				$pdf->SetLineW(array(0.2));
				$pdf->SetTextColor(0,0,0);
					$pdf->Row1(array(
						utf8_decode($problematica)
					));


				$evidencia = "Evidencia(s): {$ruta['otro_evidencia']}";
				$pdf->Ln(2);
				$pdf->SetFont('Arial','B',9);
				$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
				$pdf->SetFillColor(255);
				$pdf->SetAligns(array("L"));
				// $pdf->SetColors(array(TRUE));
				$pdf->SetLineW(array(0.2));
				$pdf->SetTextColor(0,0,0);
					$pdf->Row1(array(
						utf8_decode($evidencia)
					));

				$observaciondir = "Observaciones director: {$ruta['obs_direc']}";
				$observacionsup = "Observaciones supervisor: {$ruta['obs_supervisor']}";
				$pdf->Ln(2);
				$pdf->SetFont('Arial','B',9);
				$pdf->SetWidths(array(250)); // ancho de primer columna, segunda, tercera
				$pdf->SetFillColor(255);
				$pdf->SetAligns(array("L"));
				// $pdf->SetColors(array(TRUE));
				$pdf->SetLineW(array(0.2));
				$pdf->SetTextColor(0,0,0);
					$pdf->Row1(array(
						utf8_decode($observaciondir)
					));
					$pdf->Ln(2);
					$pdf->Row1(array(
						utf8_decode($observacionsup)
					));



				$pdf->Ln(6);
				/**/
				$pdf->SetFont('Arial','B',11);

				//Table with 4 columns
				$pdf->SetWidths(array(10,81,45,46,46,20,80)); // ancho de primer columna, segunda, tercera y cuarta

				$result = $this->Reportepdf_model->get_acciones($id_tprioritario, $tipo);


				// $cct = Utilerias::get_cct_sesion($this);

				$pdf->SetFillColor(255,255,255);
				// $pdf->SetDrawColor(0, 0, 0);
				$pdf->SetAligns(array("C","C","C","C","C","C","C"));
				// $pdf->SetColors(array(TRUE,TRUE,TRUE,TRUE,TRUE,TRUE,TRUE));
				$pdf->SetLineW(array(0.2,0.2,0.2,0.2,0.2,0.2,0.2));
				$pdf->SetTextColor(0,0,0);
				$pdf->Row(array(
					utf8_decode("No."),
					utf8_decode("Acciones"),
					utf8_decode("Fecha inicio"),
					utf8_decode("Fecha fin"),
					utf8_decode("Recursos"),
					utf8_decode("Avance (CTE Actual)"),
					utf8_decode("Responsable"),
				));


				$pdf->SetFont('Arial','',10);
				$pdf->SetAligns(array("L","L","L","L","L","L","L"));
				$pdf->SetColors(array(FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE));
				$pdf->SetLineW(array(0.09,0.09,0.09,0.09,0.09,0.09,0.09));
				$cont=0;
				$ids = "";
				$responsablesc = "";
				foreach($result as $item){

					$ids_responsables = $item["ids_responsables"];
					$auxpersonal = ($item["otro_responsable"].$ids_responsables=='')?"":strtoupper($item["otro_responsable"]).", ";
					$auxapoyopersonal = ($item["main_resp"]=='')?"":strtoupper($item["main_resp"]).", ";

					$responsablesc = $this->get_perosonal_mostrar($cvecct, $auxapoyopersonal);
					$cont++;
					$pdf->Row(array(
						$cont,
						utf8_decode($item["accion"]),
						utf8_decode($item["accion_f_inicio"]),
						utf8_decode($item["accion_f_termino"]),
						utf8_decode($item["mat_insumos"]),
						utf8_decode($item["avance"]),
						utf8_decode(substr($responsablesc, 0, -2))
					));
				}

				$pdf->Ln();

		// }else{
		// 	redirect('Rutademejora/index');
		// }
	}

	//función para mapear el RFC del personal y poder imprimirlo en el pdf del reporte
	public function get_perosonal_mostrar($cct, $ids_responsables){

		$ids_responsables = explode(",", $ids_responsables);

		$curl = curl_init();
		$method = "POST";
		$url = "http://servicios.seducoahuila.gob.mx/wservice/personal/w_service_personal_by_cct.php";
		$data = array("cct" => $cct);

	    switch ($method)
	    {
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);
	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            break;
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	    }

	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($curl);

	    curl_close($curl);
	    $response = json_decode($result);

			if ($response->status==0) {
				$personal = array();
			}
			else {
				$personal = $response->Personal;
			}

	    $listap = "";
	    foreach ($personal as $persona) {
		    for($i = 0; $i < count($ids_responsables); $i++){
		    	if($persona->rfc == $ids_responsables[$i]){
		    		$listap .= trim($persona->nombre_completo).", ";
		    	}
		    }
	    }

	    return $listap;
	}


}// class
