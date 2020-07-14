<?php
// error_reporting(0);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('FPDF_FONTPATH','font/');
require_once('fpdf181/fpdf.php');

class PDF_MC_Table extends FPDF{
  function __construct() {
    // require_once('fpdf181/fpdf.php');
    // parent::FPDF();
    parent::__construct();
  }

  var $widths;
  var $aligns;
  var $color;
  var $widht;
  var $cct;
  var $escuela;
  var $ciclo;
//inicializacion de variables de encabezado
  function SetvarHeader($cct, $escuela, $ciclo)
  {
    $this->cct=$cct;
    $this->escuela=$escuela;
    $this->ciclo=$ciclo;
  }
  // SetColors
  function SetColors($color)
  {
    $this->color=$color;
  }

  function SetLineW($widht)
  {
    $this->widht=$widht;
  }


  // ***************** /
  function SetWidths($w)
  {
    //Set the array of column widths
    $this->widths=$w;
  }

  function SetAligns($a)
  {
    //Set the array of column alignments
    $this->aligns=$a;
  }
    function Rowtab($data)
  {
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    // $this->CheckPageBreak($h);
    if($this->GetY()+$h>$this->PageBreakTrigger){
      $this->AddPage($this->CurOrientation, 'Legal');
      $this->SetFont('Arial','B',11);
      $this->SetFillColor(255,255,255);

      $this->SetAligns(array("C","C","C","C","C","C","C","C"));
      // $pdf->SetColors(array(TRUE,TRUE,TRUE,TRUE,TRUE,TRUE,TRUE));
      $this->SetLineW(array(0.2,0.2,0.2,0.2,0.2,0.2,0.2,0.2));
      $this->SetTextColor(0,0,0);
      $this->Row(array(
        utf8_decode("No."),
        utf8_decode("Acción"),
        utf8_decode("Ámbito"),
        utf8_decode("Fecha inicio"),
        utf8_decode("Fecha fin"),
        utf8_decode("Recursos"),
        utf8_decode("Avance"),
        utf8_decode("Responsables"),
      ));
      $this->SetFont('Arial','',10);
      $this->SetAligns(array("L","L","L","L","L","L","L","L"));
      $this->SetColors(array(FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE, FALSE));
      $this->SetLineW(array(0.09,0.09,0.09,0.09,0.09,0.09,0.09,0.09));
    }

    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
      $w=$this->widths[$i];
      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
      $color=isset($this->color[$i]) ? $this->color[$i] : FALSE;
      $widht=isset($this->widht[$i]) ? $this->widht[$i] : 0.2;
      // echo $widht; die();
      //Save the current position
      $x=$this->GetX();
      $y=$this->GetY();
      //Draw the border
      $this->SetLineWidth($widht);
      $this->Rect($x,$y,$w,$h);
      //Print the text
      $this->MultiCell($w,5,$data[$i],0,$a,$color);
      //Put the position to the right of the cell
      $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function Row($data)
  {
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
      $w=$this->widths[$i];
      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
      $color=isset($this->color[$i]) ? $this->color[$i] : FALSE;
      $widht=isset($this->widht[$i]) ? $this->widht[$i] : 0.2;
      // echo $widht; die();
      //Save the current position
      $x=$this->GetX();
      $y=$this->GetY();
      //Draw the border
      $this->SetLineWidth($widht);
      $this->Rect($x,$y,$w,$h);
      //Print the text
      $this->MultiCell($w,5,$data[$i],0,$a,$color);
      //Put the position to the right of the cell
      $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
  }
  function Row1($data)
  {
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
      $w=$this->widths[$i];
      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
      $color=isset($this->color[$i]) ? $this->color[$i] : FALSE;
      $widht=isset($this->widht[$i]) ? $this->widht[$i] : 0.2;
      // echo $widht; die();
      //Save the current position
      $x=$this->GetX();
      $y=$this->GetY();
      //Draw the border
      // $this->SetLineWidth($widht);
      // $this->Rect($x,$y,$w,$h);
      //Print the text
      $this->MultiCell($w,5,$data[$i],0,$a,$color);
      //Put the position to the right of the cell
      $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function Row2($data)
  {
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
    $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=1*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
      $w=$this->widths[$i];
      $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
      $color=isset($this->color[$i]) ? FALSE : FALSE;
      $widht=isset($this->widht[$i]) ? $this->widht[$i] : 0.2;
      // echo $widht; die();
      //Save the current position
      $x=$this->GetX();
      $y=$this->GetY();
      //Draw the border
      $this->SetLineWidth(0.0);
      // $this->Rect($x,$y,$w,$h);
      //Print the text
      $this->MultiCell($w,5,$data[$i],0,$a,$color);
      //Put the position to the right of the cell
      $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function CheckPageBreak($h)
  {
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
    $this->AddPage($this->CurOrientation, 'Legal');
  }

  function NbLines($w,$txt)
  {
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
    $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
    $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
      $c=$s[$i];
      if($c=="\n")
      {
        $i++;
        $sep=-1;
        $j=$i;
        $l=0;
        $nl++;
        continue;
      }
      if($c==' ')
      $sep=$i;
      $l+=$cw[$c];
      if($l>$wmax)
      {
        if($sep==-1)
        {
          if($i==$j)
          $i++;
        }
        else
        $i=$sep+1;
        $sep=-1;
        $j=$i;
        $l=0;
        $nl++;
      }
      else
      $i++;
    }
    return $nl;
  }

  function Footer()
  {
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    $this->SetTextColor(0,0,0);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
  }// Footer()

  function Header(){
    // Arial bold 16
      $this->SetFont('Arial','B',16);
      // Logo
      $this->Image('assets/img/logoreporte.png',10,8,70);

      $this->Ln(1);
      $this->SetFont('Arial','B',11);
      $this->MultiCell(0,5,utf8_decode($this->cct),0,"R");
      $this->Ln(2);
      $this->SetFont('Arial','B',11);
      $this->MultiCell(0,5,utf8_decode($this->escuela),0,"R");
      $this->Ln(3);
      $this->SetFont('Arial','B',11);
      $this->MultiCell(0,5,utf8_decode($this->ciclo),0,"R");

      // Título
      $this->SetTextColor(0,0,0);
      $this->SetFont('Arial','B',16);
      $this->Cell(120);
      $this->Cell(40,10,utf8_decode('Programa Escolar de Mejora Continua (PEMC)'),0,1,'C');
}

}



?>
