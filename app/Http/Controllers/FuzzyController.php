<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rule;
use App\RuleCriteria;
use App\Criteria;
use App\CriteriaValue;
use App\Candidate;
use App\CandidateCriteria;
use App\Batch;
use App\Result;
use Illuminate\Support\Facades\DB;

class FuzzyController extends Controller
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
        $data['page'] = 'fuzzy';

        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['isPost'] = false;

        return view('fuzzy', $data);
    }
    public function batch(Request $req){
        $data['page'] = 'fuzzy';

        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['isPost'] = true;        

        $data['batch'] = $req->batch;

        $data['criteria'] = Criteria::orderBy('ranking', 'asc')->where('batch_id', $req->batch)->get();
        $data['cvalue'] = CriteriaValue::orderBy('domain_min', 'asc')->orderBy('domain_max', 'asc')->get();

        // Input
        foreach ($data['criteria'] as $c) {
            $abc[$c->id] = [];
            foreach ($data['cvalue'] as $cv) {
                if ($cv->criteria_id == $c->id) {
                    array_push($abc[$c->id], $cv->domain_min);
                    array_push($abc[$c->id], $cv->domain_max);
                }
            }
            sort($abc[$c->id]);
            $unique = array_unique($abc[$c->id]);
            $data['abc'][$c->id] = array_values($unique);
        }
        
        // Output
        $abc_output = [];
        foreach ($data['cvalue'] as $cv) {
            if ($cv->criteria_id == 0) {
                array_push($abc_output, $cv->domain_min);
                array_push($abc_output, $cv->domain_max);
            }
        }
        sort($abc_output);
        $unique = array_unique($abc_output);
        $data['abc_output'] = array_values($unique);

        // Fuzzifikasi
        $data['candidate'] = Candidate::orderBy('name', 'asc')->where('batch_id', $req->batch)->get();
        $data['ccount'] = Criteria::where('batch_id', $req->batch)->count();
        $data['ccr'] = [[]];
        foreach ($data['candidate'] as $cd) {
            foreach ($data['criteria'] as $cr) {
                $ccr = CandidateCriteria::where([
                    ['criteria_id', $cr->id],
                    ['candidate_id', $cd->id]
                ])->first();
                $data['ccr'][$cd->id][$cr->id] = $ccr->value;
            }
        }
        $candidate_criteria = CandidateCriteria::all();
        $data['f'] = [];
        foreach ($candidate_criteria as $cr) {
            $batch = Criteria::where('id', $cr->criteria_id)->first()->batch_id;
            if ($batch == $req->batch) {
                foreach ($data['cvalue'] as $cv) {
                    if ($cv->criteria_id == $cr->criteria_id) {
                        $x = $data['ccr'][$cr->candidate_id][$cr->criteria_id];
                        $a = $data['abc'][$cr->criteria_id][0];
                        $b = $data['abc'][$cr->criteria_id][1];
                        $c = $data['abc'][$cr->criteria_id][2];
                        if($cv->domain_min == $abc[$cr->criteria_id][0] && $cv->domain_max < end($abc[$cr->criteria_id])){
                            // Kurva Turun
                            $f;
                            if ($x >= $b) {
                                $f = 0;
                            }elseif($x <= $a){
                                $f = 1;
                            }else{
                                $f = ($b-$x)/($b-$a);
                            }
                            $data['f'][$cr->candidate_id][$cr->criteria_id][0] = $f;
                        }else if($cv->domain_max == end($abc[$cr->criteria_id]) && $cv->domain_min != $abc[$cr->criteria_id][0]){
                            // Kurva Naik
                            if ($x <= $b) {
                                $f = 0;
                            }elseif($x >= $c){
                                $f = 1;
                            }else{
                                $f = ($x-$b)/($c-$b);
                            }
                            $data['f'][$cr->candidate_id][$cr->criteria_id][2] = $f;
                        }else{
                            // Kurva Segitiga
                            if ($x >= $a && $x <= $b) {
                                $f = ($x-$a)/($b-$a);
                            }elseif($x >= $b && $x <= $c){
                                $f = ($c-$x)/($c-$b);
                            }elseif($x <= 40 || $x >= 80){
                                $f = 0;
                            }
                            $data['f'][$cr->candidate_id][$cr->criteria_id][1] = $f;
                        }
                    }
                }
            }
        }
        // Basis Aturan
        $data['result'] = CriteriaValue::where('criteria_id', 0)->get();
        $criteria = Criteria::orderBy('ranking', 'asc')->where('batch_id', $req->batch)->get();
        $ccount = Criteria::where('batch_id', $req->batch)->count();
        foreach ($criteria as $key => $cr) {
            $criteria_value = CriteriaValue::select('id', 'value')->where('criteria_id', $cr->id)->get();
            $array_val[$key] = Array();
            foreach ($criteria_value as $cv) {
                array_push($array_val[$key], $cv->value);
            }
        }
        $result = [[]];
        foreach ($array_val as $property => $property_values) {
            $temp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $temp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $temp;
        }
        $rules = Rule::where('batch_id', $req->batch)->get();
        $data['rule'] = [];
        foreach ($rules as $key => $r) {
            $data['rule'][$key] = $r->result_id;
        }
        $data['rule_base'] = $result;
        // Defuzzifikasi
        $data['d_rule'] = Rule::where('batch_id', $req->batch)->get();
        $data['d_rule_criteria'] = RuleCriteria::join('criteria_values', 'criteria_values.id', 'rule_criterias.value_id')->get();
        $data['d_rule_result'] = Rule::join('criteria_values', 'criteria_values.id', 'rules.result_id')->select('rules.id', 'criteria_values.domain_min', 'criteria_values.domain_max')->where('batch_id', $req->batch)->get();
        $data['rcount'] = Rule::where('batch_id', $req->batch)->where('result_id', '!=', 0)->count();
        // Result

        $data['rb_ids'] = [];
        foreach ($data['d_rule'] as $key => $drule) {
            $data['rb_ids'][$key] = $drule->id;
        }

        return view('fuzzy', $data);
    }

    public function rule_update(Request $req){
        $rcount = Rule::where('batch_id', $req->batch_id)->count();
        for ($i=1; $i <= $rcount ; $i++) { 
            $edit = Rule::find($req->input('id'.$i));
            $edit->result_id = $req->input('result'.$i);
            $edit->save();
        }
        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil disimpan',
            'batch' => $req->batch_id
        ];

        return redirect('fuzzy')->with( $status );
    }

    public function pdf(Request $req){
        $data['content'] = $req->content;
        return view('fuzzy.pdf', $data);
    }

    public function result_truncate(Request $req){
        $delete = Result::where([['batch_id', $req->batch_id], ['method', $req->method]])->get();
        foreach ($delete as $d) {
            $dlt = Result::find($d->id);
            $dlt->delete();
        }
        return response()->json(
             [
               'success' => true,
               'message' => 'Data inserted successfully'
             ]
        );
    }
    public function result_insert(Request $req){
        $insert = new Result();
        $insert->batch_id = $req->batch_id;
        $insert->candidate_id = $req->candidate_id;
        $insert->value = $req->value;
        $insert->method = $req->method;
        $insert->save();
        return response()->json(
             [
               'success' => true,
               'message' => 'Data inserted successfully'
             ]
        );
    }
}
