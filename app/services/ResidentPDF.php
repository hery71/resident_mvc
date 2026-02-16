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

    function TableRow($label, $value)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(60, 8, $label, 1);
        $this->SetFont('Arial', '', 12);
        $this->Cell(130, 8, $value, 1, 1);
    }
}
