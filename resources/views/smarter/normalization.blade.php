<h5>Normalisasi Nilai Kriteria</h5>
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td rowspan="2">#</td>
			<td rowspan="2" width="25%">Kandidat</td>
			<td colspan="{{$ccount}}">
				Nilai Kriteria
			</td>
			<td colspan="{{$ccount}}">
				Normalisasi Nilai
			</td>
		</tr>
		<tr>
			@foreach($criteria AS $c)
				<td style="font-size: 10px !important;">{{$c->name}}</td>
			@endforeach
			@foreach($criteria AS $c)
				<td style="font-size: 10px !important;">{{$c->name}}</td>
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
					{{$ccr[$cd->id][$c->id]}}
				</td>
			@endforeach
			@foreach($criteria AS $c)
				<td>
					{{$normalization[$cd->id][$c->id]}}
				</td>
			@endforeach
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<td colspan="{{$ccount+2}}" class="text-right"><b>C<small>min</small> : </b></td>
			@foreach($criteria AS $c)
				<td class="text-center">
					<b>{{$cmin[$c->id]}}</b>
				</td>
			@endforeach
		</tr>
		<tr>
			<td colspan="{{$ccount+2}}" class="text-right"><b>C<small>max</small> : </b></td>
			@foreach($criteria AS $c)
				<td class="text-center">
					<b>{{$cmax[$c->id]}}</b>
				</td>
			@endforeach
		</tr>
		<tr>
			<td colspan="{{$ccount+2}}" class="text-right"><b>C<small>max</small> - C<small>min</small> : </b></td>
			@foreach($criteria AS $c)
				<td class="text-center">
					<b>{{$cmax[$c->id]-$cmin[$c->id]}}</b>
				</td>
			@endforeach
		</tr>
	</tfoot>
</table>