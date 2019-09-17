<?php

namespace App\Http\Controllers\API;

use App\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendCampaignDistribution;
use Carbon\Carbon;

class ClinicController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $quasarData = Clinic::getQuasarData();
        $clinic = Clinic::create(request()->all());
        $clinic->nickname = $clinic->fullName;
        $clinic->save();
        foreach ($quasarData['relations'] as $name => $relation) {
            if ($relation['type'] === 'BelongsToMany' && request()->has($name)) {
                $models = json_decode((request($name)), true);
                if (count($models)) {
                    foreach ($models as $item) {
                        $clinic->$name()->attach($item['id']);
                    }
                }
            }
        }

        return response([
            'model' => $clinic->attachFull(),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = Clinic::withTrashed()->find($id);

        $model->update(request()->all());

        return response([
            'model' => $model->attachFull(),
        ], 200);
    }

    public function posterDistributionComposer(Clinic $clinic) {
        foreach ($clinic->poster_distributions as $clinicposterdistribution) {
            $clinicposterdistribution->load(['clinic', 'address']);
            if (!$clinicposterdistribution->composed_facade()->first() || request('force')) $clinicposterdistribution->composeFacadeBuilder();
            if (!$clinicposterdistribution->complete_facade()->first() || request('force')) {
                $clinicposterdistribution->completeFacadeBuilder();
            }
        }
        return response([
            'model' => $clinic->fresh()->load(['poster_distributions']),
            'message' => 'Facade Complete Successfully',
        ], 200);
    }

    public function posterDistributionByCampaignComposer(Clinic $clinic) {
        $campaignFacades = $clinic->createCampaignFacades();

        return response([
            'model' => $campaignFacades,
            'message' => 'Facade Complete Successfully',
        ], 200);
    }
    public function posterDistributionClone(Clinic $clinic) {
        if (!request('campaign')) {
            $startDate = request('starts_at') ? Carbon::parse(request('starts_at')) : Carbon::parse(Carbon::now());
            $endDate = request('starts_at') ? Carbon::parse(request('starts_at')) : Carbon::parse(Carbon::now());
            $endDate = $endDate->subDays(1);
        } else {
            $campaign = json_decode(request('campaign'), true);
            $startDate = $campaign['starts_at'] ? $campaign['starts_at'] : Carbon::parse(Carbon::now());
            $endDate = $campaign['ends_at'] ? $campaign['ends_at'] : $campaign['starts_at'] ? Carbon::parse($campaign['starts_at'])->addMonths(3) : Carbon::parse(Carbon::now())->addMonths(3);
            $endDate = $endDate->subDays(1);
        }
        // dump($startDate);
        // dump($endDate);
        $model = $clinic;
        $clinicDistributions = $clinic->poster_distributions()->find(request('designs'));
        // dump(count($clinicDistributions));
        // dd($clinicDistributions->toArray());
        foreach ($clinicDistributions as $clinicposterdistribution) {
            // dump('Original ID: ' . $clinicposterdistribution->id);
            $distribution = json_decode($clinicposterdistribution['distributions'],true);
            $ppIds = $distribution['posterIds'];
            if (count($ppIds)) {
                $posterPriorities = \App\ClinicPosterPriority::find($ppIds);
                foreach ($posterPriorities as $pp) {
                    $newPP = \App\ClinicPosterPriority::create($pp->toArray());
                    $newPP->starts_at = $startDate;
                    if (request('campaign')) {
                        $campaign = json_decode(request('campaign'), true);
                        $newPP->ends_at = $endDate;
                        $newPP->campaign_id = $campaign['id'];
                    }
                    else {
                        $pp->ends_at = $endDate;
                        $pp->save();
                    }
                    $newPP->save();
                }
                // dump(count($posterPriorities));
            }
            if (count($distribution['holders'])) {
                foreach ($distribution['holders'] as $i => $holder ) {
                    $distribution['holders'][$i]['ext'] = [];
                    $distribution['holders'][$i]['int'] = [];
                    $distribution['posterIds'] = [];
                }
            }
            $newDist = \App\ClinicPosterDistribution::create($clinicposterdistribution->toArray());
            $newDist->starts_at = $startDate;
            $newDist->save();
            if (!request('campaign')) {
                $clinicposterdistribution->ends_at = $endDate;
                $clinicposterdistribution->save();
            } else {
                $campaign = json_decode(request('campaign'), true);
                $newDist->ends_at = $campaign['ends_at'];
                $newDist->campaign_id = $campaign['id'];
                $newDist->save();
            }
            $newDist->distributions = json_encode($distribution);
            $newDist->save();
        }
        return response([
            'model' => $model->fresh()->load('poster_distributions'),
            'message' => 'Distributions Clone Successfully',
        ], 200);
    }
    public function launchCampaignDistribution(Clinic $clinic)
    {
        $fake = request('fake') === 'false' ? false : true;
        $campaign = \App\Campaign::find(request('campaign'));

        $email = SendCampaignDistribution::dispatch($clinic, $campaign, $fake);
        
        return response([
            'model' => $email,
        ], 200);
    }
}
