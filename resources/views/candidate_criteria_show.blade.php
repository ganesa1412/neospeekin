@extends('master')
@section('title', 'Tambah Himpunan Fuzzy Kriteria')
@section('content')
<form class="col-xl-6 col-lg-6 col-sm-12  layout-spacing" action="{{ route('criteria_value.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="criteria_id" value="{{$edit->criteria_id}}">
    <div class="widget-content widget-content-area br-6">
    	<div class="form-group">
    		<label>Nilai : </label>
    		<input type="text" class="form-control" name="value" required="" value="{{$edit->value}}">
    	</div>
    	<div class="form-group">
    		<label>Domain (Min) : </label>
    		<input type="number" class="form-control" name="domain_min" required="" value="{{$edit->domain_min}}">
    	</div>
        <div class="form-group">
            <label>Domain (Max) : </label>
            <input type="number" class="form-control" name="domain_max" required="" value="{{$edit->domain_max}}">
        </div>
        <div class="text-right">
            <input type="submit" value="Simpan" class="btn btn-primary">
        </div>
    </div>
</form>
@endsection