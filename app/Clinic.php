<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $guarded = [];
    protected $with = ['county'];
    protected $appends = ['fullName', 'cleanName', 'countyName', 'stateName', 'countryName'];
    protected $casts = ['postal_code' => 'string'];
    protected $stationary = [];

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function schedules()
    {
        return $this->HasMany(Schedule::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function stationaries()
    {
        return $this->belongsToMany(Stationary::class)
            ->withPivot(['id', 'file']);
    }

    public function tableColumns()
    {
        $columns = [
            [
              'name' => 'fullName',
              'label' => 'Clínica',
              'show' => true,
              'linebreak' => [
                'needles' => ['(', 'esq.'],
                'options' => [
                  'small' => true
                ]
              ],
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'fullName',
                'options' => [
                  'search' => ['fullName'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'city',
              'label' => 'Ciudad',
              'show' => false,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'city',
                'options' => [
                  'search' => ['city'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'address_real_1',
              'label' => 'Dirección real 1',
              'show' => true,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'address_real_1',
                'options' => [
                  'search' => ['address_real_1'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'address_real_2',
              'label' => 'Dirección real 2',
              'show' => false,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'address_real_2',
                'options' => [
                  'search' => ['address_real_2'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'address_adv_1',
              'label' => 'Dirección adv 1',
              'show' => false,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'address_adv_1',
                'options' => [
                  'search' => ['address_adv_1'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'address_adv_2',
              'label' => 'Dirección adv 2',
              'show' => false,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'address_adv_2',
                'options' => [
                  'search' => ['address_adv_2'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'postal_code',
              'label' => 'CP',
              'show' => true,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'postal_code',
                'options' => [
                  'search' => ['postal_code'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'phone_real',
              'label' => 'Tel. Real',
              'show' => true,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'phone_real',
                'options' => [
                  'search' => ['phone_real'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'phone_adv',
              'label' => 'Tel. Comercial',
              'show' => false,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'phone_adv',
                'options' => [
                  'search' => ['phone_adv'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'email_ext',
              'label' => 'Email',
              'show' => true,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'email_ext',
                'options' => [
                  'search' => ['email_ext'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'sanitary_code',
              'label' => 'Código Sanitario',
              'show' => false,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'sanitary_code',
                'options' => [
                  'search' => ['sanitary_code'],
                  'noOptions' => true
                ]
              ],
              'width' => '',
            ],
            [
              'name' => 'countyName',
              'label' => 'Provincia',
              'show' => true,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'countyName',
                'options' => [
                  'search' => ['countyName'],
                  'noOptions' => false,
                ],
              ],
              'width' => '',
            ],
            [
              'name' => 'stateName',
              'label' => 'CCAA',
              'show' => true,
              'linebreak' => [
                'needles' => [','],
                'options' => [
                  'small' => true
                ]
              ],
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'stateName',
                'options' => [
                  'search' => ['stateName'],
                  'noOptions' => false,
                ],
              ],
              'width' => '',
            ],
            [
              'name' => 'countryName',
              'label' => 'País',
              'show' => true,
              'sorting' => [
                'active' => true,
              ],
              'filtering' => [
                'active' => true,
                'key' => 'countryName',
                'options' => [
                  'search' => ['countryName'],
                  'noOptions' => false,
                ],
              ],
              'width' => '',
            ],
        ];
        $collection = collect($columns);
        $collection->map(function ($column) {
            return json_encode($column);
        });
        return $collection;
    }

    public function setStationaryLinksAttribute()
    {
        $stationary = \App\Stationary::all();
        $dir = 'stationary/';
        $fullName = $this->getFullNameAttribute();
        foreach ($stationary as $item) {
            $file = $item->description . ' ' . $fullName . '.pdf';
            $this->attributes[$item->description] = storage_path('app/' . $dir . $fullName . '/' . $file);
        }
    }

    public function getStationaryFilesUrl()
    {
        $stationary = \App\Stationary::all();
        $dir = 'stationary/';
        $fullName = $this->getFullNameAttribute();
        foreach ($stationary as $item) {
            $file = $item->description . ' ' . $fullName . '.pdf';
            $this->stationary[$item->description] = storage_path('app/' . $dir . $fullName . '/' . $file);
        }
        return $this;
        // $links = $stationary->filter(function($item) {
        //     $dir = 'stationary/';
        //     $fullName = $this->getFullNameAttribute();
        //     $file = $item->description . ' ' . $fullName . '.pdf';
        //     $item['url'] = storage_path('app/'.$dir . $fullName .'/' . $file);
        //     return $item;
        // });

        // return $links;
    }

    public function getFullNameAttribute()
    {
        $street = trim(str_replace(['C/', 'c/', 's/n', '/'], ['', '', 's.n.', '-'], $this->address_real_1));
        return $this->city . ' (' . $street . ')';
    }

    public function getCleanNameAttribute() {
      $cleanName = cleanString($this->fullName);
      return $cleanName;
    }

    public function getCountyNameAttribute()
    {
        return $this->county->name;
    }

    public function getStateNameAttribute()
    {
        return $this->county->state->name;
    }

    public function getCountryNameAttribute()
    {
        return $this->county->state->country->name;
    }

    public function getPostalCodeAttribute($value)
    {
        while (strlen($value) < 5) {
            $value = '0' . $value;
        }
        return $value;
    }
}
