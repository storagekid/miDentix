<?php

namespace App;

use App\Traits\Fileable;
use App\Printers\FacadeDistributionPrinter;

class ClinicPosterDistribution extends Qmodel
{
    use Fileable;
    
    protected $fillable = ['original_facade_file_id', 'composed_facade_file_id', 'complete_facade_file_id', 'address_id', 'clinic_id', 'distributions', 'starts_at', 'ends_at'];

    public function clinic () {
        return $this->belongsTo(Clinic::class)->withTrashed();
    }
    public function address () {
        return $this->belongsTo(Address::class);
    }
    public function campaign () {
        return $this->belongsTo(Campaign::class);
    }
    public function complete_facades () {
        return $this->hasMany(ClinicPosterDistributionFacade::class);
    }

    public function composeFacadeBuilder() {
        if (request('force') === true) {
            $oldComposedFacade = File::find($this->composed_facade_file_id);
            // dd($oldComposedFacade);
            $oldComposedFacade->delete();
            // $this->composed_facade_file_id = null;
            // $this->save();
        }
        $design = json_decode($this->distributions);
        // dd($design);
        $file = $this->original_facade()->first();
        $path = $file->url;
        if ($file->is_public) $path = 'public/' . $path;
        $cleanFacade = new \Imagick(storage_path('app/' . $path));
        $cleanFacade->resizeImage(1200,0,\Imagick::FILTER_POINT, 0);
        $width = $cleanFacade->getImageWidth();
        $height = $cleanFacade->getImageHeight();

        $whiteLayer = new \Imagick();
        $whiteLayer->newImage($width, $height, new \ImagickPixel('white'), 'png');
        $whiteLayer->setImageOpacity(0.6);

        $cleanFacade->compositeImage($whiteLayer, \Imagick::COMPOSITE_OVER, 0, 0);
        $designScale = $width / 600;

        foreach ($design->holders as $holder) {
            $holderwidth = ($holder->originalWidth * $design->postersScale) * $designScale;
            $holderheight = ($holder->originalHeight * $design->postersScale) * $designScale;
            $holderwidth += 4; // Adding The Borders
            $holderheight += 4; // Adding The Borders
            $x = ($width * $holder->leftInPercentage) / 100;
            $y = ($height * $holder->topInPercentage) / 100;
            $draw = new \ImagickDraw();
            $strokeColor = new \ImagickPixel("rgb(134,49,115)");
            $fillColor = new \ImagickPixel("rgb(134,49,115)");
            $backgroundColor = new \ImagickPixel("rgb(255,255,255)");

            $draw->setStrokeColor($strokeColor);
            $draw->setFillColor($fillColor);
            $draw->setStrokeOpacity(1);
            $draw->setStrokeWidth(2);

            $draw->rectangle(0, 0, $holderwidth, $holderheight);
            $imagick = new \Imagick();
            $imagick->newImage($holderwidth, $holderheight, $backgroundColor);
            $imagick->setImageFormat("png");

            $imagick->drawImage($draw);
            $name = new \ImagickDraw();
            /* Texto blanco */
            $name->setFillColor('white');

            /* Propiedades de la fuente */
            $name->setFontFamily('Helvetica');
            $size = 12;
            $name->setFontSize( 25 );
            // while ($imagick->queryFontMetrics($name, $holder->name)['textWidth'] < ($holderwidth - 20)) {
            //     $size++;
            //     $name->setFontSize( $size );
            //     if ($size > 40) break;
            // }
            /* Crear texto */
            // $imagick->setGravity (\Imagick::GRAVITY_CENTER);
            $metrics = $imagick->queryFontMetrics($name, $holder->name);
            $xMargin = ($holderwidth - $metrics['textWidth']) / 2;
            $yMargin = ($holderheight / 2) + ($metrics['textHeight'] / 3);
            $imagick->annotateImage($name, $xMargin, $yMargin, 0, $holder->name);
            // dd($imagick->queryFontMetrics($name, $holder->name));
            $imagick->setImageOpacity(0.9);
            $cleanFacade->compositeImage($imagick, \Imagick::COMPOSITE_OVER,$x, $y);
            // header("Content-Type: image/png");
            // echo $imagick->getImageBlob();
        }
        $fileName = $file->getBaseName() . '-facade-with-holders' . $this->starts_at . '.jpg';
        $filePath = $file->path;
        if ($file->is_public) $filePath = 'public/' . $filePath;
        $cleanFacade->writeImage(storage_path('app/' . $filePath . '/' . $fileName));
        // $file = $this::storeFile($file->path . '/' . $fileName, $file->path,$fileName,null,1,6,true); // TEST WITH USER AND GROUP HARDCODED
        $file = $this::storeFile($file->path . '/' . $fileName, $file->path, $fileName,null,null,null,true);
        $this->composed_facade_file_id = $file->id;
        $this->files()->save($file);
        $this->save();
    }

    public function completeFacadeBuilder() {
        if (request('force') == 'true') {
            $completeFacde = $this->complete_facades()->where('campaign_id', request('campaign'))->first();
            if ($completeFacde) $completeFacde->delete();
            // dd($completeFacde);
            // $oldCompleteFacade = File::find($this->complete_facade_file_id);
            // $oldCompleteFacade->delete();
        }
        $campaign = \App\Campaign::findOrActive(request('campaign'));
        $campaign->load(['sanitary_codes']);
        // dd($campaign);
        // $campaign = request('campaign') ? \App\Campaign::with(['sanitary_codes'])->find(request('campaign')) : '';
        $pdf = new FacadeDistributionPrinter($this, $campaign);
        $pdfFile = $pdf->makePdf();

        $file = $this->original_facade()->first();
        // $path = $file->url;
        // if ($file->is_public) $path = 'public/' . $path;

        // $fileName = $file->getBaseName() . '-facade-complete.pdf';
        // $filePath = $file->path;
        // if ($file->is_public) $filePath = 'public/' . $filePath;
        // $cleanFacade->writeImage(storage_path('app/' . $filePath . '/' . $fileName));
        // $file = $this::storeFile($file->path . '/' . $fileName, $file->path,$fileName,null,1,6,true); // TEST WITH USER AND GROUP HARDCODED
        $path = $file->path . '/campaigns';
        $file = $this::storeFile($pdfFile->directory . $pdfFile->fileName, $path, $pdfFile->fileName,null,null,null,true,true);
        $completeFacade = $this->complete_facades()->save(new ClinicPosterDistributionFacade([
            'campaign_id' => $campaign->id,
            'complete_facade_file_id' => $file->id
        ]));
        // $completeFacade->complete_facade_file_id = $file->id;
        $completeFacade->files()->save($file);
        return $completeFacade;
    }
    public function findDistributionsPosters ($campaignPosters) {
        $holders = [];
        $distribution = json_decode($this->distributions, true);
        foreach ($distribution['holders'] as $holder) {
            $completeHolder = $this->findHolderPosters($holder, $campaignPosters);
            $holders[] = $completeHolder;
        }
        return $holders;
    }
    public function findHolderPosters($holder, $campaignPosters) {
        if ($holder['ext']) $holder['ext'] = $this->findHolderPoster($holder['ext'], $campaignPosters);
        if ($holder['int']) $holder['int'] = $this->findHolderPoster($holder['int'], $campaignPosters);
        return $holder;
    }
    public function findHolderPoster($holder, $campaignPosters) {
        // dd($campaignPosters);
        // dump($campaignPosters->toArray());
        $def = \App\ClinicPosterPriority::with('clinic_poster.poster')->find($holder)->toArray();
        $candidates = $campaignPosters->filter(function($i) use ($def) {
            if ($i->poster_id === $def['clinic_poster']['poster_id'] && $i->priority === $def['priority']) return $i;
        });
        $def['blur'] = false;
        if ($def['clinic_poster']['type'] === 'Office' || $def['clinic_poster']['type'] === 'Office Int') {
            $def['blur'] = true;
        }
        $types = $candidates->groupBy('type')->keys()->toArray();
        // dump(in_array($def['clinic_poster']['type'], $types));
        if (!in_array($def['clinic_poster']['type'], $types)) {
            if ($def['clinic_poster']['poster']['material'] === 'FOAM') {
                if ($def['clinic_poster']['type'] === 'Office Int') $def['clinic_poster']['type'] = 'Office';
                else if ($def['clinic_poster']['type'] === 'Int') $def['clinic_poster']['type'] = 'Ext';
            } else {
                $def['clinic_poster']['type'] = 'Ext';
            }
        }
        $image = $candidates->filter(function($i) use ($def) {
            if ($i->type === $def['clinic_poster']['type']) return $i;
        })->first();
        // dd($image->toArray()['poster_af']);
        $completeSide = $def;
        $completeSide['image'] = $image->poster_af->thumbnail;
        $code = null;
        // dd($holder['ext']);
        foreach ($image->codes as $tempCode) {
            if ($tempCode->clinic_id === $this->clinic_id) {
                $code = $tempCode->code;
                break;
            } elseif ($tempCode->county_id === $this->clinic->county_id) {
                $code = $tempCode->code;
                break;
            } elseif ($tempCode->state_id === $this->clinic->county->state_id) {
                $code = $tempCode->code;
                break;
            }
        }
        // if (!$code) $code = $this->clinic->sanitary_code;
        $completeSide['code'] = $code;
        return $completeSide;
    }
}