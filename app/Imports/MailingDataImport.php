<?php

namespace App\Imports;

use App\ClinicMailing;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class MailingDataImport implements OnEachRow, WithHeadingRow, WithCalculatedFormulas
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
        // dd($this->calculateFormulas);
        if (!$row['cantidad_octavillas_uds'] && !$row['cantidad_dipticos_uds']) return;
        // dd($row);
        $clinics = \App\Clinic::where('clinic_cloud_id', (int) $row['id_clinic_cloud'])->get();
        if ($clinics->count() === 1) {
            $clinic = $clinics->first();
            if ($clinic->siblings()->count() && !$clinic->shareSiblings()) {
                // dump('Dont Share');
                // dump($clinic->nickname);
                if (!in_array($clinic->id, $this->siblingsUsed)) {
                    $share = 1 + $clinic->siblings()->count();
                    $round = 1;
                    $this->saveRow($clinic, $row, $share, $round);
                    $this->siblingsUsed[] = $clinic->id;
                    $round++;
                    foreach($clinic->siblings as $sibling) {
                        $this->saveRow($sibling, $row, $share);
                        $this->siblingsUsed[] = $sibling->id;
                        $round++;
                    }
                }
            } else {
                $this->saveRow($clinic, $row);
            }
        } else {
            foreach ($clinics as $clinic) {
                if  ($clinic->parent_id) continue;
                else if ($clinic->shareSiblings()) {
                    // dump('Share');
                    // dump($clinic->nickname);
                    $this->saveRow($clinic, $row);
                } else if (!$clinic->shareSiblings()) {
                    // dump('Dont Share');
                    // dump($clinic->nickname);
                    if (!in_array($clinic->id, $this->siblingsUsed)) {
                        $share = 1 + $clinic->siblings()->count();
                        $round = 1;
                        $this->saveRow($clinic, $row, $share, $round);
                        $this->siblingsUsed[] = $clinic->id;
                        $round++;
                        foreach($clinic->siblings as $sibling) {
                            $this->saveRow($sibling, $row, $share, $round);
                            $this->siblingsUsed[] = $sibling->id;
                            $round++;
                        }
                    }
                }
                // dump($clinic->nickname);
            }
        }
    }

    public function saveRow ($clinic, $row, $share=false, $round=null) {
        $clinic_mailing = $this->mailing->clinic_mailings()->where('clinic_mailings.clinic_id', $clinic->id)->first();
        $calculate_distributed_doordrop_qty = null;
        $calculate_distributed_stand_qty = null;
        $calculate_printed_qty = null;
        $addDoordrop = 0;
        $addStand = 0;
        $addPrinted = 0;
        if ($clinic_mailing) {
            $distributed_doordrop_qty = $clinic_mailing->mailing_design->type === 'Flyer' ? (int) $row['cantidad_octavillas_uds'] : (int) $row['cantidad_dipticos_uds'];
            $distributed_stand_qty = $row['cantidad_stands_uds'];
            $hasFormula = strpos($distributed_stand_qty, '=');
            if (mb_substr($distributed_stand_qty, 0, 1, 'utf-8') === '=') {
                $cleanString = mb_substr($distributed_stand_qty, 1, null,'utf-8');
                $numbers = explode('+', $cleanString);
                // dump('Has Formula');
                // dump($numbers);
                $distributed_stand_qty = (int) array_sum($numbers);
                // dump($distributed_stand_qty);
            }
            // dump($distributed_stand_qty);
            $distributed_stand_qty = (int) $distributed_stand_qty;
            $printed_qty = $distributed_doordrop_qty + $distributed_stand_qty;
            if ($share) {
                if ($distributed_doordrop_qty%2) {
                    // dump('Odd DoorDrop');
                    // dump($distributed_doordrop_qty);
                    // dump($clinic->nickname);
                    if ($round === 1) {
                        // dump('Round 1');
                        $addDoordrop = 1;
                    }
                }
                if ($distributed_stand_qty%2) {
                    // dump('Odd Stand');
                    if ($round === 1) {
                        // dump('Round 1');
                        $addStand = 1;
                    }
                }
                if ($printed_qty%2) {
                    // dump('Odd Printed');
                    if ($round === 1) {
                        // dump('Round 1');
                        $addPrinted = 1;
                    }
                }
                $calculate_distributed_doordrop_qty = floor($distributed_doordrop_qty / $share);
                $calculate_distributed_stand_qty = floor($distributed_stand_qty / $share);
                $calculate_printed_qty = floor($printed_qty / $share);
            } else {
                $calculate_distributed_doordrop_qty = $distributed_doordrop_qty;
                $calculate_distributed_stand_qty = $distributed_stand_qty;
                $calculate_printed_qty = $printed_qty;
            }
            $clinic_mailing->update([
                'printed_qty' => $calculate_printed_qty + $addPrinted,
                'distributed_stand_qty' => $calculate_distributed_stand_qty + $addStand,
                'distributed_doordrop_qty' => $calculate_distributed_doordrop_qty + $addDoordrop
            ]);
        }
    }
}
