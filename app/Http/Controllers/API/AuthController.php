<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'name' => 'required|max:255',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken($user->name . '-token')->accessToken;

            $user->load('profiles');
            $user->append('permissions');
            if (count($user->profiles) === 1) {
                $user['profile'] = \App\Profile::with('clinics', 'stores')->find($user->profiles[0]->id)->append('clinicScope', 'storeScope');
            }
            $menus = \App\Menu::get()->toArray();
            if (!$user->isRoot()) {
                $userGroups = collect($user->groupsInfo)->keys()->toArray();
                $routes = [];
                $menuItems = collect();
                foreach ($user->groups as $group) {
                    $groupMenuItems = $group->menu_items;
                    $groupRoutes = $group->menu_items->pluck('to')->all();
                    $routes = array_merge($routes, $groupRoutes);
                    $menuItems = $menuItems->merge($groupMenuItems);
                }
                foreach ($menus AS $key => $parent) {
                    $filteredItems = [];
                    foreach ($parent['shorted_items'] as $i) {
                        // dump($i->toArray());
                        if (!count($i['groups'])) continue;
                        // dump('Here');
                        foreach ($i['groups'] as $menusGroup) {
                            if (in_array($menusGroup['name'], $userGroups)) $filteredItems[] = $i;
                        }
                    }
                    $menus[$key]['filtered_items'] = $filteredItems;
                    unset($menus[$key]['shorted_items']);
                }
            } else {
                foreach ($menus as $key => $parent) {
                    $menus[$key]['filtered_items'] = $parent['shorted_items'];
                    unset($menus[$key]['shorted_items']);
                }
                $routes = \App\MenuItem::get()->pluck('to')->all();
            }
            $routes = array_values(array_filter($routes, function($i) {
                return $i !== null;
            }));

            if (!count($routes)) {
                return response()->json(['message' => 'User has no Accesses Granted'], 403);
            }
            return response()->json(['access_token' => $token, 'user' => $user, 'menus' => $menus, 'routes' => $routes], 200);

            // $http = new \GuzzleHttp\Client;

            // $response = $http->post('http://migabinete.test/oauth/token', [
            //     'form_params' => [
            //         'grant_type' => 'password',
            //         'client_id' => 1,
            //         'client_secret' => 'bpCmaN2o7sVPsu8gtZ3HSgT97YYWuOGw5Pf2WpCk',
            //         'username' => $request->name,
            //         'password' => $request->password,
            //         'scope' => ''
            //     ],
            // ]);

            // return response(
            //     json_decode((string) $response->getBody(), true), 200
            // );

        } else {
            return response('Usuario o contraseña incorrectos', 403);
        }
    }
}
