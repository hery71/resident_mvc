<?php
require_once __DIR__ . '/../../fpdf/fpdf.php';


class BirthdayRequisitionPDF extends FPDF
{
    private array $organisation;
    public function __construct(array $organisation, $orientation='P', $unit='mm', $size='Letter')
    {
        parent::__construct($orientation, $unit, $size);
        $this->organisation = $organisation;
    }
    function Header()
    {
        $logoPath = __DIR__ . '/../../public/logo.png'; // adapte si besoin

        if (file_exists($logoPath)) {
            $this->Image($logoPath, 10, 6, 30);
        }

        $this->SetFont('Arial', 'B', 15);
        $titre = $this->organisation['nom'] . ' - Requisition Anniversaire';
        $this->Cell(0, 10, f8($titre), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-30);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, f8("Nom et initiales de l'exécutant en cuisine : __________________________"), 0, 1, 'L');

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(0, 10, 'Printing date : ' . date('d/m/Y H:i'), 0, 0, 'R');
    }

    function TableRow($label, $value, $labelWidth = 50, $valueWidth = 20)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell($labelWidth, 6, f8($label), 1);

        $this->SetFont('Arial', '', 12);
        $this->Cell($valueWidth, 6, f8($value), 1, 0, 'C');

        $this->Ln();
    }
}
