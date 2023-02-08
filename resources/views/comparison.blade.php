@extends('master')
@section('title', 'Hasil Rekomendasi')
@section('css')
<style type="text/css">
	td{
		font-size: 14px !important;
	}
	p{
		font-size: 13px !important;
	}
	.res-tb tr{
		background-color: rgba(64, 144, 110, 0.1) !important;
		border-bottom: 2px solid #40906e;
	}
	.res-th tr{
		background-color: rgba(64, 144, 110, 0.9) !important;
	}
	.res-tb td b{
		font-size: 18px !important;
		background-color: 
	}
</style>
@endsection
@section('content')
@php
    if (Session::has('batch')) {
        // $isPost = true;
        $batch = Session::get('batch');
    }
@endphp
<div class="col-md-12 col-12 layout-spacing">
	<div class="widget-content widget-content-area br-6">
        <form action="/comparison/batch" method="POST" enctype="multipart/form-data" class="row">
            @csrf
            <div class="col-md-12">Posisi / Batch {{Session::get('batch')}} : </div>
            <div class="col-md-6">
                <select name="batch" class="form-control" required="">
                    <option value="">-Pilih Batch-</option>
                    @foreach($batches AS $b)
                    <option value="{{$b->id}}" {{(isset($batch)?($b->id == $batch?'selected':''):'')}}>{{$b->position}} / {{$months[$b->month]}} {{$b->year}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-lg btn-block" id="bshow">Tampilkan</button>
            </div>
        </form>
    </div>
    <br>
    @if($isPost)
	<div class="widget box-shadow">
	    <div class="widget-content-area br-4">
	        <div class="widget-one">
	        	<div class="row">
	        		<div class="col-6">
	        			<p>Kandidat diterima berdasarkan perhitungan Metode Fuzzy Tsukamoto : </p><br>
			        	<table class="table table-bordered">
							<thead class="bg-dark text-center">
								<tr>
									<td>#</td>
									<td>Nama</td>
									<td>Nilai Akhir</td>
								</tr>
							</thead>
							<tbody class="text-center">
								@foreach($fuzzy AS $i => $f)
									<tr>
										<td>{{$i+1}}.</td>
										<td class="text-left">{{$f->name}}</td>
										<td>{{$f->value}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>	
	        		</div>
	        		<div class="col-6">
		        		<p>Kandidat diterima berdasarkan perhitungan Metode SMARTER : </p><br>
		        		<table class="table table-bordered">
							<thead class="bg-dark text-center">
								<tr>
									<td>#</td>
									<td>Nama</td>
									<td>Nilai Akhir</td>
								</tr>
							</thead>
							<tbody class="text-center">
								@foreach($smarter AS $i => $s)
									<tr>
										<td>{{$i+1}}.</td>
										<td class="text-left">{{$s->name}}</td>
										<td>{{$s->value}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>	
		        	</div>
		        	<div class="col-8">
		        		<hr>
		        		<h5>Berdasarkan perbandingan dua hasil di atas, rekomendasi calon karyawan yang diterima adalah : </h5><br>
		        	</div>
		        	<div class="col-5">
		        		<table class="table">
							<thead class="bg-dark text-center res-th">
								<tr>
									<td>#</td>
									<td class="text-left">Nama</td>
								</tr>
							</thead>
							<tbody class="res-tb">
								@php $c = 0 @endphp
								@foreach($fuzzy AS $f)
									@foreach($smarter AS $s)
										@if($f->id == $s->id)
											<tr>
												<td class="text-center"><b>{{++$c}}</b></td>
												<td class="text-left"><b>{{$s->name}}</b></td>
											</tr>
										@endif
									@endforeach
								@endforeach
								{{-- @for($f = 0; $f < 3; $f++)
									@for($s = 0; $s < 3; $s++)
										@if($fuzzy[$f][1] == $smarter[$s][1])
											<tr>
												<td class="text-center"><b>{{++$c}}.</b></td>
												<td><b>{{$fuzzy[$f][1]}}</b></td>
											</tr>
										@endif
									@endfor
								@endfor --}}
							</tbody>
						</table>
		        	</div>
	        	</div>
	        </div>
	    </div>
	</div>
	@endif
</div>
@endsection