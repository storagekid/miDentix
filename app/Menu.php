<?php

namespace App;

class Menu
{
    protected $items = [
        'Profile' => [
            'name' => 'Perfil',
            'link' => '/profile',
            'icon' => 'glyphicon glyphicon-user'
        ],
        'CPanel' => [
            'name' => 'Panel de Control',
            'link' => '/home',
            'icon' => 'glyphicon glyphicon-dashboard'
        ],
        'Requests' => [
            'name' => 'Necesidades',
            'link' => '/requests',
            'icon' => 'glyphicon glyphicon-bullhorn'
        ],
        'ExtraTime' => [
            'name' => 'Bolsa de Horas',
            'link' => '/extratime',
            'icon' => 'glyphicon glyphicon-time'
        ],
        'Schedule' => [
            'name' => 'Jornada',
            'link' => '/schedule',
            'icon' => 'glyphicon glyphicon-time'
        ],
        'Masters' => [
            'name' => 'Cursos',
            'link' => '#',
            'icon' => 'glyphicon glyphicon-education'
        ],
        'Protocols' => [
            'name' => 'Protocolos',
            'link' => '#',
            'icon' => 'glyphicon glyphicon-file'
        ],
        'Surveys' => [
            'name' => 'Encuestas',
            'link' => '#',
            'icon' => 'glyphicon glyphicon-list-alt'
        ],
        'Clinics' => [
            'name' => 'Clínicas',
            'link' => '/clinics',
            'icon' => 'glyphicon glyphicon-home'
        ],
        'Papers' => [
            'name' => 'Informes',
            'link' => '#',
            'icon' => 'glyphicon glyphicon-file'
        ],
        'Users' => [
            'name' => 'Usuarios',
            'link' => '/users',
            'icon' => 'glyphicon glyphicon-user'
        ],
        'Dentists' => [
            'name' => 'Odontólogos',
            'link' => '/dentists',
            'icon' => 'glyphicon glyphicon-user'
        ],
        'Tools' => [
            'name' => 'Tools',
            'link' => '/tools',
            'icon' => 'glyphicon glyphicon-wrench'
        ],
        'Stationary' => [
            'name' => 'Papeleria',
            'link' => '/stationary',
            'icon' => 'glyphicon glyphicon-duplicate'
        ],
        'PersonalTags' => [
            'name' => 'Identificadores',
            'link' => '/personal-tags',
            'icon' => 'glyphicon glyphicon-tags'
        ],
        'MedicalDirectory' => [
            'name' => 'Cuadro Médico',
            'link' => '/directory',
            'icon' => 'glyphicon glyphicon-th-list'
        ],
        'Orders' => [
            'name' => 'Pedidos',
            'link' => '/orders',
            'icon' => 'glyphicon glyphicon-transfer'
        ],
        'Providers' => [
            'name' => 'Proveedores',
            'link' => '/providers',
            'icon' => 'glyphicon glyphicon-briefcase'
        ],
    ];

    public function get($list)
    {
        $userMenu = [];
        foreach ($list as $name) {
            $userMenu[] = $this->items[$name];
        };
        return $userMenu;
    }
}
