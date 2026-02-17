<?php
require_once __DIR__ . '/../../fpdf/fpdf.php';
class ResidentPDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'FICHE DIETETIQUE & ALIMENTAIRE DU RESIDENT', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function TableRow4($label1, $value1, $label2, $value2)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(35, 8, $label1, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 8, $value1, 0);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(35, 8, $label2, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 8, $value2, 0, 1);
    }
}
