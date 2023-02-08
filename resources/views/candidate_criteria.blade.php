@extends('master')
@section('title', 'Edit Nilai Kriteria')
@section('content')
<form class="col-xl-7 col-lg-7 col-sm-12  layout-spacing" action="{{ route('candidate_criteria.update', $candidate_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="candidate_id" value="{{$candidate_id}}">

    <div class="widget-content widget-content-area br-6">
        <div class="text-right">
            <div class="row">
                <div class="col-md-9 text-left">
                    <h5>Kandidat : {{$candidate_name}}</h5>
                </div>     
            </div>
        </div>
        <hr>
        @foreach($lists as $list)
        <div class="form-group">
            <label><b>{{$list->name}} : </b></label>
            <input type="number" class="form-control" name="value{{$list->cc_id}}" required="" value="{{$list->value}}">
        </div>
        @endforeach
        <div class="text-right">
            <input type="submit" value="Simpan" class="btn btn-primary">
        </div>
    </div>
</form>
@endsection