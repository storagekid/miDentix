<?php

namespace App\Http\Controllers\API;

use App\Clinic;
use App\Http\Controllers\Controller;
use App\Http\Requests\QStore;
use App\Jobs\SendCampaignDistribution;
use Carbon\Carbon;

class ClinicController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QStore $request, $id)
    {
        $model = Clinic::withTrashed()->find($id);

        $model->update(request()->all());

        return response([
            'model' => $model->attachFull(),
        ], 200);
    }

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
}
