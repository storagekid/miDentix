<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

// class ClinicPosterExports implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return ClinicPoster::all();
//     }
// }
class ClinicPosterPriorityExports implements FromView
{
    public static $blueprints = ['TPA', 'TPA (Crear Interiores)', 'TPA (Janire)'];

    public function view(): View
    {
        switch (request('blueprint')) {
            case 'TPA':
                $view = $this->exportTPA();
                return $view;
                break;
            case 'TPA (Crear Interiores)':
                $view = $this->exportTPACountOfficeInt();
                return $view;
                break;
            case 'TPA (Janire)':
                $view = $this->exportTPAJanire();
                return $view;
                break;
        }
    }
    public function exportTPA(): View {
        $posters = \App\ClinicPosterPriority::with(['clinic_poster' => function ($q) {
            $q->with(['clinic' => function ($q) { $q->withTrashed(); }, 'poster']);
        }]);
        $posters = count(request('ids')) ? $posters->find(request('ids')) : $posters->get();
        foreach ($posters as $poster) {
            $poster->append('clinic_id');
            $poster->append('poster_type');
        }
        $grouped = $posters->groupBy(['clinic_id', 'priority', 'clinic_poster.poster.name', 'clinic_poster.type']);
        // Grouping Numbers For TPA
        $translights = ['692x991', '1795x1193', '1195x993'];
        foreach ($grouped as $clinicId => $priorities) {
            foreach ($priorities as $priority => $sizes) {
                foreach ($sizes as $size => $types) {
                    if ($types->has('Ext') && $types->has('Int')) {
                        $grouped[$clinicId][$priority][$size]['Normal'] = collect();
                        foreach($types['Ext'] as $type) {
                            $grouped[$clinicId][$priority][$size]['Normal'][] = $type;
                        }
                        $types->forget('Ext');
                        foreach($types['Int'] as $type) {
                            $grouped[$clinicId][$priority][$size]['Normal'][] = $type;
                        }
                        $types->forget('Int');
                    } else if (in_array($size, $translights) && $types->has('Ext')) {
                        $grouped[$clinicId][$priority][$size]['Normal'] = collect();
                        foreach($types['Ext'] as $type) {
                            $grouped[$clinicId][$priority][$size]['Normal'][] = $type;
                        }
                        $types->forget('Ext');
                    }
                }
            }
        }
        // END Grouping Numbers For TPA
        $sorted = $grouped->sortKeys();

        return view('exports.clinicPoster', [
            'posters' => $sorted
        ]);
    }
    public function exportTPACountOfficeInt(): View {
        $campaign = \App\Campaign::findOrActive();
        $posters = \App\ClinicPosterPriority::with(['clinic_poster' => function ($q) {
            $q->with(['clinic' => function ($q) { $q->withTrashed(); }, 'poster']);
        }]);
        $posters = count(request('ids')) ? $posters->find(request('ids')) : $posters->get();
        foreach ($posters as $poster) {
            $poster->append('clinic_id');
            $poster->append('poster_type');
        }
        $grouped = $posters->groupBy(['clinic_id', 'priority', 'clinic_poster.poster.name', 'clinic_poster.type']);
        // Grouping Numbers For TPA
        $translights = ['692x991', '1795x1193', '1195x993'];
        foreach ($grouped as $clinicId => $priorities) {
            foreach ($priorities as $priority => $sizes) {
                foreach ($sizes as $size => $types) {
                    if ($types->has('Ext') && $types->has('Int')) {
                        $grouped[$clinicId][$priority][$size]['Normal'] = collect();
                        foreach($types['Ext'] as $type) {
                            $grouped[$clinicId][$priority][$size]['Normal'][] = $type;
                        }
                        $types->forget('Ext');
                        foreach($types['Int'] as $type) {
                            $grouped[$clinicId][$priority][$size]['Normal'][] = $type;
                        }
                        $types->forget('Int');
                    } else if ($types->has('Office') && !$types->has('Office Int')) {
                        if (!$grouped[$clinicId]->has('5')) {
                            $grouped[$clinicId]->put('5', collect());
                            $grouped[$clinicId]['5']->put($size, collect());
                            $grouped[$clinicId]['5'][$size]->put('Office Int', collect());
                        } else if (!$grouped[$clinicId]['5']->has($size)) {
                            $grouped[$clinicId]['5']->put($size, collect());
                            $grouped[$clinicId]['5'][$size]->put('Office Int', collect());
                        } else if (!$grouped[$clinicId]['5'][$size]->has('Office Int')) {
                            $grouped[$clinicId]['5'][$size]->put('Office Int', collect());
                        }
                        foreach($types['Office'] as $type) {
                            $grouped[$clinicId]['5'][$size]['Office Int'][] = $type;
                        }
                    } else if (in_array($size, $translights) && $types->has('Ext')) {
                        $grouped[$clinicId][$priority][$size]['Normal'] = collect();
                        foreach($types['Ext'] as $type) {
                            $grouped[$clinicId][$priority][$size]['Normal'][] = $type;
                        }
                        $types->forget('Ext');
                    }
                }
            }
        }
        // END Grouping Numbers For TPA
        $sorted = $grouped->sortKeys();

        return view('exports.clinicPoster', [
            'posters' => $sorted
        ]);
    }
    public function exportTPAJanire(): View {
        $clinics = \App\ClinicPosterDistribution::find(request('ids'))->groupBy('clinic_id');
        // dd($distributions->toArray());
        $campaign = \App\Campaign::with('campaign_poster_priorities')->where('starts_at', '>=', $clinics->first()->first()->starts_at)->first();
        $campaignPriorities = [];
        foreach ($campaign->campaign_poster_priorities as $cp) {
            $campaignPriorities[$cp->priority] = $cp->poster_model_name;
        }
        // dd($campaignPriorities);
        $posters = [];
        foreach ($clinics as $clinic => $distributions) {
            $clinicPosters = [];
            foreach ($distributions as $distribution) {
                $dist = json_decode($distribution->distributions, true);
                foreach ($dist['holders'] as $holder) {
                    $holderPosters = $this->buildTpaPoster($holder, $campaignPriorities);
                    if (count($clinicPosters)) {
                        // dump('Count');
                        // dump(count($clinicPosters));
                        foreach ($holderPosters as $poster) {
                            $found = false;
                            foreach ($clinicPosters as $i => $cp) {
                                if ($cp['Modelo'] === $poster['Modelo'] && $cp['Tamaño'] === $poster['Tamaño'] && $cp['Tipo'] === $poster['Tipo']) {
                                    $clinicPosters[$i]['Unidades']++;
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) $clinicPosters[] = $poster;
                        }
                    } else {
                        // dump('Empty');
                        $clinicPosters = array_merge($clinicPosters, $holderPosters);
                    }
                }
            }
            // dump($clinicPosters);
            $posters = array_merge($posters, $clinicPosters);
        }
        return view('exports.clinicPosterTpaJanire', [
            'posters' => $posters
        ]);
    }
    public function buildTpaPoster($holder, $campaignPriorities) {
        $posterExt = null;
        $posterInt = null;
        if ($holder['ext']) $posterExt = \App\ClinicPosterPriority::with('clinic_poster.clinic')->find($holder['ext']);
        if ($holder['int']) $posterInt = \App\ClinicPosterPriority::with('clinic_poster.clinic')->find($holder['int']);
        $isFOAM = $posterExt->clinic_poster->poster->material === 'FOAM';
        if ($isFOAM) {
            $model = ($holder['ext'] ? $campaignPriorities[$posterExt->priority] : 'Vacio' ). '/' . ($holder['int'] ? $campaignPriorities[$posterInt->priority] : 'Vacio');
            $posterDef = [
                'Clínica' => $posterExt->clinic_poster->clinic->nickname,
                'CCAA' => $posterExt->clinic_poster->clinic->county->state->name,
                'Modelo' => $model,
                'Tamaño' => $posterExt->clinic_poster->poster->name,
                'Tipo' => $posterExt->clinic_poster->type === 'Office' ? 'Gabinete' : 'Normal',
                'Unidades' => 1,
                'Idioma' => $posterExt->clinic_poster->clinic->language->native_name
            ];
            return [$posterDef];
        } else {
            $posters = [];
            if ($posterExt) {
                $model = $campaignPriorities[$posterExt->priority];
                $posterDef = [
                    'Clínica' => $posterExt->clinic_poster->clinic->nickname,
                    'CCAA' => $posterExt->clinic_poster->clinic->county->state->name,
                    'Modelo' => $model,
                    'Tamaño' => $posterExt->clinic_poster->poster->name,
                    'Tipo' => 'Translight',
                    'Unidades' => 1,
                    'Idioma' => $posterExt->clinic_poster->clinic->language->native_name
                ];
                $posters[] = $posterDef;
            }
            if ($posterInt) {
                $model = $campaignPriorities[$posterInt->priority];
                $posterDef = [
                    'Clínica' => $posterExt->clinic_poster->clinic->nickname,
                    'CCAA' => $posterExt->clinic_poster->clinic->county->state->name,
                    'Modelo' => $model,
                    'Tamaño' => $posterExt->clinic_poster->poster->name,
                    'Tipo' => 'Translight',
                    'Unidades' => 1,
                    'Idioma' => $posterExt->clinic_poster->clinic->language->native_name
                ];
                $posters[] = $posterDef;
            }
            if (count($posters) === 2) {
                // dump('2 Translight Faces');
                if ($posters[0]['Modelo'] === $posters[1]['Modelo'] && $posters[0]['Tamaño'] === $posters[1]['Tamaño']) {
                    // dump('Same Translight Face');
                    $posters[0]['Unidades']++;
                    unset($posters[1]);
                }
            }
            return $posters;
        }
    }
}
