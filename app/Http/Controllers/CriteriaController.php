<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;
use Session;
use App\Criteria;
use App\CriteriaValue;
use App\CriteriaSub;
use App\Candidate;
use App\CandidateCriteria;
use App\Rule;
use App\RuleCriteria;
use App\Batch;
use Illuminate\Support\Facades\DB;


class CriteriaController extends Controller
{
    public function __construct(){
        $this->middleware('admin-middleware');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page'] = 'criteria';
        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['isPost'] = false;
        return view('criteria', $data);
    }
    public function batch(Request $req){
        $data['page'] = 'criteria';
        $data['isPost'] = true;

        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $data['lists'] = Criteria::orderBy('ranking', 'asc')->where('batch_id', $req->batch)->get();
        $data['lists2'] = CriteriaValue::orderBy('domain_min', 'asc')->get();
        $data['lists3'] = CriteriaSub::orderBy('min', 'desc')->get();

        $data['batch'] = $req->batch;
        // print_r($data['lists']);
        return view('criteria', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($batch)
    {
        $data['page'] = 'criteria';

        $data['batch'] = $batch;
        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('criteria_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = new Criteria();
        $insert->name = $request->name;
        $insert->ranking = $request->ranking;
        $insert->batch_id = $request->batch;
        $insert->save();

        $candidate = Candidate::where('batch_id', $request->batch)->get();
        foreach ($candidate as $c) {
            $insert2 = new CandidateCriteria();
            $insert2->criteria_id = $insert->id;
            $insert2->candidate_id = $c->id;
            $insert2->save();
        }

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil ditambahkan',
            'batch' => $request->batch
        ];

        return redirect('criteria')->with( $status );
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

        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $data['edit'] = Criteria::where('id', $id)->first();
        $data['batch'] = $data['edit']->batch_id;
        return view('criteria_show', $data);
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
        $edit = Criteria::find($id);
        $edit->name = $request->name;
        $edit->ranking = $request->ranking;
        $edit->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil diubah',
            'batch' => $request->batch
        ];

        return redirect('criteria')->with( $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Criteria::find($id);
        $batch_id = $delete->batch_id;
        $delete->delete();

        $cc = CandidateCriteria::where('criteria_id', $id)->get();
        foreach ($cc as $c) {
            $delete2 = CandidateCriteria::find($c->id);
            $delete2->delete();
        }
        
        $cv = CriteriaValue::where('criteria_id', $id)->get();
        foreach ($cv as $c) {
            $delete3 = CriteriaValue::find($c->id);
            $delete3->delete();
        }

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil dihapus',
            'batch' => $batch_id
        ];

        $this->rule_update($batch_id);
        return redirect('criteria')->with( $status );
    }

    public function rule_update($batch_id){
        $rule = Rule::where('batch_id', $batch_id)->get();
        foreach ($rule as $rl) {
            RuleCriteria::where('rule_id', $rl->id)->delete();
        }
        Rule::where('batch_id', $batch_id)->delete();

        $criteria = Criteria::where('batch_id', $batch_id)->get();
        $ccount = Criteria::where('batch_id', $batch_id)->count();
        foreach ($criteria as $key => $cr) {
            $criteria_value = CriteriaValue::select('id', 'value')->where('criteria_id', $cr->id)->get();
            $array_id[$key] = Array();
            foreach ($criteria_value as $cv) {
                array_push($array_id[$key], $cv->id);
            }
        }
        $result = [[]];
        foreach ($array_id as $property => $property_values) {
            $temp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $temp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $temp;
        }

        foreach ($result as $r) {
            $insert = new Rule();
            $insert->result_id = 0;
            $insert->batch_id = $batch_id;
            $insert->save();
            foreach ($criteria as $i => $c) {
                $insert2 = new RuleCriteria();
                $insert2->criteria_id = $c->id;
                $insert2->value_id = $r[$i];
                $insert2->rule_id = $insert->id;
                $insert2->save();
            }
        }
    }
}
