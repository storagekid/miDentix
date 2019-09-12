<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class WildCardExports implements FromCollection
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->model::get();
    }
}
