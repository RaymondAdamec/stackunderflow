<?php

namespace App\Service;

use Knp\Snappy\Pdf;
use Twig\Environment;

class PdfExportService
{
    private $pdf;
    private $twig;

    public function __construct(Pdf $pdf, Environment $twig)
    {
        $this->pdf = $pdf;
        $this->twig = $twig;
    }

    public function exportToPdf($data)
    {
        // Hier kannst du die Daten an dein Twig-Template übergeben
        $html = $this->twig->render('your_template.html.twig', ['data' => $data]);

        // PDF generieren
        $pdfFile = '/path/to/output_' . time() . '.pdf';  // Passe den Pfad an, wo die PDF-Datei gespeichert werden soll
        $this->pdf->generateFromHtml($html, $pdfFile);

        return $pdfFile;
    }
}
