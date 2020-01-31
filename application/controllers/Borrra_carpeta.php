<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 */
class Borrra_carpeta extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('Utilerias');

	}
	function borra(){
		$this->rmDir_rf("C:/wamp64/www/sarape/evidencias_rm/4237/8216/526");
	}

	function rmDir_rf($carpeta)
    {
    
      foreach(glob($carpeta . "/*") as $archivos_carpeta){
    
        if (is_dir($archivos_carpeta)){
          rmDir_rf($archivos_carpeta);
          echo 'eliminó carpeta';
        } else {
        unlink($archivos_carpeta);
        echo 'eliminó archivo';
        }
      }
      rmdir($carpeta);
     }

}
