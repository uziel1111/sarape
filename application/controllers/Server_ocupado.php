<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server_ocupado extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('Utilerias');
    }

    public function index(){
        $data = array();
        Utilerias::pagina_basica($this, "ruta/supervisor/error_trabajando", $data);
    }
}