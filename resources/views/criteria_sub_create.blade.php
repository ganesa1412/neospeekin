@extends('master')
@section('title', 'Tambah Data Sub Kriteria')
@section('content')
<form class="col-xl-6 col-lg-6 col-sm-12  layout-spacing" action="{{ route('criteria_sub.store') }}" method="POST" enctype="multipart/form-data">
	@csrf
	{{-- <input type="hidden" name="_method" value="PUT"> --}}
    <input type="hidden" name="criteria_id" value="{{$id}}">
    <div class="widget-content widget-content-area br-6">
    	<div class="form-group">
    		<label>Min : </label>
    		<input type="number" class="form-control" name="min" id="min" onchange="minmax()" required="">
    	</div>
        <div class="form-group">
            <label>Max : </label>
            <input type="number" class="form-control" name="max" id="max" onchange="minmax()" required="">
        </div>
        <div class="text-right">
            <a href="/criteria_sub/detail/{{$id}}" class="btn btn-dark">
                Kembali
            </a>
            <input type="submit" value="Simpan" class="btn btn-primary">
        </div>
    </div>
</form>
@endsection
@section('script')
    <script type="text/javascript">
        function minmax(){
            var min = $('#min').val();
            var max = $('#max').val();

            $('#max').attr('min', min);
            $('#min').attr('max', max);
        }
    </script>
@endsection