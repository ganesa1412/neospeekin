<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;
use Session;
use App\Candidate;
use App\CandidateCriteria;
use App\Criteria;
use App\Batch;

class CandidateController extends Controller
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
        $data['page'] = 'candidate';
        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['isPost'] = false;
        
        return view('candidate', $data);
    }
    public function batch(Request $req){
        $data['page'] = 'candidate';
        $data['isPost'] = true;

        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $data['lists'] = Candidate::where('batch_id', $req->batch)->orderBy('name', 'asc')->get();
        $data['lists2'] = CandidateCriteria::join('criterias', 'criterias.id', 'candidate_criterias.criteria_id')->orderBy('ranking', 'asc')->get();

        $data['batch'] = $req->batch;
        return view('candidate', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($batch)
    {
        $data['page'] = 'candidate';

        $data['batch'] = $batch;
        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return view('candidate_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = new Candidate();
        $insert->name = $request->name;
        $insert->batch_id = $request->batch;
        $insert->save();

        $criteria = Criteria::where('batch_id', $request->batch)->get();
        foreach ($criteria as $c) {
        	$insert2 = new CandidateCriteria();
        	$insert2->criteria_id = $c->id;
        	$insert2->candidate_id = $insert->id;
        	$insert2->save();
        }

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil ditambahkan',
            'batch' => $request->batch
        ];

        return redirect('candidate')->with( $status );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page'] = 'candidate';

        $data['batches'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $data['edit'] = Candidate::where('id', $id)->first();
        $data['batch'] = $data['edit']->batch_id;
        return view('candidate_show', $data);
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
        $edit = Candidate::find($id);
        $edit->name = $request->name;
        $edit->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil diubah',
            'batch' => $request->batch
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
        $delete = Candidate::find($id);
        $batch_id = $delete->batch_id;
        $delete->delete();

        $cc = CandidateCriteria::where('candidate_id', $id)->get();
        foreach ($cc as $c) {
        	$delete2 = CandidateCriteria::find($c->id);
        	$delete2->delete();
        }
        

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil dihapus',
            'batch' => $batch_id
        ];

        return redirect('candidate')->with( $status );
    }
}
