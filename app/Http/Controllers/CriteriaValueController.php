<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Criteria;
use App\CriteriaValue;
use App\Rule;
use App\RuleCriteria;
use Str;
use Session;

class CriteriaValueController extends Controller
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
        $data['page'] = 'criteria';
        $data['lists'] = CriteriaValue::where('criteria_id', $id)->orderBy('domain_min', 'asc')->get();
        $data['criteria_id'] = Criteria::where('id', $id)->first()->id;
        $data['criteria_name'] = Criteria::where('id', $id)->first()->name;
        return view('criteria_value', $data);
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
        $insert = new CriteriaValue();
        $insert->value = $request->value;
        $insert->domain_min = $request->domain_min;
        $insert->domain_max = $request->domain_max;
        $insert->criteria_id = $request->criteria_id;
        $insert->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil ditambahkan'
        ];

        $batch_id = Criteria::where('id', $request->criteria_id)->first()->batch_id;
        $this->rule_update($batch_id);
        return redirect('criteria_value/detail/'.$request->criteria_id)->with( $status );
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
        $data['edit'] = CriteriaValue::where('id', $id)->first();
        return view('criteria_value_show', $data);
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
        $edit = CriteriaValue::find($id);
        $edit->value = $request->value;
        $edit->domain_min = $request->domain_min;
        $edit->domain_max = $request->domain_max;
        $edit->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil diubah'
        ];

        return redirect('criteria_value/detail/'.$request->criteria_id)->with( $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $criteria_id = CriteriaValue::where('id', $id)->first()->criteria_id;
        $delete = CriteriaValue::find($id);
        $delete->delete();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil dihapus'
        ];

        $batch_id = Criteria::where('id', $criteria_id)->first()->batch_id;
        $this->rule_update($batch_id);
        return redirect('criteria_value/detail/'.$criteria_id)->with( $status ); 
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
