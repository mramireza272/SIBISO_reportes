<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use \Spatie\Permission\Models\Role;

class Navigation
{
    private $menus;

    function __construct(){
        //$this->menus = [];

        $url = str_replace(url('/'),'',url()->current());
        $this->menus = [
            'Menu principal'    => [
                'url'     => url('/home'),
                'active'  => ($url == '') ? ' class="active-sub"' : '',
                'icon'    => 'pli-home',
            ],
        ];

        if(Auth::check()){
            if(Auth::user()->hasRole(['SIBISO', 'Administrador'])){
                $this->menus['Bitácora'] = [
                    'url'     => route('bitacora.index'),
                    'active' => (strpos($url, str_replace(url('/'), '', '/bitacora')) !== false) ? ' class="active-sub"' : '',
                    'icon'   => 'pli-bulleted-list'
                ];
            }

            
            if(Auth::user()->hasPermissionTo('index_form')){
                $this->menus['Formularios'] = [
                    'url'    => url('/formularios'),
                    'active' => (strpos($url, str_replace(url('/'), '', '/formularios')) !== false) ? ' class="active-sub"' : '',
                    'icon'   => 'pli-full-view-2'
                ];
            }
            
            if(Auth::user()->hasPermissionTo('index_user')){
                $this->menus['Usuarios'] = [
                    'url'    => url('/usuarios'),
                    'active' => (strpos($url, str_replace(url('/'), '', '/usuarios')) !== false) ? ' class="active-sub"' : '',
                    'icon'   => 'pli-male-female'
                ];
            }

            if(Auth::user()->hasPermissionTo('index_roles')){
                $this->menus['Roles'] = [
                    'url'    => url('/roles'),
                    'active' => (strpos($url, str_replace(url('/'), '', '/roles')) !== false) ? ' class="active-sub"' : '',
                    'icon'   => 'pli-id-card'
                ];

                $this->menus['Permisos'] = [
                    'url'    => url('/permisos'),
                    'active' => (strpos($url, str_replace(url('/'), '', '/permisos')) !== false) ? ' class="active-sub"' : '',
                    'icon'   => 'pli-key'
                ];
            }

            if(Auth::user()->hasAnyPermission(['index_ined', 'index_cgib', 'index_asc', 'index_sdh', 'index_iapp'])){
                $this->menus['Reportes'] = [
                    'url'    => url('/reportes'),
                    'active' => (strpos($url, str_replace(url('/'), '', '/reportes')) !== false) ? ' class="active-sub"' : '',
                    'icon'   => 'pli-notepad-2'
                ];
            }
        }

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $menu = collect($this->menus);
        \Session::put('Current.menu', $menu);
        return $next($request);
    }
}
