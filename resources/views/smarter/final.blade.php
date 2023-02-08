<h5>Nilai Utility</h5>
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td rowspan="2">#</td>
			<td rowspan="2" width="24%">Kandidat</td>
			<td colspan="{{$ccount+1}}">
				Nilai Akhir
			</td>
		</tr>
		<tr>
			@foreach($criteria AS $c)
				<td>{{$c->name}}</td>
			@endforeach
			<td>Total</td>
		</tr>
	</thead>
	<tbody class="text-center">
		@php
			$no = 0;
		@endphp
		@foreach($candidate AS $cd)
		<tr>
			<td>{{++$no}}.</td>
			<td class="text-left">{{$cd->name}}</td>
			@php $f = 0 @endphp
			@foreach($criteria AS $c)
				<td>
					<small>{{$roc[$c->id]}} * {{$utility[$cd->id][$c->id]}} = </small><b>{{$final[$cd->id][$c->id]}}</b>
				</td>
				@php $f += $final[$cd->id][$c->id]; @endphp
			@endforeach
			@php
				array_push($uti, [$f, $cd->id, $cd->name]);
				rsort($uti);
			@endphp
			<td><b>{{$f}}</b></td>
		</tr>
		@endforeach
	</tbody>
</table>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
		type: 'POST',
		url: '{{url('/smarter/result_truncate')}}',
		data: {
			batch_id : {{$batch}},
			method : 'smarter'
		},
		success: function(response) {
			// alert('hore' + response.message);
		},
		error: function(error) {
			console.log(error);
			// alert(error);
		}
	});
	
</script>

@php $accepted = 1; @endphp
@foreach($uti as $i => $d)
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
	$('#result').append(`<tr style="{{$accepted<=3?"font-weight: bold; background-color: rgba(64, 144, 110, 0.1) !important;":''}}">
			<td class="text-center">{{++$i}}</<td>
			<td>{{$d[2]}}</<td>
			<td class="text-center">{{$d[0]*100}}</<td>
			<td class="text-center {{$accepted<=3?"text-success":""}}">{{$accepted<=3?"Diterima":"Ditolak"}}</<td>
		</tr>`);

	@if($accepted <= 3)
	var batch_id = {{$batch}};
	var candidate_id = {{$d[1]}};
	var value = {{$d[0]}};
	var method = 'smarter';
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$.ajax({
		type: 'POST',
		url: '{{url('/smarter/result')}}',
		data: {
			batch_id : batch_id,
			candidate_id : candidate_id,
			value : value*100,
			method : method
		},
		success: function(response) {
			// alert('hore' + response.message);
		},
		error: function(error) {
			console.log(error);
			alert(error);
		}
	});
	@endif
</script>
@php
	Session::put('smarter'.$accepted, $i."|".$d[2]."|".($d[0]*100));
	$accepted++;
@endphp
@endforeach