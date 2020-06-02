<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendCampaignDistribution;
use App\Printers\StationaryCustomizablePrinter as StationaryPrinter;

class ClinicController extends Controller
{

    public function posterDistributionComposer($clinic) {
        $model = \App\Clinic::withTrashed()->find($clinic);
        foreach ($model->poster_distributions as $clinicposterdistribution) {
            $clinicposterdistribution->load(['clinic', 'address']);
            if (!$clinicposterdistribution->composed_facade()->first() || request('force')) $clinicposterdistribution->composeFacadeBuilder();
            if (!$clinicposterdistribution->complete_facade()->first() || request('force')) {
                $clinicposterdistribution->completeFacadeBuilder();
            }
        }
        return response([
            'model' => $model->fresh()->load(['poster_distributions']),
            'message' => 'Facade Complete Successfully',
        ], 200);
    }

    public function posterDistributionByCampaignComposer($clinic) {
        $model = \App\Clinic::withTrashed()->find($clinic);
        $campaignFacades = $model->createCampaignFacades();

        return response([
            'model' => $campaignFacades,
            'message' => 'Facade Complete Successfully',
        ], 200);
    }
    public function posterDistributionClone($clinic) {
        $model = \App\Clinic::withTrashed()->find($clinic);
        $placePriorities = request()->has('placePriorities');
        $model->cloneDistributions($placePriorities);
        return response([
            'model' => $model->fresh()->load('poster_distributions'),
            'message' => 'Distributions Clone Successfully',
        ], 200);
    }
    public function launchCampaignDistribution($clinic)
    {
        $model = \App\Clinic::withTrashed()->find($clinic);

        $fake = request('fake') === 'false' ? false : true;
        $campaign = \App\Campaign::find(request('campaign'));

        $email = SendCampaignDistribution::dispatch($model, $campaign, $fake);
        
        return response([
            'model' => $email,
        ], 200);
    }
    public function newDistributionCriterion($clinic) {
        // dump ('newDistributionCriterion');
        // dump ('starts_at');
        $model = \App\Clinic::withTrashed()->find($clinic);
        $placePriorities = request()->has('placePriorities');
        $models = $model->cloneDistributions($placePriorities);
        // foreach ($newDists as $newDistribution) $newDistribution->newPrioritiesCriterion(request('newPriorities'));
        // dump ('newPrioritiesCriterion');
        $newPrioritiesArray = [];
        foreach (request('newPriorities') as $newPriority) {
            // dump(json_decode($newPriority, true));
            $newPrioritiesArray[] = json_decode($newPriority, true);
        }
        dump ($newPrioritiesArray);
        // $distribution = json_decode($this->distributions, true);
        $posterPriorities = $models['newPPs'];
        $posterPrioritiesEnhanced = $models['newPPsEnhanced'];
        dump ('HERE????');
        dump ($posterPrioritiesEnhanced);

        foreach ($posterPrioritiesEnhanced as $pp) {
            // dump ((int) $pp->priority);
            // dump ($pp->clinic_poster->type);
            foreach ($newPrioritiesArray as $newPriority) {
                if (
                    $pp['oldTypeA'] === $newPriority['oldTypeA']
                    && $pp['oldTypeB'] === $newPriority['oldTypeB']
                    && (int) $pp['oldPriorityA'] === (int) $newPriority['oldPriorityA']
                    && (int) $pp['oldPriorityB'] === (int) $newPriority['oldPriorityB']
                    && $pp['model']->clinic_poster->type === $newPriority['newType']
                    )
                {
                    $pp['model']->priority = $newPriority['newPriority'];
                    $pp['model']->save();
                    break;
                }
            }
        }

        // foreach ($posterPriorities as $pp) {
        //     // dump ((int) $pp->priority);
        //     // dump ($pp->clinic_poster->type);
        //     foreach ($newPrioritiesArray as $newPriority) {
        //         if ($pp->clinic_poster->type === $newPriority['oldType'] && (int) $pp->priority === (int) $newPriority['oldPriority']) {
        //             $pp->priority = $newPriority['newPriority'];
        //             $pp->save();
        //         }
        //     }
        // }

        return response([
            'message' => 'New Criterion Builded',
        ], 200);
    }
    public function setDefaultDistributions($clinic) {
        $model = \App\Clinic::withTrashed()->find($clinic);
        $model->setDefaultDistributions(request('designs'));
        return response([
            'model' => $model->fresh()->load('poster_distributions'),
            'message' => 'Distributions Clone Successfully',
        ], 200);
    }
    public function posterPrioritiesFixer($clinic) {
        $model = \App\Clinic::withTrashed()->find($clinic);
        $model->posterPrioritiesFixer();
        return response([
            'model' => $model->fresh()->load('poster_distributions'),
            'message' => 'Distributions Clone Successfully',
        ], 200);
    }
    public function generateStationaries($clinic, $params = ['force' => false]) {
        if (request()->has('force')) {
            $params['force'] = request('force') === 'true' ?: false;
        }
        $model = \App\Clinic::fetch(['ids'=>[$clinic], 'with' => ['clinic_stationaries']])[0]->append(['real_address', 'real_phone']);
        $storeableStationaries = \App\Product::with(['product_category' => function($q) { return $q->where('name', 'stationary'); }])->where('storeable', 1)->get();
        $clinicStationariesIds = $model->clinic_stationaries->pluck('product_id');
        foreach ($storeableStationaries as $stationary) {
            // $clinicStationary = null;
            if ($clinicStationariesIds->contains($stationary->id)) {
                if (!$params['force']) continue;
                $clinicStationary = $model->clinic_stationaries()->where('product_id', $stationary->id)->first();
                $clinicStationary->af()->first()->delete();
            }
            else {
                $clinicStationary = new \App\ClinicStationary([
                    'clinic_id' => $model->id,
                    'product_id' => $stationary->id
                ]);
            }
            $file = $clinicStationary->makeStationary();
            if (!$file) continue;

            $clinicStationary['af_file_id'] = $file->id;
            $model->clinic_stationaries()->save($clinicStationary);
            $clinicStationary->files()->save($file);
        }
        return response([
            'model' => $model->getView(request('view')),
        ], 200);
    }
}
