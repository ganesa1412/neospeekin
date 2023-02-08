<h5>Inferensi</h5>
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td rowspan="2">#</td>
			<td rowspan="2" width="25%">Kandidat</td>
			<td colspan="{{$ccount}}">Derajat Keanggotaan</td>
		</tr>
		<tr>
			@foreach($criteria AS $c)
			<td>{{$c->name}}</td>
			@endforeach
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
			@foreach($criteria AS $c)
				<td>
					Nilai : <b>{{$ccr[$cd->id][$c->id]}}</b><br>
					@foreach($cvalue AS $cv)
						@if($cv->criteria_id == $c->id)
							@if($cv->domain_min == $abc[$c->id][0] && $cv->domain_max != end($abc[$c->id]))
								<small>μ{{$cv->value}}</small> : <b>{{$f[$cd->id][$c->id][0]}}</b><br>
							@elseif($cv->domain_max == end($abc[$c->id]) && $cv->domain_min != $abc[$c->id][0])
								<small>μ{{$cv->value}}</small> : <b>{{$f[$cd->id][$c->id][2]}}</b><br>
							@else
								<small>μ{{$cv->value}}</small> : <b>{{$f[$cd->id][$c->id][1]}}</b><br>
							@endif
						@endif
					@endforeach
				</td>
			@endforeach
		</tr>
		@endforeach
	</tbody>
</table>