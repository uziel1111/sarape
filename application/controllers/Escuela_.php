<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Escuela extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->load->library('Utilerias');
			$this->load->helper('form');
		}

		function get_info()
		{
			$id_cct = $this->input->post('id_cct');
			echo $id_cct; die();
		}


}
