<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImeiUser;
use App\DeliveryTeam;
use App\LocationTmp;
use App\User;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /*ini_set('memory_limit','1024M');
        //dd(date('W',strtotime('2019-04-24')));
        //$now = Carbon::now()->format('Y-m-d');
        //$now = Carbon::now()->setTimestamp(strtotime('2019-04-17'));
        //dd($now->weekOfYear);
        //dd($now->startOfWeek()->format('Y-m-d H:i'));
        //dd($now->endOfWeek());
        //->whereDate('reported_date', '=', $now)
        $now = Carbon::now()->format('Y-m-d');
        $users = User::role('Proveedor')
                        ->where('active',true)
                        ->with('tmplocation')
                        ->get();
        $locations = $users->filter(function($i){
             return sizeof($i->tmplocation) > 0;
        });
        $locations = $users->filter(function($i){
                             return sizeof($i->tmplocation) > 0;
                        })->map(function($i){
                                $userName = $i->name." ".$i->paterno." ".$i->materno;
                                    return [
                                        $i->tmplocation->first()->id,
                                        $i->tmplocation->first()->latitude,
                                        $i->tmplocation->first()->longitude,
                                        $userName,
                                        "Desayunos Escolares - Proveedor",
                                        Carbon::parse($i->tmplocation->first()->created_at)->format('d-m-Y h:i:s A')
                                    ];
        })->values();
        $deliveryteam = DeliveryTeam::select('id','delivery_truck_id','driver_delivery_man')
                                    ->where('active',true)
                                    ->with(array('truck', 'driver','programada' => function($query) use($now){
                                             $query->whereDate('shipping_date', '=', $now);
                                        },'entregada' => function($query) use($now){
                                             $query->whereDate('delivery_date', '=', $now);
                                        }))
                                    ->get();
        $deliveryteam = $deliveryteam->map(function($i){
            $i->programadas = $i->programada->unique('cct');
            $i->entregadas = $i->entregada->unique('cct');
            return $i;
        });

        $startWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
        $deliveryteamweek = DeliveryTeam::select('id','delivery_truck_id','driver_delivery_man')
                                    ->where('active',true)
                                    ->with(array('truck', 'driver','programada' => function($query) use($startWeek, $endWeek){
                                             $query->whereBetween('shipping_date', [$startWeek,$endWeek]);
                                        },'entregada' => function($query) use($startWeek, $endWeek){
                                             $query->whereBetween('delivery_date', [$startWeek,$endWeek]);
                                        }))
                                    ->get();
        $deliveryteamweek = $deliveryteamweek->map(function($i){
            $i->programadas = $i->programada->unique('cct');
            $i->entregadas = $i->entregada->unique('cct');
            return $i;
        });*/

        $users = [];
        $deliveryteamweek = [];
        $locations = json_encode([]);
        $deliveryteam = [];

        return view('home', compact('users','deliveryteam','locations','deliveryteamweek'));
    }

    public function menu(){
        return \View::make('home');
    }

    public function getDataUser(Request $request){
        //dd($request->all());
        if($request->date == null){
            $start_date = now();
            $request->merge([
                'date' => $start_date
            ]);
        }
        $imei = User::select('imei','name','paterno','materno')->findOrFail($request->user);
        $locations = LocationTmp::select('id','imei','latitude','longitude','created_at as fecha')
                            ->where('imei',$imei->imei)
                            ->whereDate('created_at', '=', $request->date)
                            ->where('active',true)
                            ->orderBy('created_at')
                            ->get();
        $userName = $imei->name." ".$imei->paterno." ".$imei->materno;   
        $locations = $locations->map(function($i) use($userName){
             return [
                $i->id,
                $i->latitude,
                $i->longitude,
                $userName,
                "Desayunos Escolares - Proveedor",
                Carbon::parse($i->fecha)->format('d-m-Y h:i:s')
            ];
        });
        return $locations;
    }
    
    public function getDataTableToday(){
        $now = Carbon::now()->format('Y-m-d');
        $deliveryteam = DeliveryTeam::select('id','delivery_truck_id','driver_delivery_man')
                                    ->where('active',true)
                                    ->with(array('truck', 'driver','programada' => function($query) use($now){
                                             $query->whereDate('shipping_date', '=', $now);
                                        },'entregada' => function($query) use($now){
                                             $query->whereDate('delivery_date', '=', $now);
                                        }))
                                    ->get();
        $deliveryteam = $deliveryteam->map(function($i){
            $i->programadas = $i->programada->unique('cct');
            $i->entregadas = $i->entregada->unique('cct');
            return $i;
        }); 
        /*$html = \View::make('inicio.tabla', compact('deliveryteam'));
        return [
            'html' => $html->render()
        ];*/
        return $deliveryteam->toJson();
    }

    public function getDataTableWeek(){
        $now = Carbon::now()->format('Y-m-d');
        $startWeek = $now->startOfWeek()->format('Y-m-d');
        $endWeek = $now->endOfWeek()->format('Y-m-d');
        //->whereBetween('reported_date', [$startWeek,$endWeek]);
        $deliveryteam = DeliveryTeam::select('id','delivery_truck_id','driver_delivery_man')
                                    ->where('active',true)
                                    ->with(array('truck', 'driver','programada' => function($query) use($startWeek, $endWeek){
                                             $query->whereBetween('shipping_date', [$startWeek,$endWeek]);
                                        },'entregada' => function($query) use($startWeek, $endWeek){
                                             $query->whereDate('delivery_date', [$startWeek,$endWeek]);
                                        }))
                                    ->get();
        $deliveryteam = $deliveryteam->map(function($i){
            $i->programadas = $i->programada->unique('cct');
            $i->entregadas = $i->entregada->unique('cct');
            return $i;
        });
        $html = \View::make('inicio.tabla', compact('deliveryteam'));
        return [
            'html' => $html->render()
        ];
    }
}
