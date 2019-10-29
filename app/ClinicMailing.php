<?php

namespace App;
use App\Traits\Fileable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClinicMailing extends Qmodel
{
    use Fileable;
    use SoftDeletes;

    protected $fillable = ['mailing_design_id', 'clinic_id', 'clinic_af_file_id', 'printer_id', 'printer_product_id', 'printed_qty', 'distributor_id', 'distributor_service_id', 'distributed_stand_qty', 'distributed_doordrop_qty'];
    protected static $full = ['mailing_design', 'clinic', 'clinic_af', 'printer', 'product', 'distributor', 'service'];
    // protected $appends = ['value', 'label', 'distributed_total_qty'];
    // protected $with = ['clinic', 'clinic_af'];

    protected static $permissions = [
        'view' => [
            'Marketing' => ['*'],
        ]
    ];

    // Quasar DATA
    protected $quasarFormNewLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['mailing_design_id', 'clinic_id', 'file', 'multiFile']
            ],
        ],
    ];
    protected $quasarFormUpdateLayout = [
        [
            'title' => 'Información',
            'subtitle' => 'General',
            'fields' => [
                ['mailing_design_id', 'clinic_id', 'printer_id', 'file', 'multiFile']
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
        'mailing_design_id' => [
            'label' =>'Diseño Buzoneo',
            'type' => [
                'name' =>'select',
                'model' => 'mailing_designs',
                'default' => [
                    'text' => 'Selecciona un Diseño de Buzoneo',
                ],
            ],
        ],
        'printer_id' => [
            'label' =>'Impresor',
            'batch' => true,
            'type' => [
                'name' =>'select',
                'model' => 'providers',
                'default' => [
                    'text' => 'Selecciona un Proveedor',
                ],
            ],
        ],
        'file' => [
          'label' =>'Diseño',
          'unreal' => true,
          'type' => [
            'name' => 'file',
          ],
        ],
        'multiFile' => [
            'unreal' => true,
            'label' =>'Diseño',
            'type' => [
              'name' => 'multiFile',
            ],
        ],
    ];
    protected $onRelationMode = ['table'];
    protected $listFields = [
        'mode' => 'table-grid',
        'left' => [],
        'main' => [
            'thumbnail64' => ['image'],
        ],
        'right' => [
            'file' => ['text']
        ],
    ];
    protected $keyField = 'keyField';
    // END Quasar DATA

    // Tableable DATA
    protected $tableColumns = [
        'clinic.nickname' => [
            'label' => 'Clínica'
        ],
        'clinic.clinic_cloud_id' => [
            'label' => 'CC ID'
        ],
        'clinic_af.thumbnail' => [
            'label' => 'Clinic AF',
            'onGrid' => 'footer',
            'show' => false
        ],
        'mailing_design.name' => [
            'label' => 'Diseño Buzoneo',
            'show' => false
        ],
        'printer.name' => [
            'label' => 'Impresor',
            'show' => false
        ],
        'product.description' => [
            'label' => 'Modelo Impresor',
            'show' => false
        ],
        'printed_qty' => [
            'label' => 'Cantidad Impresa',
        ],
        'printer_total_price' => [
            'label' => 'Precio Impresión',
        ],
        'distributor.name' => [
            'label' => 'Distribuidor',
            'show' => false
        ],
        'service.description' => [
            'label' => 'Modelo Distribuidor',
            'show' => false
        ],
        'service.price' => [
            'label' => 'Tarifa Distribuidor',
        ],
        'distributed_stand_qty' => [
            'label' => 'Distribuido Stand',
        ],
        'distributed_doordrop_qty' => [
            'label' => 'Distribuido Resto',
        ],
        'distributed_total_qty' => [
            'label' => 'Distribuido Total',
        ],
        'distributor_total_price' => [
            'label' => 'Precio Distribución',
        ],
        'total_price' => [
            'label' => 'Precio Total',
        ],
    ];
    // END Table Data

    public function mailing_design() {
        return $this->belongsTo(MailingDesign::class);
    }
    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }
    public function printer() {
        return $this->belongsTo(Provider::class, 'printer_id');
    }
    public function distributor() {
        return $this->belongsTo(Provider::class, 'distributor_id');
    }
    public function product() {
        return $this->belongsTo(ProductProvider::class, 'printer_product_id');
    }
    public function service() {
        return $this->belongsTo(ServiceProvider::class, 'distributor_service_id');
    }

    public function getDistributedTotalQtyAttribute() {
        return round($this->distributed_stand_qty + $this->distributed_doordrop_qty, 2);
    }
    public function getPrinterTotalPriceAttribute() {
        return $this->product ? round($this->product->price * $this->printed_qty, 2) : null;
    }
    public function getDistributorTotalPriceAttribute() {
        return $this->service ? round($this->service->price * $this->distributed_doordrop_qty, 2) : null;
    }
    public function getTotalPriceAttribute() {
        return round($this->printer_total_price + $this->distributor_total_price, 2);
    }

    public function getFileName() {
        $mailingName = $this->mailing_design->mailing->name;
        $type = $this->mailing_design->type;
        $clinic = $this->clinic->cleanName;
        $lang = $this->mailing_design->language['639-1'];

        $name = $mailingName . ' ' . $type . ' ' . $clinic . ' ' . $lang;

        return $name;
    }
}
