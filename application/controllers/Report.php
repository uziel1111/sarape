<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('ExcelPHP');
		$this->load->model('Escuela_model');
		$this->load->model('Estadistica_e_indicadores_xcct_model');
		$this->load->model('Municipio_model');
		$this->load->model('Nivel_model');
		$this->load->model('Sostenimiento_model');
		$this->load->model('Modalidad_model');
		$this->load->model('Ciclo_model');
		$this->load->model('Planeaxmuni_model');
		$this->load->model('Inegixmuni_model');
		$this->load->model('Supervision_model');
		$this->load->model('Subsostenimiento_model');
		$this->load->model('Indicadoresxmuni_model');
		$this->load->model('Indicadoresxestado_model');

		$this->style_encabezado = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			),
			'fill' => array(
				'type'  => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array(
					'rgb' => 'F4FCFC')
				),
				'font' => array(
					'name'  => 'Arial',
					'bold'  => true,
					'color' => array(
						'rgb' => '000000'
					)
				)
			);
			$this->style_contenido = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type'  => PHPExcel_Style_Fill::FILL_SOLID
				),
				'font' => array(
					'name'  => 'Arial',
					// 'bold'  => true,
					'color' => array(
						'rgb' => '000000'
					)
				),
				'alignment' =>  array(
					'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
					// 'wrap'      => TRUE
				)
			);

			$this->style_titulo = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				),
				'fill' => array(
					'type'  => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array(
						'rgb' => 'DFF5F5')
					),
					'font' => array(
						'name'  => 'Arial',
						'bold'  => true,
						'color' => array(
							'rgb' => '000000'
						)
					),
					'alignment' =>  array(
						'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
						// 'wrap'      => TRUE
					)
				);

			}

			public function por_escuela(){
				$cve_municipio = $this->input->post('slc_busquedalista_municipio_reporte');
				$cve_nivel = $this->input->post('slc_busquedalista_nivel_reporte');
				$cve_sostenimiento = $this->input->post('slc_busquedalista_sostenimiento_reporte');
				$nombre_escuela = $this->input->post('itxt_busquedalista_nombreescuela_reporte');

				$result_escuelas = $this->Escuela_model->get_xparams($cve_municipio,$cve_nivel,$cve_sostenimiento,$nombre_escuela);
				// echo "<pre>"; print_r($result_escuelas); die();

				$obj_excel = new PHPExcel();
				$obj_excel->getActiveSheet()->SetCellValue('A1', 'Lista de escuelas');
				$obj_excel->getActiveSheet()->SetCellValue('A2', 'CCT');
				$obj_excel->getActiveSheet()->SetCellValue('B2', 'Turno');
				$obj_excel->getActiveSheet()->SetCellValue('C2', 'Nombre');
				$obj_excel->getActiveSheet()->SetCellValue('D2', 'Nivel');
				$obj_excel->getActiveSheet()->SetCellValue('E2', 'Municipio');
				$obj_excel->getActiveSheet()->SetCellValue('F2', 'Localidad');
				$obj_excel->getActiveSheet()->SetCellValue('G2', 'Domicilio');

				$obj_excel->getActiveSheet()->mergeCells('A1:G1');
				$obj_excel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($this->style_titulo);
				$obj_excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getStyle('A2:G2')->applyFromArray($this->style_encabezado);

				$aux = 3;
				foreach ($result_escuelas as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['cve_centro']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, utf8_encode($row['turno_single']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, utf8_encode($row['nombre_centro']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, utf8_encode($row['municipio']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, utf8_encode($row['localidad']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, utf8_encode($row['domicilio']) );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':G'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}
				date_default_timezone_set('America/Mexico_City');
				$hoy = date("Y-m-d");
				$name_file = "Reporte_escuelas_".$hoy.'.xlsx';
				$this->downloand_file($obj_excel,$name_file);
			}// por_escuela()

			private function downloand_file($obj_excel,$nombre){
				// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
				header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
				header("Content-Disposition: attachment;filename={$nombre}");
				header("Cache-Control: max-age=0");
				$obj_writer = PHPExcel_IOFactory::createWriter($obj_excel, "Excel2007");
				ob_end_clean();
				$obj_writer->save("php://output");
			}// downloand_file()

			public function est_generales_xmuni(){
				$id_municipio = $this->input->post('id_municipio');
				$id_nivel = $this->input->post('id_nivel');
				$id_sostenimiento = $this->input->post('id_sostenimiento');
				$id_modalidad = $this->input->post('id_modalidad');
				$id_ciclo = $this->input->post('id_ciclo');

				$result_alumnos = $this->Estadistica_e_indicadores_xcct_model->get_nalumnos_xmunciclo($id_municipio, $id_ciclo);
				$result_docentes = $this->Estadistica_e_indicadores_xcct_model->get_pdocente_xmunciclo($id_municipio, $id_ciclo);
				$result_infraest = $this->Estadistica_e_indicadores_xcct_model->get_infraest_xmunciclo($id_municipio, $id_ciclo);
				$result_planea = array();
				 $result_planea_prim = $this->Planeaxmuni_model->get_planea_xmunciclo($id_municipio, 2018, 4);
				 $result_planea_sec = $this->Planeaxmuni_model->get_planea_xmunciclo($id_municipio, 2019, 5);
				 $result_planea_msuperior = $this->Planeaxmuni_model->get_planea_xmunciclo($id_municipio, 2017, 6);
				 array_push($result_planea, $result_planea_prim[0]);
				 array_push($result_planea, $result_planea_sec[0]);
				 array_push($result_planea, $result_planea_msuperior[0]);

				 if ($id_municipio==0) {
					 $result_asistencia_nv = $this->Indicadoresxestado_model->get_ind_asistenciaxestadoidciclo(1);
  				 $result_permanencia_nv = $this->Indicadoresxestado_model->get_ind_permanenciaxestadoidciclo(1);
				 }
				 else {
					 $result_asistencia_nv = $this->Indicadoresxmuni_model->get_ind_asistenciaxmuniidciclo($id_municipio, 1);
  				 $result_permanencia_nv = $this->Indicadoresxmuni_model->get_ind_permanenciaxmuniidciclo($id_municipio, 1);
				 }


				$result_rezinegi = $this->Inegixmuni_model->get_rezago_xmunciclo($id_municipio, '2015');
				$result_analfinegi = $this->Inegixmuni_model->get_analf_xmunciclo($id_municipio, '2015');
				// echo "<pre>";print_r($result_analfinegi); die();
				$obj_excel = new PHPExcel();
				$obj_excel->getActiveSheet()->SetCellValue('A1', 'Estadística e indicadores educativos generales');
				$obj_excel->getActiveSheet()->SetCellValue('A2', 'Municipio: '.$this->Municipio_model->get_muncipio($id_municipio).', Nivel: '.$this->Nivel_model->get_nivel($id_nivel).', Sostenimiento: '.$this->Sostenimiento_model->get_sostenimiento($id_sostenimiento).', Modalidad: '.$this->Modalidad_model->get_modalidad($id_modalidad).', Ciclo escolar: '.$this->Ciclo_model->get_ciclo($id_ciclo).'');
				$obj_excel->getActiveSheet()->SetCellValue('A3', 'Alumnos');
				$obj_excel->getActiveSheet()->SetCellValue('A4', 'Nivel educativo');
				$obj_excel->getActiveSheet()->SetCellValue('B4', 'Sostenimiento');
				$obj_excel->getActiveSheet()->SetCellValue('C4', 'Modalidad');
				$obj_excel->getActiveSheet()->SetCellValue('D4', 'Total');
				$obj_excel->getActiveSheet()->SetCellValue('D5', 'M');
				$obj_excel->getActiveSheet()->SetCellValue('E5', 'H');
				$obj_excel->getActiveSheet()->SetCellValue('F5', 'T');
				$obj_excel->getActiveSheet()->SetCellValue('G4', '1°');
				$obj_excel->getActiveSheet()->SetCellValue('H4', '2°');
				$obj_excel->getActiveSheet()->SetCellValue('I4', '3°');
				$obj_excel->getActiveSheet()->SetCellValue('J4', '4°');
				$obj_excel->getActiveSheet()->SetCellValue('K4', '5°');
				$obj_excel->getActiveSheet()->SetCellValue('L4', '6°');

				$obj_excel->getActiveSheet()->mergeCells('A1:L1');
				$obj_excel->getActiveSheet()->mergeCells('A2:L2');
				$obj_excel->getActiveSheet()->mergeCells('A3:L3');
				$obj_excel->getActiveSheet()->mergeCells('A4:A5');
				$obj_excel->getActiveSheet()->mergeCells('B4:B5');
				$obj_excel->getActiveSheet()->mergeCells('C4:C5');
				$obj_excel->getActiveSheet()->mergeCells('D4:F4');
				$obj_excel->getActiveSheet()->mergeCells('G4:G5');
				$obj_excel->getActiveSheet()->mergeCells('H4:H5');
				$obj_excel->getActiveSheet()->mergeCells('I4:I5');
				$obj_excel->getActiveSheet()->mergeCells('J4:J5');
				$obj_excel->getActiveSheet()->mergeCells('K4:K5');
				$obj_excel->getActiveSheet()->mergeCells('L4:L5');
				$obj_excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($this->style_titulo);
				$obj_excel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($this->style_titulo);
				$obj_excel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($this->style_titulo);

				$obj_excel->getActiveSheet()->getStyle('A4:L5')->applyFromArray($this->style_encabezado);

				$aux = 6;
				foreach ($result_alumnos as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, utf8_encode($row['sostenimiento']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, utf8_encode($row['modalidad']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['alumn_m_t']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['alumn_h_t']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['alumn_t_t']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['alumn_t_1']) );
					$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, number_format($row['alumn_t_2']) );
					$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, number_format($row['alumn_t_3']) );
					$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, number_format($row['alumn_t_4']) );
					$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, number_format($row['alumn_t_5']) );
					$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, number_format($row['alumn_t_6']) );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Personal docente');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':L'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Nivel educativo');
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Sostenimiento');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, 'Modalidad');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':A'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('B'.$aux.':B'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('C'.$aux.':C'.($aux+1));
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'Docentes');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, 'Directivo con grupo');
				$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, 'Directivo sin grupo');
				$obj_excel->getActiveSheet()->mergeCells('D'.$aux.':F'.$aux);
				$obj_excel->getActiveSheet()->mergeCells('G'.$aux.':I'.$aux);
				$obj_excel->getActiveSheet()->mergeCells('J'.$aux.':L'.$aux);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, 'Total');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, 'Total');
				$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, 'Total');
				$obj_excel->getActiveSheet()->getStyle('A'.($aux-1).':L'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				foreach ($result_docentes as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, utf8_encode($row['sostenimiento']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, utf8_encode($row['modalidad']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['docente_m']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['docente_h']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['docentes_t_g']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['directivo_m_congrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, number_format($row['directivo_h_congrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, number_format($row['directivo_t_congrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, number_format($row['directivo_m_singrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, number_format($row['directivo_h_singrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, number_format($row['directivo_t_singrup']) );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}
				$aux++;

				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Infraestructura');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':L'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Nivel educativo');
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Sostenimiento');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, 'Modalidad');
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'Escuelas');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':A'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('B'.$aux.':B'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('C'.$aux.':C'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('D'.$aux.':D'.($aux+1));
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, 'Grupos');
				$obj_excel->getActiveSheet()->mergeCells('E'.$aux.':L'.$aux);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, '1°');
				$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, '2°');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, '3°');
				$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, '4°');
				$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, '5°');
				$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, '6°');
				$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, 'Multigrado');
				$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, 'Total');
				$obj_excel->getActiveSheet()->getStyle('A'.($aux-1).':L'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				foreach ($result_infraest as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, utf8_encode($row['sostenimiento']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, utf8_encode($row['modalidad']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['nescuelas']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['grupos_1']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['grupos_2']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['grupos_3']) );
					$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, number_format($row['grupos_4']) );
					$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, number_format($row['grupos_5']) );
					$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, number_format($row['grupos_6']) );
					$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, number_format($row['grupos_multi']) );
					$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, number_format($row['grupos_t']) );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}

				$obj_excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Indicadores de Asistencia');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':C'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':C'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'ciclo escolar 2017-2018');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':C'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':C'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux.'', 'Nivel');
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux.'', 'Cobertura');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux.'', 'Absorción');
				$obj_excel->getActiveSheet()->getStyle('A'.($aux-1).':C'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				foreach ($result_asistencia_nv as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, ($row['cobertura']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, ($row['absorcion']).'%' );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':C'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}

				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Indicadores de Permanencia');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':D'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':D'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'ciclo escolar 2016-2017');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':D'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':D'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux.'', 'Nivel');
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux.'', 'Retención');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux.'', 'Aprobación');
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux.'', 'Eficiencia Terminal');
				$obj_excel->getActiveSheet()->getStyle('A'.($aux-1).':D'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				foreach ($result_permanencia_nv as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, ($row['retencion']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, ($row['aprobacion']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, ($row['et']).'%' );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':D'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}

				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Indicadores de aprendizaje');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':K'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':K'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Resultados de prueba PLANEA 2016');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':K'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':K'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Nivel educativo');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':A'.($aux+2));
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Lenguaje y Comunicación');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, 'Matemáticas');
				$obj_excel->getActiveSheet()->mergeCells('B'.$aux.':F'.$aux);
				$obj_excel->getActiveSheet()->mergeCells('G'.$aux.':K'.$aux);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Nivel de dominio');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, 'Nivel de dominio');
				$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, 'Porcentaje de alumnos con nivel bueno y excelente');
				$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, 'Porcentaje de alumnos con nivel bueno y excelente');
				$obj_excel->getActiveSheet()->mergeCells('B'.$aux.':E'.$aux);
				$obj_excel->getActiveSheet()->mergeCells('G'.$aux.':J'.$aux);
				$obj_excel->getActiveSheet()->mergeCells('F'.$aux.':F'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('K'.$aux.':K'.($aux+1));
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'I Insuficiente');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, 'II Elemental');
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'III Bueno');
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, 'IV Excelente');

				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, 'I Insuficiente');
				$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, 'II Elemental');
				$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, 'III Bueno');
				$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, 'IV Excelente');

				$obj_excel->getActiveSheet()->getStyle('A'.($aux-2).':K'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				foreach ($result_planea as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, ($row['lyc_i']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, ($row['lyc_ii']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, ($row['lyc_iii']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, ($row['lyc_iv']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, ($row['lyc_iii']+$row['lyc_iv']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, ($row['mat_i']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, ($row['mat_ii']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, ($row['mat_iii']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, ($row['mat_iv']).'%' );
					$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, ($row['mat_iii']+$row['mat_iv']).'%' );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':K'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}
				$aux++;

		/*		$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Rezago educativo');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':G'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':G'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Población por grupo de edad que no asiste a la escuela');
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Población total');
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, 'Población que no asiste a la escuela');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':A'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('B'.$aux.':D'.($aux));
				$obj_excel->getActiveSheet()->mergeCells('E'.$aux.':G'.($aux));
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'Total');
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, 'Total');
				$obj_excel->getActiveSheet()->getStyle('A'.($aux-1).':G'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				$temp=$aux;
				foreach ($result_rezinegi as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, ('3 a 5 años') );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, number_format($row['P_3A5_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, number_format($row['P_3A5_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['P_3A5_F']+$row['P_3A5_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['P3A5_NOA_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['P3A5_NOA_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['P3A5_NOA_M']+$row['P3A5_NOA_F']) );
					$aux++;
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, ('6 a 11 años') );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, number_format($row['P_6A11_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, number_format($row['P_6A11_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['P_6A11_F']+$row['P_6A11_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['P6A11_NOAM']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['P6A11_NOAF']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['P6A11_NOAM']+$row['P6A11_NOAF']) );
					$aux++;
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, ('12 a 14 años') );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, number_format($row['P_12A14_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, number_format($row['P_12A14_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['P_12A14_F']+$row['P_12A14_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['P12A14NOAM']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['P12A14NOAF']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['P12A14NOAM']+$row['P12A14NOAF']) );
					$aux++;
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, ('15 a 17 años') );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, number_format($row['P_15A17_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, number_format($row['P_15A17_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['P_15A17_F']+$row['P_15A17_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['P15A17A_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['P15A17A_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['P15A17A_M']+$row['P15A17A_F']) );
					$aux++;
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, ('18 a 22 años') );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, number_format($row['P_18A24_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, number_format($row['P_18A24_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['P_18A24_M']+$row['P_18A24_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['P18A24A_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['P18A24A_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['P18A24A_M']+$row['P18A24A_F']) );
					$obj_excel->getActiveSheet()->getStyle('A'.$temp.':G'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}
				$aux++; */
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Analfabetismo');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':D'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':D'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'Total');
				$obj_excel->getActiveSheet()->getStyle('A'.($aux-1).':D'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				$temp=$aux;

				foreach ($result_analfinegi as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, ('Población de 8 a 14 años que no saben leer ni escribir') );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, number_format($row['P8A14AN_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, number_format($row['P8A14AN_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['P8A14AN_M']+$row['P8A14AN_F']) );
					$aux++;
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, ('Población mayor de 15 años que no saben leer ni escribir') );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, number_format($row['P15YM_AN_M']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, number_format($row['P15YM_AN_F']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['P15YM_AN_M']+$row['P15YM_AN_F']) );

					$obj_excel->getActiveSheet()->getStyle('A'.$temp.':D'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}
				date_default_timezone_set('America/Mexico_City');
				$hoy = date("Y-m-d");
				$name_file = "Estadistica_e_indicadores_generales_".$hoy.'.xlsx';
				$this->downloand_file($obj_excel,$name_file);
			}// est_generales_xmuni()

			public function est_generales_xzona(){
				$id_nivel_z = $this->input->post('id_nivel_z');
				$id_sostenimiento_z = $this->input->post('id_sostenimiento_z');
				$id_zona_z = $this->input->post('id_zona_z');
				$id_ciclo_z = $this->input->post('id_ciclo_z');

				$result_alumnos = $this->Estadistica_e_indicadores_xcct_model->get_nalumnos_xzona($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z);
				$result_docentes = $this->Estadistica_e_indicadores_xcct_model->get_pdocente_xzona($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z);
				$result_infraest = $this->Estadistica_e_indicadores_xcct_model->get_infraest_xzona($id_nivel_z,$id_sostenimiento_z,$id_zona_z,$id_ciclo_z);

				$obj_excel = new PHPExcel();
				$obj_excel->getActiveSheet()->SetCellValue('A1', 'Estadística e indicadores educativos generales');
				$obj_excel->getActiveSheet()->SetCellValue('A2', 'Nivel: '.$this->Nivel_model->get_nivel($id_nivel_z).', Sostenimiento: '.$this->Subsostenimiento_model->get_subsostenimiento($id_sostenimiento_z).', Zona escolar: '.$this->Supervision_model->get_zona($id_nivel_z, $id_sostenimiento_z,$id_zona_z).', Ciclo escolar: '.$this->Ciclo_model->get_ciclo($id_ciclo_z).'');
				$obj_excel->getActiveSheet()->SetCellValue('A3', 'Alumnos');
				$obj_excel->getActiveSheet()->SetCellValue('A4', 'Nivel educativo');
				$obj_excel->getActiveSheet()->SetCellValue('B4', 'Sostenimiento');
				$obj_excel->getActiveSheet()->SetCellValue('C4', 'Modalidad');
				$obj_excel->getActiveSheet()->SetCellValue('D4', 'Total');
				$obj_excel->getActiveSheet()->SetCellValue('D5', 'M');
				$obj_excel->getActiveSheet()->SetCellValue('E5', 'H');
				$obj_excel->getActiveSheet()->SetCellValue('F5', 'T');
				$obj_excel->getActiveSheet()->SetCellValue('G4', '1°');
				$obj_excel->getActiveSheet()->SetCellValue('H4', '2°');
				$obj_excel->getActiveSheet()->SetCellValue('I4', '3°');
				$obj_excel->getActiveSheet()->SetCellValue('J4', '4°');
				$obj_excel->getActiveSheet()->SetCellValue('K4', '5°');
				$obj_excel->getActiveSheet()->SetCellValue('L4', '6°');

				$obj_excel->getActiveSheet()->mergeCells('A1:L1');
				$obj_excel->getActiveSheet()->mergeCells('A2:L2');
				$obj_excel->getActiveSheet()->mergeCells('A3:L3');
				$obj_excel->getActiveSheet()->mergeCells('A4:A5');
				$obj_excel->getActiveSheet()->mergeCells('B4:B5');
				$obj_excel->getActiveSheet()->mergeCells('C4:C5');
				$obj_excel->getActiveSheet()->mergeCells('D4:F4');
				$obj_excel->getActiveSheet()->mergeCells('G4:G5');
				$obj_excel->getActiveSheet()->mergeCells('H4:H5');
				$obj_excel->getActiveSheet()->mergeCells('I4:I5');
				$obj_excel->getActiveSheet()->mergeCells('J4:J5');
				$obj_excel->getActiveSheet()->mergeCells('K4:K5');
				$obj_excel->getActiveSheet()->mergeCells('L4:L5');
				$obj_excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($this->style_titulo);
				$obj_excel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($this->style_titulo);
				$obj_excel->getActiveSheet()->getStyle('A3:L3')->applyFromArray($this->style_titulo);

				$obj_excel->getActiveSheet()->getStyle('A4:L5')->applyFromArray($this->style_encabezado);

				$aux = 6;
				foreach ($result_alumnos as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, utf8_encode($row['subsostenimiento']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, utf8_encode($row['modalidad']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['alumn_m_t']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['alumn_h_t']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['alumn_t_t']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['alumn_t_1']) );
					$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, number_format($row['alumn_t_2']) );
					$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, number_format($row['alumn_t_3']) );
					$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, number_format($row['alumn_t_4']) );
					$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, number_format($row['alumn_t_5']) );
					$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, number_format($row['alumn_t_6']) );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Personal docente');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':L'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Nivel educativo');
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Sostenimiento');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, 'Modalidad');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':A'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('B'.$aux.':B'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('C'.$aux.':C'.($aux+1));
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'Docentes');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, 'Directivo con grupo');
				$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, 'Directivo sin grupo');
				$obj_excel->getActiveSheet()->mergeCells('D'.$aux.':F'.$aux);
				$obj_excel->getActiveSheet()->mergeCells('G'.$aux.':I'.$aux);
				$obj_excel->getActiveSheet()->mergeCells('J'.$aux.':L'.$aux);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, 'Total');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, 'Total');
				$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, 'Mujeres');
				$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, 'Hombres');
				$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, 'Total');
				$obj_excel->getActiveSheet()->getStyle('A'.($aux-1).':L'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				foreach ($result_docentes as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, utf8_encode($row['subsostenimiento']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, utf8_encode($row['modalidad']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['docente_m']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['docente_h']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['docentes_t_g']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['directivo_m_congrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, number_format($row['directivo_h_congrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, number_format($row['directivo_t_congrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, number_format($row['directivo_m_singrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, number_format($row['directivo_h_singrup']) );
					$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, number_format($row['directivo_t_singrup']) );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}
				$aux++;

				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Infraestructura');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':L'.$aux);
				$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_titulo);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, 'Nivel educativo');
				$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, 'Sostenimiento');
				$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, 'Modalidad');
				$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, 'Escuelas');
				$obj_excel->getActiveSheet()->mergeCells('A'.$aux.':A'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('B'.$aux.':B'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('C'.$aux.':C'.($aux+1));
				$obj_excel->getActiveSheet()->mergeCells('D'.$aux.':D'.($aux+1));
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, 'Grupos');
				$obj_excel->getActiveSheet()->mergeCells('E'.$aux.':L'.$aux);
				$aux++;
				$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, '1°');
				$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, '2°');
				$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, '3°');
				$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, '4°');
				$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, '5°');
				$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, '6°');
				$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, 'Multigrado');
				$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, 'Total');
				$obj_excel->getActiveSheet()->getStyle('A'.($aux-1).':L'.$aux)->applyFromArray($this->style_encabezado);
				$aux++;
				foreach ($result_infraest as $row) {
					$obj_excel->getActiveSheet()->SetCellValue('A'.$aux, utf8_encode($row['nivel']) );
					$obj_excel->getActiveSheet()->SetCellValue('B'.$aux, utf8_encode($row['subsostenimiento']) );
					$obj_excel->getActiveSheet()->SetCellValue('C'.$aux, utf8_encode($row['modalidad']) );
					$obj_excel->getActiveSheet()->SetCellValue('D'.$aux, number_format($row['nescuelas']) );
					$obj_excel->getActiveSheet()->SetCellValue('E'.$aux, number_format($row['grupos_1']) );
					$obj_excel->getActiveSheet()->SetCellValue('F'.$aux, number_format($row['grupos_2']) );
					$obj_excel->getActiveSheet()->SetCellValue('G'.$aux, number_format($row['grupos_3']) );
					$obj_excel->getActiveSheet()->SetCellValue('H'.$aux, number_format($row['grupos_4']) );
					$obj_excel->getActiveSheet()->SetCellValue('I'.$aux, number_format($row['grupos_5']) );
					$obj_excel->getActiveSheet()->SetCellValue('J'.$aux, number_format($row['grupos_6']) );
					$obj_excel->getActiveSheet()->SetCellValue('K'.$aux, number_format($row['grupos_multi']) );
					$obj_excel->getActiveSheet()->SetCellValue('L'.$aux, number_format($row['grupos_t']) );
					$obj_excel->getActiveSheet()->getStyle('A'.$aux.':L'.$aux)->applyFromArray($this->style_contenido);
					$aux++;
				}

				$obj_excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
				$obj_excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);

				date_default_timezone_set('America/Mexico_City');
				$hoy = date("Y-m-d");
				$name_file = "Estadistica_por_zona_escolar_".$hoy.'.xlsx';
				$this->downloand_file($obj_excel,$name_file);
			}// est_generales_xzona()

		}// Report
