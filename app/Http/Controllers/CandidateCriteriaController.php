<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Criteria;
use App\Candidate;
use App\CandidateCriteria;
use Str;
use Session;

class CandidateCriteriaController extends Controller
{
    public function __construct(){
        $this->middleware('admin-middleware');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id){
        $data['page'] = 'candidate';
        $data['lists'] = CandidateCriteria::select('*', 'candidate_criterias.id as cc_id')->join('criterias', 'criterias.id', 'candidate_criterias.criteria_id')->where('candidate_id', $id)->orderBy('ranking', 'asc')->get();
        // dd($data['lists']);
        $data['candidate_id'] = Candidate::where('id', $id)->first()->id;
        $data['candidate_name'] = Candidate::where('id', $id)->first()->name;
        return view('candidate_criteria', $data);
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
        return view('criteria_value_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
    	$cc = CandidateCriteria::where('candidate_id', $id)->get();
    	foreach ($cc as $c) {
    		$edit = CandidateCriteria::find($c->id);
    		$edit->value = $request->input('value'.$c->id);
    		$edit->save();
    	}

        $batch_id = Candidate::where('id', $id)->first()->batch_id;

        // $edit = CriteriaValue::find($id);
        // $edit->value = $request->value;
        // $edit->domain_min = $request->domain_min;
        // $edit->domain_max = $request->domain_max;
        // $edit->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil diubah',
            'batch' => $batch_id
        ];

        return redirect('candidate')->with( $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
