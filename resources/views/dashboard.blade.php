@extends('master')
@section('title', 'Dashboard')
@section('content')
<div class="col-md-7 col-12 layout-spacing">
	<div class="widget box-shadow">
	    <div class="widget-content-area br-4">
	        <div class="widget-one">

	            <h3>Selamat datang, {{Session::get('name')}}</h3>

	            <div class="text-center">
	            	<img src="/assets/img/dashboard.jpg" style="width: 95%;">
	            </div>

	        </div>
	    </div>
	</div>
</div>
<div class="col-md">
	@if(Session::get('level'))
	<a href="/batch" class="btn btn-block btn-lg mb-3 btn-info">Batch Rekrutmen</a>
	<a href="/criteria" class="btn btn-block btn-lg mb-3 btn-primary">Data Kriteria</a>
	<a href="/candidate" class="btn btn-block btn-lg mb-3 btn-primary">Data Kandidat</a>
	@endif
	<a href="/fuzzy" class="btn btn-block btn-lg mb-3 btn-warning">Hasil Keputusan (Fuzzy Tsukamoto)</a>
	<a href="/smarter" class="btn btn-block btn-lg mb-3 btn-warning">Hasil Keputusan (SMARTER)</a>
	<a href="/comparison" class="btn btn-block btn-lg mb-3 btn-success">Hasil Keputusan</a>
	<a href="/logout" class="btn btn-block btn-lg mb-3 btn-danger">Logout</a>
</div>
@endsection