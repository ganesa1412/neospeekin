<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rule;
use App\RuleCriteria;
use App\Criteria;
use App\CriteriaValue;
use App\CriteriaSub;
use App\Candidate;
use App\CandidateCriteria;
use App\Batch;
use App\Result;
use Illuminate\Support\Facades\DB;

class SmarterController extends Controller
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
    	$data['page'] = 'smarter';
        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['isPost'] = false;

        return view('smarter', $data);
    }
    public function batch(Request $req){
        $data['page'] = 'smarter';

        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['isPost'] = true;        

        $data['batch'] = $req->batch;

    	$data['criteria'] = Criteria::orderBy('ranking')->where('batch_id', $req->batch)->get();

    	// roc
    	$data['ccount'] = Criteria::where('batch_id', $req->batch)->count();
    	foreach ($data['criteria'] as $key => $c) {
    		$roc = 0;
    		$cur = $key+1;
    		for ($i=1; $i <= $data['ccount']; $i++) { 
    			if ($i < $cur) {
    				$roc += 0;
    			}else{
    				$roc += (1/$i);
    			}
    		}
    		$data['roc'][$c->id] = round($roc/$data['ccount'], 2);
    	}
        $data['criteria_sub'] = CriteriaSub::orderBy('min', 'desc')->get();
        foreach ($data['criteria'] as $c) {
            $data['cscount'][$c->id] = CriteriaSub::where('criteria_id', $c->id)->count();
            $data['sub'][$c->id] = CriteriaSub::where('criteria_id', $c->id)->orderBy('min', 'desc')->get();
            foreach ($data['sub'][$c->id] as $key => $cs) {
                $roc = 0;
                $cur = $key+1;
                for ($i=1; $i <= $data['cscount'][$c->id]; $i++) { 
                    if ($i < $cur) {
                        $roc += 0;
                    }else{
                        $roc += (1/$i);
                    }
                }
                $data['roc2'][$cs->id] = round($roc/$data['cscount'][$c->id], 2);
            }
        }

    	// normalisasi
    	$data['candidate'] = Candidate::orderBy('name', 'asc')->where('batch_id', $req->batch)->get();
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
        $data['normalization'] = [[]];
        foreach ($data['candidate'] as $cd) {
            foreach ($data['criteria'] as $cr) {
                $ccr = CandidateCriteria::where([
                    ['criteria_id', $cr->id],
                    ['candidate_id', $cd->id]
                ])->first();
                $ccr_sub = CriteriaSub::where('criteria_id', $cr->id)->get();
                foreach ($ccr_sub as $sub) {
                    if ($ccr->value >= $sub->min && $ccr->value <= $sub->max) {
                        $data['normalization'][$cd->id][$cr->id] = $data['roc2'][$sub->id];;
                    }
                }
            }
        }
        // dd($data['normalization']);
        foreach ($data['criteria'] as $cr) {
            $cmaxmin[$cr->id] = [];
            $ccr_sub = CriteriaSub::where('criteria_id', $cr->id)->get();
            foreach ($data['candidate'] as $cd) {
                array_push($cmaxmin[$cr->id], $data['normalization'][$cd->id][$cr->id]);
            }
            $data['cmin'][$cr->id] = min($cmaxmin[$cr->id]);
            $data['cmax'][$cr->id] = max($cmaxmin[$cr->id]);
        }

        // utility
        $data['utility'] = [[]];
        $data['final'] = [[]];
        foreach ($data['candidate'] as $cd) {
            foreach ($data['criteria'] as $cr) {
                if ($data['cmax'][$cr->id]-$data['cmin'][$cr->id] != 0) {
                    $u = ($data['normalization'][$cd->id][$cr->id]-$data['cmin'][$cr->id])/($data['cmax'][$cr->id]-$data['cmin'][$cr->id]);
                }else{
                    $u = 0;
                }
                $data['utility'][$cd->id][$cr->id] = round($u, 2);
                $data['final'][$cd->id][$cr->id] = round($data['roc'][$cr->id]*$data['utility'][$cd->id][$cr->id], 2);
            }
        }

    	return view('smarter', $data);
    }

    public function pdf(Request $req){
        $data['content'] = $req->content;
        return view('smarter.pdf', $data);
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
