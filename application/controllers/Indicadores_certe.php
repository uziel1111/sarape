<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Indicadores_certe extends CI_Controller {
	
	  function __construct() {
        parent::__construct();
        $this->data = array( );
        $this->load->library('Utilerias');
       
    }


    public function index()
    {
       $data['espacio'] ="<br><br><br><br><br><br>" ;
        Utilerias::pagina_basica($this, "index/indicadoresCerte", $data);
    }
}