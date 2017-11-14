<?php
namespace App;

class Menu {
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
		 	'link' => '#',
		 	'icon' => 'glyphicon glyphicon-home'
		],
		'Papers' => [
			'name' => 'Informes', 
		 	'link' => '#',
		 	'icon' => 'glyphicon glyphicon-file'
		],
		'Users' => [
			'name' => 'Usuarios', 
		 	'link' => '#',
		 	'icon' => 'glyphicon glyphicon-user'
		]
	];
	public function get($list) {
		$userMenu = array();
		foreach ($list as $name) {
			$userMenu[] = $this->items[$name];
		};
		return $userMenu;
	}
}