@extends('master')
@section('title', 'Perhitungan Metode SMARTER')
@section('css')
<link rel="stylesheet" type="text/css" href="/plugins/jquery-step/jquery.steps.css">
<link href="/assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css" />
<link href="/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
<style type="text/css">
	.pill.wizard > .steps a{
		font-size: 12px !important;
	}
	.wizard > .content > .body ul{
		list-style: none !important;
	}
	.pill.wizard ul, .pill.wizard.tabcontrol ul {
	    display: flex;
	    justify-content: unset;
	}
	/*.wizard > .content{
		background-color: #fff !important;
		border: 1px solid #ecf0f1;
	}*/

	.membership_function{
		border-bottom: 1px solid #ecf0f1;
		padding-bottom: 25px;
		padding-top: 25px;
	}
	.mf-left, .mf-right{
		height: auto;
		padding: 10px;
		font-size: 14px;
		display: inline-block !important;
		vertical-align: middle !important;
	}
	.mf-right{
		position: relative;
		padding-left: 30px;
	}
	.mf-right::after{
		content: "";
		background-image: url('/assets/img/kurawal.png');
		height: 150px;
		width: 25px;
		background-size: 100% 100%;
		opacity: 0.7;
		position: absolute;
		left: 0px;
		top: -10px;
		font-size: 28px;
	}
	.fuz-th td{
		vertical-align: middle !important;
	}
	.defuz-tb td{
		font-size: 12px !important;
		vertical-align: top !important;
	}
	td.text-success{
		font-weight: bold;
		color: #40906e !important;
	}
</style>
{{-- <link href="/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" /> --}}
<script src="/plugins/apex/apexcharts.min.js"></script>
<script type="text/javascript">
	function chart(sel, data){
		var sLineArea = {
		    chart: {
		        height: 240,
		        type: 'area',
		        toolbar: {
		          show: false,
		        }
		    },
		    dataLabels: {
		        enabled: false
		    },
		    stroke: {
		        curve: 'smooth'
		    },
		    series: data,
		    xaxis: {
		    	type: 'numeric',
		    	tickAmount: 'dataPoints',
			    labels : {
			    	formatter: function (val) {
						return val.toFixed(0);
					}
			    },
		        // categories: ['0', '40', '60', '80', '100'],                
		    },	
		}

		var chart = new ApexCharts(
		    document.querySelector("#"+sel+""),
		    sLineArea
		);

		chart.render();
	}
</script>
@endsection
@section('content')
@php
    if (Session::has('batch')) {
        // $isPost = true;
        $batch = Session::get('batch');
    }
@endphp
 <div class="col-lg-12 layout-spacing">
    <div class="statbox widget box box-shadow">
    	<div class="widget-content widget-content-area br-6">
	        <form action="/smarter/batch" method="POST" enctype="multipart/form-data" class="row">
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
	    @if($isPost)
	    <br>
        <div class="widget-content widget-content-area">
            <div id="pills">
            	@php $uti = [] @endphp
            	<h3>Pembobotan ROC</h3>
                <section>@include('smarter.roc')</section>
                <h3>Normalisasi Nilai Kriteria</h3>
                <section>@include('smarter.normalization')</section>
                <h3>Nilai Utility</h3>
                <section>@include('smarter.utility')</section>
                <h3>Nilai Akhir</h3>
                <section>@include('smarter.final')</section>
                <h3>Hasil Keputusan</h3>
                <section>@include('smarter.result')</section>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('script')
<script src="/plugins/jquery-step/jquery.steps.min.js"></script>
<script type="text/javascript">
	// $("#pills").steps({
	//     headerTag: "h3",
	//     bodyTag: "section",
	//     transitionEffect: "slideLeft",
	//     cssClass: 'pills wizard',
	//     titleTemplate: '#title#',
	//     stepsOrientation: "vertical"
	// });
	$("#pills").steps({
	    headerTag: "h3",
	    bodyTag: "section",
	    transitionEffect: "slideLeft",
	    autoFocus: true,
	    titleTemplate: '#title#',
	    cssClass: 'pill wizard',
	    enableFinishButton: false
	});
</script>
@if(Session::has('batch'))
    <script type="text/javascript">
      $('#bshow').click();
    </script>
@endif
@endsection