<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Formable;
use App\Traits\Tableable;

class Provider_Stationary extends Model
{
    use Formable;
    use Tableable;

    protected $fillable = ['provider_id', 'country_id', 'state_id', 'county_id', 'clinic_id'];

    protected $table = 'product_providers';

    protected $appends = ['providerName', 'countryName', 'stateName', 'countyName', 'clinicName'];

    // TABLE
    protected $tableColumns = [
        'providerName' => [
            'label' => 'Nombre'
        ], 
        'countryName' => [
            'label' => 'País',
            'filtering' => ['search']
        ],
        'stateName' => [
            'label' => 'CCAA',
            'filtering' => ['search']
        ],
        'countyName' => [
            'label' => 'Provincia',
            'filtering' => ['search']
        ],
        'clinicName' => [
            'label' => 'Clínica',
            'filtering' => ['search']
        ],
    ];

    protected $tableOptions = [['show','edit','delete'], true, true];    

    // FORM

    protected $formFields = [
        'country_id' => [
            'label' => 'País',
            'rules' => ['required'],
            'name' => 'country_id',
            'value' => null,
            'dontRecord' => false,
            'affects' => 'state_id',
            'type' => [
              'name' => 'select',
              'model' => 'countries',
              'text' => 'name',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona un País',
                'disabled' => true,
              ],
            ],
            'batch' => true,
          ],
          'state_id' => [
            'label' => 'CCAA',
            'rules' => [],
            'name' => 'state_id',
            'value' => null,
            'dontRecord' => false,
            'dependsOn' => 'country_id',
            'affects' => 'county_id',
            'type' => [
              'name' => 'select',
              'model' => 'states',
              'text' => 'name',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona una CCAA',
                'disabled' => true,
              ],
            ],
            'batch' => true,
          ],
          'county_id' => [
            'label' => 'Provincia',
            'rules' => [],
            'name' => 'county_id',
            'value' => null,
            'dependsOn' => 'state_id',
            'affects' => 'clinic_id',
            'type' => [
              'name' => 'select',
              'model' => 'counties',
              'text' => 'name',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona una Provincia',
                'disabled' => true,
              ],
            ],
            'batch' => true,
          ],
          'clinic_id' => [
            'label' => 'Clínica',
            'rules' => [],
            'name' => 'clinic_id',
            'value' => null,
            'dontRecord' => false,
            'dependsOn' => 'county_id',
            'type' => [
              'name' => 'select',
              'model' => 'clinics',
              'text' => 'fullName',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona una Clínica',
                'disabled' => true,
              ],
            ],
            'batch' => true,
          ],
          'provider_id' => [
            'label' => 'Proveedor',
            'rules' => ['required'],
            'name' => 'provider_id',
            'value' => null,
            'dontRecord' => false,
            'type' => [
              'name' => 'select',
              'model' => 'providers',
              'text' => 'name',
              'value' => 'id',
              'default' => [
                'value' => null,
                'text' => 'Selecciona un Proveedor',
                'disabled' => true,
              ],
            ],
          ],
    ];

    protected $formModels = ['countries','counties','states','providers'];

    public function provider() {
        return $this->belongsTo(Provider::class);
    }
    public function country() {
        return $this->belongsTo(Country::class);
    }
    public function state() {
        return $this->belongsTo(State::class);
    }
    public function county() {
        return $this->belongsTo(County::class);
    }
    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }


    public function getProviderNameAttribute() {
        return $this->provider ? $this->provider->name : null;
    }
    public function getCountryNameAttribute() {
        return $this->country ? $this->country->name : null;
    }
    public function getStateNameAttribute() {
        return $this->state ? $this->state->name : null;
    }
    public function getCountyNameAttribute() {
        return $this->county ? $this->county->name : null;
    }
    public function getClinicNameAttribute() {
        return $this->clinic ? $this->clinic->fullName : null;
    }
}
