@extends('master')
@section('title', 'Tambah Data Batch Rekrutmen')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
@section('content')
<form class="col-xl-6 col-lg-6 col-sm-12  layout-spacing mt-2" action="{{ route('batch.store') }}" method="POST" enctype="multipart/form-data">
	@csrf
	{{-- <input type="hidden" name="_method" value="PUT"> --}}
    <div class="widget-content widget-content-area br-6">
    	<div class="form-group">
    		<label>Posisi: </label>
    		<input type="text" class="form-control" name="position" required="">
    	</div>
    	<div class="form-group">
    		<label>Bulan / Tahun : </label>
            <input type="text" id="datepicker" class="form-control" name="month">
    		{{-- <select class="form-control" name="month" required="">
                <option value="">-Pilih Bulan-</option>
                @foreach($months AS $k => $m)
                    @if($k > 0)
                    <option value="{{$k}}">{{$m}}</option>
                    @endif
                @endforeach
            </select> --}}
    	</div>
        {{-- <div class="form-group">
            <label>Tahun : </label>
            <input type="number" class="form-control" name="year" value="{{date('Y')}}" max="9999" required="">
        </div> --}}
        
        <div class="text-right">
            <a href="/batch" class="btn btn-dark">
                Kembali
            </a>
            <input type="submit" value="Simpan" class="btn btn-primary">
        </div>
    </div>
</form>
@endsection
@section('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $("#datepicker").datepicker( {
        format: "mm-yyyy",
        startView: "months", 
        minViewMode: "months"
    });
</script>
@endsection