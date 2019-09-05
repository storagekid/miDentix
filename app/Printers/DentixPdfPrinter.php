<?php

namespace App\Printers;

use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Support\Facades\Storage;

class DentixPdfPrinter
{
    protected $pdf;

    public $directory = 'DentixPrinter/';

    protected $bleed, $slug;

    protected $Color512 = 'PANTONE 512 C';
    protected $Color9C = 'PANTONE Cool Grey 9C';

    protected $fontDxThin = 'dentixth';
    protected $fontDxLight = 'dentixlt';
    protected $fontDxRoman = 'dentixroman';

    protected $logo512, $logo512_10, $logoCMYK, $logoCMYK_10, $logoWhite, $logoBlack; // Logos WithOut Claim
    protected $logoClaim512, $logoClaim512_10, $logoClaimCMYK, $logoClaimCMYK10, $logoClaimWhite, $logoClaimBlack; // Logos WITH Claim
    protected $logo512_BOX, $logo512_10_BOX, $logoCMYK_BOX, $logoCMYK10_BOX, $logoWhite_BOX, $logoBlack_BOX; // Logos WithOut Claim BOXED
    protected $logoClaim512_BOX, $logoClaim512_10_BOX, $logoClaimCMYK_BOX, $logoClaimCMYK10_BOX, $logoClaimWhite_BOX, $logoClaimBlack_BOX; // Logos WITH Claim BOXED

    protected $web = 'www.dentix.com';

    protected $files = array();

    public function __construct() {
        
        $this->pdf = new Fpdi('P', 'mm', 'A4', true, 'UTF-8', false, true);

        $this->pdf->SetAuthor('Dentix® - Dpto. de Marketing');
        $this->pdf->SetCreator('Juan Gabriel Villalba. Dentix®.');

        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);

        $this->pdf->SetMargins(0, 0, 0);

        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $this->pdf->AddSpotColor($this->Color512, 50, 90, 13, 15);
        $this->pdf->AddSpotColor($this->Color9C, 0, 0, 0, 80);

        $this->pdf->SetAutoPageBreak(1,1);

        // Initialize Plain Logos
        $this->logo512 = storage_path('app/sources/logo/plain/logo-512C.eps');
        $this->logo512_10 = storage_path('app/sources/logo/plain/logo-512C_10.eps');
        $this->logoCMYK = storage_path('app/sources/logo/plain/logo-50901315.eps');
        $this->logoCMYK_10 = storage_path('app/sources/logo/plain/logo-50901315_10.eps');
        $this->logoWhite = storage_path('app/sources/logo/plain/logo-White.eps');
        $this->logoBlack = storage_path('app/sources/logo/plain/logo-Bhite.eps');
        // Initialize Claim Logos
        $this->logoClaim512 = storage_path('app/sources/logo/claim/logo-claim-512C.eps');
        $this->logoClaim512_10 = storage_path('app/sources/logo/claim/logo-claim-512C_10.eps');
        $this->logoClaimCMYK = storage_path('app/sources/logo/claim/logo-claim-50901315.eps');
        $this->logoClaimCMYK_10 = storage_path('app/sources/logo/claim/logo-claim-50901315_10.eps');
        $this->logoClaimWhite = storage_path('app/sources/logo/claim/logo-claim-White.eps');
        $this->logoClaimBlack = storage_path('app/sources/logo/claim/logo-claim-Bhite.eps');
        // Initialize Plain Logos BOXED
        $this->logo512_BOX = storage_path('app/sources/logo/box/plain/logo-512C_BOX.eps');
        $this->logo512_10_BOX = storage_path('app/sources/logo/box/plain/logo-512C_10_BOX.eps');
        $this->logoCMYK_BOX = storage_path('app/sources/logo/box/plain/logo-50901315_BOX.eps');
        $this->logoCMYK_10_BOX = storage_path('app/sources/logo/box/plain/logo-50901315_10_BOX.eps');
        $this->logoBlack_BOX = storage_path('app/sources/logo/box/plain/logo-Bhite_BOX.eps');
        // Initialize Claim Logos BOXED
        $this->logoClaim512_BOX = storage_path('app/sources/logo/box/claim/logo-claim-512C_BOX.eps');
        $this->logoClaim512_10_BOX = storage_path('app/sources/logo/box/claim/logo-claim-512C_10_BOX.eps');
        $this->logoClaimCMYK_BOX = storage_path('app/sources/logo/box/claim/logo-claim-50901315_BOX.eps');
        $this->logoClaimCMYK_10_BOX = storage_path('app/sources/logo/box/claim/logo-claim-50901315_10_BOX.eps');
        $this->logoClaimBlack_BOX = storage_path('app/sources/logo/box/claim/logo-claim-Bhite_BOX.eps');

        if (!Storage::exists($this->directory)) {
            Storage::makeDirectory($this->directory);
        }
    }

    // Generic Functions
    public function dotLine($pdf, $start, $y, $weight, $end)
    {
        $margin = $weight * 4;

        while ($start < $end) {
            $pdf->Circle($start, $y, $weight, 0, 360, 'F');
            $start += $margin;
        }
    }

    public function bleedLines($pdf, $pageWidth, $pageHeight, $bleed, $slug) {
        $pdf->SetLineWidth(0.15);
        $pdf->SetDrawColor(0);

        // Líneas de sangre horizontales
        $pdf->Line(0,$slug+$bleed,$slug,$slug+$bleed);
        $pdf->Line($pageWidth,$slug+$bleed,$pageWidth-($slug),$slug+$bleed);
        $pdf->Line(0,$pageHeight-($slug+$bleed),$slug,$pageHeight-($slug+$bleed));
        $pdf->Line($pageWidth,$pageHeight-($slug+$bleed),$pageWidth-($slug),$pageHeight-($slug+$bleed));

        // Líneas de sangre verticales
        $pdf->Line($slug+$bleed,0,$slug+$bleed,$slug);
        $pdf->Line($pageWidth-($slug+$bleed),0,$pageWidth-($slug+$bleed),$slug);
        $pdf->Line($slug+$bleed,$pageHeight,$slug+$bleed,$pageHeight-$slug);
        $pdf->Line($pageWidth-($slug+$bleed),$pageHeight,$pageWidth-($slug+$bleed),$pageHeight-$slug);
    }

    public function concat()
    {
        foreach($this->files AS $file) {
          // dump($file->getRealPaths()['url']);
          // dd('Test');
          $file = $file->getRealPaths()['url'];
          // $file = storage_path('app/public/' . $file);
            $pageCount = $this->pdf->setSourceFile($file);
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $pageId = $this->pdf->ImportPage($pageNo);
                $s = $this->pdf->getTemplatesize($pageId);
                $this->pdf->AddPage($s['orientation'], $s);
                $this->pdf->useImportedPage($pageId);
            }
        }
    }
}