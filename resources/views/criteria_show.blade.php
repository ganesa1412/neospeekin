@extends('master')
@section('title', 'Edit Data Kriteria')
@section('content')
<form class="col-xl-6 col-lg-6 col-sm-12  layout-spacing" action="{{ route('criteria.update', $edit->id) }}" method="POST" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="_method" value="PUT">
    <div class="widget-content widget-content-area br-6">
        <div class="form-group">
            <label>Posisi / Batch: </label>
            <input type="hidden" name="batch" value="{{$batch}}">
            <select class="form-control" required="" disabled="">
                <option value="">-Pilih Batch-</option>
                @foreach($batches AS $b)
                <option value="{{$b->id}}" {{($b->id == $batch?'selected':'')}}>{{$b->position}} / {{$months[$b->month]}} {{$b->year}}</option>
                @endforeach
            </select>
        </div>
    	<div class="form-group">
    		<label>Nama Kriteria : </label>
    		<input type="text" class="form-control" name="name" required="" value="{{$edit->name}}">
    	</div>
    	<div class="form-group">
    		<label>Ranking : </label>
    		<input type="number" class="form-control" name="ranking" required="" value="{{$edit->ranking}}">
    	</div>
        <div class="text-right">
            <a href="/criteria" class="btn btn-dark">
                Kembali
            </a>
            <input type="submit" value="Simpan" class="btn btn-primary">
        </div>
    </div>
</form>
@endsection