<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;
use Session;
use App\Batch;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
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
        $data['page'] = 'batch';
        $data['lists'] = Batch::orderBy('year', 'asc')->orderBy('month', 'asc')->orderBy('position', 'asc')->get();
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('batch', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page'] = 'batch';
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('batch_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $time = explode('-', $request->month);
        $insert = new Batch();
        $insert->position = $request->position;
        $insert->month = $time[0];
        $insert->year = $time[1];
        $insert->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil ditambahkan'
        ];

        return redirect('batch')->with( $status );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page'] = 'batch';
        $data['months'] = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $data['edit'] = Batch::where('id', $id)->first();
        return view('batch_show', $data);
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
        $time = explode('-', $request->month);
        $edit = Batch::find($id);
        $edit->position = $request->position;
        $edit->month = $time[0];
        $edit->year = $time[1];
        $edit->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil diubah'
        ];

        return redirect('batch')->with( $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Batch::find($id);
        $delete->delete();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil dihapus'
        ];

        return redirect('batch')->with( $status );
    }
}
