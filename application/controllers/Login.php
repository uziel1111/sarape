<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

		function __construct() {
			parent::__construct();
			$this->data = array( );
			$this->logged_in = FALSE;
			$this->load->library('Utilerias');
			$this->load->model('Usuario_model');
		}

		public function index(){
			$data = $this->data;
		    $data['error'] = ''; 
		    $this->load->view('login/index',$data); 
		}// index()

		public function login_action(){
			$user = $this->input->post('usuario');
	        $pwd = $this->input->post('password');

	        $user_data = $this->Usuario_model->get_datos_sesion($user, md5($pwd));

	        if(count($user_data) > 0){
	            Utilerias::set_usuario_sesion($this, $user_data);
	            if(Utilerias::haySesionAbierta($this)){
	            	redirect('panel/index');
	            }
	        }else{
	            $data = $this->data;
	            $data['login_failed'] = TRUE;
	            $this->load->view('login/index',$data); 
	        }
		}

		public function cerrar_sesion(){
			Utilerias::destroy_all_session($this);
	        redirect('login/index');
	    }
}// Login
