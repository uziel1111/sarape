<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aprovechamiento_escolar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->data = array( );
        $this->load->library('Utilerias');
       
    }


    public function index()
    {
       $data['espacio'] ="<br><br><br><br><br><br>" ;
       $data['aprov_prim'] = $this->load->view('aprovechamiento_escolar/primaria_frame',$data, TRUE);
       $data['aprov_secu'] = $this->load->view('aprovechamiento_escolar/secundaria_frame',$data, TRUE);
        Utilerias::pagina_basica($this, "index/aprovechamiento_escolar", $data);
    }
}