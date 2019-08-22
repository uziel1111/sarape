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
// 	public function deleteDir($dirE) {
// 	    $dir = $dirE;
// $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
// $files = new RecursiveIteratorIterator($it,
//              RecursiveIteratorIterator::CHILD_FIRST);
// foreach($files as $file) {
//     if ($file->isDir()){
//         rmdir($file->getRealPath());
//     } else {
//         unlink($file->getRealPath());
//     }
// }
// rmdir($dir);
// 	}
	function rmDir_rf($carpeta)
    {
        // echo "<pre>";print_r($carpeta);die();
      foreach(glob($carpeta . "/*") as $archivos_carpeta){
                // echo "<pre>";print_r($archivos_carpeta);die();
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
