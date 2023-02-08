<h5>Nilai C<small>max</small> & C<small>min</small></h5>
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td rowspan="2">#</td>
			<td rowspan="2" width="25%">Kandidat</td>
			@foreach($criteria AS $c)
			<td>{{$c->name}}</td>
			@endforeach
			<td>C<small>max</small></td>
			<td>C<small>min</small></td>
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
			<td></td>
			<td></td>
		</tr>
		@endforeach
	</tbody>
</table>