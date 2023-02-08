<h5>Pembobotan ROC Pada Kriteria</h5>
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td>Ranking</td>
			<td>Nama Kriteria</td>
			<td colspan="2">Bobot RoC</td>
		</tr>
	</thead>
	<tbody>
		@foreach($criteria AS $key => $c)
		<tr>
			<td class="text-center">{{$c->ranking}}</td>
			<td>{{$c->name}}</td>
			<td class="text-center">
				(
				@for($i = 1; $i <= $ccount; $i++)
					@if($i < $key+1)
						0
					@else
						1/{{$i}}
					@endif
					@if($i<$ccount) + @endif
				@endfor
				) / {{$ccount}} =
			</td>
			<td class="text-center"><b>{{$roc[$c->id]}}</b></td>
		</tr>
		@endforeach
	</tbody>
</table>
<hr>
<h5 class="mt-5">Pembobotan ROC Pada Sub Kriteria</h5>
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td>Ranking</td>
			<td>Nama Kriteria</td>
			<td>Sub Kriteria</td>
			<td colspan="2">Bobot RoC</td>
		</tr>
	</thead>
	<tbody>
		@foreach($criteria AS $key => $c)
		<tr>
			<td class="text-center">{{$c->ranking}}</td>
			<td>{{$c->name}}</td>
			<td class="text-center">
				@foreach($criteria_sub AS $cs)
					@if($cs->criteria_id == $c->id)
						{{$cs->min}}-{{$cs->max}}<br>
					@endif
				@endforeach
			</td>
			<td class="text-center">
				@foreach($sub[$c->id] AS $key => $cs)
					@if($cs->criteria_id == $c->id)
						(
						@for($i = 1; $i <= $cscount[$c->id]; $i++)
							@if($i < $key+1)
								0
							@else
								1/{{$i}}
							@endif
							@if($i<$cscount[$c->id]) + @endif
						@endfor
						) / {{$cscount[$c->id]}} =
						<br>
					@endif
				@endforeach
			</td>
			<td class="text-center">
				@foreach($criteria_sub AS $cs)
					@if($cs->criteria_id == $c->id)
						<b>{{$roc2[$cs->id]}}</b><br>
					@endif
				@endforeach
			</td>
		</tr>
		@endforeach
	</tbody>
</table>