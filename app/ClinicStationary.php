<?php

namespace App;

use App\Traits\Fileable;
use App\Printers\StationaryCustomizablePrinter as StationaryPrinter;

class ClinicStationary extends Qmodel
{
    use Fileable;

    protected $fillable = ['clinic_id', 'product_id', 'af_file_id'];
    protected static $permissions = [
        'view' => ['*']
    ];
    protected static $full = ['clinic', 'product', 'af'];
    // Quasar DATA
    protected $onRelationMode = ['table'];
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['clinic_id', 'product_id', 'af_file_id']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['clinic_id', 'product_id', 'af_file_id']
            ],
        ]
    ];
    protected $quasarFormFields = [
        'clinic_id' => [
            'label' =>'Clínica',
            'type' => [
                'name' =>'select',
                'model' => 'clinics',
                'default' => [
                    'text' => 'Selecciona una Clínica',
                ],
            ],
        ],
        'product_id' => [
            'label' =>'Material',
            'type' => [
                'name' =>'select',
                'model' => 'products',
                'default' => [
                    'text' => 'Selecciona un Material',
                ],
            ],
        ],
        'af_file_id' => [
            'label' =>'AAFF',
            'type' => [
                'name' => 'file',
                'thumbnail' => true,
                'public' => false,
                'permissions' => '740'
            ],
        ],
    ];
    protected $listFields = [
        'mode' => 'table',
        'left' => [],
        'main' => [
            'name' => ['text'],
        ],
        'right' => [],
    ];
    protected $keyField = 'name';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'clinic.nickname' => [
            'label' => 'Clínica',
        ],
        'product.description' => [
            'label' => 'Material',
        ],
    ];
    // END Tableable Data

    public function product() {
    	return $this->belongsTo(Product::class);
    }
    public function clinic() {
    	return $this->belongsTo(Clinic::class);
    }

    public function makeStationary() {
        try {
            $pdf = new StationaryPrinter($this->clinic, $this->product);
            $pdfFile = $pdf->makeStationary();
            $fileRoute = $pdfFile->directory . $pdfFile->fileName;
            if (!$pdfFile) return null;
            $formFields = $this->getFileFields();
            $name = $this->getFileNames('af_file_id');
            $path = $this->getFilePaths('af_file_id');
            $thumbnail = $formFields['af_file_id']['type']['thumbnail'];
            $public = $formFields['af_file_id']['type']['public'];
            $permissions = $formFields['af_file_id']['type']['permissions'];

            // dump($fileRoute);
            // dump($name);
            // dump($path);
            // dd('Testing');
            $file = $this->saveFile($fileRoute, 'af_file_id');
            // $file = \App\ClinicStationary::storeFile($pdfFile->directory . $pdfFile->fileName, $path, $name, $thumbnail, auth()->user()->id, auth()->user()->group_users()->first()->group_id, $public, true, $permissions);
            return $file;
        } catch (\Exception $e) {
            abort(301, 'Incomplete File Data.');
        }
    }

    public function getFileNames($field = 'af_file_id') {
        switch ($field) {
            case 'af_file_id':
                return $this->product->description . ' ' . $this->clinic->cleanName;
                break;
            default:
                abort(301, 'Campo de archivo erróneo');
                break;
        }
    }
    public function getFilePaths($field = 'af_file_id') {
        switch ($field) {
            case 'af_file_id':
                return 'clinics/' . $this->clinic->id . '/stationaries';
                break;
            default:
                abort(301, 'Campo de archivo erróneo');
                break;
        }
    }
}
