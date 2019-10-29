<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IndesignRenameExports implements FromView
{
    protected $mailing, $mailing_design, $legals, $clinics, $sanitary_codes;
    protected $columns = [];
    protected $names = [];
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
        $clinics = \App\Clinic::withTrashed()->orderBy('city')->find(request('ids'));
        $date = new Carbon($this->mailing->starts_at);
        $year = $date->year;

        foreach ($clinics as $clinic) {
            $name = '';
            $name .= $clinic->fullName . ' ';
            $name .= $this->mailing_design->name . ' ';
            $name .= $year;

            $this->names[] = $name;
        }

        return view('exports.mailing.indesign_rename', [
            'names' => $this->names
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
