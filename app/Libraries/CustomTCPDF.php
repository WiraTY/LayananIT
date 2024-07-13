<?php

namespace App\Libraries;

use TCPDF;

class CustomTCPDF extends TCPDF {
    // Override the Header method
    public function Header() {
        // Logo
        $logoFilePath = K_PATH_IMAGES . PDF_HEADER_LOGO;
        $this->Image($logoFilePath, 15, 0, PDF_HEADER_LOGO_WIDTH);

        // Set font
        $this->SetFont('helvetica', 'B', 12);

        // Title
        $this->Cell(0, 1, PDF_HEADER_TITLE, 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        // Subtitle
        $this->SetFont('helvetica', '', 10);
        $this->MultiCell(0, 0, PDF_HEADER_STRING, 0, 'C', 0, 1, '', '', true, 0, false, true, 0, 'T', false);
        $this->Line(10, 25, $this->getPageWidth() - 10, 25);
    }
}
