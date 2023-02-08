<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Str;
use Session;
use App\Criteria;

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
        $data['page'] = 'user';
        $data['lists'] = User::all();
        return view('user', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page'] = 'user';
        return view('user_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = new User();
        $insert->username = $request->username;
        $insert->name = $request->name;
        $insert->password = $request->password;
        $insert->level = $request->level;
        $insert->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil ditambahkan'
        ];

        return redirect('user')->with( $status );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['page'] = 'milestone';
        $data['edit'] = Milestone::where('id', $id)->first();
        return view('admin.milestone_show', $data);
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
        $edit = Milestone::find($id);
        $edit->year = $request->year;
        $edit->description = $request->description;
        $edit->save();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil diubah'
        ];

        return redirect('admin/about/milestone')->with( $status );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Milestone::find($id);
        $delete->delete();

        $status = [
            'status' => 'success',
            'msg' => 'Data berhasil dihapus'
        ];

        return redirect('admin/about/milestone')->with( $status );
    }
}
