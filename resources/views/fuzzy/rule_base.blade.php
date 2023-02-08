<h5>Basis Aturan Fuzzy</h5>
<form action="/fuzzy/rule_update" method="post">
@csrf
<input type="hidden" name="batch_id" value="{{$batch}}">
<table class="table table-striped table-bordered">
	<thead class="bg-dark text-center fuz-th">
		<tr>
			<td rowspan="2">#</td>
			@foreach($criteria AS $c)
			<td>{{$c->name}}</td>
			@endforeach
			<td>Output</td>
		</tr>
	</thead>
	<tbody class="text-center">
		@foreach($rule_base AS $i => $r)
		<tr>
			<td>R{{$i+1}}</td>
			@for($j = 0; $j < $ccount; $j++)
			<td>{{$r[$j]}}</td>
			@endfor
			<td>
				<input type="hidden" name="id{{$i+1}}" value="{{$rb_ids[$i]}}">
				<select class="form-control" name="result{{$i+1}}">
					<option value="0" {{$rule[$i]==0?'selected':''}}>-Pilih Output-</option>
					@foreach($result AS $r2)
					<option value="{{$r2->id}}" {{$rule[$i]==$r2->id?'selected':''}}>{{$r2->value}}</option>
					@endforeach
				</select>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div class="text-right">
	<button type="submit" class="btn btn-success">Simpan Basis Aturan</button>
</div>
</form>