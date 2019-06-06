<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemRol;
use App\Models\Report;
use App\Models\RolStructureItem;
use App\Models\ItemValueReport;
use Auth;

class BuildForm extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id_rol = Auth::user()->roles->pluck('id')[0];
        $items_rol = ItemRol::where('rol_id',$id_rol)->where('parent_id',null)->get();
        print('<table order="1">');
        foreach ($items_rol as $itm) {
            print('<tr style="border:1px dotted black;margin:5px;">');
                print('<td>'.$itm->item.'</td>');
                foreach ($itm->cols as $col) {
                    print('<td>'.$col->columns.'</td>');
                }
            print('</tr>');
            foreach($itm->childs as $ch){
                print('<tr style="border:1px dotted black;margin:5px;">');
                print('<td>'.$ch->item.'</td>');
                foreach ($itm->cols as $col) {
                    print('<td><input type="text" name="" /></td>');
                }
                print('</tr>');
                foreach($ch->childs as $subch){
                    print('<tr style="border:1px dotted black;margin:5px;">');
                    print('<td>'.$subch->item.'</td>');
                    foreach ($itm->cols as $col) {
                        print('<td><input type="text" name="" /></td>');
                    }
                    print('</tr>');
                }


            }

        }



        print('</table>');

        #dd($items_rol);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
