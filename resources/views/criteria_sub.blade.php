@extends('master')
@section('title', 'Kelola Data Sub Kriteria')
@section('content')
<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="widget-content widget-content-area br-6">
    	<div class="text-right">
    		<div class="row">
                <div class="col-md-6 text-left">
                    <h5>Kriteria : {{$criteria_name}}</h5>
                </div>      
                <div class="col-md-6">
                    <a href="/criteria" class="btn btn-dark">
                        Kembali
                    </a>
                    <a href="/criteria_sub/create/{{$criteria_id}}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        Tambah
                    </a>
                </div>      
            </div>
    	</div>
        <div class="table-responsive mb-4 mt-4">
            <table id="zero-config" class="table table-hover table-striped" style="width:100%">
                <thead>
                    <tr>
                    	<th>No.</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th class="no-content"></th>
                    </tr>
                </thead>
                <tbody>
                	@php $no = 1 @endphp
                	@foreach($lists as $list)
                    <tr>
                    	<td>{{$no++}}.</td>
                        <td>{{$list->min}}</td>
                        <td>{{$list->max}}</td>
                        <td>
							  <a href="/criteria_sub/{{$list->id}}" class="btn btn-warning btn-sm">
							  	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg> Edit
							  </a>
							  <form action="{{route('criteria_sub.destroy', $list->id)}}" method="post">
							  	@csrf
							  	<input type="hidden" name="_method" value="DELETE">
							  	<button type="submit" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Delete this data?')">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus
								  </button>
							  </form>
                        </td>
                    </tr>
                	@endforeach
                </tbody>
                <tfoot>
                    <tr>
                    	<th>No.</th>
                        <th>Min</th>
                        <th>Max</th>
                        <th class="no-content"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection