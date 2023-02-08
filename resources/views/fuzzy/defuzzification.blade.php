<h5>Defuzzifikasi</h5>
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td>#</td>
			<td width="20%">Kandidat</td>
			<td>α-predikat</td>
			<td>Z</td>
			<td>Defuzzifikasi</td>
		</tr>
	</thead>
	<tbody class="text-center defuz-tb">
		@php
			$no = 0;
		@endphp
		@foreach($candidate AS $cd)
		<tr>
			<td>{{++$no}}.</td>
			<td class="text-left">{{$cd->name}}</td>
			<td>
				@php
				$ap = [[]];
				@endphp
				@foreach($d_rule AS $i => $r)
					α<small> predikat {{++$i}}</small> = min
					@php
					$min = array();
					@endphp
						@foreach($d_rule_criteria AS $rc)
							@if($rc->rule_id == $r->id)
								@if($rc->domain_min == $abc[$rc->criteria_id][0] && $rc->domain_max != end($abc[$rc->criteria_id]))
									(<span title="µ{{$rc->value}}">{{$f[$cd->id][$rc->criteria_id][0]}}</span>)
									@php
										array_push($min, $f[$cd->id][$rc->criteria_id][0]);
									@endphp
								@elseif($rc->domain_max == end($abc[$rc->criteria_id]) && $rc->domain_min != $abc[$rc->criteria_id][0])
									(<span title="µ{{$rc->value}}">{{$f[$cd->id][$rc->criteria_id][2]}}</span>)
									@php
										array_push($min, $f[$cd->id][$rc->criteria_id][2]);
									@endphp
								@else
									(<span title="µ{{$rc->value}}">{{$f[$cd->id][$rc->criteria_id][1]}}</span>)
									@php
										array_push($min, $f[$cd->id][$rc->criteria_id][1]);
									@endphp
								@endif
							@endif
						@endforeach
						@php
						@endphp
					= <b>{{min($min)}}</b><br>
					@php
					$ap[$cd->id][$r->id] = min($min);
					@endphp
				@endforeach
			</td>
			<td>
				@php
					$z = [];
					$total_apz = 0;
					$total_ap = 0;
				@endphp
				@foreach($d_rule_result AS $i => $r)
				Z<small>{{++$i}}</small> = 
					@if($r->domain_min == $abc_output[0] && $r->domain_max < end($abc_output))
						@if($ap[$cd->id][$r->id] == 0)
							@php $z[$cd->id][$r->id] = $abc_output[1]  @endphp							
						@elseif($ap[$cd->id][$r->id] == 1)
							@php $z[$cd->id][$r->id] = $abc_output[0]  @endphp
						@else
							({{$ap[$cd->id][$r->id]}}x({{$abc_output[1]}}-{{$abc_output[0]}}))+{{$abc_output[0]}} = 
							@php
								$z[$cd->id][$r->id] = (($ap[$cd->id][$r->id])*($abc_output[1]-$abc_output[0])+$abc_output[0])
							@endphp
						@endif
					@elseif($r->domain_max == end($abc_output) && $r->domain_min != $abc_output[0])
						@if($ap[$cd->id][$r->id] == 0)
							@php $z[$cd->id][$r->id] = $abc_output[1]  @endphp
						@elseif($ap[$cd->id][$r->id] == 1)
							@php $z[$cd->id][$r->id] = $abc_output[2]  @endphp
						@else
							({{$ap[$cd->id][$r->id]}}x({{end($abc_output)}}-{{$abc_output[1]}})+{{$abc_output[1]}}) = 
							@php
								$z[$cd->id][$r->id] = ($ap[$cd->id][$r->id]*((end($abc_output)-$abc_output[1]))+$abc_output[1])
							@endphp				
						@endif					
					@endif
					<b>{{round($z[$cd->id][$r->id], 2)}}</b>
				<br>
					@php
					$z[$cd->id][$r->id] = round($z[$cd->id][$r->id], 2);
					$total_ap += $ap[$cd->id][$r->id];
					$total_apz += ($ap[$cd->id][$r->id]*$z[$cd->id][$r->id]);
					@endphp
				@endforeach
			</td>
			<td><b title="{{$total_apz}}/{{$total_ap}}">{{round($total_apz/$total_ap,2)}}</b></td>
			@php
				$d = round($total_apz/$total_ap,2);
				array_push($def, [$d, $cd->id, $cd->name, ($d>=$abc_output[1]?'Diterima':'Ditolak')]);
				rsort($def);
			@endphp
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
		url: '{{url('/fuzzy/result_truncate')}}',
		data: {
			batch_id : {{$batch}},
			method : 'fuzzy'
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
@foreach($def as $i => $d)
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript">
	$('#result').append(`<tr style="{{$accepted<=3?"font-weight: bold; background-color: rgba(64, 144, 110, 0.1) !important;":''}}">
			<td class="text-center">{{++$i}}</<td>
			<td>{{$d[2]}}</<td>
			<td class="text-center">{{$d[0]}}</<td>
			<td class="text-center {{$accepted<=3?"text-success":''}}">{{$d[3]}}</<td>
		</tr>`);

	@if($accepted <= 3)
	var batch_id = {{$batch}};
	var candidate_id = {{$d[1]}};
	var value = {{$d[0]}};
	var method = 'fuzzy';
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$.ajax({
		type: 'POST',
		url: '{{url('/fuzzy/result')}}',
		data: {
			batch_id : batch_id,
			candidate_id : candidate_id,
			value : value,
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
	Session::put('fuzzy'.$accepted, $i."|".$d[2]."|".$d[0]);
	$accepted++;
@endphp
@endforeach