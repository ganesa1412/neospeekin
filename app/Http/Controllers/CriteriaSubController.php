<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Criteria;
use App\CriteriaSub;
use App\Rule;
use App\RuleCriteria;
use Str;
use Session;

class CriteriaSubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('admin-middleware');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id){
        $data['page'] = 'criteria';
        $data['lists'] = CriteriaSub::where('criteria_id', $id)->orderBy('min', 'asc')->get();
        $data['criteria_id'] = Criteria::where('id', $id)->first()->id;
        $data['criteria_name'] = Criteria::where('id', $id)->first()->name;
        return view('criteria_sub', $data);
    }
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['page'] = 'criteria';
        $data['id'] = $id;
        return view('criteria_sub_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = new CriteriaSub();
        $insert->min = $request->min;
        $insert->max = $request->max;
        $insert->criteria_id = $request->criteria_id;
        $insert->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil ditambahkan'
        ];

        return redirect('criteria_sub/detail/'.$request->criteria_id)->with( $status );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page'] = 'criteria';
        $data['edit'] = CriteriaSub::where('id', $id)->first();
        return view('criteria_sub_show', $data);
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
        $edit = CriteriaSub::find($id);
        $edit->min = $request->min;
        $edit->max = $request->max;
        $edit->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil diubah'
        ];

        return redirect('criteria_sub/detail/'.$request->criteria_id)->with( $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $criteria_id = CriteriaSub::where('id', $id)->first()->criteria_id;
        $delete = CriteriaSub::find($id);
        $delete->delete();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil dihapus'
        ];

        return redirect('criteria_sub/detail/'.$criteria_id)->with( $status );
    }
}
