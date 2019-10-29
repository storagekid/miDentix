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
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QStore $request)
    {
        $mailing = \App\Mailing::find(request('mailing_id'));
        $model = $mailing->mailing_designs()->create([
            'name' => request('name'),
            'description' => request('description'),
            'mailing_id' => request('mailing_id'),
            'language_id' => request('language_id'),
            'country_id' => request('country_id'),
            'state_id' => request('state_id'),
            'county_id' => request('county_id'),
            'clinic_id' => request('clinic_id'),
            'type' => request('type'),
        ]);
        
        $name = $model->getFileName();

        if (request()->file('file')) {
            $file = MailingDesign::storeFile(request()->file('file'), 'mailing/' . $mailing->id . '/designs', $name, 'multi', auth()->user()->id, 5, false);
            $model->base_af_file_id = $file->id;
            $model->save();
            $model->files()->save($file);
        }

        return response([
            'model' => $model->fresh(),
        ], 200);
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QStore $request, $id)
    {
        $model = MailingDesign::find($id);

        $model->update([
            'name' => request('name'),
            'description' => request('description'),
            'mailing_id' => request('mailing_id'),
            'language_id' => request('language_id'),
            'country_id' => request('country_id'),
            'state_id' => request('state_id'),
            'county_id' => request('county_id'),
            'clinic_id' => request('clinic_id'),
            'type' => request('type'),
        ]);

        if (request('file')) {
            $base_af = $model->base_af()->first()->delete();

            $name = $model->getFileName();
            $file = MailingDesign::storeFile(request()->file('file'), 'mailing/' . $model->mailing->id . '/designs', $name, 'multi', auth()->user()->id, 5, false);

            $model->base_af_file_id = $file->id;
            $model->save();
            $model->files()->save($file);
        }

        return response([
            'model' => $model->fresh(),
        ], 200);
    }

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
        // return Excel::download(new \App\Exports\IndesignCSVExports($mailing_design), $mailing_design->name . ' ' . $mailing_design->date_string . '.csv');
        $file = $mailing_design->indesignFileBuilder();
        // $date = $mailing_design->date_string;
        // $fileName = $mailing_design->name . ' ' . $date . '.txt';
        // if (!Storage::exists('temp')) {
        //     Storage::makeDirectory('temp');
        // }
        // Storage::put('temp/'.$fileName, $content);
        // Storage::put('public/'.$fileName, $content);
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
