<?php

namespace App\Printers;

use TCPDF;
use App\Stationary;
use App\Clinic;
use Illuminate\Support\Facades\Storage;

class StationaryPrinter
{
    protected $pdf;
    
    public static $rootDirectory = 'stationary/'; 
    public $directory, $fileName, $pathToFile;
    public $clinic, $profile, $stationary;
    public $force;

    public static $thumbnailRootDirectory = 'public/stationary/';
    public $thumbnailDirectory, $thumbnailFile, $thumbnailPath;

    protected $Color512 = 'PANTONE 512 C';
    protected $Color9C = 'PANTONE Cool Grey 9C';

    // protected $fontDxThin = 'dentixth';
    // protected $fontDxLight = 'dentixlt';
    // protected $fontDxRoman = 'dentixroman';

    protected $fontDxThin = 'newdentixthin';
    protected $fontDxLight = 'newdentixlight';
    protected $fontDxRoman = 'newdentixroman';

    protected $logo, $logo10percent, $logoClaim512, $logoClaimWhite;

    protected $web = 'www.dentix.com';

    public function __construct(Stationary $stationary, $force = false) {

        $this->pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false, true);

        $this->pdf->SetAuthor('Dentix® - Dpto. de Desarrollo');
        $this->pdf->SetCreator('Impresora de Papelería Dentix®.');

        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);

        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $this->pdf->AddSpotColor($this->Color512, 50, 90, 13, 15);
        $this->pdf->AddSpotColor($this->Color9C, 0, 0, 0, 80);

        $this->logo = storage_path('app/sources/logo.eps');
        $this->logo10percent = storage_path('app/sources/logo10.eps');
        $this->logoClaim512 = storage_path('app/sources/logo-claim-512.eps');
        $this->logoClaimWhite = storage_path('app/sources/logo-claim-white.eps');

        $this->stationary = $stationary;
        $this->force = $force;

    }

    public function directoryConstructor() {
        $mainDirectory = self::$rootDirectory . $this->clinic->countryName;
        $thumbnailMainDirectory = self::$thumbnailRootDirectory . $this->clinic->countryName;
        if ($this->stationary->customizable) {
            $mainDirectory .= '/clinics/' . $this->clinic->cleanName;
            $thumbnailMainDirectory .= '/clinics/' . $this->clinic->cleanName;
        } else if ($this->profile) {
            $mainDirectory .= '/personal/' . $this->clinic->cleanName . '/' . $this->stationary->cleanDescription;
            $thumbnailMainDirectory .= '/personal/' . $this->clinic->cleanName . '/' . $this->stationary->cleanDescription;
        } else {
            $mainDirectory .= '/generic';
            $thumbnailMainDirectory .= '/generic';
        }

        if (!Storage::exists($mainDirectory)) {
            Storage::makeDirectory($mainDirectory);
        }

        if (!Storage::exists($thumbnailMainDirectory)) {
            Storage::makeDirectory($thumbnailMainDirectory);
        }

        $this->directory = $mainDirectory;
        $this->thumbnailDirectory = $thumbnailMainDirectory;
    }

    public function fileNameConstructor() {
        if ($this->stationary->customizable) {
            return $this->clinic->cleanName . ' ' . $this->stationary->cleanDescription . '.pdf';
        } else if ($this->profile) {
            return $this->clinic->cleanName . ' ' . $this->stationary->cleanDescription . ' ' . $this->profile->cleanName . ' - ' . Carbon::now() . '.pdf';
        }

        // if (Storage::exists($dir . $object . $file) && !$force) {
        //     return false;
        // }
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

    // Thumbnails
    public function createThumbnail() {
        // create Imagick object
        $imagick = new \Imagick();
        // Reads image from PDF
        $imagick->readImage($this->pathToFile.'[0]');
        // Assigns filename and path to the model
        $this->thumbnailFile = str_replace('.pdf', '.jpg', $this->fileName);
        $this->thumbnailPath = Storage::url($this->thumbnailDirectory . '/' . $this->thumbnailFile);
        // Writes an image
        $imagick->writeImage(storage_path('app/' . $this->thumbnailDirectory . '/' . $this->thumbnailFile));
    }

    public static function cleanDirectories(Clinic $clinic) {
        Storage::deleteDirectory(self::$rootDirectory . $clinic->countryName . '/clinics/' . $clinic->cleanName);
        Storage::deleteDirectory(self::$thumbnailRootDirectory . $clinic->countryName .  '/clinics/' . $clinic->cleanName);
    }
}