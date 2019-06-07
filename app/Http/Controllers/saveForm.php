<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemRol;
use App\Models\Report;
use App\Models\RolStructureItem;
use App\Models\ItemValueReport;
use Auth;

class saveForm extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



        $id_rol = Auth::user()->roles->pluck('id')[0];
        $items_rol = ItemRol::where('rol_id',$id_rol)->where('parent_id',null)->get();
        print('<table order="1"><form action="/saveform" method="post">');
        print('<tr>');
        print('<td><input type="text" name="start" />');
        print('<td><input type="text" name="end" />');
        print('</td>');
        print('</tr>');

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
                    print('<td><input type="text" name="f_'.$id_rol.'_'.$col->id.'_'.$ch->id.'" /></td>');
                }
                print('</tr>');
                foreach($ch->childs as $subch){
                    print('<tr style="border:1px dotted black;margin:5px;">');
                    print('<td>'.$subch->item.'</td>');
                    foreach ($itm->cols as $col) {
                        print('<td><input type="text" name="f_'.$id_rol.'_'.$col->id.'_'.$subch->id.'" /></td>');
                    }
                    print('</tr>');
                }


            }

        }



        print('<tr><td><input type="hidden" name="_token" value="'.$request->session()->token().'"><input type="submit"/></td></tr></form></table>');



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $post = $request->post();
        $id_rol = Auth::user()->roles->pluck('id')[0];
        $user_id = Auth::user()->id;
        $report = Report::create([
            'rol_id'=>$id_rol,
            'created_by'=>$user_id,
            'date_start'=>$post['start'],
            'date_end'=>$post['end'],
            'active'=>true
        ]);
        foreach ($post as $key => $value) {

            $field = strpos($key,'f_');
            if($field>-1 and strlen($value)>-1){
                $pices = explode('_', $key);
                $ivr = ItemValueReport::firstOrCreate([
                    'report_id'=>$report->id,
                    'item_rol_id'=>$pices[3],
                    'item_col_id'=>$pices[2]
                ]);
                $ivr->valore = $value;
                $ivr->save();
            }
        }
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
    public function edit($id,Request $request)
    {
        $report = Report::find($id);

        if($report==null){
            return 'No report allowed';
        }

        $id_rol = $report->rol_id;
        $items_rol = ItemRol::where('rol_id',$id_rol)->where('parent_id',null)->get();
        $items_values = ItemValueReport::where('report_id',$report->id)->get();
        $vals = [];
        foreach ($items_values as $itve) {
            $vals[$itve->item_col_id][$itve->item_rol_id]=[
                'value'=>$itve->valore,
                'id'=>$itve->id
            ];
        }

        print('<table order="1"><form action="/updateform/" method="post">');
        print('<tr>');
        print('<td><input type="hidden" name="report_id" value="'.$report->id.'"  />');
        print('<input type="text" name="start" value="'.$report->date_start.'"  />');
        print('<input type="text" name="end" value="'.$report->date_end.'"  />');
        print('</td>');
        print('</tr>');

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
                    print('<td><input type="text" name="f_'.$vals[$col->id][$ch->id]['id'].'" value="'.$vals[$col->id][$ch->id]['value'].'" /></td>');
                }
                print('</tr>');
                foreach($ch->childs as $subch){
                    print('<tr style="border:1px dotted black;margin:5px;">');
                    print('<td>'.$subch->item.'</td>');
                    foreach ($itm->cols as $col) {
                        print('<td><input type="text" name="f_'.
                            $vals[$col->id][$ch->id]['id'].'" value="'.$vals[$col->id][$subch->id].'" /></td>');
                    }
                    print('</tr>');
                }


            }

        }



        print('<tr><td><input type="hidden" name="_token" value="'.$request->session()->token().'"><input type="submit"/></td></tr></form></table>');



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $post = $request->post();
        $report = Report::find($post['report_id']);
        $report->date_start=$post['start'];
        $report->date_end=$post['end'];
        $report->save();
                foreach ($post as $key => $value) {

            $field = strpos($key,'f_');
            if($field>-1 and strlen($value)>-1){
                $pices = explode('_', $key);
                $ivr = ItemValueReport::find($pices[1]);
                $ivr->valore = $value;
                $ivr->save();
            }
        }

        

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
