<h5>Nilai Utility</h5>
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td rowspan="2">#</td>
			<td rowspan="2" width="24%">Kandidat</td>
			<td colspan="{{$ccount}}">
				Nilai Utility
			</td>
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
					({{$normalization[$cd->id][$c->id]}}-{{$cmin[$c->id]}})/{{$cmax[$c->id]-$cmin[$c->id]}} = <b>{{$utility[$cd->id][$c->id]}}</b>
				</td>
			@endforeach
		</tr>
		@endforeach
	</tbody>
</table>