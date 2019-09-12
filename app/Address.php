<?php

namespace App;

class Address extends Qmodel
{
    protected $fillable = ['address_line_1', 'address_line_2', 'type','description','main'];
    protected $casts = ['main' => 'boolean'];
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
                ['address_line_1','address_line_2','description','type','main']
            ],
        ],
    ];
    protected $quasarFormFields = [
        'address_line_1' => [
            'label' =>'Dirección',
        ],
        'address_line_2' => [
            'label' =>'Dirección (detalle)',
        ],
        'description' => [
            'label' =>'Descripción',
        ],
        'type' => [
            'label' =>'Tipo',
            'type' => [
                'name' =>'array',
                'array' => ['Fiscal', 'Comercial', 'Oficina', 'Casa'],
                'default' => [
                    'value' => null,
                    'text' => 'Selecciona un Tipo',
                    'disabled' => true,
                ],
            ],
        ],
        'main' => [
            'label' =>'Principal',
            'type' => [
                'name' =>'boolean',
                'default' => [
                    'text' => '¿Es el principal?',
                ],
            ],
        ]
    ];
    protected $listFields = [
        'left' => [
            'type' => ['chips'],
        ],
        'main' => [
            'address_line_1' => ['text'],
            'address_line_2' => ['text'],
            'main' => ['boolean'],
        ],
        'right' => [
            'description' => [],
        ],
    ];
    protected $keyField = 'address_line_1';
    // END Quasar DATA

    public function addressable()
    {
        return $this->morphTo();
    }
    public function setMainAttribute($value)
    {
        $this->attributes['main'] = (int)($value === 'true');
    }
    public function getCleanStreetAttribute() {
        $address = $this->address_line_1;
        $address = str_replace(['C/', 'c/', 'Rúa', 'Pl.', 'Pl ', 'Av.', 'P.º', 'Pg.', 'Rbla.', 'C.º', 'Ctra.', 'Ptge.', 'L\'', '\'', '’', '´'], '', $address);
        $address = str_replace(['s/n', '/'], ['s.n.', '-'], $address);
        return trim($address);
        // return trim(str_replace(['C/', 'c/', 's/n', '/'], ['', '', 's.n.', '-'], $this->address_line_1));
    }
    public function getCleanAddresstAttribute() {
        return trim(str_replace(['C/', 'c/', 's/n', '/'], ['', '', 's.n.', '-'], ($this->address_line_1 . ' ' . $this->address_line_2)));
    }
}
