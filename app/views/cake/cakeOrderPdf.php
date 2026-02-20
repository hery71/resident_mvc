<?php
require_once __DIR__ . '/../../../fpdf/fpdf.php';
define('IMAGE_PATH', ROOT_PATH . '/public/assets/images');
function enc($str) {
    return mb_convert_encoding($str ?? '', 'ISO-8859-1', 'UTF-8');
}

class PDF extends FPDF {
    private $logoPath;

    public function __construct($logoPath = null) {
        parent::__construct();
        $this->logoPath = $logoPath;
    }

    function Header() {
        if ($this->logoPath) {
            $this->Image($this->logoPath, 10, 6, 30);
        }
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, enc('COMMANDE DE GATEAU'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-30);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 10, enc("Nom et initiales du responsable : __________________________"), 0, 1, 'L');
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->Cell(0, 10, 'Printing date : ' . date('d/m/Y H:i'), 0, 0, 'R');
    }
}

$pdf = new PDF($logoPath);
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter');

$lineHeight = 6;
$checked = enc("☑");    // Case cochée
$unchecked = enc("☐");  // Case non cochée
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, $lineHeight, enc('Date :'), 0, 0,'L');
$pdf->Cell(70, $lineHeight, enc($row['dateLivraison'] ?? ''), 'B', 0, 'L');
$pdf->Cell(30, $lineHeight, enc('Heure :'), 0, 0,'L');
$pdf->Cell(70, $lineHeight, enc('11:00Am'), 'B', 1, 'L');
//*************************************************************************
$pdf->Cell(30, $lineHeight, enc('Grandeur :'), 0, 0,'L');
$pdf->Cell(70, $lineHeight, enc('10Po'), 'B', 0, 'L');
$pdf->Cell(30, $lineHeight, enc('Personnage :'), 0, 0,'L');
$pdf->Cell(70, $lineHeight, enc(''), 'B', 1, 'L');
$pdf->Ln(6);
$y = $pdf->GetY();  // base Y de la ligne
$startX = 30;       // point de départ horizontal de toute la ligne
// 1. Label principal "Saveur :"
$pdf->SetXY($startX, $y);
$pdf->Cell(30, $lineHeight, enc('Saveur :'), 0, 0, 'L');

// 2. Case + label "Blanc"
$checkedImg = ROOT_PATH . '/public/assets/images/checked.jpg';
$uncheckedImg = ROOT_PATH . '/public/assets/images/unchecked.jpg';
$pdf->SetXY($startX + 35, $y);
$pdf->Image($checkedImg, $startX + 35, $y, 5);
$pdf->SetXY($startX + 42, $y);
$pdf->Cell(20, $lineHeight, enc("Blanc"), 0, 0);

// 3. Case + label "Chocolat"
$pdf->SetXY($startX + 70, $y);
$pdf->Image($uncheckedImg, $startX + 70, $y, 5);
$pdf->SetXY($startX + 77, $y);
$pdf->Cell(25, $lineHeight, enc("Chocolat"), 0, 0);

// 4. Case + label "Marbré"
$pdf->SetXY($startX + 110, $y);
$pdf->Image($uncheckedImg, $startX + 110, $y, 5);
$pdf->SetXY($startX + 117, $y);
$pdf->Cell(25, $lineHeight, enc("Marbré"), 0, 1); // `0,1` pour aller à la ligne ensuite
$pdf->Ln(6);
//****************************************************************

$pdf->Cell(70, $lineHeight, enc('Couleur du Glacage(Icing)(Fond) :'), 0, 0,'L');
$pdf->Cell(80, $lineHeight, enc(($row['couleur'] ?? '') . '  Blanc'), 'B', 1, 'L');
//****************************************************************
$pdf->Cell(70, $lineHeight, enc('Couleur et décorations :'), 0, 0,'L');
$pdf->Cell(80, $lineHeight, enc('Ecriture     fleurs etc...'), 'B', 1, 'L');
//****************************************************************
$pdf->Cell(70, $lineHeight, enc('Message :'), 0, 0,'L');
$pdf->Cell(80, $lineHeight, enc($row['message'] ?? ''), 'B', 1, 'L');
//****************************************************************
$pdf->Ln(6);
$pdf->Cell(100, $lineHeight, enc('Objet spécial à ajouter:(ex, gradué, premiere communion, dessin etc 3$ ou 5$'), 0, 1, 'L');
//******************************************************
$pdf->Cell(15, $lineHeight, enc('Nom :'), 0, 0,'L');
$pdf->Cell(75, $lineHeight, enc($GLOBALS['organisation_name']), 'B', 0, 'L');
$pdf->Cell(30, $lineHeight, enc('Telephone :'), 0, 0,'L');
$pdf->Cell(60, $lineHeight, enc('506-775-2040'), 'B', 1, 'L');
//****************************************************************
$pdf->Cell(50, $lineHeight, enc('Signature: Hery :'), 0, 0,'L');
$pdf->Output("I", "CakeOrder.pdf");
