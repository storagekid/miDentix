<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IndesignCSVExports implements FromView
{
    protected $mailing, $mailing_design, $legals, $clinics, $sanitary_codes;
    protected $columns = [];
    protected $columnIndexes = [];

    public function __construct($mailing_design)
    {
        $this->mailing_design = $mailing_design;
        $this->mailing = $mailing_design->mailing;
        $this->sanitary_codes = $mailing_design->mailing->sanitary_codes;
        $this->legals = $mailing_design->legals;
        $this->legals = $this->legals->concat($mailing_design->country->legals);
    }

    public function view(): View
    {
        // $clinics = \App\Clinic::withTrashed()
        //     ->where([['starts_at', '<', $this->mailing->ends_at], ['ends_at', '=', null]])
        //     ->with('clinic_siblings')
        //     ->withCount('clinic_siblings')
        //     ->orderBy('city')
        //     ->find(request('ids'));
        $clinics = $this->mailing_design->filteredClinics;

        $maxSiblings = $clinics->count() ? $clinics->sortByDesc('clinic_siblings_count')->first()->clinic_siblings_count : 0;
        if ($maxSiblings) $clinics = \App\Clinic::cleanSiblings($clinics);

        foreach ($clinics as $clinic) {
            $this->addColumn('city', 'Clinic1');
            $this->addColumn('city2', 'Clinic2');
            $clinic['city2'] = '';
            // Check if Clinic Name is too Long
            if (strlen($clinic->city) > 15) {
                $index = false;
                $round = 0;
                $needles = [' del ', ' de ', ' i '];
                while ($index === false) {
                    $index = strpos($clinic->city, $needles[$round]);
                    $round++;
                    if ($round === count($needles)) break;
                }
                if ($index === false) $index = strpos($clinic->city, ' ');
                $clinic['city2'] = substr($clinic->city, $index);
                $clinic['city'] = substr($clinic->city, 0, $index);
            }
            // Find Virtual Phone Number
            $this->addColumn('virtual', 'Tel.Virtual');
            $clinic['virtual'] = $clinic->phones()->where('type', 'Virtual')->first()->number;
            // Find Addresses
            $address = $clinic->addresses()->where('type', 'Comercial')->first();
            if (!$address) $address = $clinic->addresses()->where('type', 'Fiscal')->first();
            $this->addColumn('dir1', 'Dir.1');
            $this->addColumn('dir2', 'Dir.2');
            $clinic['dir1'] = $address->address_line_1;
            $clinic['dir2'] = $address->address_line_2;
            // Find Sanitary Codes
            $code = $this->findCS($this->sanitary_codes, $clinic);
            $this->addColumn('code1', 'Code1');
            $clinic['code1'] = $code;
            // Find Sibling Data
            $round = 1;
            while ($round <= $maxSiblings) {
                $clinic['dir' . (2+$round)] = '';
                $clinic['separator'] = '';
                $clinic['code' . (1+$round)] = '';
                $this->addColumn('dir' . (2+$round), 'Dir.' . (2+$round));
                $this->addColumn('code' . (1+$round), 'Code' . (1+$round));
                $this->addColumn('separator', 'Separator');
                $round++;
            }
            if ($clinic->siblings->count()) {
                $clinic['separator'] = '.....................';
                $round = 1;
                foreach ($clinic->siblings as $sibling) {
                    // Find Sibling Address
                    $address = $sibling->addresses()->where('type', 'Comercial')->first();
                    if (!$address) $address = $sibling->addresses()->where('type', 'Fiscal')->first();
                    $clinic['dir' . (2+$round)] = $address->address_line_1 . ' ' . $address->address_line_2;
                    // Find Sibling CS
                    $code = $this->findCS($this->sanitary_codes, $sibling);
                    $clinic['code' . (1+$round)] = $code;
                    $round++;
                }
            }
            // Find Design Legals
            foreach($this->legals as $legal) {
                $clinic[$legal->name] = $legal->text;
                $this->addColumn($legal->name, $legal->name);
            }
        }
        $this->clinics = $clinics;

        return view('exports.mailing.indesign_csv', [
            'columns' => $this->columns,
            'clinics' => $this->clinics
        ]);
    }

    // Helpers

    public function addColumn($column, $label) {
        if (!in_array($column, $this->columnIndexes)) {
            $this->columnIndexes[] = $column;
            $this->columns[$column] = $label;
        }

    }
    public function findCS($codes, $clinic) {
        $code = $clinic->sanitary_code;
        foreach ($codes as $source) {
            if ($source->clinic_id) {
                if ($source->clinic_id === $clinic->id) {
                    $code = $source->code;
                    break;
                } else continue;
            } else if ($source->county_id) {
                if ($source->county_id === $clinic->county_id) {
                    $code = $source->code;
                    break;
                } else continue;
            } else if ($source->state_id) {
                if ($source->state_id === $clinic->county->state_id) {
                    $code = $source->code;
                    break;
                } else continue;
            }
        }
        return $code;
    }
}
