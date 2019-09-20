<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Estadistica_pemc extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->data = array( );
        $this->load->library('Utilerias');
        $this->load->model('Estadistica_pemc_model');

    }

     function index()
    {   
      $data = $this->data;
      $data['error'] = '';
     $this->load->view( "Estadistica_pemc/login", $data);
  }

    public function login_action(){
        $user = $this->input->post('usuario');
        $pwd = $this->input->post('password');

        $user_data = $this->Estadistica_pemc_model->get_datos_sesion($user, md5($pwd));

        if(count($user_data) > 0){
            $data = 0;
            Utilerias::set_usuario_sesion($this, $user_data);
            if(Utilerias::haySesionAbierta($this)){
                 Utilerias::pagina_basica($this, 'Estadistica_pemc/index',$data); 
            }
        }else{
            $data = $this->data;
            $data['error'] = 'Usuario o contraseña incorrecta';
            $data['login_failed'] = TRUE;
            $this->load->view('Estadistica_pemc/login',$data); 
        }
    }


}