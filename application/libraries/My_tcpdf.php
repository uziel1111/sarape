<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class My_tcpdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    public function Header() {

    }
    public function Footer() {
            $this->SetY(-15);
            $this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
            $this->Cell(0, 10, '', 0, false, 'C');

    }
    public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
            $this->SetXY($x+20, $y); // 20 = margin left
            $this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
            $this->Cell($width, $height, $textval, 0, false, $align);
    }
}

class My_tcpdf_page extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    public function Header() {

    }
    public function Footer() {
            $this->SetY(-15);
            $this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
            $this->Cell(0, 10,"Página: ".$this->getAliasNumPage(), 0, false, 'R');
    }
    public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
            $this->SetXY($x+20, $y); // 20 = margin left
            $this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
            $this->Cell($width, $height, $textval, 0, false, $align);
    }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
