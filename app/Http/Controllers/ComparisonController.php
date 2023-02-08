<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Result;
use App\Candidate;
use App\Batch;
use Session;

class ComparisonController extends Controller
{
    public function __construct(){
        $this->middleware('admin-middleware');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['page'] = 'comparison';
        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['isPost'] = false;

        return view('comparison', $data);
    }
    public function batch(Request $req){
        $data['page'] = 'comparison';

        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['isPost'] = true;        

        $data['batch'] = $req->batch;
        // return redirect('criteria')->with( $status );
        $data['page'] = 'comparison';

        $data['fuzzy'] = Result::join('candidates', 'results.candidate_id', 'candidates.id')->orderBy('value', 'desc')->where([
            ['results.batch_id', $req->batch],
            ['results.method', 'fuzzy']
        ])->select('candidates.id', 'candidates.name', 'results.value')->get();
        $data['smarter'] = Result::join('candidates', 'results.candidate_id', 'candidates.id')->orderBy('value', 'desc')->where([
            ['results.batch_id', $req->batch],
            ['results.method', 'smarter']
        ])->select('candidates.id', 'candidates.name', 'results.value')->get();
        
        return view('comparison', $data);
    }
}
