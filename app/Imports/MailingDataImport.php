<?php

namespace App\Imports;

use App\ClinicMailing;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MailingDataImport implements OnEachRow, WithHeadingRow
{
    protected $mailing;
    protected $clinic_mailings;
    protected $siblingsUsed = [];

    public function __construct($mailing)
    {
        $this->mailing = $mailing;
        $this->clinic_mailings = $mailing->clinic_mailings;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();
        if (!$row['cantidad_octavillas_uds']) return;
        // dd($row);
        $clinics = \App\Clinic::where('clinic_cloud_id', (int) $row['id_clinic_cloud'])->get();
        if ($clinics->count() === 1) {
            $clinic = $clinics->first();
            if ($clinic->siblings()->count() && !$clinic->shareSiblings()) {
                dump('Dont Share');
                dump($clinic->nickname);
                if (!in_array($clinic->id, $this->siblingsUsed)) {
                    $share = 1 + $clinic->siblings()->count();
                    $this->saveRow($clinic, $row, $share);
                    $this->siblingsUsed[] = $clinic->id;
                    foreach($clinic->siblings as $sibling) {
                        $this->saveRow($sibling, $row, $share);
                        $this->siblingsUsed[] = $sibling->id;
                    }
                }
            } else {
                $this->saveRow($clinic, $row);
            }
        } else {
            foreach ($clinics as $clinic) {
                if  ($clinic->parent_id) continue;
                else if ($clinic->shareSiblings()) {
                    dump('Share');
                    dump($clinic->nickname);
                    $this->saveRow($clinic, $row);
                } else if (!$clinic->shareSiblings()) {
                    dump('Dont Share');
                    dump($clinic->nickname);
                    if (!in_array($clinic->id, $this->siblingsUsed)) {
                        $share = 1 + $clinic->siblings()->count();
                        $this->saveRow($clinic, $row, $share);
                        $this->siblingsUsed[] = $clinic->id;
                        foreach($clinic->siblings as $sibling) {
                            $this->saveRow($sibling, $row, $share);
                            $this->siblingsUsed[] = $sibling->id;
                        }
                    }
                }
                // dump($clinic->nickname);
            }
        }
    }

    public function saveRow ($clinic, $row, $share=false) {
        $clinic_mailing = $this->mailing->clinic_mailings()->where('clinic_mailings.clinic_id', $clinic->id)->first();
        if ($clinic_mailing) {
            $distributed_doordrop_qty = $clinic_mailing->mailing_design->type === 'Flyer' ? (int) $row['cantidad_octavillas_uds'] : (int) $row['cantidad_dipticos_uds'];
            $distributed_stand_qty = (int) $row['cantidad_stands_uds'];
            $printed_qty = $distributed_doordrop_qty + $distributed_stand_qty;
            if ($share) {
                $distributed_doordrop_qty = $distributed_doordrop_qty / $share;
                $distributed_stand_qty = $distributed_stand_qty / $share;
                $printed_qty = $printed_qty / $share;
            }
            $clinic_mailing->update([
                'printed_qty' => $printed_qty,
                'distributed_stand_qty' => $distributed_stand_qty,
                'distributed_doordrop_qty' => $distributed_doordrop_qty
            ]);
        }
    }
}
