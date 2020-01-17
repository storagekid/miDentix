<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;
use App\MailingDesign;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MailingDesignController extends Controller
{

    public function clinicMailingGenerator(MailingDesign $mailing_design) {
        foreach(request('ids') as $clinic) {
            $mailing_design->clinic_mailings()->firstOrCreate(['clinic_id' => $clinic]);
        }
        return response([
            'message' => 'Clinic Mailing Generated',
        ], 200);
    }
    public function productAndServicesGenerator(MailingDesign $mailing_design) {
        $mailing = $mailing_design->mailing;
        $product = \App\Product::where([['category', 'Mailing'], ['name', 'like', '%' . strtolower($mailing_design->type) . '%']])->first();
        $product_provider_candidates = $product->product_providers()->where([['starts_at', '<', $mailing->ends_at], ['ends_at', '>', $mailing->starts_at]])->get();
        $service = \App\Service::where('name', 'Mailing_Doordrop')->first();
        $service_provider_candidates =
            $service->service_providers()
                ->where([['starts_at', '<', $mailing->ends_at], ['ends_at', '>', $mailing->starts_at]])
                ->orWhere([['starts_at', '<', $mailing->ends_at], ['ends_at', null]])
                ->orderBy('clinic_id', 'desc')
                ->orderBy('county_id', 'desc')
                ->orderBy('state_id', 'desc')
                ->orderBy('country_id', 'desc')
                ->get();
        foreach(request('ids') as $clinic) {
            if ($product_provider_candidates->count() === 1) $product_provider = $product_provider_candidates[0];
            if ($service_provider_candidates->count() === 1) $product_provider = $product_provider_candidates[0];
            else {
                $clinicModel = \App\Clinic::find($clinic);
                $service_provider = $clinicModel->filterScope($service_provider_candidates);
            }
            $mailing_design->clinic_mailings()->updateOrCreate(
                ['clinic_id' => $clinic],
                [
                    'printer_id' => $product_provider->provider->id,
                    'printer_product_id' => $product_provider->id,
                    'distributor_id' => $service_provider->provider->id,
                    'distributor_service_id' => $service_provider->id,
                ]
            );
        }
        return response([
            'message' => 'Clinic Mailing Generated',
        ], 200);
    }
    public function indesignCSVGenerator(MailingDesign $mailing_design) {
        $file = $mailing_design->indesignFileBuilder();
        return response()->download(storage_path('app/temp/'.$file))->deleteFileAfterSend(true);
    }
    public function indesignRenameGenerator(MailingDesign $mailing_design) {
        $content = $mailing_design->renameFileBuilder();
        $date = $mailing_design->date_string;
        $fileName = $mailing_design->name . ' ' . $date . ' REN.txt';
        if (!Storage::exists('temp')) {
            Storage::makeDirectory('temp');
        }
        Storage::put('temp/'.$fileName, $content);
        return response()->download(storage_path('app/temp/'.$fileName))->deleteFileAfterSend(true);
    }

}
