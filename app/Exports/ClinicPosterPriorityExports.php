<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
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
    public static $blueprints = ['TPA', 'TPA (Crear Interiores)'];

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
}
