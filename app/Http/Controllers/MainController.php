<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;

class MainController extends Controller
{
    public function __construct(){
        $this->middleware('admin-middleware', ['except' => ['login','login_process']]);
    }
    public function index()
    {
    	$data['page'] = 'dashboard';
    	
        return view('dashboard', $data);
    }

    public function login(){
    	return view('login');
    }

    public function login_process(Request $req){
    	$where = array(
    		'username' => $req->username,
    		'password' => md5($req->password)
    	);

    	$userdata = User::where($where)->first();
    	$count = User::where($where)->count();
    	if ($count == 0) {
            $status = [
	            'status' => 'error',
	            'msg' => 'Username atau password salah'
	        ];

    		return redirect('/login')->with($status);
    	}else{
    		Session::put('id', $userdata->id);
    		Session::put('name', $userdata->name);
    		Session::put('username', $userdata->username);
    		Session::put('level', $userdata->level);
    		Session::put('tipe', $userdata->level);

    		return redirect('/');
    	}
    }

     public function logout(){
    	Session::flush();
    	return redirect('/login');
    }
}
